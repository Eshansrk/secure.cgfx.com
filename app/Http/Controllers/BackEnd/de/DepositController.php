<?php

namespace App\Http\Controllers\BackEnd\de;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\CMS_Account;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Mail;
use Session; 
use PDF;

class DepositController extends Controller
{
  public function __construct()
  {
    $this->middleware('adminAccess', ['except' => ['voguepayDepositNotify','skrillDepositStatus','perfectMoneyDepositStatus']]);
  }


  public function serverConfigs(){
    $server_configs=DB::table('server_configs')->first();
    return $server_configs;

  }

  public function email_adds(){
    $email_adds=DB::table('cms_email_addresses')->first();
    return $email_adds;
  }

  public function mail_data(){

    $general_information = DB::table('general_information')->first();
    $email_adds = DB::table('cms_email_addresses')->select('support_email')->first();
    $server_configs = DB::table('server_configs')->select('server_client','download_link')->first();
    $mail_data = array(

   'company_name' => $general_information->company_name,
   'company_url' => $general_information->company_url,
   'support_email' => $email_adds->support_email,
   'client_portal_url' => $general_information->client_portal_url,
   'phone' => $general_information->phone,
   'address' => $general_information->address,
   'copyright_text' => $general_information->copyright_text,
   'server_client' => $server_configs->server_client,
   'download_link' => $server_configs->download_link,
   'risk_warning_title' => $general_information->risk_warning_title,
   'risk_warning_text' => $general_information->risk_warning_text,
   'legal_information_text' => $general_information->legal_information_text,
   
 );
    return $mail_data;

  }




/*=================================
=          Deposit Funds         =
=================================*/



  /*=================================
  =          UPay Card             =
  =================================*/


  public function upaycardDeposit(Request $request){
      if($request->ac){
          $selected_account=$request->ac;
      }
      else{
          $selected_account="";
      }

      $accounts=DB::table('cms_account')->join('mt4_users','mt4_users.LOGIN','=','cms_account.account_no')->where([

          ['cms_account.email','=',session('login_email')],
          ['cms_account.account_no','<>','0'],
          ['cms_account.act_type','<>','IB'],
          ['cms_account.act_type','<>','DEMO']
      ])->select('cms_account.*','mt4_users.BALANCE')->orderBy('cms_account.account_no','desc')->get();

      return view ('backEnd.'.app()->getLocale().'.crm.deposit.upaycard-deposit',compact('accounts', 'selected_account'));
  }





  public function postUpaycardDeposit(Request $request){

      if(is_numeric($request->amount)==false){
          return redirect('/upaycard-deposit')->withErrors(['Please Enter a valid amount']);
      }
      elseif($request->amount<1){
          return redirect('/upaycard-deposit')->withErrors(['Minimum U pay card deposit is 1 usd']);
      }
      elseif(is_numeric($request->userAccount)==false ){
          return redirect('/upaycard-deposit')->withErrors(['Your given UPAY Card account no. is invalid.']);
      }
      else{
          $profile=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
          $time=time();
          $orderId = $profile->affiliate_prom_code.$time;
          $apiReceiverAcc = '3188911';
          $apiMerchantKey = 'aec00e37173a1d61';
          $apiMerchantSecret = 'f614a132fe9a7738';

          $url = 'https://api.upaycard.com/api/merchant/v/1.0/function/create_purchase';
          $ch = curl_init($url);

          $data = array(
              "receiver_account"=>$apiReceiverAcc,
              "amount"=>$request->amount,
              "currency"=>"USD",
              "order_id"=>$orderId,
              "sender_user_id"=>$request->userName,
              "sender_account"=>$request->userAccount,
              "url_user_on_success"=>URL::to('/')."/upaycard-deposit-success",
              "url_user_on_fail"=>URL::to('/')."/upaycard-deposit-fail",
              "url_api_on_success"=>URL::to('/')."/upaycard-api-success",
              "url_api_on_fail"=>URL::to('/')."/upaycard-api-fail",
              "key"=>$apiMerchantKey,
              "ts"=>$time,
              "sign"=>""
          );

          $strToSign = '';
          ksort($data);
          foreach ($data as $k => $v){
              if($v !== ""){
                  $strToSign .= "$k:$v:";
              }
          }
          $strToSign .= $apiMerchantSecret;
          $data['sign']=md5($strToSign);

          $payload = json_encode($data);

          curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

          $serverOutput = curl_exec($ch);
          curl_close($ch);

          DB::table('payment_notifications')->insert([
              'payment_method'=>'UPayInitial',
              'notification'=>$serverOutput
          ]);

          $serverOutput = json_decode($serverOutput,true);



          if (isset($serverOutput['status']) && $serverOutput['status'] == 'error') {
              return redirect('/upaycard-deposit')->withErrors([$serverOutput['msg']]);
          }

          DB::table('payment_predata')->insert([
              'payment_type'=>'UPay',
              'account_no'=>$request->deposit_to,
              'reference_no'=>$orderId,
              'email'=>session('login_email'),
              'amount'=>$request->amount,
              'transaction_fee'=>'0',
              'net_amount'=>$request->amount,
              'currency'=>'USD',
              'transaction_id'=>$serverOutput['reference_id'],
              'status'=>'0',
              'transaction_time'=>date("Y-m-d H:i:s",$time)
          ]);

          session([
              'account_no' => $request->deposit_to,
              'amount' => $request->amount,
              'user_id' => $request->userName,
              'upaycard_account' => $request->userAccount,
              'order_id' => $serverOutput['order_id'],
              'amount' => $serverOutput['amount'],
              'reference' => $serverOutput['reference_id'],
              'time' => $time
          ]);

          Session::save();

          $redirect_url=base64_encode($serverOutput['url']);
          return redirect("https://user.upaycard.com/en/auth/login/redirect/".$redirect_url);

      }

  }



  public function upaycardDepositSuccess(){
      $apiMerchantKey = 'aec00e37173a1d61';
      $apiMerchantSecret = 'f614a132fe9a7738';

      $url = 'https://api.upaycard.com/api/merchant/v/1.0/function/get_purchase_status';

      $ch = curl_init($url);

      $data = array(
          "reference_id"=>session('reference'),
          "key"=>$apiMerchantKey,
          "ts"=>session('time'),
          "sign"=>""
      );

      $strToSign = '';
      ksort($data);
      foreach ($data as $k => $v){
          if($v !== ""){
              $strToSign .= "$k:$v:";
          }
      }
      $strToSign .= $apiMerchantSecret;

      $data['sign']=md5($strToSign);

      $payload = json_encode($data);

      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $serverOutput = curl_exec($ch);
      curl_close($ch);

      DB::table('payment_notifications')->insert([
          'payment_method'=>'UPay',
          'notification'=>$serverOutput
      ]);

      $serverOutput = json_decode($serverOutput,true);

      if($serverOutput['status']=='success' && $serverOutput['msg']=='Success' && $serverOutput['reference_id']==session('reference') && $serverOutput['order_id']==session('order_id') && $serverOutput['purchase_status']==9){

          // Transfer to MT4

          $status=1;

          $myvalue = session('account_no');
          $arr = explode(' ',trim($myvalue));


          // $message = '{ "Method" : "ChangeBalance" , "SecureCode" :"2017" , "Parameter" : { "Login" : '.$arr[0].', "Amount" : '.$request->amount.' , "Type" : "In" , "Comment" : "Neteller#'.$reference.'" } }';
          // $host    = "127.0.0.1";

          $server_configs = $this->serverConfigs();

          $server=$server_configs->server;
          $server_login=$server_configs->login;
          $server_password=$server_configs->password;
          $amount=$serverOutput['amount'];
          $reference=$serverOutput['reference_id'];
          $deposit_to=$arr[0];
          $comment="UPAY DP#".$reference;
          $a=exec(storage_path('/api/DepositBalanceWeb.exe')." \"".$server."\" \"".$server_login."\" \"".$server_password."\" \"".$deposit_to."\" \"".$amount."\" \"".$comment);

          if($a!='Successful'){
              return Redirect::back();
          }

          DB::table('payment_predata')
              ->where('payment_type','UPay')
              ->where('transaction_id',$serverOutput['reference_id'])
              ->where('status',0)
              ->update([
                  'status' => 1
              ]);

          //  Insert into Database

          DB::table('cms_deposit')
              ->insert(
                  [
                      'email'=>session('login_email'),
                      'amount'=>$serverOutput['amount'],
                      'net_amount'=>$serverOutput['amount'],
                      'transaction_fee'=>0,
                      'account_no'=>session('account_no'),
                      'payment_type'=>'UPAY Card',
                      'account_id'=>session('upaycard_account'),
                      'transaction_id'=>$reference,
                      'reference_no' => $reference,
                      'currency'=>'USD',

                      'status'=>$status,
                      'transaction_time'=>date("Y-m-d h:i:s",session('time'))
                  ]
              );

          /* ********************* insert into cc_log **************************************** */

          DB::table('cms_log')
              ->insert(
                  ['ref_id' => $reference,
                      'table_name'=>'cms_deposit',
                      'naration'=>'account_no = '.session('account_no'),
                      'ip_address'=>$_SERVER['REMOTE_ADDR'],
                      'date_time'=>date("Y-m-d h:i:s",session('time'))
                  ]
              );

          /* ********************* End insert into cc_log **************************************** */



          // Notification Mail to Accounts Section

          $profile=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
          $name=$profile->fname." ".$profile->lname;
          $data = array(
              'name' => $name ,
              'reference' => $reference,
              'email'=>session('login_email'),
              'amount'=>$serverOutput['amount'],
              'payment_type'=>'UPAY Card',
              'transaction_id'=>$reference,
              'account'=>session('upaycard_account'),
              'deposit_to'=>session('account_no').' ('.$cms_account->act_type.')'

          );

          $email_adds = $this->email_adds();
          $from_email_id=$email_adds->deposit_email_from;
          $user_mail=$email_adds->deposit_email_to;
          $user_name='JC Capital Finance';

          $mail_subject='New Deposit From Client';
          $from_name='Client Deposit';



          Mail::send('backEnd.'.app()->getLocale().'.crm.mail.deposit-mail',
              $data, function($message)use ($from_email_id,$from_name,$user_mail, $user_name,$mail_subject)
              {
                  $message->from($from_email_id,$from_name);
                  $message->to($user_mail, $user_name)->subject($mail_subject);
              });

          Session::flash('msg','Your Deposit has been processed successfully to '.session('account_no').' ('.$cms_account->act_type.')');

          //Notifications

          $intIds=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
          DB::table('admins')
              ->where('id',$intIds->manager)
              ->orWhere([
                  'country_access'=>'All',
                  'manager'=>0
              ])
              ->orWhere([
                  'country_access'=>$intIds->country,
                  'manager'=>0
              ])
              ->increment('clientDeposit', 1);

      }

      Session::forget('account_no');
      Session::forget('amount');
      Session::forget('user_id');
      Session::forget('upaycard_account');
      Session::forget('order_id');
      Session::forget('amount');
      Session::forget('reference');
      Session::forget('time');

      return redirect('/upaycard-deposit');

  }


  public function upaycardDepositFail(){
      Session::forget('account_no');
      Session::forget('amount');
      Session::forget('user_id');
      Session::forget('upaycard_account');
      Session::forget('order_id');
      Session::forget('amount');
      Session::forget('reference');
      Session::forget('time');
      return redirect('/upaycard-deposit')->withErrors(['Your Deposit has been cancelled. Please Retry.']);
  }


/*=================================
=          Neteller               =
=================================*/ 

public function netellerDeposit(Request $request){
  if($request->ac){
    $selected_account=$request->ac;
  }
  else{
    $selected_account="";
  }
  $accounts=DB::table('cms_account')->join('mt4_users','mt4_users.LOGIN','=','cms_account.account_no')->where([    
    ['cms_account.email','=',session('login_email')],
    ['cms_account.account_no','<>','0'],
    ['cms_account.act_type','<>','IB'],
    ['cms_account.act_type','<>','DEMO']
])->select('cms_account.*')->orderBy('cms_account.account_no','desc')->get();
  foreach($accounts as $account){
    $balance=DB::table('mt4_users')->where('LOGIN',$account->account_no)->first();
    if($balance){
      $account->BALANCE=$balance->BALANCE;
    }
    else{
      $account->BALANCE=0;
    }
  }
  return view ('backEnd.'.app()->getLocale().'.crm.deposit.neteller-deposit',compact('accounts','selected_account'));
}





public function postNetellerDeposit(Request $request){
  if(is_numeric($request->amount)==false){
    return redirect('/neteller_deposit')->withErrors(['Please Enter a valid amount']);
  }
  elseif($request->amount<2){
    return redirect('/neteller_deposit')->withErrors(['Minimum Neteller deposit is 2 usd']);
  }
  elseif(is_numeric($request->account)==false || $request->account<1000000000){
    return redirect('/neteller_deposit')->withErrors(['Your given Neteller account id is invalid.']);
  }

  else{

//   Balance Transfer to Neteller

$username = 'AAABWzpNlYUeFFLw';  // clint id
$password = "0.SCpZDKA5J_08ClvYaEX494I_lmTwLEFPLc-pAux0QMs.EAAQ7CrQ_5DBgrGfPvEPXBcKEyxvoSc";  // client secret key
//get the vars from POST request and set an array with all the required vars
$profile=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
$time = time();
$reference=$profile->affiliate_prom_code.$time;
$neteller_amount=$request->amount*100;
$fields = array(
     'version' => '4.1',
    'amount' => urlencode($neteller_amount),
    'currency' => 'USD',
    'net_account' => urlencode($request->account), //'455524407461'
    'secure_id' => urlencode($request->secure_id), //'622700'
    'merchant_id' => urlencode('58997'), //CMSamar2015!@#
    'merch_key' => urlencode("$username:$password"), //183216
    'merch_transid' => urlencode($reference),
    'merch_name' => urlencode('GICM'),
    'merch_account' => urlencode('GICM'),
    'scope'=>'default',
    'button' => 'Make Transfer'
);
 
 
$ch = curl_init();

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_URL, "https://api.neteller.com/v1/oauth2/token?grant_type=client_credentials");
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:application/json", "Cache-Control:no-cache"));
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$serverOutput = curl_exec($ch);
$serverOutput = json_decode($serverOutput,true);


if (isset($serverOutput['error']) && $serverOutput['error'] != '') {
    
    return redirect('/neteller_deposit')->withErrors([$serverOutput['error']]);
}


else{
    $requestParams = array
      (
            "paymentMethod" => array
            (
                  "type" => "neteller",
                  "value" => $fields['net_account'],
            ),
            "transaction" => array
            (
                  "merchantRefId" => (string)$time,
                  "amount" => $neteller_amount, 
                  "currency" => "USD"
            ),
            "verificationCode" => $request->secure_id
      );

//print_r($requestParams);exit;
$curl = curl_init();
$accessToken = $serverOutput["accessToken"];
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_URL, "https://api.neteller.com/v1/transferIn");
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type:application/json", "Authorization: Bearer $accessToken"));
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($requestParams));
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$serverOutput = curl_exec($curl);

  DB::table('payment_notifications')->insert([
  'payment_method'=>'Neteller',
  'notification'=>$serverOutput
]);
// echo $serverOutput;exit;

  $serverOutput = json_decode($serverOutput,true);

  if (isset($serverOutput['error']['code']) && $serverOutput['error']['code'] != '') {
   
    return redirect('/neteller_deposit')->withErrors($serverOutput['error']['message']);
}
$transaction_id=$serverOutput['transaction']['id'];
$description = $serverOutput['transaction']['description'];
$arr = explode(' ',trim($description));
$payment_email = $arr[0];
curl_close($ch);
}


// Transfer to MT4


$status=1;

$myvalue = $request->deposit_to;
$arr = explode(' ',trim($myvalue));

$server_configs=$this->serverConfigs();
$server=$server_configs->server;
$server_login=$server_configs->login;
$server_password=$server_configs->password;
$amount=$request->amount;

$deposit_to=$arr[0];
$comment="Neteller DP#".$reference;
$a=exec(storage_path('/api/DepositBalanceWeb.exe')." \"".$server."\" \"".$server_login."\" \"".$server_password."\" \"".$deposit_to."\" \"".$amount."\" \"".$comment);

if($a!='Successful'){
  return Redirect::back();
}



//  Insert into Database


 $insert=DB::table('cms_deposit')
    ->insert(
    ['reference_no' => $reference,
     
     'email'=>session('login_email'),
     'amount'=>$request->amount,
     'net_amount'=>$request->amount,
     'transaction_fee'=>0,
     'account_no'=>$request->deposit_to,
     'payment_type'=>'Neteller',
     'account_id'=>$request->account,
     'payment_email'=>$payment_email,
     
     'currency'=>'USD',
         
     'status'=>$status,
     'transaction_id' => $transaction_id,
     'transaction_time'=>date("Y-m-d H:i:s",$time)
     ]
);


            
          

            /* ********************* insert into cc_log **************************************** */


            $insert=DB::table('cms_log')
    ->insert(
    ['ref_id' => $reference,
     'table_name'=>'cms_deposit',
     'naration'=>'account_no = '.$request->deposit_to,
     'ip_address'=>$_SERVER['REMOTE_ADDR'],
     
     'date_time'=>date("Y-m-d H:i:s",$time)
     ]
);
            
            /* ********************* End insert into cc_log **************************************** */

$cms_account=DB::table('cms_account')->where([
            ['email',session('login_email')],
            ['account_no',$request->deposit_to]
            ])->first();




// Notification Mail to Accounts Section


$name=$profile->fname." ".$profile->lname;
$mobile=$profile->mobile;
$address=$profile->address;   
$email=$profile->email;   
$amount=$request->amount;
$deposit_to=$request->deposit_to;

$email_adds = $this->email_adds();
$from_email_id=$email_adds->deposit_email_from;
$from_name='Client Deposit';

$user_mail=$email_adds->deposit_email_to;
// $user_mail='mkhassan25@gmail.com';
$user_name=config('app.name');

$mail_subject='New Neteller Deposit From Client';
$from_name='Client Deposit';
$email_adds = DB::table('cms_email_addresses')->first();
$data = array(
 'name' => $name,
 'reference_no' => $reference,
 'email'=>$email,
 'mobile'=>$mobile,
 'address'=>$address,
 'support_email'=>$email_adds->support_email,     
 'amount'=>$amount,
 'payment_type'=>'Neteller',
 'transaction_id'=>$transaction_id,
 'account'=>$deposit_to,
 'deposit_to'=>$deposit_to.' ('.$cms_account->act_type.')',
 'transaction_time'=>date("Y-m-d H:i:s",$time)
);

$pdf = PDF::loadView('backEnd.'.app()->getLocale().'.crm.mail.deposit-invoice-mail', $data);
$pdfName="NetellerDepositBy".$deposit_to.".pdf";


Mail::send('backEnd.'.app()->getLocale().'.crm.mail.deposit-invoice-mail',
  $data, function($message)use ($from_email_id,$from_name,$user_mail, $user_name,$mail_subject,$pdf,$pdfName)
  {
    $message->from($from_email_id,$from_name) 
    ->to($user_mail, $user_name)
    ->attachData($pdf->output(),$pdfName, [
      'mime' => 'application/pdf',
    ])
    ->subject($mail_subject);
  });


// Mail to client

$from_email_id=$email_adds->deposit_email_to;
$user_mail=$email;
// $user_mail='mkhassan25@gmail.com';
$user_name=$name;

$mail_subject='Your Deposiit has been processed successfully';
$from_name=config('app.name');

Mail::send('backEnd.'.app()->getLocale().'.crm.mail.deposit-invoice-mail',
  $data, function($message)use ($from_email_id,$from_name,$user_mail, $user_name,$mail_subject,$pdf,$pdfName)
  {
    $message->from($from_email_id,$from_name) 
    ->to($user_mail, $user_name)
    ->attachData($pdf->output(),$pdfName, [
      'mime' => 'application/pdf',
    ])
    ->subject($mail_subject);
  });


Session::flash('msg','Your Deposit has been processed successfully to '.$request->deposit_to.' ('.$cms_account->act_type.')');

        //Notifications


$intIds=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
DB::table('admins')
->where('id',$intIds->manager)
->orWhere([
  'country_access'=>'All',
  'manager'=>0
])
->orWhere([
  'country_access'=>$intIds->country,
  'manager'=>0
])
->increment('clientDeposit', 1);

return redirect('/neteller_deposit');


}



}






/*=================================
=          Skrill               =
=================================*/ 

public function skrillDeposit(Request $request){
  if($request->ac){
    $selected_account=$request->ac;
  }
  else{
    $selected_account="";
  }

  $accounts=DB::table('cms_account')->join('mt4_users','mt4_users.LOGIN','=','cms_account.account_no')->where([    
    ['cms_account.email','=',session('login_email')],
    ['cms_account.account_no','<>','0'],
    ['cms_account.act_type','<>','IB'],
    ['cms_account.act_type','<>','DEMO']
])->select('cms_account.*','mt4_users.BALANCE','mt4_users.CURRENCY')->orderBy('cms_account.account_no','desc')->get();
  
  return view ('backEnd.'.app()->getLocale().'.crm.deposit.skrill-deposit',compact('accounts','selected_account'));
}


public function postSkrillDeposit(Request $request){
  if(is_numeric($request->amount)==false){
    return redirect('/skrill_deposit')->withErrors(['Bitte geben Sie einen gültigen Betrag ein']);
  }
  elseif($request->amount<1){
    return redirect('/skrill_deposit')->withErrors(['Die Mindesteinzahlung für Skrill beträgt 1 USD']);
  }
  else{
    $time = time();      
    session(['account_no' => $request->deposit_to]);
    session(['skrill' => 1]);
    Session::save(); 
    $apc = DB::table('cms_liveaccount')->where('email',session('login_email'))->select('affiliate_prom_code')->first();
    $reference = $apc->affiliate_prom_code.$time;
    return view('backEnd.'.app()->getLocale().'.crm.deposit.skrill-deposit-details',compact('request','reference'));         
  }



}



public function skrillDepositSuccess(){

  if(Session::has('account_no') && Session::has('skrill')){

  $account_no = session('account_no');
  Session::forget('account_no');
  Session::forget('skrill');
  Session::flash('msg','Ihre Einzahlung zu '.$account_no.' ist in Bearbeitung.');
  return redirect('/skrill_deposit');

}
else {
  return view('errors.'.app()->getLocale().'.404');
}

}




public function skrillDepositCancel(){
  if(Session::has('account_no') && Session::has('skrill')){

    $account_no = session('account_no');
    Session::forget('account_no');
    Session::forget('skrill');
    return redirect('/skrill_deposit')->withErrors(['Ihre Einzahlung wurde storniert. Bitte erneut versuchen.']);
   
  
  }
  else {
    return view('errors.'.app()->getLocale().'.404');
  }

}


public function skrillDepositStatus(Request $request){
  $noti = json_encode($request->all());
  DB::table('payment_notifications')->insert([
    'payment_method'=>'Skrill',
    'notification'=>$noti
  ]);
  
  $exist = DB::table('cms_deposit')->where('transaction_id',$request->mb_transaction_id)->where('payment_type','Skrill')->first();
if($exist){
  return 'Already Exists';
}
$merchant_id = $request->merchant_id;
  $transaction_id = $request->transaction_id;
  $mb_secret = 'C8BF4677896287EDF4755560107F5559';
  $mb_amount = $request->mb_amount;
  $mb_currency = $request->mb_currency;  
  $status = $request->status;
  $md5sigCalc = strtoupper(md5($merchant_id.$transaction_id.$mb_secret.$mb_amount.$mb_currency.$status));
if($request->md5sig==$md5sigCalc && $request->status=="2" && $request->pay_to_email=="finance@gicmarkets.com" && $request->mb_currency=="USD"){
  $time = time();
  $transaction_time = date("Y-m-d H:i:s",$time);
$sql=DB::table('cms_deposit')->insert([
    'payment_type'=>'Skrill',
    'account_no'=>$request->account_no,
    'reference_no'=>$request->transaction_id,
    'transaction_id'=>$request->mb_transaction_id,
    'email'=>$request->email,
    'payment_email'=>$request->pay_from_email,
    'amount'=>$request->mb_amount,
    'transaction_fee'=>'0',
    'net_amount'=>$request->mb_amount,
    'currency'=>'USD',
    'status'=>'1',
    'transaction_time'=>$transaction_time
    

]); 
  
   /* ********************* insert into cc_log **************************************** */


            $insert=DB::table('cms_log')
    ->insert(
    ['ref_id' => $request->transaction_id,
     'table_name'=>'cms_deposit',
     'naration'=>'account_no = '.$request->account_no,
     'ip_address'=>\Request::ip(),     
     'date_time'=>$transaction_time
     ]
);
            
            /* ********************* End insert into cc_log **************************************** */

   // Deposit to MT4

  
  $server_configs=$this->serverConfigs();
  $server=$server_configs->server;
  $server_login=$server_configs->login;
  $server_password=$server_configs->password;
  $amount=$request->mb_amount;
          
  $deposit_to=$request->account_no;
  
 $comment="Skrill DP#".$request->transaction_id;
 $a=exec(storage_path('/api/DepositBalanceWeb.exe')." \"".$server."\" \"".$server_login."\" \"".$server_password."\" \"".$request->account_no."\" \"".$amount."\" \"".$comment);

//  echo $a.'<br>'.$server.'<br>'.$server_login.'<br>'.$server_password.'<br>'.$request->transaction_id.'<br>'.$amount.'<br>'.$comment.'<br>';exit;

 if($a!='Successful'){
            return "failed1";
          }
$email = $request->email;
$transaction_id = $request->mb_transaction_id;

$cms_account=DB::table('cms_account')->where([
            ['email',$email],
            ['account_no',$request->account_no]
            ])->first();

 // Notification Mail to Accounts Section

 $profile=DB::table('cms_liveaccount')->where('email',$email)->first();
 $name=$profile->fname." ".$profile->lname;
 $mobile=$profile->mobile;
 $address=$profile->address;   

 $email_adds = $this->email_adds();
 $from_email_id=$email_adds->deposit_email_from;
 $from_name='Client Deposit';

 $user_mail=$email_adds->deposit_email_to;
 // $user_mail='mkhassan25@gmail.com';
 $user_name=config('app.name');

 $mail_subject='New Skrill Deposit From Client';
 $from_name='Client Deposit';
 $email_adds = DB::table('cms_email_addresses')->first();
 $data = array(
  'name' => $name,
  'reference_no' => $request->transaction_id,
  'email'=>$email,
  'mobile'=>$mobile,
  'address'=>$address,
  'support_email'=>$email_adds->support_email,     
  'amount'=>$amount,
  'payment_type'=>'Skrill',
  'transaction_id'=>$transaction_id,
  'account'=>$deposit_to,
  'deposit_to'=>$deposit_to.' ('.$cms_account->act_type.')',
  'transaction_time'=>$transaction_time
);

 $pdf = PDF::loadView('backEnd.'.app()->getLocale().'.crm.mail.deposit-invoice-mail', $data);
 $pdfName="SkrillDepositBy".$deposit_to.".pdf";
 

 Mail::send('backEnd.'.app()->getLocale().'.crm.mail.deposit-invoice-mail',
   $data, function($message)use ($from_email_id,$from_name,$user_mail, $user_name,$mail_subject,$pdf,$pdfName)
   {
     $message->from($from_email_id,$from_name) 
     ->to($user_mail, $user_name)
     ->attachData($pdf->output(),$pdfName, [
       'mime' => 'application/pdf',
     ])
     ->subject($mail_subject);
   });


// Mail to client

 $from_email_id=$email_adds->deposit_email_to;
 $user_mail=$email;
 // $user_mail='mkhassan25@gmail.com';
 $user_name=$name;

 $mail_subject='Ihre Anzahlung wurde erfolgreich verarbeitet';
 $from_name=config('app.name');

 Mail::send('backEnd.'.app()->getLocale().'.crm.mail.deposit-invoice-mail',
   $data, function($message)use ($from_email_id,$from_name,$user_mail, $user_name,$mail_subject,$pdf,$pdfName)
   {
     $message->from($from_email_id,$from_name) 
     ->to($user_mail, $user_name)
     ->attachData($pdf->output(),$pdfName, [
       'mime' => 'application/pdf',
     ])
     ->subject($mail_subject);
   });
  
     
        //Notifications        

     $intIds=DB::table('cms_liveaccount')->where('email',$request->email)->first();
    DB::table('admins')
      ->where('id',$intIds->manager)
      ->orWhere([
        'country_access'=>'All',
        'manager'=>0
    ])
      ->orWhere([
        'country_access'=>$intIds->country,
        'manager'=>0
      ])
    ->increment('clientDeposit', 1);

    return 'success';

}

return 'failed2';

}




/*=================================
=          Perfect Money          =
=================================*/ 

public function perfectMoneyDeposit(Request $request){

  if($request->ac){
    $selected_account=$request->ac;
  }
  else{
    $selected_account="";
  }

  $accounts=DB::table('cms_account')->join('mt4_users','mt4_users.LOGIN','=','cms_account.account_no')->where([
    
    ['cms_account.email','=',session('login_email')],
    ['cms_account.account_no','<>','0'],
    ['cms_account.act_type','<>','IB'],
    ['cms_account.act_type','<>','DEMO']
])->select('cms_account.*','mt4_users.BALANCE','mt4_users.CURRENCY')->orderBy('cms_account.account_no','desc')->get();
  
  return view ('backEnd.'.app()->getLocale().'.crm.deposit.perfect-money-deposit',compact('accounts','selected_account'));
}


public function postPerfectMoneyDeposit(Request $request){

  if(is_numeric($request->amount)==false){
    return redirect('/perfect_money_deposit')->withErrors(['Bitte geben Sie einen gültigen Betrag ein']);
  }
  elseif($request->amount<1){
    return redirect('/perfect_money_deposit')->withErrors(['Minimum Perfect Money Anzahlung ist 1 USD']);
  }
  else{
    $time = time(); 
    $apc = DB::table('cms_liveaccount')->where('email',session('login_email'))->select('affiliate_prom_code')->first();
    $reference = $apc->affiliate_prom_code.$time;      
    session(['account_no' => $request->deposit_to]);
    session(['amount' => $request->amount]);
    session(['reference' => $reference]);
    session(['tr_time' => $time]);
    session(['perfectMoney' => 1]);
    Session::save();
    
    return view('backEnd.'.app()->getLocale().'.crm.deposit.perfect-money-deposit-details',compact('request','reference'));         
  }


}



public function perfectMoneyDepositSuccess(Request $request){


  if(Session::has('account_no') && Session::has('perfectMoney')){

    $sql=DB::table('cms_deposit')->insert([
      'payment_type'=>'Perfect Money',
      'account_no'=>session('account_no'),
      'reference_no'=>session('reference'),
      'email'=>session('login_email'),
      'amount'=>session('amount'),
      'transaction_fee'=>'0',
      'net_amount'=>session('amount'),
      'currency'=>'USD',
      'status'=>'0',
      'transaction_time'=>date("Y-m-d H:i:s",session('tr_time'))  
    ]);

    $account_no = session('account_no');
    Session::forget('account_no');
    Session::forget('amount');
    Session::forget('reference');
    Session::forget('tr_time');
    Session::forget('perfectMoney');
    Session::flash('msg','
    Ihre Einzahlung bei '.$account_no.' ist in Bearbeitung.');
    return redirect('/perfect_money_deposit');
  
  }
  else {
    return view('errors.'.app()->getLocale().'.404');
  }

}




public function perfectMoneyDepositCancel(){
  if(Session::has('account_no') && Session::has('perfectMoney')){

    $account_no = session('account_no');
    Session::forget('account_no');
    Session::forget('amount');
    Session::forget('reference');
    Session::forget('tr_time');
    Session::forget('perfectMoney');
    return redirect('/perfect_money_deposit')->withErrors(['Ihre Einzahlung wurde storniert. Bitte erneut versuchen.']);
   
  
  }
  else {
    return view('errors.'.app()->getLocale().'.404');
  }

}


public function perfectMoneyDepositStatus(Request $request){

  $noti = json_encode($request->all());
  DB::table('payment_notifications')->insert([
    'payment_method'=>'Perfect Money',
    'notification'=>$noti
  ]);exit;

  // $exist = DB::table('cms_deposit')->where('transaction_id',$transaction_id)->where('payment_type','Voguepay')->first();
  // if($exist){
  //   return "duplicate";
  // }
  
//   define('ALTERNATE_PHRASE_HASH',  '340EE365C338B01BFC4B0DB8F9D7C60D');

// /* Two constants below are required to act additional payment 
// 	 verification using Perfect Money API interface in purpose of 
// 	 improving security. Please fill in them with your actual data.
// 	 Please note that you also need to turn on API for your server's 
// 	 IP in your Perfect Money account.*/
//   define('PM_MEMBER_ID',  '4138191'); // Your Perfect Money member ID
//   define('PM_PASSWORD',  '$$RUETete094025$$'); // Password you use to login your account

// function additionlPaymentCheckingUsingAPI(){

// 			$f=fopen('https://perfectmoney.is/acct/historycsv.asp?AccountID='.PM_MEMBER_ID.'&PassPhrase='.PM_PASSWORD.'&startmonth='.date("m", $request->TIMESTAMPGMT).'&startday='.date("d", $request->TIMESTAMPGMT).'&startyear='.date("Y", $request->TIMESTAMPGMT).'&endmonth='.date("m", $request->TIMESTAMPGMT).'&endday='.date("d", $request->TIMESTAMPGMT).'&endyear='.date("Y", $request->TIMESTAMPGMT).'&paymentsreceived=1&batchfilter='.$request->PAYMENT_BATCH_NUM, 'rb');
// 			if($f===false) return 'error openning url';

// 			$lines=array();
// 			while(!feof($f)) array_push($lines, trim(fgets($f)));

// 			fclose($f);

// 			if($lines[0]!='Time,Type,Batch,Currency,Amount,Fee,Payer Account,Payee Account,Payment ID,Memo'){
// 				 return $lines[0];
// 			}else{

// 				 $ar=array();
// 				 $n=count($lines);
// 				 if($n!=2) return 'payment not found';

// 				 $item=explode(",", $lines[1], 10);
// 				 if(count($item)!=10) return 'invalid API output';
// 				 $item_named['Time']=$item[0];
// 				 $item_named['Type']=$item[1];
// 				 $item_named['Batch']=$item[2];
// 				 $item_named['Currency']=$item[3];
// 				 $item_named['Amount']=$item[4];
// 				 $item_named['Fee']=$item[5];
// 				 $item_named['Payer Account']=$item[6];
// 				 $item_named['Payee Account']=$item[7];
// 				 $item_named['Payment ID']=$item[8];
// 				 $item_named['Memo']=$item[9];

// 				 if($item_named['Batch']==$request->PAYMENT_BATCH_NUM && $request->PAYMENT_ID==$item_named['Payment ID'] && $item_named['Type']=='Income' && $request->PAYEE_ACCOUNT==$item_named['Payee Account'] && $request->PAYMENT_AMOUNT==$item_named['Amount'] && $request->PAYMENT_UNITS==$item_named['Currency'] && $request->PAYER_ACCOUNT==$item_named['Payer Account']){
// 						return 'OK';
// 				 }else{
// 						return "Some payment data not match: 
// batch:  {$request->PAYMENT_BATCH_NUM} vs. {$item_named['Batch']} = ".(($item_named['Batch']==$request->PAYMENT_BATCH_NUM) ? 'OK' : '!!!NOT MATCH!!!')."
// payment_id:  {$request->PAYMENT_ID} vs. {$item_named['Payment ID']} = ".(($item_named['Payment ID']==$request->PAYMENT_ID) ? 'OK' : '!!!NOT MATCH!!!')."
// type:  Income vs. {$item_named['Type']} = ".(('Income'==$item_named['Type']) ? 'OK' : '!!!NOT MATCH!!!')."
// payee_account:  {$request->PAYEE_ACCOUNT} vs. {$item_named['Payee Account']} = ".(($item_named['Payee Account']==$request->PAYEE_ACCOUNT) ? 'OK' : '!!!NOT MATCH!!!')."
// amount:  {$request->PAYMENT_AMOUNT} vs. {$item_named['Amount']} = ".(($item_named['Amount']==$request->PAYMENT_AMOUNT) ? 'OK' : '!!!NOT MATCH!!!')."
// currency:  {$request->PAYMENT_UNITS} vs. {$item_named['Currency']} = ".(($item_named['Currency']==$request->PAYMENT_UNITS) ? 'OK' : '!!!NOT MATCH!!!')."
// payer account:  {$request->PAYER_ACCOUNT} vs. {$item_named['Payer Account']} = ".(($item_named['Payer Account']==$request->PAYER_ACCOUNT) ? 'OK' : '!!!NOT MATCH!!!');
// 				 }

// 			}

// }

// // Path to directory to save logs. Make sure it has write permissions.
// define('PATH_TO_LOG',  '/somewhere/out/of/document_root/');

// $string=
//       $request->PAYMENT_ID.':'.$request->PAYEE_ACCOUNT.':'.
//       $request->PAYMENT_AMOUNT.':'.$request->PAYMENT_UNITS.':'.
//       $request->PAYMENT_BATCH_NUM.':'.
//       $request->PAYER_ACCOUNT.':'.ALTERNATE_PHRASE_HASH.':'.
//       $request->TIMESTAMPGMT;

// $hash=strtoupper(md5($string));

// /* 
//    Please use this tool to see how valid hash is genereted: 
//    https://perfectmoney.is/acct/md5check.html 
// */
// if($hash==$request->V2_HASH){ // proccessing payment if only hash is valid

//    /* In section below you must implement comparing of data you recieved
//    with data you sent. This means to check if $request->PAYMENT_AMOUNT is
//    particular amount you billed to client and so on. */

   

//    if($request->PAYMENT_AMOUNT=='15.95' && $request->PAYEE_ACCOUNT=='U1234567' && $request->PAYMENT_UNITS=='USD'){

// 			$apcua=additionlPaymentCheckingUsingAPI();
// 			if($apcua=='OK'){

// 				/* ...insert some code to proccess valid payments here... */

// 				// uncomment code below if you want to log successfull payments
// 				/* $f=fopen(PATH_TO_LOG."good.log", "ab+");
// 				fwrite($f, date("d.m.Y H:i")."; POST: ".serialize($_POST)."; STRING: $string; HASH: $hash\n");
// 				fflush($f);
// 				fclose($f); */
				
// 			}else{	// you can also save invalid payments for debug purposes

// 				// uncomment code below if you want to log requests with fake data
// 				/* $f=fopen(PATH_TO_LOG."bad.log", "ab+");
// 				fwrite($f, date("d.m.Y H:i")."; REASON: additional checking failed with error(s): ".$apcua."; POST: ".serialize($_POST)."; STRING: $string; HASH: $hash\n");
// 				fflush($f);
// 				fclose($f); */

// 			}

//    }else{ // you can also save invalid payments for debug purposes

//       // uncomment code below if you want to log requests with fake data
//       /* $f=fopen(PATH_TO_LOG."bad.log", "ab+");
//       fwrite($f, date("d.m.Y H:i")."; REASON: fake data; POST: ".serialize($_POST)."; STRING: $string; HASH: $hash\n");
// 			fflush($f);
//       fclose($f); */

//    }


// }else{ // you can also save invalid payments for debug purposes

//    // uncomment code below if you want to log requests with bad hash
//    /* $f=fopen(PATH_TO_LOG."bad.log", "ab+");
//    fwrite($f, date("d.m.Y H:i")."; REASON: bad hash; POST: ".serialize($_POST)."; STRING: $string; HASH: $hash\n");
// 	 fflush($f);
//    fclose($f); */

// }
}



/*=================================
=          VOGUEPAY               =
=================================*/ 

public function voguepayDeposit(Request $request)
{

  if($request->ac){
    $selected_account=$request->ac;
  }
  else{
    $selected_account="";
  }

  $accounts=DB::table('cms_account')->join('mt4_users','mt4_users.LOGIN','=','cms_account.account_no')->where([
    
    ['cms_account.email','=',session('login_email')],
    ['cms_account.account_no','<>','0'],
    ['cms_account.act_type','<>','IB'],
    ['cms_account.act_type','<>','DEMO']
])->select('cms_account.*','mt4_users.BALANCE')->orderBy('cms_account.account_no','desc')->get();

  return view ('backEnd.'.app()->getLocale().'.crm.deposit.voguepay-deposit',compact('accounts','selected_account'));
}

public function postVoguepayDeposit(Request $request){
  if(is_numeric($request->amount)==false){
    return redirect('/voguepay_deposit')->withErrors(['Bitte geben Sie einen gültigen Betrag ein']);
  }
  elseif($request->amount<1){
    return redirect('/voguepay_deposit')->withErrors(['Die Mindesteinzahlung für Voguepay beträgt 1 USD']);
  }
  else{
    $time = time();
    
    $apc = DB::table('cms_liveaccount')->where('email',session('login_email'))->select('affiliate_prom_code')->first();
    $reference = $apc->affiliate_prom_code.$time;
    // echo $reference;exit;
    $sql=DB::table('payment_predata')->insert([
        'payment_type'=>'Voguepay',
        'account_no'=>$request->deposit_to,
        'reference_no'=>$reference,
        'email'=>session('login_email'),
        'amount'=>$request->amount,
        'transaction_fee'=>'0',
        'net_amount'=>$request->amount,
        'currency'=>'USD',
        'status'=>'0',
        'transaction_time'=>date("Y-m-d H:i:s",$time)  
      ]); 
    
    return view('backEnd.'.app()->getLocale().'.crm.deposit.voguepay-deposit-details',compact('request','reference'));          
  }

}





public function voguepayDepositNotify(Request $request){
  
  if($request->transaction_id){

  $merchant_id = 'demo';
  $transaction_id = $request->transaction_id;

  $exist = DB::table('cms_deposit')->where('transaction_id',$transaction_id)->where('payment_type','Voguepay')->first();
  if($exist){
    return "duplicate";
  }

  $ch = curl_init();
  $headers = array(
    'Accept: application/json',
    'Content-Type: application/json'
    );
   curl_setopt($ch, CURLOPT_URL, 'https://voguepay.com/?v_transaction_id='.$transaction_id.'&type=json&demo=true');
  
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  $serverOutput = curl_exec($ch);
  curl_close($ch);
  // echo $serverOutput;exit;
  DB::table('payment_notifications')->insert([
    'payment_method'=>'Voguepay',
    'notification'=>$serverOutput
  ]);
  $serverOutput = json_decode($serverOutput,true);
  
  if (isset($serverOutput['status']) && $serverOutput['status'] == 'Approved' && $serverOutput['merchant_id'] == $merchant_id && $serverOutput['cur'] == '$') {

    $predata = DB::table('payment_predata')->where('reference_no',$serverOutput['merchant_ref'])->where('payment_type','Voguepay')->where('amount',$serverOutput['total_amount'])->first();
    if($predata){

      // Deposit to MT4

    $server_configs = $this->serverConfigs();
    $server = $server_configs->server;
    $server_login = $server_configs->login;
    $server_password = $server_configs->password;
    $amount = $predata->amount;
    $deposit_to = $predata->account_no;
    $reference = $predata->reference_no;
    $email = $predata->email;
    $transaction_fee = $predata->transaction_fee;
    $net_amount = $predata->net_amount;
    $currency = $predata->currency;
    $transaction_time = $serverOutput['date'];
    $payment_email = $serverOutput['email'];

    $comment="Voguepay DP#".$reference;

    $a=exec(storage_path('/api/DepositBalanceWeb.exe')." \"".$server."\" \"".$server_login."\" \"".$server_password."\" \"".$deposit_to."\" \"".$amount."\" \"".$comment); 

    if($a!='Successful'){
      return "failed";
    }


    // Insert into table

    $sql=DB::table('cms_deposit')->insert([
      'payment_type'=>'Voguepay',
      'payment_email'=>$payment_email,
      'account_no'=>$deposit_to,
      'reference_no'=>$reference,
      'email'=>$email,
      'amount'=>$amount,
      'transaction_fee'=>$transaction_fee,
      'net_amount'=>$amount,
      'currency'=>$currency,
      'status'=>'1',
      'transaction_id'=>$transaction_id,
      'transaction_time'=>$transaction_time

    ]); 

    /* ********************* insert into cc_log **************************************** */


    $insert=DB::table('cms_log')
    ->insert(
      ['ref_id' => $reference,
      'table_name'=>'cms_deposit',
      'naration'=>'account_no = '.$deposit_to,
      'ip_address'=>$_SERVER['REMOTE_ADDR'],

      'date_time'=>$transaction_time
    ]
  );

    /* ********************* End insert into cc_log **************************************** */

    $cms_account=DB::table('cms_account')->where([
      ['email',$email],
      ['account_no',$deposit_to]
    ])->first();

    
    // Notification Mail to Accounts Section

    $profile=DB::table('cms_liveaccount')->where('email',$email)->first();
    $name=$profile->fname." ".$profile->lname;
    $mobile=$profile->mobile;
    $address=$profile->address;   

    $email_adds = $this->email_adds();
    $from_email_id=$email_adds->deposit_email_from;
    $from_name='Client Deposit';

    $user_mail=$email_adds->deposit_email_to;
    // $user_mail='mkhassan25@gmail.com';
    $user_name=config('app.name');

    $mail_subject='New Voguepay Deposit From Client';
    $from_name='Client Deposit';
    $email_adds = DB::table('cms_email_addresses')->first();
    $data = array(
     'name' => $name,
     'reference_no' => $reference,
     'email'=>$email,
     'mobile'=>$mobile,
     'address'=>$address,
     'support_email'=>$email_adds->support_email,     
     'amount'=>$amount,
     'payment_type'=>'Voguepay',
     'transaction_id'=>$transaction_id,
     'account'=>$deposit_to,
     'deposit_to'=>$deposit_to.' ('.$cms_account->act_type.')',
     'transaction_time'=>$transaction_time
   );

    $pdf = PDF::loadView('backEnd.'.app()->getLocale().'.crm.mail.deposit-invoice-mail', $data);
    $pdfName="VoguepayDepositBy".$deposit_to.".pdf";
    

    Mail::send('backEnd.'.app()->getLocale().'.crm.mail.deposit-invoice-mail',
      $data, function($message)use ($from_email_id,$from_name,$user_mail, $user_name,$mail_subject,$pdf,$pdfName)
      {
        $message->from($from_email_id,$from_name) 
        ->to($user_mail, $user_name)
        ->attachData($pdf->output(),$pdfName, [
          'mime' => 'application/pdf',
        ])
        ->subject($mail_subject);
      });


// Mail to client

    $from_email_id=$email_adds->deposit_email_to;
    $user_mail=$email;
    // $user_mail='mkhassan25@gmail.com';
    $user_name=$name;

    $mail_subject='Ihre Anzahlung wurde erfolgreich verarbeitet';
    $from_name=config('app.name');

    Mail::send('backEnd.'.app()->getLocale().'.crm.mail.deposit-invoice-mail',
      $data, function($message)use ($from_email_id,$from_name,$user_mail, $user_name,$mail_subject,$pdf,$pdfName)
      {
        $message->from($from_email_id,$from_name) 
        ->to($user_mail, $user_name)
        ->attachData($pdf->output(),$pdfName, [
          'mime' => 'application/pdf',
        ])
        ->subject($mail_subject);
      });


        //Notifications

    DB::table('admins')
    ->where('id',$profile->manager)
    ->orWhere([
      'country_access'=>'All',
      'manager'=>0
    ])
    ->orWhere([
      'country_access'=>$profile->country,
      'manager'=>0
    ])
    ->increment('clientDeposit', 1);

    }

    else{
      return "failed";
    }
  
  }

  return "success";

}
  else{
    return "failed";
  }
}





/*=================================
=          Citigate               =
=================================*/ 

public function citigateStat(Request $request){
  return $request->TransTypeID;
}

public function citigateDeposit(){

  $info=DB::table('cms_liveaccount')->where('email',session::get('login_email'))->first();
  if(!$info->bank_name || !$info->bank_acc_name || !$info->bank_address || !$info->bank_acc_num || !$info->iban_num || !$info->swift_num || !$info->bank_residence_country || !$info->bank_residence_state || !$info->bank_residence_city || !$info->bank_residence_code){
    Session::flash('bank-info','Please Update Your Bank Information');
    return redirect('/bank-information');
  }

  $accounts=DB::table('cms_account')->where([
    ['email',session::get('login_email')],
    ['account_no','<>','0'],
    ['act_type','<>','IB'],
    ['act_type','<>','DEMO']
  ])->get();
  foreach($accounts as $account){
    $balance=DB::table('mt4_users')->where('LOGIN',$account->account_no)->first();
    if($balance){
      $account->BALANCE=$balance->BALANCE;
    }
    else{
      $account->BALANCE=0;
    }
  }
  return view ('backEnd.'.app()->getLocale().'.crm.deposit.citigate-deposit',compact('accounts'));
}

public function postCitigateDeposit(Request $request){
  if(is_numeric($request->amount)==false){
    return redirect('/citigate_deposit')->withErrors(['Please Enter a valid amount']);
  }
  elseif($request->amount<10){
    return redirect('/citigate_deposit')->withErrors(['Minimum deposit is 10 usd']);
  }
  else{
    $reference=time();
    $amount=$request->amount*100;
    session(['account_no' => $request->deposit_to]);
    session(['amount' => $amount]);
    session(['success_amount' => $request->amount]);
    session(['reference' => $reference]);
    $signature=sha1('p@s5w0Rd123'.$reference.'USD'.$amount);
    session(['signature' => $signature]);
    Session::save();

    $info=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
    $country=DB::table('countries')->where('countries_name',$info->bank_residence_country)->first();
    if($info->bank_residence_country=='United States'){
      $state=DB::table('us_states')->where('name','like',$info->bank_residence_state)->first();
      if($state){
        $state=$state->abv;
      }
      else {
        Session::flash('state','Please Correct Your State Province First');
        return redirect('/bank-information');
      }
    }
    else{
      $state='';
    }
    return view('backEnd.'.app()->getLocale().'.crm.deposit.citigate-deposit-details',compact('request','reference','info','country','state'));          
  }
}

public function workHere()
{
  // echo session::get('success_amount')."<br>";
  // echo session::get('reference');
  if(session::get('success_amount')){


   $reference=session::get('reference');
    // Insert into table

   $sql=DB::table('cms_deposit')->insert([
    'payment_type'=>'Citigate',
    'account_no'=>session::get('account_no'),
    'reference_no'=>$reference,
    'email'=>session::get('login_email'),
    'amount'=>session::get('success_amount'),
    'transaction_fee'=>'0',
    'net_amount'=>session::get('success_amount'),
    'currency'=>'USD',
    'status'=>'0',
    'transaction_time'=>date("Y-m-d H:i:s",$reference)
    

  ]); 


   /* ********************* insert into cc_log **************************************** */


   $insert=DB::table('cms_log')
   ->insert(
    ['ref_id' => $reference,
    'table_name'=>'cms_deposit',
    'naration'=>'account_no = '.session::get('account_no'),
    'ip_address'=>$_SERVER['REMOTE_ADDR'],

    'date_time'=>date("Y-m-d H:i:s",$reference)
  ]
);

   /* ********************* End insert into cc_log **************************************** */

   $cms_account=DB::table('cms_account')->where([
    ['email',session::get('login_email')],
    ['account_no',session::get('account_no')]
  ])->first();


       // Notification Mail to Accounts Section

   $profile=DB::table('cms_liveaccount')->where('email',session::get('login_email'))->first();
   $name=$profile->fname." ".$profile->lname;
   $data = array(
     'name' => $name ,
     'reference' => $reference,
     'email'=>session::get('login_email'),
     'amount'=>session::get('success_amount'),
     'payment_type'=>'Citigate',
     'account'=>session::get('account_no'),
     'deposit_to'=>session::get('account_no').' ('.$cms_account->act_type.')'
   );

   $email_adds = $this->email_adds();
$from_email_id=$email_adds->deposit_email_from;
$from_name='Client Deposit';

$user_mail=$email_adds->deposit_email_to;
$user_name=config('app.name');

 $mail_subject='New Deposit From Client';



   Mail::send('backEnd.'.app()->getLocale().'.crm.mail.deposit-mail',
    $data, function($message)use ($from_email_id,$from_name,$user_mail, $user_name,$mail_subject)
    {
      $message->from($from_email_id,$from_name);
      $message->to($user_mail, $user_name)->subject($mail_subject);
    });

        //Notifications

   $intIds=DB::table('cms_liveaccount')->where('email',session::get('login_email'))->first();
   DB::table('admins')
   ->where('id',$intIds->manager)
   ->orWhere([
    'country_access'=>'All',
    'manager'=>0
  ])
   ->orWhere([
    'country_access'=>$intIds->country,
    'manager'=>0
  ])
   ->increment('clientDeposit', 1);


    // Deposit to MT4


   $server_configs=$this->serverConfigs();
   $server=$server_configs->server;
   $server_login=$server_configs->login;
   $server_password=$server_configs->password;
   $amount=session::get('success_amount');

   $deposit_to=session::get('account_no');

   $comment="Citigate DP#".$reference;
   $a=exec(storage_path('/api/DepositBalanceWeb.exe')." \"".$server."\" \"".$server_login."\" \"".$server_password."\" \"".$deposit_to."\" \"".$amount."\" \"".$comment); 

   if($a!='Successful'){
    return Redirect::back();
  }


  Session::flash('msg','Your Deposit has been processed successfully to '.session::get('account_no').' ('.$cms_account->act_type.')');

  Session::forget('reference');
  Session::forget('amount'); 
  Session::forget('success_amount'); 


  Session::forget('account_no');

// echo "account deposited successfully";

  return redirect('/citigate_deposit');

}
else {
  return view('errors.'.app()->getLocale().'.404');
}

}

public function citigateDepositSuccess(){
  // return redirect('/fdfd');
  // return session::get('success_amount');
  if(session::get('success_amount')){


   $reference=session::get('reference');
    // Insert into table

   $sql=DB::table('cms_deposit')->insert([
    'payment_type'=>'Citigate',
    'account_no'=>session::get('account_no'),
    'reference_no'=>$reference,
    'email'=>session::get('login_email'),
    'amount'=>session::get('success_amount'),
    'transaction_fee'=>'0',
    'net_amount'=>session::get('success_amount'),
    'currency'=>'USD',
    'status'=>'0',
    'transaction_time'=>date("Y-m-d H:i:s",$reference)


  ]); 

   /* ********************* insert into cc_log **************************************** */


   $insert=DB::table('cms_log')
   ->insert(
    ['ref_id' => $reference,
    'table_name'=>'cms_deposit',
    'naration'=>'account_no = '.session::get('account_no'),
    'ip_address'=>$_SERVER['REMOTE_ADDR'],

    'date_time'=>date("Y-m-d H:i:s",$reference)
  ]
);

   /* ********************* End insert into cc_log **************************************** */

   $cms_account=DB::table('cms_account')->where([
    ['email',session::get('login_email')],
    ['account_no',session::get('account_no')]
  ])->first();



    // Notification Mail to Accounts Section

   $profile=DB::table('cms_liveaccount')->where('email',session::get('login_email'))->first();
   $name=$profile->fname." ".$profile->lname;
   $data = array(
     'name' => $name ,
     'reference' => $reference,
     'email'=>session::get('login_email'),
     'amount'=>session::get('success_amount'),
     'payment_type'=>'Citigate',

     'account'=>session::get('account_no'),
     'deposit_to'=>session::get('account_no').' ('.$cms_account->act_type.')'


   );

   $email_adds = $this->email_adds();
$from_email_id=$email_adds->deposit_email_from;
$from_name='Client Deposit';

$user_mail=$email_adds->deposit_email_to;
$user_name=config('app.name');

 $mail_subject='New Deposit From Client';



   Mail::send('backEnd.'.app()->getLocale().'.crm.mail.deposit-mail',
    $data, function($message)use ($from_email_id,$from_name,$user_mail, $user_name,$mail_subject)
    {
      $message->from($from_email_id,$from_name);
      $message->to($user_mail, $user_name)->subject($mail_subject);
    });

        //Notifications


   $intIds=DB::table('cms_liveaccount')->where('email',session::get('login_email'))->first();
   DB::table('admins')
   ->where('id',$intIds->manager)
   ->orWhere([
    'country_access'=>'All',
    'manager'=>0
  ])
   ->orWhere([
    'country_access'=>$intIds->country,
    'manager'=>0
  ])
   ->increment('clientDeposit', 1);


    // Deposit to MT4

   $server_configs=$this->serverConfigs();
   $server=$server_configs->server;
   $server_login=$server_configs->login;
   $server_password=$server_configs->password;
   $amount=session::get('success_amount');

   $deposit_to=session::get('account_no');

   $comment="Citigate DP#".$reference;
   $a=exec(storage_path('/api/DepositBalanceWeb.exe')." \"".$server."\" \"".$server_login."\" \"".$server_password."\" \"".$deposit_to."\" \"".$amount."\" \"".$comment); 

   if($a!='Successful'){
    return Redirect::back();
  }




  Session::flash('msg','Your Deposit has been processed successfully to '.session::get('account_no').' ('.$cms_account->act_type.')');

  Session::forget('reference');
  Session::forget('amount'); 
  Session::forget('success_amount'); 


  Session::forget('account_no');



  return redirect('/citigate_deposit');




}
else {
  return view('errors.'.app()->getLocale().'.404');
}

}




public function citigateDepositCancel(){

    // if(session('amount')){
  Session::forget('reference');
  Session::forget('amount'); 
  Session::forget('success_amount');
  Session::forget('account_no'); 
  return redirect('/citigate_deposit')->withErrors(['Your Deposit has been cancelled. Please Retry.']);
// }
// else {
//   return view('errors.'.app()->getLocale().'.404');
// }
}


// public function citigateDepositNotify(){
//   Session::forget('reference');
// Session::forget('amount'); 
// Session::forget('success_amount'); 
// Session::forget('account_no');
// return redirect('/citigate_deposit');
// }





}
