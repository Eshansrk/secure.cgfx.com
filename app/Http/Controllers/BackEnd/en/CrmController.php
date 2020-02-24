<?php

namespace App\Http\Controllers\BackEnd\en;
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
use Datatables; 
use PDF;
use App\Http\Requests\BankInformationRequest;

class CrmController extends Controller
{
  public function __construct()
  {
    $this->middleware('adminAccess');
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
   'header_color' => $general_information->header_color
 );
    return $mail_data;

  }


/*=================================
=          Error 404              =
=================================*/

public function errorNotFound(){
 return view('errors.'.app()->getLocale().'.404');
}




public function testMailPdf()
{

  $data = array(
   'name' => 'Saif',
   'reference' => '123456',
   'email'=>session('login_email'),
   'amount'=>12,
   'payment_type'=>'Test',
   'transaction_id'=>'tr123',
   'account'=>'123',
   'deposit_to'=>'123 (Standard)'


 );

  $pdf = PDF::loadView('backEnd.'.app()->getLocale().'.crm.mail.deposit-mail', $data);

 $from_email_id='test@netcoden.com';

 $user_mail='mkhassan25@gmail.com';
 $user_name='Netcoden Test';

 $mail_subject='New Deposit From Client';
 $from_name='Client Deposit';
 Mail::send('backEnd.'.app()->getLocale().'.crm.mail.deposit-mail',
  $data, function($message)use ($from_email_id,$from_name,$user_mail, $user_name,$mail_subject,$pdf)
  {
    $message->from($from_email_id,$from_name) 
            ->to($user_mail, $user_name)
            ->attachData($pdf->output('deposit-mail'),'voguepay-deposit-123456.pdf', [
                        'mime' => 'application/pdf',
                    ])
            ->subject($mail_subject);
  });

}



/*=================================
=          Dashboard              =
=================================*/



public function getIndex(Request $request){

      // Trading Accounts with balance


      $accounts=DB::table('cms_account')->join('mt4_users','mt4_users.LOGIN','=','cms_account.account_no')->where([
        ['cms_account.email','=',session('login_email')],
        ['cms_account.account_no','<>','0'],
        ['cms_account.act_type','<>','IB'],
        ['cms_account.act_type','<>','DEMO']
    ])->orderBy('account_no','desc')->limit(5)->select('cms_account.account_no','cms_account.act_type','cms_account.leverage','mt4_users.BALANCE')->get();






      // ORDERS (Total closed/running trades)


  $all_accounts=DB::table('cms_account')->join('mt4_users','mt4_users.LOGIN','=','cms_account.account_no')->where([
    ['cms_account.email',session('login_email')],
    ['cms_account.account_no','<>','0'],
    ['cms_account.act_type','<>','IB'],
    ['cms_account.act_type','<>','DEMO']
  ])->select('cms_account.account_no')->get();


  $order=0;
  $volume=0;
  $running_trades=0;
  foreach($all_accounts as $account){
    $histories=DB::table('mt4_trades')->where([
      ['LOGIN',$account->account_no],
      ['CMD','0'],
      ['CLOSE_TIME','<>','1970-01-01 00:00:00']
    ])->orWhere([
      ['LOGIN',$account->account_no],
      ['CMD','1'],
      ['CLOSE_TIME','<>','1970-01-01 00:00:00']
    ])->get();

    $order+=count($histories);

    foreach($histories as $history){
      $volume+=$history->VOLUME;
    }

    $run_trades=DB::table('mt4_trades')->where([
      ['LOGIN',$account->account_no],
      ['CMD','0'],
      ['CLOSE_TIME','1970-01-01 00:00:00']
    ])->orWhere([
      ['LOGIN',$account->account_no],
      ['CMD','1'],
      ['CLOSE_TIME','1970-01-01 00:00:00']
    ])->get();
    $running_trades+=count($run_trades);
  }

  $volume=$volume/100;
      // TOTAL BALANCE


  $balance=0;
  foreach($all_accounts as $account){
    $balances=DB::table('mt4_users')->where([
      ['LOGIN',$account->account_no]
    ])->first();
    
    if($balances){
      $balance+=$balances->BALANCE;
    }
    else{
      $balance=0;
    }

    
  }
  $balance=round($balance,2);

      // TOTAL EQUITY


  $equity=0;
  foreach($all_accounts as $account){
    $equities=DB::table('mt4_users')->where([
      ['LOGIN',$account->account_no]
    ])->first();
    if($equities){
      $equity+=$equities->EQUITY;
    }
    else{
      $equity=0;
    }
  }
  $equity=round($equity,2);



      // TOTAL DEPOSIT


  $deposit=0;
  foreach($all_accounts as $account){
    $histories=DB::table('mt4_trades')->where([
      ['LOGIN',$account->account_no],
      ['CMD','6'],
      ['PROFIT','>','0'],
    ])->get();
    foreach($histories as $his){
      $deposit+=$his->PROFIT;
    }
  }
  $deposit=round($deposit,2);



      // TOTAL Credited Amount


  $cr_in=0;
  $cr_out=0;
  foreach($all_accounts as $account){
    $credited=DB::table('mt4_trades')->where([
      ['LOGIN',$account->account_no],
      ['CMD','7'],
      ['PROFIT','>','0'],
    ])->get();
    foreach($credited as $cred){
      $cr_in+=$cred->PROFIT;
    }
    $credited=DB::table('mt4_trades')->where([
      ['LOGIN',$account->account_no],
      ['CMD','7'],
      ['PROFIT','<','0'],
    ])->get();
    foreach($credited as $cred){
      $cr_out+=$cred->PROFIT;
    }
  }
  if($cr_out!=0){
    $cr_out=(-1)*round($cr_out,2);
  }

      // TOTAL Withdrawal


  $withdraw=0;
  foreach($all_accounts as $account){
    $histories=DB::table('mt4_trades')->where([
      ['LOGIN',$account->account_no],
      ['CMD','6'],
      ['PROFIT','<','0'],
    ])->get();
    foreach($histories as $his){
      $withdraw+=$his->PROFIT;
    }
  }
  if($withdraw!=0){
    $withdraw=(-1)*round($withdraw,2);
  }

      // TOTAL Internal Transfer


  $in_tr=0;
  foreach($all_accounts as $account){
    $inter_trans=DB::table('cms_internal_transfer')->where([
      ['from_account',$account->account_no]

    ])->get();
    foreach($inter_trans as $intr){
      $in_tr+=$intr->amount;
    }
  }
  $in_tr=round($in_tr,2);


      // Transaction History


  return view('backEnd.'.app()->getLocale().'.crm.index2',compact('order','volume','balance','equity','deposit','cr_in','cr_out','withdraw','in_tr','accounts','all_accounts'));
}



/*=================================
=      Become A Partner      =
=================================*/

public function becomeIB(Request $request){

   $client_email = $request->email;
   $ib_status= $request->status;
   
   // dd($ib_status);
   DB::table('cms_liveaccount')
  ->where('email', session('login_email'))
  ->update([
    'ib_status' => $ib_status,
    
  ]);

   $info=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
   // dd($info);

                    $email_adds = $this->email_adds();
                    $from_email_id=$email_adds->deposit_email_to;
                    $from_name=config('app.name');

                    // $user_mail=$info->email;
                    
                    $user_mail='mkhassan25@gmail.com';

                    $name=$info->fname." ".$info->lname;
                    $email=$info->email;
                    $mobile=$info->mobile;
                    $country_name=$info->country;
                    $city_name=$info->city;

                    $mail_data=$this->mail_data();
                    
                    $mail_subject='Request for IB';
                    $data=array(
                        'name'=>$name,
                        'email'=>$email,
                        'mobile'=>$mobile,
                        'country'=>$country_name,
                        'city'=>$city_name,
                        'mail_data' => $mail_data
                      ); 

                    Mail::send('backEnd.'.app()->getLocale().'.crm.mail.become_an_ib_mail',
                            $data, function($message)use ($user_mail,$mail_subject,$from_email_id,$from_name)
                        {
                            $message->from($from_email_id,$from_name);
                            $message->to($user_mail)->subject($mail_subject);
                        });

      return 'success';
}



/*=================================
=      All Trading Accounts       =
=================================*/

public function allTradingAccounts(){

  $accounts=DB::table('cms_account')->join('mt4_users','mt4_users.LOGIN','=','cms_account.account_no')->where([
    
    ['cms_account.email','=',session('login_email')],
    ['cms_account.account_no','<>','0'],
    ['cms_account.act_type','<>','IB'],
    ['cms_account.act_type','<>','DEMO']
])->select('cms_account.*','mt4_users.*')->orderBy('cms_account.account_no','desc')->get();


foreach($accounts as $ac){
  $running=DB::table('mt4_trades')->where('mt4_trades.LOGIN',$ac->account_no)->where('mt4_trades.CLOSE_TIME','1970-01-01 00:00:00')->count();
  $ac->running_trades=$running;
}
 

return view('backEnd.'.app()->getLocale().'.crm.trading.all-trading-accounts',compact('accounts'));

}



/*=================================
=    Download Trading Platforms   =
=================================*/


public function downloadPlatforms(){
  $server_configs = DB::table('server_configs')->select('download_link')->first();
  $download_link = $server_configs->download_link;
  return view('backEnd.'.app()->getLocale().'.crm.trading.download-platforms',compact('download_link'));
}







// Live Trade for curtain account

public function ajaxLiveTrade(Request $request){
  $accounts=DB::table('cms_account')->where(
    'account_no',$request->id)->first();
  $trades=DB::table('mt4_trades')->where([
    ['LOGIN',$request->id],
    ['CLOSE_TIME','1970-01-01 00:00:00']
  ])->orderBy('TICKET', 'desc')->get();


  

  if(count($trades)>0){
    foreach($trades as $trade){
      if($trade->CMD=='0'){
        $cmd='Buy';
      }
      elseif ($trade->CMD=='1'){
        $cmd='Sell';
      }
      else{
        $cmd='';
      }
      $open_time=$trade->OPEN_TIME;
      $open_time=strtotime($open_time);
      $open_time=date('m/d/y',$open_time);
      $lots=$trade->VOLUME/100;


      echo '
      <tr>
      <td>'.$trade->TICKET.'</td>
      <td>'.$open_time.'</td>
      <td>'.$cmd.'</td>
      <td>'.$lots.'</td>
      <td>'.$trade->SYMBOL.'</td>
      <td>'.$trade->OPEN_PRICE.'</td>
      <td>'.$trade->SL.'</td>
      <td>'.$trade->TP.'</td>
      <td>'.$trade->CLOSE_PRICE.'</td>
      <td>'.$trade->COMMISSION.'</td>
      <td>'.$trade->SWAPS.'</td>
      <td>'.$trade->PROFIT.'</td>
      </tr>';
    }
  }
  else{

    echo '<tr><td colspan="14" style="text-align:center;"><strong>No Running Trade</strong></td></tr>';
  } 
  


  

}



/*=================================
=            Live Trades          =
=================================*/

public function getLiveTrades(){

  // DB::raw('(CASE WHEN mt4_trades.CMD = 0 THEN "Buy" WHEN mt4_trades.CMD = 1 THEN "Sell" ELSE "" END) as cmd'


  $accounts=DB::table('cms_account')->join('mt4_trades','mt4_trades.Login','cms_account.account_no')->join('mt4_users','mt4_users.Login','cms_account.account_no')->where([
    
    ['cms_account.email','=',session('login_email')],
    ['cms_account.account_no','<>','0'],
    ['cms_account.act_type','<>','IB'],
    ['cms_account.act_type','<>','DEMO'],
    ['mt4_trades.CLOSE_TIME','1970-01-01 00:00:00']
])->select('cms_account.*','mt4_users.*')->orderBy('cms_account.account_no','desc')->groupBy('mt4_trades.LOGIN')->get();

  $live_trades = DB::table('cms_account')->Join('mt4_trades','cms_account.account_no','=','mt4_trades.LOGIN')->Join('mt4_users','cms_account.account_no','=','mt4_users.LOGIN')->select('cms_account.account_no','cms_account.act_type','mt4_users.BALANCE','mt4_users.LEVERAGE','mt4_users.EQUITY')->where([['cms_account.email','=',session('login_email')],['cms_account.account_no','<>',0],['cms_account.act_type','<>','IB'],['cms_account.act_type','<>','DEMO'],['mt4_trades.CLOSE_TIME','1970-01-01 00:00:00']])->orderBy('mt4_trades.TICKET', 'desc')->get();

  return view('backEnd.'.app()->getLocale().'.crm.trading.live-trades',compact('accounts','live_trades'));
}




/*=================================
=          Trading Details        =
=================================*/

public function tradingDetails(Request $request){

  $check=CMS_Account::where([
    ['account_no',$request->id],
    ['email',session('login_email')]
  ])->first();
  if(!$check){
    return view('errors.'.app()->getLocale().'.404');
  }

 $accounts=DB::table('cms_account')->join('mt4_users','mt4_users.LOGIN','=','cms_account.account_no')->where([
  ['cms_account.account_no',$request->id]
])->select('cms_account.*','mt4_users.*')->first();


 $trades=DB::table('mt4_trades')->orderBy('mt4_trades.TICKET', 'desc')->where([
  ['mt4_trades.CLOSE_TIME','1970-01-01 00:00:00'],
  ['mt4_trades.LOGIN',$request->id]
])->get();


 return view('backEnd.'.app()->getLocale().'.crm.trading.trading-details',compact('accounts','trades'));
}



public function tradingHistorySingleDatatable(Request $request){

  $check=CMS_Account::where([
    ['account_no',$request->account_no],
    ['email',session('login_email')]
  ])->first();
  if(!$check){
    return view('errors.'.app()->getLocale().'.404');
  }


  $arrStart = explode("/", $request->from);
  $arrEnd = explode("/", $request->to);
  $start = Carbon::create($arrStart[2], $arrStart[1], $arrStart[0], 0, 0, 0);
  $end = Carbon::create($arrEnd[2], $arrEnd[1], $arrEnd[0], 23, 59, 59);
  $account_no=$request->account_no;

// $start = Carbon::now()->addMonths(-1);
//   $end = Carbon::now();
//   $account_no='2100396458';
 

  $tradingHistory=DB::table('mt4_trades')->where('mt4_trades.LOGIN',$account_no)->leftJoin('mt4_users','mt4_trades.LOGIN','=','mt4_users.LOGIN')->where([['mt4_trades.CLOSE_TIME','<>','1970-01-01 00:00:00']
    ])->where('mt4_trades.CLOSE_TIME','>=',$start)->where('CLOSE_TIME','<=',$end)->select(['mt4_trades.TICKET','mt4_trades.CLOSE_TIME',DB::raw("CASE mt4_trades.CMD 
     WHEN 0 THEN CONCAT('Buy &nbsp;&nbsp;|&nbsp;&nbsp; ',mt4_trades.SYMBOL)
     WHEN 1 THEN CONCAT('Sell &nbsp;&nbsp;|&nbsp;&nbsp; ',mt4_trades.SYMBOL)
     WHEN 2 THEN CONCAT('Buy Limit &nbsp;&nbsp;|&nbsp;&nbsp; ',mt4_trades.SYMBOL)
     WHEN 3 THEN CONCAT('Sell Limit &nbsp;&nbsp;|&nbsp;&nbsp; ',mt4_trades.SYMBOL)
     WHEN 4 THEN CONCAT('Buy Stop &nbsp;&nbsp;|&nbsp;&nbsp; ',mt4_trades.SYMBOL)
     WHEN 5 THEN CONCAT('Sell Stop &nbsp;&nbsp;|&nbsp;&nbsp; ',mt4_trades.SYMBOL)
     ELSE  ''
     END as Type_c "),DB::raw("CASE  
     WHEN mt4_trades.CMD < 2 THEN round(mt4_trades.VOLUME/100,2)
     ELSE ''
     END as lots"),DB::raw("CONCAT (mt4_trades.OPEN_PRICE,' &nbsp;&nbsp;|&nbsp;&nbsp; ',mt4_trades.SL,' &nbsp;&nbsp;|&nbsp;&nbsp; ',mt4_trades.TP,' &nbsp;&nbsp;|&nbsp;&nbsp; ',mt4_trades.CLOSE_PRICE) as op"),DB::raw("CONCAT (mt4_trades.COMMISSION,' &nbsp;&nbsp;|&nbsp;&nbsp; ',mt4_trades.SWAPS) as com"),'mt4_trades.COMMENT','mt4_trades.PROFIT']);

    $datatables = Datatables::of($tradingHistory);


    return $datatables
    
    ->filterColumn('Type_c', function ($query, $keyword) {
      $query->whereRaw("CASE mt4_trades.CMD 
    WHEN 0 THEN CONCAT('Buy &nbsp;&nbsp;|&nbsp;&nbsp; ',mt4_trades.SYMBOL)
     WHEN 1 THEN CONCAT('Sell &nbsp;&nbsp;|&nbsp;&nbsp; ',mt4_trades.SYMBOL)
     WHEN 2 THEN CONCAT('Buy Limit &nbsp;&nbsp;|&nbsp;&nbsp; ',mt4_trades.SYMBOL)
     WHEN 3 THEN CONCAT('Sell Limit &nbsp;&nbsp;|&nbsp;&nbsp; ',mt4_trades.SYMBOL)
     WHEN 4 THEN CONCAT('Buy Stop &nbsp;&nbsp;|&nbsp;&nbsp; ',mt4_trades.SYMBOL)
     WHEN 5 THEN CONCAT('Sell Stop &nbsp;&nbsp;|&nbsp;&nbsp; ',mt4_trades.SYMBOL)
     ELSE  ''
     END LIKE ?", ["%$keyword%"]);
    })
    ->filterColumn('lots', function ($query, $keyword) {
      $query->whereRaw("CASE  
     WHEN mt4_trades.CMD < 2 THEN round(mt4_trades.VOLUME/100,2)
     ELSE ''
     END LIKE ?", ["%$keyword%"]);
    })
    ->filterColumn('op', function ($query, $keyword) {
      $query->whereRaw("CONCAT (mt4_trades.OPEN_PRICE,' &nbsp;&nbsp;|&nbsp;&nbsp; ',mt4_trades.SL,' &nbsp;&nbsp;|&nbsp;&nbsp; ',mt4_trades.TP,' &nbsp;&nbsp;|&nbsp;&nbsp; ',mt4_trades.CLOSE_PRICE) LIKE ?", ["%$keyword%"]);
    })
    ->filterColumn('com', function ($query, $keyword) {
      $query->whereRaw("CONCAT (mt4_trades.COMMISSION,' &nbsp;&nbsp;|&nbsp;&nbsp; ',mt4_trades.SWAPS) LIKE ?", ["%$keyword%"]);
    })

    ->make(true);
    
  }


public function tradingHistorySingleTotal(Request $request){

   $check=CMS_Account::where([
    ['account_no',$request->account_no],
    ['email',session('login_email')]
  ])->first();
  if(!$check){
    return view('errors.'.app()->getLocale().'.404');
  }


  $arrStart = explode("/", $request->from);
  $arrEnd = explode("/", $request->to);
  $start = Carbon::create($arrStart[2], $arrStart[1], $arrStart[0], 0, 0, 0);
  $end = Carbon::create($arrEnd[2], $arrEnd[1], $arrEnd[0], 23, 59, 59);
  $account_no=$request->account_no;

// $start = Carbon::now()->addMonths(-1);
//   $end = Carbon::now()->addMonths(-1);
//   $account_no='2100396458';

  $deposit=DB::table('mt4_trades')->where('mt4_trades.CMD','6')->where('mt4_trades.PROFIT','>','0')->where('mt4_trades.CLOSE_TIME','>=',$start)->where('mt4_trades.CLOSE_TIME','<=',$end)->where('mt4_trades.Login',$account_no)->sum('mt4_trades.PROFIT');

   $withdraw=DB::table('mt4_trades')->where('mt4_trades.CMD','6')->where('mt4_trades.PROFIT','<','0')->where('mt4_trades.CLOSE_TIME','>=',$start)->where('mt4_trades.CLOSE_TIME','<=',$end)->where('mt4_trades.Login',$account_no)->sum('mt4_trades.PROFIT');

  $creditIn=DB::table('mt4_trades')->where('mt4_trades.CMD','7')->where('mt4_trades.PROFIT','>','0')->where('mt4_trades.CLOSE_TIME','>=',$start)->where('mt4_trades.CLOSE_TIME','<=',$end)->where('mt4_trades.Login',$account_no)->sum('mt4_trades.PROFIT');

$creditOut=DB::table('mt4_trades')->where('mt4_trades.CMD','7')->where('mt4_trades.PROFIT','<','0')->where('mt4_trades.CLOSE_TIME','>=',$start)->where('mt4_trades.CLOSE_TIME','<=',$end)->where('mt4_trades.Login',$account_no)->sum('mt4_trades.PROFIT');

$profit=DB::table('mt4_trades')->where('mt4_trades.CMD','<','2')->where('mt4_trades.CLOSE_TIME','>=',$start)->where('mt4_trades.CLOSE_TIME','<=',$end)->where('mt4_trades.Login',$account_no)->sum('mt4_trades.PROFIT');


        
        
      echo '<b>Deposit:</b> '.round($deposit,2).', ';
      if($withdraw==0){
        echo '<b>Withdraw:</b> 0, ';
      }
      else{
      echo '<b>Withdraw:</b> '.(-1)*round($withdraw,2).', ';
      }
      echo '<b>Credit In:</b> '.round($creditIn,2).', ';
      echo '<b>Credit Out:</b> '.round($creditOut,2).', ';
      echo '<b>Profit:</b> '.round($profit,2);
      
  }






  


/*=================================
=             Profile              =
=================================*/

public function profile(){
  $countries=DB::table('countries')->get();

//   $verifies=DB::table('cms_verification')->where('email',session('login_email'))->get();
//   $status='<span style="color:red">Not Verified</span>';
//   $id_status=2;
//   $address_status=2;
//   foreach($verifies as $verify){
//     if( $verify->document_type=='ID Proof'){
//       if($verify->status==1){
//         $id_status=1;
//       }
//       if($id_status!=1){
//         if($id_status!=0){
//           $id_status=$verify->status;
//         }

//       }

//     }
//     if( $verify->document_type=='Address Proof'){
//      if($verify->status==1){
//       $address_status=1;
//     }
//     if($address_status!=1){
//       if($address_status!=0){
//         $address_status=$verify->status;
//       }
//     }
//   }

// }
// if($id_status==1 && $address_status==1){
//   $status='<span style="color:green">Verified</span>';
// }

// elseif($id_status==1 && $address_status!=1){
//   $status='<span style="color:orange">Pending</span>';
// }

// elseif($id_status!=1 && $address_status==1){
//   $status='<span style="color:orange">Pending</span>';
// }
// elseif($id_status==0 || $address_status==0){
//   $status='<span style="color:orange">Pending</span>';
// }


// else{

//   $status='<span style="color:red">Not Verified</span>';
// }
  $profile=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();

  $identity = $profile->identity;
  $resident = $profile->resident;
  $sum = $identity + $resident;
  $condition1 = $sum == 2;
  $sub_condition1 = $identity == 0 || $resident == 0;
  $condition2 = $sum == 1 || $sum == 3;
  $condition3 = $sum == 4;
  $profile_pic = $profile->profile_pic_url;

  return view('backEnd.'.app()->getLocale().'.crm.profile.profile',compact('profile','countries','condition1','sub_condition1','condition2','condition3','identity','resident','profile_pic'));
}

public function uploadProfilePic(Request $request)
{
  $client_url = DB::table('general_information')->select('client_portal_url')->first();

  $ImageName = 'profile-'.time().'.'.$request->profile_pic->getClientOriginalExtension();

  $request->profile_pic->move(public_path('/img/profile/'), $ImageName);

  DB::table('cms_liveaccount')->where('email',session('login_email'))->update([
    'profile_pic_url' => $client_url->client_portal_url.'/img/profile/'.$ImageName]);

  session(['profile_pic' => $client_url->client_portal_url.'/img/profile/'.$ImageName])->save(); 
}



public function updateProfile(){

  $countries=DB::table('countries')->get();

  $profile=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
  
  
  return view('backEnd.'.app()->getLocale().'.crm.profile.update-profile',compact('profile','countries'));
}




public function postUpdateProfile(Request $request){
  if(strlen($request->mobile)<8){
    Session::flash('mobile_error','Mobile number is too short');
    return Redirect::back();
  }
  DB::table('cms_liveaccount')
  ->where('email', session('login_email'))
  ->update([

    'country' => $request->country,
    'mobile' => preg_replace('/[^ a-zA-Z0-9,+-]/', '', $request->mobile),
    'address' => preg_replace('/[^ a-zA-Z0-9,+-]/', '', $request->address),
    'state' => preg_replace('/[^ a-zA-Z0-9,+-]/', '', $request->state),
    'city' => preg_replace('/[^ a-zA-Z0-9,+-]/', '', $request->city),
    'postal_code' => preg_replace('/[^ a-zA-Z0-9,+-]/', '', $request->zip) 
  ]);
  Session::flash('msg','Your Profile has been updated successfully');
  return Redirect::back();
}

public function notificationStatusUpdate(Request $request){
  $field = $request->field;
  $agree = $request->agree;
  DB::table('cms_liveaccount')->where('email',session('login_email'))->update([
    $field => $agree]);
}


public function verifyProfile(){



  $profile=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();

  $identity = $profile->identity;
  $resident = $profile->resident;
  $status = $identity + $resident;


  $doc=DB::table('cms_verification')->where('email',session('login_email'))->orderby('int_id','desc')->get();

  return view('backEnd.'.app()->getLocale().'.crm.profile.verify-profile',compact('status','doc'));
}



public function postVerifyProfile(Request $request){


  $this->validate($request, [

    'id_proof' => 'mimes:jpeg,png,jpg,gif,tif,tiff,pdf|max:3072',
    'address_proof' => 'mimes:jpeg,png,jpg,gif,tif,tiff,pdf|max:3072',

  ]);
  $addressImageName='';
  $idImageName='';
  $addressImage='';
  $idImage='';
  if($request->id_proof){
    $document_type="ID Proof";

    $idImageName = 'IdProof-'.time().'.'.$request->id_proof->getClientOriginalExtension();

    $request->id_proof->move(public_path('/documents/'), $idImageName);
    $intIds=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
    $intId=$intIds->intId;
    $client_url = DB::table('general_information')->select('client_portal_url')->first();
    DB::table('cms_verification')->insert([
      'document_type'=>$document_type,
      'document'=>$client_url->client_portal_url.'/documents/'.$idImageName,
      'date_time'=>date("Y-m-d H:i:s"),
      'status'=>'0',
      'email'=>session('login_email'),
      'userId'=>$intId
    ]);
    $idImage = $client_url->client_portal_url.'/documents/'.$idImageName;

  }
  if($request->address_proof){
    $document_type="Address Proof";

    $addressImageName = 'ResProof-'.time().'.'.$request->address_proof->getClientOriginalExtension();

    $request->address_proof->move(public_path('documents/'), $addressImageName);
    $intIds=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();

    $intId=$intIds->intId;
    $client_url = DB::table('general_information')->select('client_portal_url')->first();
    DB::table('cms_verification')->insert([
      'document_type'=>$document_type,
      'document'=>$client_url->client_portal_url.'/documents/'.$addressImageName,
      'date_time'=>date('Y-m-d H:i:s'),
      'status'=>'0',
      'email'=>session('login_email'),
      'userId'=>$intId
    ]);

    $addressImage = $client_url->client_portal_url.'/documents/'.$addressImageName;

  }
  if(!$request->address_proof && !$request->id_proof){
    return Redirect::back()->withErrors(['Can not be uploaded']);
  }

  

  $email_adds = $this->email_adds();

  $user_mail1=$email_adds->support_email;
  $user_mail2=$email_adds->backoffice_email;
  $from_mail=$email_adds->backoffice_email;
  
  
  $intIds=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
  $client_Name=$intIds->fname.' '.$intIds->lname;     

  $mail_subject='Client request for profile verification';
  $data=array(
    'email'=>session('login_email'),
    'name'=>$client_Name,
    'idImage'=>$idImage,
    'addressImage'=>$addressImage
  );
  Mail::send('backEnd.'.app()->getLocale().'.crm.mail.documents',
    $data, function($message) use ($user_mail1,$mail_subject,$from_mail)
    {
      $message->from($from_mail,'Client Profile Verification');
      $message->to($user_mail1, config('app.name'))->subject($mail_subject);
    });
  Mail::send('backEnd.'.app()->getLocale().'.crm.mail.documents',
    $data, function($message) use ($user_mail2,$mail_subject,$from_mail)
    {
      $message->from($from_mail,'Client Profile Verification');
      $message->to($user_mail2, config('app.name'))->subject($mail_subject);
    });
  Session::flash('msg','Your Document has been uploaded successfully');

     //Notifications


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
  ->increment('documentUpload', 1);

  return Redirect::back();



}

public function changePassword(){
  return view('backEnd.'.app()->getLocale().'.crm.profile.change-password2');
}

public function sendPasswordResetCode()
{
  $profile=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
  $general_info=DB::table('general_information')->first();
  $mail_data=$this->mail_data();
  $name=$profile->fname.' '.$profile->lname;

  $email_adds = $this->email_adds();
  $from_email_id=$email_adds->support_email;
  $from_name=config('app.name');
  $user_mail=session('login_email');
  $mail_subject='Verification Code for Password Change';
  $verification_code=mt_rand(100000, 999999);
  session(['password_verification_code' => $verification_code]);
  Session::save();
  $data = array('name' => $name , 'verification_code' => $verification_code, 'general_info_others' => $general_info, 'mail_data' => $mail_data);
  Mail::send('backEnd.'.app()->getLocale().'.crm.mail.change-password',
    $data, function($message)use ($from_email_id,$from_name,$user_mail, $name,$mail_subject)
    {
      $message->from($from_email_id,$from_name);
      $message->to($user_mail, $name)->subject($mail_subject);
    });
}

public function checkVerificationCode(Request $request){
  $code = $request->code;
  if (session('password_verification_code')==$code) {
    return 1;
  }
  else return 0;
}



public function postChangePassword(Request $request){
  if($request->new_password!=$request->confirm_new_password){
    Session::flash('error','Password does not match. Please Reenter.');
    return Redirect::back();
  }
  else{
    $profile=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
    $name=$profile->fname.' '.$profile->lname;

    $email_adds = $this->email_adds();
    $from_email_id=$email_adds->support_email;
    
    $from_name=config('app.name');;
    $user_mail=session('login_email');
    $mail_subject='Verification Code for Password Change';
    $verification_code=mt_rand(100000, 999999);
    session(['password_verification_code' => $verification_code]);
    Session::save();
    $data = array('name' => $name , 'verification_code' => $verification_code);
    Mail::send('backEnd.'.app()->getLocale().'.crm.mail.change-password',
      $data, function($message)use ($from_email_id,$from_name,$user_mail, $name,$mail_subject)
      {
        $message->from($from_email_id,$from_name);
        $message->to($user_mail, $name)->subject($mail_subject);
      });
    return view('backEnd.'.app()->getLocale().'.crm.profile.password-verification',compact('request')); 


  }

}


public function passwordVerification(Request $request){if($request->verification_code!=session('password_verification_code')){
  return view('backEnd.'.app()->getLocale().'.crm.profile.password-verification',compact('request'))->withErrors(['Verification code is incorrect. ']);
}

else{
  Session::forget('password_verification_code');
  $password=password_hash($request->new_password, PASSWORD_BCRYPT);
  DB::table('cms_liveaccount')
  ->where('email', session('login_email'))
  ->update([
    'password' => $password
  ]);
  Session::flash('msg','Your Password has been changed successfully');
  return view('backEnd.'.app()->getLocale().'.crm.profile.change-password2').redirect('/logout');
}
}

public function saveUpdatedPassword(Request $request)
{
  Session::forget('password_verification_code');
  $password=password_hash($request->pass, PASSWORD_BCRYPT);
  DB::table('cms_liveaccount')
  ->where('email', session('login_email'))
  ->update([
    'password' => $password
  ]);
  Session::flash('msg','Your Password has been changed successfully');
}


public function bankInformation(){
  $countries=DB::table('countries')->get();
  $email =session('login_email');
  $info=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
  return view('backEnd.'.app()->getLocale().'.crm.profile.bank-information',compact('countries','info')); 
}

public function postBankInformation(BankInformationRequest $request){
 DB::table('cms_liveaccount')
 ->where('email', session('login_email'))
 ->update([
  'bank_name' => $request->bank_name,
  'bank_residence_country' => $request->bank_residence_country,
  'bank_acc_name' => $request->bank_acc_name,
  'bank_acc_num' => $request->bank_acc_num,  
  'swift_num' => $request->swift_num,
  'bank_address' => $request->bank_address,
  'bank_residence_state' => $request->bank_residence_state,
  'bank_residence_city' => $request->bank_residence_city,
  'bank_residence_code' => $request->bank_residence_code
]);
 Session::flash('success','Bank information updated successfully');
 return Redirect::back();         
}


/*=================================
=       Open Demo Account      =
=================================*/

public function openDemoAccount(){

  $leverage = DB::table('cms_leverage')->get();
  $account_types=DB::table('cms_account_type')->where([
    ['demo_live','demo'],
    ['ac_name','Default'],
		['status','=',1]
  ])->get();
  return view('backEnd.'.app()->getLocale().'.crm.account.open-demo-account',compact('leverage','account_types')); 
}

public function openNewAccount(){
  return view('backEnd.'.app()->getLocale().'.crm.account.select-trading-account');
}

public function openDemoAccountConfirmation(Request $request){


$uppercase = preg_match('@[A-Z]@', $request->password);
  $lowercase = preg_match('@[a-z]@', $request->password);
  $number    = preg_match('@[0-9]@', $request->password);



  if(strlen($request->password) < 8) {
    Session::flash('error','Password should contain minimum 8 characters');
    return Redirect::back()->withInput();
  }

  if(!$uppercase || !$lowercase || !$number){
    Session::flash('error','Password should contain uppercase,lowercase and number');
    return Redirect::back()->withInput();
  }

  if($request->password!=$request->c_password){
    Session::flash('error','Password doesn\'t match');
    return Redirect::back()->withInput();
  }
  $time = date("Y-m-d H:i:s");
  
    $password = $request->password;

    $investor_password = base64_encode($password);

    $email =session('login_email');
    $data=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
    $p_code=$data->p_code;
    $name=$data->fname." ".$data->lname;
    $fname=$data->fname;
    $lname=$data->lname;
    $email=$data->email;
    $country=$data->country;
    $state=$data->state;
    $city=$data->city;
    $dob = $data->dob;
    $address=$data->address;
    $reference_no=$data->reference_no;
    $mobile=$data->mobile;
    $status='0';
    $postal_code=$data->postal_code;
    $id=$data->intId;
    $leverage = $data->leverage;
    $affiliate_code = $data->affiliate_prom_code;
    //$deposit=$_POST["deposit"];
    $phone_password=$data->phone_password;

    if($city=='' || $address=='' || $postal_code=='' || $state==''){
      Session::flash('profile-error','Please Complete your profile information');
      return redirect('/profile');

    }

    $group=$request->account_type;
    $max_allowance=DB::table('cms_account_type')->where([
      ['ac_name',$data->email],
      ['mt4_ac_type',$group],
      ['demo_live','demo']
    ])->first();
    if(!$max_allowance){
      $max_allowance=DB::table('cms_account_type')->where([
        ['ac_name','Default'],
        ['mt4_ac_type',$group],
        ['demo_live','demo']
      ])->first();
    }
    if($data->owner_type=='personal'){
      $allowance=$max_allowance->max_allowance_personal;
    }
    else{
      $allowance=$max_allowance->max_allowance_corporate;
    }
    $accounts_already=DB::table('cms_account')->where([
      ['email',$data->email],
      ['act_type','DEMO']
    ])->get();
    $total_accounts=count($accounts_already);
    if($total_accounts>=$allowance){
      Session::flash('max_allowance_error','You have excceeded maximum allowance of trading accounts for this account type.');
      return Redirect::back();
    }




    

    $reference_no =time();

    $leverage =$request->leverage;
    $ref= time();
    $reg_time =time();

    $server_configs=$this->serverConfigs();
    $server=$server_configs->demo_server;
    $server_login=$server_configs->demo_login;
    $server_password=$server_configs->demo_password;

    $download_link=$server_configs->download_link;

    $login=0;
    $zipcode=$postal_code;
    $enable=1;

    $phone=$mobile;
    $comment="Demo Account";
    $investorpassword=$investor_password;
    $phonepassword=$password;
    


    $a= exec(storage_path('/api/CreateAccountWeb.exe')." \"".$server."\" \"".$server_login."\" \"".$server_password."\" \"".$name."\" \"".$email."\" \"".$city."\" \"".$state."\" \"".$country."\" \"".$address."\" \"".$zipcode."\" \"".$phone."\" \"".$comment."\" \"".$login."\" \"".$password."\" \"".$investorpassword."\" \"".$phonepassword."\" \"".$group."\" \"".$leverage."\" \"".$enable);

    if (strpos($a, "New account's login: ") !== false) {
     $b=explode("New account's login: ",$a);

     $login_id=$b[1];
   }         
   else{ 
    return Redirect::back();
  }




  session(['login' => $login_id]);
  session(['pass' => $password]);
  Session::save();

  $deposit=$request->deposit;
  $comment='Deposit';
  $a=exec(storage_path('/api/DepositBalanceWeb.exe')." \"".$server."\" \"".$server_login."\" \"".$server_password."\" \"".$login_id."\" \"".$deposit."\" \"".$comment); 
  if($a!='Successful'){
    return Redirect::back();
  }


  $sql=DB::table('cms_account')->insert([
    'leverage' => $request->leverage,
    
    
    'act_type'=>'DEMO',
    'email' => session('login_email'),
    'reference_no'=>$ref,
    'password'=>$password,
    'investor_password'=>$investor_password,
    'account_no'=>$login_id,
    'deposit'=>$request->deposit,
    'date_time'=>$time,
    'status'=>'0'
    //,
    // 'balance'=>$deposit

  ]); 

  

  $user_mail=session('login_email');
  $email_adds = $this->email_adds();
  $from_email = $email_adds->noreply_email;

  $mail_subject=config('app.name').' Demo account Details';
  $mail_data=$this->mail_data();
  $data=array(
    'date'=>$time,
    'name'=>$name,
    'login'=>$login_id,
    'password'=>$password,
    'investor_password'=>$investor_password,
    'server'=>$server,
    'mail_data'=>$mail_data
  );
  Mail::send('backEnd.'.app()->getLocale().'.crm.mail.open-demo-account-mail',
    $data, function($message)use ($user_mail, $name,$mail_subject,$from_email)
    {
      $message->from($from_email,config('app.name'));
      $message->to($user_mail, $name)->subject($mail_subject);
    });

        //Notifications

  $intIds=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
  DB::table('admins')
  ->where('id',$intIds->manager)
  ->orWhere([
    'country_access'=>'All',
    'manager'=>0
  ])
  ->orWhere([
    'country_access'=>$country,
    'manager'=>0
  ])
  ->increment('demoAccount', 1);
  
  return view('backEnd.'.app()->getLocale().'.crm.account.open-demo-account-confirmation',compact('request','login_id','password','investor_password','server','download_link'));
  
}





/*=================================
=       Open Trading Account      =
=================================*/

public function openTradingAccount(){
  $cms_account=DB::table('cms_account_type')->where([
    ['demo_live','live'],
    ['ac_name','Default'],
		['status','=',1]
  ])->get();

  $leverage = DB::table('cms_leverage')->get();
  return view('backEnd.'.app()->getLocale().'.crm.account.open-trading-account',compact('cms_account','leverage')); 
}

public function openTradingAccountConfirmation(Request $request){

  $uppercase = preg_match('@[A-Z]@', $request->password);
  $lowercase = preg_match('@[a-z]@', $request->password);
  $number    = preg_match('@[0-9]@', $request->password);



  if(strlen($request->password) < 8) {
    Session::flash('error','Password should contain minimum 8 characters');
    return Redirect::back()->withInput();
  }

  if(!$uppercase || !$lowercase || !$number){
    Session::flash('error','Password should contain uppercase,lowercase and number');
    return Redirect::back()->withInput();
  }

  if($request->password!=$request->c_password){
    Session::flash('error','Password doesn\'t match');
    return Redirect::back()->withInput();
  }

  $data=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
 
  $name=$data->fname." ".$data->lname;
  $fname=$data->fname;
  $lname=$data->lname;
  $email=$data->email;
  $country=$data->country;
  $state=$data->state;
  $city=$data->city;
  $dob = $data->dob;
  $address=$data->address;
  $reference_no=$data->reference_no;
  $mobile=$data->mobile;
 
  $postal_code=$data->postal_code;
  $id=$data->intId;
 
  if($city=='' || $address=='' || $postal_code=='' || $state==''){
    Session::flash('profile-error','Please Complete your profile information');
    return redirect('/profile');

  }
  $group = $request->account_type;
  

  $max_allowance=DB::table('cms_account_type')->where([
    ['ac_name',$data->email],
    ['mt4_ac_type',$group],
    ['demo_live','live']
  ])->first();
  if(!$max_allowance){
    $max_allowance=DB::table('cms_account_type')->where([
      ['ac_name','Default'],
      ['mt4_ac_type',$group],
      ['demo_live','live']
    ])->first();
  }
  if($data->owner_type=='personal'){
    $allowance=$max_allowance->max_allowance_personal;
  }
  else{
    $allowance=$max_allowance->max_allowance_corporate;
  }
  $act_type = $max_allowance->account_type;
  $accounts_already=DB::table('cms_account')->where([
    ['email',$data->email],
    ['act_type',$act_type]
  ])->get();
  $total_accounts=count($accounts_already);
  if($total_accounts>=$allowance){
    Session::flash('max_allowance_error','You have excceeded maximum allowance of trading accounts for this account type.');
    return Redirect::back();
  }





  $password = $request->password;

  $investor_password= base64_encode($password);

  $pass=base64_encode($password);

  $leverage = $request->leverage;
  $date_time=date("Y-m-d H:i:s");

  $server_configs=$this->serverConfigs();
  $server=$server_configs->server;
  $server_login=$server_configs->login;
  $server_password=$server_configs->password;
  $server_client=$server_configs->server_client;

  $download_link=$server_configs->download_link;
  $login=0;
  $zipcode=$postal_code;
  $enable=1;

  $phone=$mobile;
  $comment="";
  $investorpassword=$investor_password;
  $phonepassword=$password;
  // $group=$arr_groups[$accounttype];




  $a= exec(storage_path('/api/CreateAccountWeb.exe')." \"".$server."\" \"".$server_login."\" \"".$server_password."\" \"".$name."\" \"".$email."\" \"".$city."\" \"".$state."\" \"".$country."\" \"".$address."\" \"".$zipcode."\" \"".$phone."\" \"".$comment."\" \"".$login."\" \"".$password."\" \"".$investorpassword."\" \"".$phonepassword."\" \"".$group."\" \"".$leverage."\" \"".$enable);


  if (strpos($a, "New account's login: ") !== false) {
   $b=explode("New account's login: ",$a);

   $login_id=$b[1];
 }         
 else{ 
  return Redirect::back();
}

if(isset($affiliate_code) && $affiliate_code!=""){
  $affiliate_code=$affiliate_code;
}else{
  $affiliate_code = 0;
}

$sql=DB::table('cms_account')->insert([
  'leverage' => $request->leverage,
  'email' => session('login_email'),
  'affiliate_code'=>$affiliate_code,
  'act_type'=>$act_type,
  'reference_no'=>$reference_no,
  'password'=>$password,
  // 'investor_password'=>$pass,
  'investor_password'=>$investorpassword,
  'account_no'=>$login_id,
  'date_time'=>$date_time
    //,
    // 'balance'=>$deposit

]); 

$query=DB::table('cms_account_series')->insert([

  ['account_no'=>$login_id]

]);

$email_adds = $this->email_adds();
$from_mail = $email_adds->noreply_email;
$user_mail=session('login_email');


$mail_subject=config('app.name').' trading account Details';
$mail_data=$this->mail_data();
$data=array(
  'date'=>$date_time,
  'name'=>$name,
  'login'=>$login_id,
  'password'=>$password,
  'investor_password'=>$investorpassword,
  'mail_data'=>$mail_data
);
Mail::send('backEnd.'.app()->getLocale().'.crm.mail.open-trading-account-mail',
  $data, function($message)use ($user_mail, $name,$mail_subject,$from_mail)
  {
    $message->from($from_mail,config('app.name'));
    $message->to($user_mail, $name)->subject($mail_subject);
  });

                //Notifications

$intIds=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();

DB::table('admins')
->where('id',$intIds->manager)
->orWhere([
  'country_access'=>'All',
  'manager'=>0
])
->orWhere([
  'country_access'=>$country,
  'manager'=>0
])
->increment('tradingAccount', 1);

return view('backEnd.'.app()->getLocale().'.crm.account.open-trading-account-confirmation',compact('request','password','login_id','investor_password','server_client','download_link'));

}



/*=================================
=          Change Leverage        =
=================================*/

public function changeLeverage(Request $request){
  if($request->ac){
    $selected_account=$request->ac;
  }
  else{
    $selected_account="";
  }
  $leverage = DB::table('cms_leverage')->get();
  $accounts=DB::table('cms_account')->join('mt4_users','mt4_users.LOGIN','=','cms_account.account_no')->where([
    
    ['cms_account.email','=',session('login_email')],
    ['cms_account.account_no','<>','0'],
    ['cms_account.act_type','<>','IB'],
    ['cms_account.act_type','<>','DEMO']
])->select('cms_account.*')->orderBy('cms_account.account_no','desc')->get();    
  return view('backEnd.'.app()->getLocale().'.crm.leverage.change-leverage',compact('leverage','accounts','selected_account'));  
}


public function postChangeLeverage(Request $request){
  
  $lev=DB::table('cms_account')->where('account_no',$request->account)->first(); 
  if ($lev->leverage==$request->leverage) {
    return Redirect::back()->withErrors(['This account is already set to '.$request->leverage.':1']);
  }

  else{
    $profile=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
    $general_info=DB::table('general_information')->first();
    $mail_data=$this->mail_data();
    $name=$profile->fname.' '.$profile->lname;

    $email_adds = $this->email_adds();
    
    $from_email_id=$email_adds->noreply_email;
    $from_name=config('app.name');
    $user_mail=session('login_email');
    $mail_subject='Verification Code for Leverage Change';
    $verification_code=mt_rand(100000, 999999);
    session(['leverage_verification_code' => $verification_code]);
    Session::save();
    $data = array('name' => $name , 'verification_code' => $verification_code, 'general_info_others' => $general_info, 'mail_data' => $mail_data);
    Mail::send('backEnd.'.app()->getLocale().'.crm.mail.leverage-verification',
      $data, function($message)use ($from_email_id,$from_name,$user_mail, $name,$mail_subject)
      {
        $message->from($from_email_id,$from_name);
        $message->to($user_mail, $name)->subject($mail_subject);
      });
    return view('backEnd.'.app()->getLocale().'.crm.leverage.leverage-verification',compact('request')); 
  }
}


public function leverageVerification(Request $request){
  if($request->verification_code!=session('leverage_verification_code')){
    return view('backEnd.'.app()->getLocale().'.crm.leverage.leverage-verification',compact('request'))->withErrors(['Verification code is incorrect. ']);
  }

  else{
    $cms_account=DB::table('cms_account')->where('account_no',$request->account)->first();
    

    Session::forget('leverage_verification_code');

    $server_configs=$this->serverConfigs();
    $server=$server_configs->server;
    $server_login=$server_configs->login;
    $server_password=$server_configs->password;
    $login=$request->account;
    $leverage=$request->leverage;


    $a=  exec(storage_path('/api/UpdateAccountWeb.exe')." \"".$server."\" \"".$server_login."\" \"".$server_password."\" \"".$login."\" \"Leverage\" \"".$leverage);
    if($a!='Successful'){

      return view('backEnd.'.app()->getLocale().'.crm.leverage.leverage-verification',compact('request'))->withErrors(['Leverage change is not possible for this moment. Please try again later.']);
    }

    $date_time=date("Y-m-d H:i:s");
    $insert=DB::table('cms_changeleverage')->insert([
      'account_no' => $request->account,
      'act_type' => $cms_account->act_type,
      'email' => session('login_email'),
      'current_leverage' => $cms_account->leverage,
      'new_leverage' => $request->leverage,
      'status' => '1',
      'tr_time' => $date_time

    ]);
    $update=DB::table('cms_account')
    ->where('account_no', $request->account)
    ->update([
      'leverage' => $request->leverage
    ]);
    Session::flash('msg','Leverage has been changed successfully');
    return redirect('/change-leverage');
    
  }


}




/*=================================
=       Change MT4 Password       =
=================================*/

public function changeMt4Password(Request $request){

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
  return view('backEnd.'.app()->getLocale().'.crm.password.change-mt4-password',compact('accounts','selected_account'));  
}


public function postChangeMt4Password(Request $request){
  
  $uppercase = preg_match('@[A-Z]@', $request->password);
  $lowercase = preg_match('@[a-z]@', $request->password);
  $number    = preg_match('@[0-9]@', $request->password);



  if(strlen($request->password) < 8) {
    Session::flash('error','Password should contain minimum 8 characters');
    return Redirect::back()->withInput()->withErrors('pass_error');
  }

  if(!$uppercase || !$lowercase || !$number){
    Session::flash('error','Password should contain uppercase,lowercase and number');
    return Redirect::back()->withInput();
  }

  if($request->password!=$request->c_password){
    Session::flash('error','Password doesn\'t match');
    return Redirect::back()->withInput();
  }



  
  $profile=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
  $general_info=DB::table('general_information')->first();
  $mail_data=$this->mail_data();
  $name=$profile->fname.' '.$profile->lname;

  $email_adds = $this->email_adds();
    
  $from_email_id=$email_adds->noreply_email;
  
  $from_name=config('app.name');
  $user_mail=session('login_email');
  // $user_mail='mkhassan25@gmail.com';
  $mail_subject='Verification Code for MT4 Password Change';
  $verification_code=mt_rand(100000, 999999);
  session(['mt4_password_verification_code' => $verification_code]);
  Session::save();
  $data = array('name' => $name , 'verification_code' => $verification_code, 'general_info_others' => $general_info, 'mail_data' => $mail_data);
  Mail::send('backEnd.'.app()->getLocale().'.crm.mail.mt4-password-verification',
    $data, function($message)use ($from_email_id,$from_name,$user_mail, $name,$mail_subject)
    {
      $message->from($from_email_id,$from_name);
      $message->to($user_mail, $name)->subject($mail_subject);
    });
  return view('backEnd.'.app()->getLocale().'.crm.password.mt4-password-verification',compact('request')); 
  
}


public function mt4PasswordVerification(Request $request){
  if($request->verification_code!=session('mt4_password_verification_code')){
    return view('backEnd.'.app()->getLocale().'.crm.password.mt4-password-verification',compact('request'))->withErrors(['Verification code is incorrect. ']);
  }

  else{
    Session::forget('mt4_password_verification_code');
    $cms_account=DB::table('cms_account')->where('account_no',$request->account_no)->first();
    
    $info=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
    $name=$info->fname." ".$info->lname;    


    $server_configs=$this->serverConfigs();
    $server=$server_configs->server;
    $server_login=$server_configs->login;
    $server_password=$server_configs->password;
    $login=$request->account_no;
    $password=$request->password;
    //$investor_password=$request->investor_password;
    $download_link=$server_configs->download_link;


    $a=  exec(storage_path('/api/UpdateAccountWeb.exe')." \"".$server."\" \"".$server_login."\" \"".$server_password."\" \"".$login."\" \"Password\" \"".$password);

    // $b=  exec(storage_path('/api/UpdateAccountWeb.exe')." \"".$server."\" \"".$server_login."\" \"".$server_password."\" \"".$login."\" \"Passwordinvestor\" \"".$investor_password);

    $c=  exec(storage_path('/api/UpdateAccountWeb.exe')." \"".$server."\" \"".$server_login."\" \"".$server_password."\" \"".$login."\" \"Passwordphone\" \"".$password);

    if($a!='Successful' || $c!='Successful'){
      return Redirect::back();
    }



    $update=DB::table('cms_account')
    ->where('account_no', $request->account_no)
    ->update([
      'password' => $request->password
    ]);
    //Session::flash('msg','Password has been changed successfully');

    $email_adds = $this->email_adds();
    
    $from_email_id=$email_adds->noreply_email;
    $user_mail=session('login_email');


    $mail_subject=config('app.name').' Trading Account Password';
    $mail_data=$this->mail_data();
    $data=array(

      'name'=>$name,
      'login'=>$login,
      'password'=>$password,
      'server'=>$server,
      'download_link'=>$download_link,
      'mail_data'=>$mail_data
    );
    Mail::send('backEnd.'.app()->getLocale().'.crm.mail.mt4-password-change-mail',
      $data, function($message)use ($user_mail, $name,$mail_subject,$from_email_id)
      {
        $message->from($from_email_id,config('app.name'));
        $message->to($user_mail, $name)->subject($mail_subject);
      });


    return view('backEnd.'.app()->getLocale().'.crm.password.mt4-password-change-confirmation',compact('password','login','server','download_link'));
    
  }


}


/*=================================
=       Change MT4 Investor Password       =
=================================*/



public function postChangeMt4InvestorPassword(Request $request){
  
  $uppercase = preg_match('@[A-Z]@', $request->investor_password);
  $lowercase = preg_match('@[a-z]@', $request->investor_password);
  $number    = preg_match('@[0-9]@', $request->investor_password);


  if(strlen($request->investor_password) < 8) {
    Session::flash('investor_error','Password should contain minimum 8 characters');
    return Redirect::back()->withInput();
  }

  if(!$uppercase || !$lowercase || !$number){
    Session::flash('investor_error','Password should contain uppercase,lowercase and number');
    return Redirect::back()->withInput();
  }

  if($request->investor_password!=$request->cinvestor_password){
    Session::flash('investor_error','Password doesn\'t match');
    return Redirect::back()->withInput();
  }


  
  $profile=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
  $general_info=DB::table('general_information')->first();
  $mail_data=$this->mail_data();
  $name=$profile->fname.' '.$profile->lname;
  $email_adds = $this->email_adds();
    
  $from_email_id=$email_adds->noreply_email;  
  $from_name=config('app.name');

  $user_mail=session('login_email');
  $mail_subject='Verification Code for MT4 Password Change';
  $verification_code=mt_rand(100000, 999999);
  session(['mt4_investor_password_verification_code' => $verification_code]);
  Session::save();
  $data = array('name' => $name , 'verification_code' => $verification_code, 'general_info_others' => $general_info, 'mail_data' => $mail_data);
  Mail::send('backEnd.'.app()->getLocale().'.crm.mail.mt4-investor-password-verification',
    $data, function($message)use ($from_email_id,$from_name,$user_mail, $name,$mail_subject)
    {
      $message->from($from_email_id,$from_name);
      $message->to($user_mail, $name)->subject($mail_subject);
    });
  return view('backEnd.'.app()->getLocale().'.crm.password.mt4-investor-password-verification',compact('request')); 
  
}


public function mt4InvestorPasswordVerification(Request $request){
  if($request->verification_code!=session('mt4_investor_password_verification_code')){
    return view('backEnd.'.app()->getLocale().'.crm.password.mt4-investor-password-verification',compact('request'))->withErrors(['Verification code is incorrect. ']);
  }

  else{
    Session::forget('mt4_investor_password_verification_code');
    $cms_account=DB::table('cms_account')->where('account_no',$request->account_no)->first();
    
    $info=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
    $name=$info->fname." ".$info->lname;    


    $server_configs=$this->serverConfigs();
    $server=$server_configs->server;
    $server_login=$server_configs->login;
    $server_password=$server_configs->password;
    $login=$request->account_no;
    
    $investor_password=$request->investor_password;
    $download_link=$server_configs->download_link;




    $b=  exec(storage_path('/api/UpdateAccountWeb.exe')." \"".$server."\" \"".$server_login."\" \"".$server_password."\" \"".$login."\" \"Passwordinvestor\" \"".$investor_password);



    if($b!='Successful'){
      return Redirect::back();
    }



    $update=DB::table('cms_account')
    ->where('account_no', $request->account_no)
    ->update([


      'investor_password' => $request->investor_password
    ]);
    //Session::flash('msg','Investor Password has been changed successfully');

    $email_adds = $this->email_adds();
    
    $from_email_id=$email_adds->support_email;  
    $from_name=config('app.name');
    $user_mail=session('login_email');


    $mail_subject=config('app.name').' Trading Account Investor Password';
    $mail_data=$this->mail_data();
    $data=array(

      'name'=>$name,
      'login'=>$login,
      'investor_password'=>$investor_password,
      
      'mail_data'=>$mail_data
    );
    Mail::send('backEnd.'.app()->getLocale().'.crm.mail.mt4-investor-password-change-mail',
      $data, function($message)use ($user_mail, $name,$mail_subject,$from_email_id,$from_name)
      {
        $message->from($from_email_id,$from_name);
        $message->to($user_mail, $name)->subject($mail_subject);
      });


    return view('backEnd.'.app()->getLocale().'.crm.password.mt4-investor-password-change-confirmation',compact('investor_password','login','server','download_link'));
    
  }


}



/*=================================
=       Internal Transfer         =
=================================*/

public function internalTransfer(Request $request){
  if($request->ac){
    $selected_account=$request->ac;
  }
  else{
    $selected_account="";
  }
  $accounts=DB::table('cms_account')->join('mt4_users','mt4_users.LOGIN','=','cms_account.account_no')->where([
    ['cms_account.email',session('login_email')],
    ['cms_account.account_no','<>','0'],
    ['cms_account.act_type','<>','IB'],
    ['cms_account.act_type','<>','DEMO']
  ])->select('cms_account.*','mt4_users.BALANCE')->orderby('account_no','desc')->get();
  return view ('backEnd.'.app()->getLocale().'.crm.withdraw.internal-transfer',compact('accounts','selected_account'));

}


public function postInternalTransfer(Request $request){
  $running=DB::table('mt4_trades')->where('LOGIN',$request->transfer_from)->orderby('TICKET','desc')->first();
  if($running){
    if($running->CLOSE_TIME=="1970-01-01 00:00:00"){
      return redirect('/internal-transfer')->withErrors([$request->transfer_from.' has one or more running trades']);
    }
  }
  $balance=DB::table('mt4_users')->where('LOGIN',$request->transfer_from)->first();
  
  if($balance){
    $BALANCE=$balance->BALANCE;
  }
  else{
    $BALANCE=0;
  }
  if($request->transfer_from==$request->transfer_to){
    return redirect('/internal-transfer')->withErrors(['Transfer to separate account only.']);
  }
  elseif(is_numeric($request->amount)==false){
    return redirect('/internal-transfer')->withErrors(['Please Enter a valid amount']);
  }
  
  elseif($request->amount<1){
    return redirect('/internal-transfer')->withErrors(['Minimum Internal Transfer is 1 usd']);
  }
  
  elseif($BALANCE>=$request->amount && $request->amount>=1){
    $profile=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
    $general_info=DB::table('general_information')->first();
    $mail_data=$this->mail_data();
    $name=$profile->fname.' '.$profile->lname;
    $email_adds = $this->email_adds();
    
    $from_email_id=$email_adds->noreply_email;  
    $from_name=config('app.name');
    
    $user_mail=session('login_email');
    $mail_subject='Verification Code for Internal Transfer';
    $verification_code=mt_rand(100000, 999999);
    session(['verification_code' => $verification_code]);
    Session::save();
    $data = array('name' => $name , 'verification_code' => session('verification_code'), 'general_info_others' => $general_info, 'mail_data' => $mail_data);
    Mail::send('backEnd.'.app()->getLocale().'.crm.mail.email-template',
      $data, function($message)use ($from_email_id,$from_name,$user_mail, $name,$mail_subject)
      {
        $message->from($from_email_id,$from_name);
        $message->to($user_mail, $name)->subject($mail_subject);
      });


    return view('backEnd.'.app()->getLocale().'.crm.withdraw.internal_verification_code',compact('request'));



  }

  else {
    return redirect('/internal-transfer')->withErrors(['Your balance is not sufficient for this transfer']);
  }

}


public function postInternalVerification(Request $request){
  if($request->verification_code!=session('verification_code')){
    return view('backEnd.'.app()->getLocale().'.crm.withdraw.internal_verification_code',compact('request'))->withErrors(['Verification code is incorrect. ']);
  }

  else{
    $running=DB::table('mt4_trades')->where('LOGIN',$request->transfer_from)->orderby('TICKET','desc')->first();
  if($running){
    if($running->CLOSE_TIME=="1970-01-01 00:00:00"){
      return redirect('/internal-transfer')->withErrors([$request->transfer_from.' has one or more running trades']);
    }
  }
    $balance=DB::table('mt4_users')->where('LOGIN',$request->transfer_from)->first();
  
  if($balance){
    $BALANCE=$balance->BALANCE;
  }
  else{
    $BALANCE=0;
  }
  if($request->amount<1){
    return redirect('/internal-transfer')->withErrors(['Minimum Internal Transfer is 1 usd']);
  }
  if($request->amount>$BALANCE){
    return redirect('/internal-transfer')->withErrors(['Your balance is not sufficient for this transfer']);
  }
   $ref = time();
   $date = date("Y-m-d H:i:s");

   $act1=DB::table('cms_account')->where([
    ['account_no',$request->transfer_from],
    ['email',session('login_email')]
  ])->first();

   $insert1=DB::table('cms_internal_transfer')->insert([
    'from_account' => $request->transfer_from,
    'to_account' => $request->transfer_to,
    'email' => session('login_email'),
    'amount' => $request->amount,
    'currency' => 'USD',
    'status' => '1',
    'tr_time' => $date

  ]);

   $act2=DB::table('cms_account')->where([
    ['account_no',$request->transfer_to],
    ['email',session('login_email')]
  ])->first();


   Session::forget('verification_code');

// MT4 Internal Transfer

   $server_configs=$this->serverConfigs();
   $server=$server_configs->server;
   $server_login=$server_configs->login;
   $server_password=$server_configs->password;
   $amount=$request->amount;

   $transfer_from=$request->transfer_from;
   $transfer_to=$request->transfer_to;
   $comment1='int tx to '.$transfer_to;
   $a=exec(storage_path('/api/WithdrawBalanceWeb.exe')." \"".$server."\" \"".$server_login."\" \"".$server_password."\" \"".$transfer_from."\" \"".$amount."\" \"".$comment1);

   $comment2='int tx from '.$transfer_from;

   $b=exec(storage_path('/api/DepositBalanceWeb.exe')." \"".$server."\" \"".$server_login."\" \"".$server_password."\" \"".$transfer_to."\" \"".$amount."\" \"".$comment2);


   if($a!='Successful' || $b!='Successful'){
    return Redirect::back();
  }





// Mail

  $profile=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
  $name=$profile->fname." ".$profile->lname;
  $data = array(
   'name' => $name ,
   'reference' => $ref,
   'email'=>session('login_email'),
   'amount'=>$request->amount,
   'transfer_from'=>$request->transfer_from.' ('.$act1->act_type.')',
   'transfer_to'=>$request->transfer_to.' ('.$act2->act_type.')'


 );

  $email_adds = $this->email_adds();
    
    $from_email_id=$email_adds->withdraw_email_from;  
    $from_name='Client Internal Transfer';

  $user_mail=$email_adds->withdraw_email_to;
  $user_name=config('app.name');
  
  $mail_subject='New Internal Transfer from Client';
  

  Mail::send('backEnd.'.app()->getLocale().'.crm.mail.internal-mail',
    $data, function($message)use ($from_email_id,$from_name,$user_mail, $user_name,$mail_subject)
    {
      $message->from($from_email_id,$from_name);
      $message->to($user_mail, $user_name)->subject($mail_subject);
    });



  Session::flash('msg','Your Internal Transfer has been processed successfully to '.$request->transfer_to.' ('.$act2->act_type.')');
  return redirect('/internal-transfer');
}

}


/*=================================
=          Withdraw Funds         =
=================================*/

public function withdrawFunds(Request $request){

  if($request->ac){
    $selected_account=$request->ac;
  }
  else{
    $selected_account="";
  }

  return view('backEnd.'.app()->getLocale().'.crm.withdraw.withdraw-funds',compact('selected_account'));
}

/*=================================
=          Neteller               =
=================================*/	

public function netellerWithdraw(Request $request){

  if($request->ac){
    $selected_account=$request->ac;
  }
  else{
    $selected_account="";
  }

  $accounts = DB::table('cms_account')->join('mt4_users','mt4_users.LOGIN','=','cms_account.account_no')->select(['cms_account.account_no','mt4_users.BALANCE as balance',DB::raw('CONCAT(cms_account.account_no," ( ",cms_account.act_type," )") as acc_no')])->where([['cms_account.act_type','<>','DEMO'],['cms_account.act_type','<>','NULL'],['cms_account.email','=',session('login_email')]])->orderBy('cms_account.account_no','desc')->get();
  return view ('backEnd.'.app()->getLocale().'.crm.withdraw.neteller-withdraw',compact('accounts','selected_account'));
}


public function postNetellerWithdraw(Request $request){

  $balance=DB::table('mt4_users')->where('LOGIN',$request->transfer_from)->first();
  if($balance){
    $BALANCE=$balance->BALANCE;
  }
  else{
    $BALANCE=0;
  }
  
  if(is_numeric($request->amount)==false){
    return redirect('/neteller_withdraw')->withErrors(['Please Enter a valid amount']);
  }
  elseif(is_numeric($request->account)==false || $request->account<1000000000){
    return redirect('/neteller_withdraw')->withErrors(['Your given Neteller account no. is invalid.']);
  }
  elseif($request->amount<1){
    return redirect('/neteller_withdraw')->withErrors(['Minimum Neteller withdraw is 1 usd']);
  }
  elseif($BALANCE>=$request->amount && $request->amount>=1){
    $profile=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
    $name=$profile->fname.' '.$profile->lname;
    $request->payment_type='Neteller';
    $email_adds = $this->email_adds();
    
    $from_email_id=$email_adds->noreply_email;  
    $from_name=config('app.name');
    $user_mail=session('login_email');
    $mail_subject='Verification Code for Withdraw Funds';
    $verification_code=mt_rand(100000, 999999);
    session(['verification_code' => $verification_code]);
    Session::save();
    $data = array('name' => $name , 'verification_code' => session('verification_code'));
    Mail::send('backEnd.'.app()->getLocale().'.crm.mail.email-template',
      $data, function($message)use ($from_email_id,$from_name,$user_mail, $name,$mail_subject)
      {
        $message->from($from_email_id,$from_name);
        $message->to($user_mail, $name)->subject($mail_subject);
      });






    return view('backEnd.'.app()->getLocale().'.crm.withdraw.verification_code',compact('request'));
  }

  else {
    return redirect('/neteller_withdraw')->withErrors(['Your balance is not sufficient for this withdrawal request']);
  }

}





/*=================================
=          Perfect Money          =
=================================*/ 

public function perfectMoneyWithdraw(Request $request){

  if($request->ac){
    $selected_account=$request->ac;
  }
  else{
    $selected_account="";
  }
  $accounts = DB::table('cms_account')->join('mt4_users','mt4_users.LOGIN','=','cms_account.account_no')->select(['cms_account.account_no','mt4_users.BALANCE as balance',DB::raw('CONCAT(cms_account.account_no," ( ",cms_account.act_type," )") as acc_no')])->where([['cms_account.act_type','<>','DEMO'],['cms_account.act_type','<>','NULL'],['cms_account.email','=',session('login_email')]])->orderBy('cms_account.account_no','desc')->get();
  return view ('backEnd.'.app()->getLocale().'.crm.withdraw.perfect-money-withdraw',compact('accounts','selected_account'));
}


public function postPerfectMoneyWithdraw(Request $request){

  $balance=DB::table('mt4_users')->where('LOGIN',$request->transfer_from)->first();
  if($balance){
    $BALANCE=$balance->BALANCE;
  }
  else{
    $BALANCE=0;
  }
  
  if(is_numeric($request->amount)==false){
    return redirect('/perfect_money_withdraw')->withErrors(['Please Enter a valid amount']);
  }
  
  elseif($request->amount<1){
    return redirect('/perfect_money_withdraw')->withErrors(['Minimum Perfect Money withdraw is 1 usd']);
  }
  elseif($BALANCE>=$request->amount && $request->amount>=1){
    $profile=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
    $name=$profile->fname.' '.$profile->lname;
    $request->payment_type='Perfect Money';
    $email_adds = $this->email_adds();
    
    $from_email_id=$email_adds->noreply_email;  
    $from_name=config('app.name');
    $user_mail=session('login_email');
    $mail_subject='Verification Code for Withdraw Funds';
    $verification_code=mt_rand(100000, 999999);
    session(['verification_code' => $verification_code]);
    Session::save();
    $data = array('name' => $name , 'verification_code' => session('verification_code'));
    Mail::send('backEnd.'.app()->getLocale().'.crm.mail.email-template',
      $data, function($message)use ($from_email_id,$from_name,$user_mail, $name,$mail_subject)
      {
        $message->from($from_email_id,$from_name);
        $message->to($user_mail, $name)->subject($mail_subject);
      });






    return view('backEnd.'.app()->getLocale().'.crm.withdraw.verification_code',compact('request'));
  }

  else {
    return redirect('/perfect_money_withdraw')->withErrors(['Your balance is not sufficient for this withdrawal request']);
  }

}

/*=================================
=          Skrill                 =
=================================*/ 

public function skrillWithdraw(Request $request){

  if($request->ac){
    $selected_account=$request->ac;
  }
  else{
    $selected_account="";
  }

  $accounts = DB::table('cms_account')->join('mt4_users','mt4_users.LOGIN','=','cms_account.account_no')->select(['cms_account.account_no','mt4_users.BALANCE as balance',DB::raw('CONCAT(cms_account.account_no," ( ",cms_account.act_type," )") as acc_no')])->where([['cms_account.act_type','<>','DEMO'],['cms_account.act_type','<>','NULL'],['cms_account.email','=',session('login_email')]])->orderBy('cms_account.account_no','desc')->get();
  return view ('backEnd.'.app()->getLocale().'.crm.withdraw.skrill-withdraw',compact('accounts','selected_account'));
}


public function postSkrillWithdraw(Request $request){

  $balance=DB::table('mt4_users')->where('LOGIN',$request->transfer_from)->first();
  
  if($balance){
    $BALANCE=$balance->BALANCE;
  }
  else{
    $BALANCE=0;
  }
  if(is_numeric($request->amount)==false){
    return redirect('/skrill_withdraw')->withErrors(['Please Enter a valid amount']);
  }
  
  elseif($request->amount<1){
    return redirect('/skrill_withdraw')->withErrors(['Minimum Skrill withdraw is 1 usd']);
  }
  elseif($BALANCE>=$request->amount && $request->amount>=1){
    $profile=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
    $name=$profile->fname.' '.$profile->lname;
    $request->payment_type='Skrill';
    $email_adds = $this->email_adds();
    
    $from_email_id=$email_adds->noreply_email;  
    $from_name=config('app.name');
    $user_mail=session('login_email');
    $mail_subject='Verification Code for Withdraw Funds';
    $verification_code=mt_rand(100000, 999999);
    session(['verification_code' => $verification_code]);
    Session::save();
    $data = array('name' => $name , 'verification_code' => session('verification_code'));
    Mail::send('backEnd.'.app()->getLocale().'.crm.mail.email-template',
      $data, function($message)use ($from_email_id,$from_name,$user_mail, $name,$mail_subject)
      {
        $message->from($from_email_id,$from_name);
        $message->to($user_mail, $name)->subject($mail_subject);
      });


    return view('backEnd.'.app()->getLocale().'.crm.withdraw.verification_code',compact('request'));
  }

  else {
    return redirect('/skrill_withdraw')->withErrors(['Your balance is not sufficient for this withdrawal request']);
  }

}


/*=================================
=          Okpay                 =
=================================*/ 

public function okpayWithdraw(Request $request){

 if($request->ac){
  $selected_account=$request->ac;
}
else{
  $selected_account="";
}

$accounts = DB::table('cms_account')->join('mt4_users','mt4_users.LOGIN','=','cms_account.account_no')->join('cms_account_type','mt4_users.GROUP','=','cms_account_type.mt4_ac_type')->select(['cms_account.account_no','mt4_users.BALANCE as balance',DB::raw('CONCAT(cms_account.account_no," ( ",cms_account_type.account_type," )") as acc_no')])->where([['cms_account.act_type','<>','DEMO'],['cms_account.act_type','<>','NULL'],['cms_account_type.ac_name','=','Default'],['cms_account_type.demo_live','=','live'],['cms_account.email','=',session('login_email')]])->orderBy('cms_account.account_no','desc')->get();
return view ('backEnd.'.app()->getLocale().'.crm.withdraw.okpay-withdraw',compact('accounts','selected_account'));
}


public function postOkpayWithdraw(Request $request){

  $balance=DB::table('mt4_users')->where('LOGIN',$request->transfer_from)->first();
  
  if($balance){
    $BALANCE=$balance->BALANCE;
  }
  else{
    $BALANCE=0;
  }
  if(is_numeric($request->amount)==false){
    return redirect('/okpay_withdraw')->withErrors(['Please Enter a valid amount']);
  }
  
  elseif($request->amount<1){
    return redirect('/okpay_withdraw')->withErrors(['Minimum Okpay withdraw is 1 usd']);
  }
  elseif($BALANCE>=$request->amount && $request->amount>=1){
    $profile=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
    $name=$profile->fname.' '.$profile->lname;
    $request->payment_type='Okpay';
    $email_adds = $this->email_adds();
    
    $from_email_id=$email_adds->noreply_email;  
    $from_name=config('app.name');
    $user_mail=session('login_email');
    $mail_subject='Verification Code for Withdraw Funds';
    $verification_code=mt_rand(100000, 999999);
    session(['verification_code' => $verification_code]);
    Session::save();
    $data = array('name' => $name , 'verification_code' => session('verification_code'));
    Mail::send('backEnd.'.app()->getLocale().'.crm.mail.email-template',
      $data, function($message)use ($from_email_id,$from_name,$user_mail, $name,$mail_subject)
      {
        $message->from($from_email_id,$from_name);
        $message->to($user_mail, $name)->subject($mail_subject);
      });






    return view('backEnd.'.app()->getLocale().'.crm.withdraw.verification_code',compact('request'));
  }

  else {
    return redirect('/okpay_withdraw')->withErrors(['Your balance is not sufficient for this withdrawal request']);
  }

}



/*=================================
=          Bank Transfer          =
=================================*/ 

public function bankTransfer(Request $request){

  if($request->ac){
    $selected_account=$request->ac;
  }
  else{
    $selected_account="";
  }

  $accounts = DB::table('cms_account')->join('mt4_users','mt4_users.LOGIN','=','cms_account.account_no')->select(['cms_account.account_no','mt4_users.BALANCE as balance',DB::raw('CONCAT(cms_account.account_no," ( ",cms_account.act_type," )") as acc_no')])->where([['cms_account.act_type','<>','DEMO'],['cms_account.act_type','<>','NULL'],['cms_account.email','=',session('login_email')]])->orderBy('cms_account.account_no','desc')->get();
  return view ('backEnd.'.app()->getLocale().'.crm.withdraw.bank-transfer',compact('accounts','selected_account'));
}




/*=================================
=          Verification           =
=================================*/ 

public function postVerification(Request $request){
  if($request->verification_code!=session('verification_code')){
    return view('backEnd.'.app()->getLocale().'.crm.withdraw.verification_code',compact('request'))->withErrors(['Verification code is incorrect. ']);
  }

  else{
    
  $account_info=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
    $fname=$account_info->fname;
    $lname=$account_info->lname;
    $country=$account_info->country;
    $reference=time();
    $amount=round($request->amount,2);

    $cms_account=DB::table('cms_account')->where([
      ['email',session('login_email')],
      ['account_no',$request->transfer_from]
    ])->first();

    if($request->currency){
      $currency = $request->currency;
    }
    else{
      $currency = 'USD';
    }
    $proccessing_fee = round($amount*.025,2);
    $net_amount = $amount-$proccessing_fee;
    $insert=DB::table('cms_withdraw')
    ->insert(
      ['reference_id' => $reference,

      'email'=>session('login_email'),
      'amount'=>$amount,
      'net_amount'=>$net_amount,
      'proccessing_fee'=>$proccessing_fee,
      'account_no'=>$request->transfer_from,
      'payment_type'=>$request->payment_type,
      'payment_email'=>$request->email,
      'account_id'=>$request->account,
      'currency'=>$currency,
      'withdraw_reason'=>'',
      'bank_name'=>$request->bank_name,
      'bank_country'=>$request->bank_residence_country,
      'bank_account'=>$request->bank_account,
      
      'bank_iban'=>$request->bank_iban,
      'bank_swift'=>$request->bank_swift,
      'bank_address'=>$request->bank_address,    
      'status'=>'0',
      'withdrawl_time'=>date("Y-m-d H:i:s",$reference)
    ]
  );
 


    DB::table('cms_log')
    ->insert(
      ['ref_id' => $reference,
      'table_name'=>'cms_withdraw',
      'naration'=>'account_no = '.$request->transfer_from,
      'ip_address'=>$_SERVER['REMOTE_ADDR'],

      'date_time'=>date("Y-m-d H:i:s",$reference)
    ]
  );

    $name=$fname." ".$lname;
    $data = array(
      'name' => $name ,
      'reference' => $reference,
      'email'=>session('login_email'),
      'amount'=>$request->amount,
      'net_amount'=>$request->net_amount,
      'proccessing_fee'=>$amount-$request->net_amount,
      'amount'=>$request->amount,
      'payment_type'=>$request->payment_type,
      'transfer_from'=>$request->transfer_from.' ('.$cms_account->act_type.')',
      'payment_email'=>$request->email,
      'account'=>$request->account,
      'bank_name'=>$request->bank_name,
      'bank_country'=>$request->bank_residence_country,
      'bank_acc_name'=>$request->bank_account,
      'iban_num'=>$request->bank_iban,
      'swift_num'=>$request->bank_swift,
      'bank_address'=>$request->bank_address,
      'correspondent_bank'=>$request->correspondent_bank,
      'trading_account'=>$request->trading_account,
      'verification_code'=>session('verification_code')
    );
 

    $email_adds = $this->email_adds();
    
    $from_email_id=$email_adds->withdraw_email_from;  
    $from_name='Client Fund Withdraw';
    
    $user_mail=$email_adds->withdraw_email_to;
    $user_name=config('app.name');
    
    $mail_subject='New withdraw request arrived';
    
    

    Mail::send('backEnd.'.app()->getLocale().'.crm.mail.withdraw-request-mail',
      $data, function($message)use ($from_email_id,$from_name,$user_mail, $user_name,$mail_subject)
      {
        $message->from($from_email_id,$from_name);
        $message->to($user_mail, $user_name)->subject($mail_subject);
      });


        //Notifications



    DB::table('admins')
    ->where('id',$account_info->manager)
    ->orWhere([
      'country_access'=>'All',
      'manager'=>0
    ])
    ->orWhere([
      'country_access'=>$account_info->country,
      'manager'=>0
    ])
    ->increment('clientWithdraw', 1);

    Session::forget('verification_code');

    return view('backEnd.'.app()->getLocale().'.crm.withdraw.successful-withdraw-request');
  }

}









/*=================================
=          Deposit Funds         =
=================================*/

public function depositFunds(Request $request){
  if($request->ac){
    $selected_account=$request->ac;
  }
  else{
    $selected_account="";
  }
  $bank_info = DB::table('broker_bank_information')->select('transfer_method','methods_logo_url','currency','commission','processing_time')->orderBy('id','desc')->first();
  return view('backEnd.'.app()->getLocale().'.crm.deposit.deposit-funds',compact('bank_info','selected_account'));
}







/*=================================
=       Transaction History       =
=================================*/ 

public function transactionHistory(){

  return view('backEnd.'.app()->getLocale().'.crm.withdraw.transaction-history');


}


public function transactionHistoryDatatable(Request $request){
  if(!$request->from || !$request->to || !$request->transaction_type){
    return view('errors.'.app()->getLocale().'.404');
  }
  $arrStart = explode("/", $request->from);
  $arrEnd = explode("/", $request->to);
  $start = Carbon::create($arrStart[2], $arrStart[1], $arrStart[0], 0, 0, 0);
  $end = Carbon::create($arrEnd[2], $arrEnd[1], $arrEnd[0], 23, 59, 59);
  $transaction_type=$request->transaction_type;

// $start = Carbon::now()->addMonths(-1);
//   $end = Carbon::now();
// $transaction_type='withdraw';
 if($transaction_type=='all'){

  $transactionHistory=DB::table('cms_account')->join('mt4_trades','cms_account.account_no','mt4_trades.LOGIN')->leftJoin('mt4_users','mt4_trades.LOGIN','=','mt4_users.LOGIN')->where([
    ['mt4_trades.CLOSE_TIME','<>','1970-01-01 00:00:00'],
    ['mt4_trades.CLOSE_TIME','>=',$start],
    ['mt4_trades.CLOSE_TIME','<=',$end],
    ['mt4_trades.CMD','>','5'],
    ['cms_account.email',session('login_email')],
    ['cms_account.account_no','<>','0'],
    ['cms_account.act_type','<>','IB'],
    ['cms_account.act_type','<>','DEMO']
    ])

  ->select(['mt4_trades.CLOSE_TIME','mt4_trades.LOGIN',DB::raw("CASE 
     WHEN mt4_trades.CMD=6 AND mt4_trades.PROFIT>=0 AND mt4_trades.COMMENT LIKE 'int tx%' THEN 'Internal Transfer In'
     WHEN mt4_trades.CMD=6 AND mt4_trades.PROFIT>=0 AND mt4_trades.COMMENT LIKE 'internal transfer%' THEN 'Internal Transfer In'
     WHEN mt4_trades.CMD=6 AND mt4_trades.PROFIT<0 AND mt4_trades.COMMENT LIKE 'int tx%' THEN 'Internal Transfer Out'
     WHEN mt4_trades.CMD=6 AND mt4_trades.PROFIT<0 AND mt4_trades.COMMENT LIKE 'internal transfer%' THEN 'Internal Transfer Out'  
     WHEN mt4_trades.CMD=6 AND mt4_trades.PROFIT>=0 THEN 'Deposit'
     WHEN mt4_trades.CMD=6 AND mt4_trades.PROFIT<0 THEN 'Withdraw'
     WHEN mt4_trades.CMD=7 AND mt4_trades.PROFIT>=0 THEN 'Credit In'
     ELSE  'Credit Out'
     END as Type_c "),DB::raw("CASE  
     WHEN mt4_trades.PROFIT < 0 THEN mt4_trades.PROFIT*(-1)
     ELSE mt4_trades.PROFIT
     END as Amount_c"),'mt4_trades.COMMENT']);
}

elseif($transaction_type=='deposit'){
   $transactionHistory=DB::table('cms_account')->join('mt4_trades','cms_account.account_no','mt4_trades.LOGIN')->leftJoin('mt4_users','mt4_trades.LOGIN','=','mt4_users.LOGIN')->where([
    ['mt4_trades.CLOSE_TIME','<>','1970-01-01 00:00:00'],
    ['mt4_trades.CLOSE_TIME','>=',$start],
    ['mt4_trades.CLOSE_TIME','<=',$end],
    ['mt4_trades.CMD','=','6'],
    ['mt4_trades.PROFIT','>=','0'],
    ['mt4_trades.COMMENT','NOT LIKE','int tx%'],
    ['mt4_trades.COMMENT','NOT LIKE','intenal transfer%'],
    ['cms_account.email',session('login_email')],
    ['cms_account.account_no','<>','0'],
    ['cms_account.act_type','<>','IB'],
    ['cms_account.act_type','<>','DEMO']
    ])

  ->select(['mt4_trades.CLOSE_TIME','mt4_trades.LOGIN',DB::raw("'Deposit' as Type_c"),DB::raw("mt4_trades.PROFIT 
as Amount_c"),'mt4_trades.COMMENT']);
}

elseif($transaction_type=='withdraw'){
  $transactionHistory=DB::table('cms_account')->join('mt4_trades','cms_account.account_no','mt4_trades.LOGIN')->leftJoin('mt4_users','mt4_trades.LOGIN','=','mt4_users.LOGIN')->where([
    ['mt4_trades.CLOSE_TIME','<>','1970-01-01 00:00:00'],
    ['mt4_trades.CLOSE_TIME','>=',$start],
    ['mt4_trades.CLOSE_TIME','<=',$end],
    ['mt4_trades.CMD','=','6'],
    ['mt4_trades.PROFIT','<','0'],
    ['mt4_trades.COMMENT','NOT LIKE','int tx%'],
    ['mt4_trades.COMMENT','NOT LIKE','intenal transfer%'],
    ['cms_account.email',session('login_email')],
    ['cms_account.account_no','<>','0'],
    ['cms_account.act_type','<>','IB'],
    ['cms_account.act_type','<>','DEMO']
    ])

  ->select(['mt4_trades.CLOSE_TIME','mt4_trades.LOGIN',DB::raw("'Withdraw' as Type_c"),DB::raw("mt4_trades.PROFIT*(-1) 
as Amount_c"),'mt4_trades.COMMENT']);
}

elseif($transaction_type=='credit_in'){
  $transactionHistory=DB::table('cms_account')->join('mt4_trades','cms_account.account_no','mt4_trades.LOGIN')->leftJoin('mt4_users','mt4_trades.LOGIN','=','mt4_users.LOGIN')->where([
    ['mt4_trades.CLOSE_TIME','<>','1970-01-01 00:00:00'],
    ['mt4_trades.CLOSE_TIME','>=',$start],
    ['mt4_trades.CLOSE_TIME','<=',$end],
    ['mt4_trades.CMD','=','7'],
    ['mt4_trades.PROFIT','>=','0'],
    ['mt4_trades.COMMENT','NOT LIKE','int tx%'],
    ['mt4_trades.COMMENT','NOT LIKE','intenal transfer%'],
    ['cms_account.email',session('login_email')],
    ['cms_account.account_no','<>','0'],
    ['cms_account.act_type','<>','IB'],
    ['cms_account.act_type','<>','DEMO']
    ])

  ->select(['mt4_trades.CLOSE_TIME','mt4_trades.LOGIN',DB::raw("'Credit In' as Type_c"),DB::raw("mt4_trades.PROFIT 
as Amount_c"),'mt4_trades.COMMENT']);
}

elseif($transaction_type=='credit_out'){
  $transactionHistory=DB::table('cms_account')->join('mt4_trades','cms_account.account_no','mt4_trades.LOGIN')->leftJoin('mt4_users','mt4_trades.LOGIN','=','mt4_users.LOGIN')->where([
    ['mt4_trades.CLOSE_TIME','<>','1970-01-01 00:00:00'],
    ['mt4_trades.CLOSE_TIME','>=',$start],
    ['mt4_trades.CLOSE_TIME','<=',$end],
    ['mt4_trades.CMD','=','7'],
    ['mt4_trades.PROFIT','<','0'],
    ['mt4_trades.COMMENT','NOT LIKE','int tx%'],
    ['mt4_trades.COMMENT','NOT LIKE','intenal transfer%'],
    ['cms_account.email',session('login_email')],
    ['cms_account.account_no','<>','0'],
    ['cms_account.act_type','<>','IB'],
    ['cms_account.act_type','<>','DEMO']
    ])

  ->select(['mt4_trades.CLOSE_TIME','mt4_trades.LOGIN',DB::raw("'Credit Out' as Type_c"),DB::raw("mt4_trades.PROFIT*(-1) 
as Amount_c"),'mt4_trades.COMMENT']);
}


else{
    $transactionHistory=DB::table('cms_account')->join('mt4_trades','cms_account.account_no','mt4_trades.LOGIN')->leftJoin('mt4_users','mt4_trades.LOGIN','=','mt4_users.LOGIN')->where([
    ['mt4_trades.CLOSE_TIME','<>','1970-01-01 00:00:00'],
    ['mt4_trades.CLOSE_TIME','>=',$start],
    ['mt4_trades.CLOSE_TIME','<=',$end],
    ['mt4_trades.CMD','=','6'],
    
    ['cms_account.email',session('login_email')],
    ['cms_account.account_no','<>','0'],
    ['cms_account.act_type','<>','IB'],
    ['cms_account.act_type','<>','DEMO']
    ])
  ->where(function ($query) {
                $query->where('mt4_trades.COMMENT','LIKE','int tx%')
                      ->orWhere('mt4_trades.COMMENT','LIKE','intenal transfer%');
            })


  ->select(['mt4_trades.CLOSE_TIME','mt4_trades.LOGIN',DB::raw("CASE 
     WHEN mt4_trades.CMD=6 AND mt4_trades.PROFIT>=0 AND mt4_trades.COMMENT LIKE 'int tx%' THEN 'Internal Transfer In'
     WHEN mt4_trades.CMD=6 AND mt4_trades.PROFIT>=0 AND mt4_trades.COMMENT LIKE 'internal transfer%' THEN 'Internal Transfer In'
     WHEN mt4_trades.CMD=6 AND mt4_trades.PROFIT<0 AND mt4_trades.COMMENT LIKE 'int tx%' THEN 'Internal Transfer Out'
     ELSE 'Internal Transfer Out'
     END as Type_c"),DB::raw("CASE  
     WHEN mt4_trades.PROFIT < 0 THEN mt4_trades.PROFIT*(-1)
     ELSE mt4_trades.PROFIT
     END 
as Amount_c"),'mt4_trades.COMMENT']);
}




    $datatables = Datatables::of($transactionHistory);


    return $datatables
    
    ->filterColumn('Type_c', function ($query, $keyword) {
      $query->whereRaw("CASE 
     WHEN mt4_trades.CMD=6 AND mt4_trades.PROFIT>=0 AND mt4_trades.COMMENT LIKE 'int tx%' THEN 'Internal Transfer In'
     WHEN mt4_trades.CMD=6 AND mt4_trades.PROFIT>=0 AND mt4_trades.COMMENT LIKE 'internal transfer%' THEN 'Internal Transfer In'
     WHEN mt4_trades.CMD=6 AND mt4_trades.PROFIT<0 AND mt4_trades.COMMENT LIKE 'int tx%' THEN 'Internal Transfer Out'
     WHEN mt4_trades.CMD=6 AND mt4_trades.PROFIT<0 AND mt4_trades.COMMENT LIKE 'internal transfer%' THEN 'Internal Transfer Out'  
     WHEN mt4_trades.CMD=6 AND mt4_trades.PROFIT>=0 THEN 'Deposit'
     WHEN mt4_trades.CMD=6 AND mt4_trades.PROFIT<0 THEN 'Withdraw'
     WHEN mt4_trades.CMD=7 AND mt4_trades.PROFIT>=0 THEN 'Credit In'
     ELSE  'Credit Out'
     END LIKE ?", ["%$keyword%"]);
    })
    ->filterColumn('Amount_c', function ($query, $keyword) {
      $query->whereRaw("CASE  
     WHEN mt4_trades.PROFIT < 0 THEN mt4_trades.PROFIT*(-1)
     ELSE mt4_trades.PROFIT
     END LIKE ?", ["%$keyword%"]);
    })

    ->make(true);
}



/*=================================
=                FAQs             =
=================================*/

public function getContest(){
  return view('backEnd.'.app()->getLocale().'.crm.contest.contest');
}

/*=================================
=                FAQs             =
=================================*/

public function getMamPammPlatform(){
  return view('backEnd.'.app()->getLocale().'.crm.mam-pamm.mam-pamm-platform');
}

/*=================================
=                FAQs             =
=================================*/

public function getFaqs(){
  return view('backEnd.'.app()->getLocale().'.crm.faqs.faqs');
}


public function identityDetails(){

  $doc=DB::table('cms_verification')->where(['email'=>session('login_email'),'document_type' => 'ID Proof'])->orderBy('int_id','desc')->get();

  return view ('backEnd.'.app()->getLocale().'.crm.profile.identity-details',compact('doc'));
}

public function residenceDetails(){
  $doc=DB::table('cms_verification')->where(['email'=>session('login_email'),'document_type' => 'Address Proof'])->orderBy('int_id','desc')->get();

  return view ('backEnd.'.app()->getLocale().'.crm.profile.residence-details',compact('doc'));
}

public function identityDocumentUpload(Request $request)
{
  $this->validate($request, [

    'file' => 'mimes:jpeg,png,jpg,gif,tif,tiff,pdf|max:3072'

  ]);
  $client_url = DB::table('general_information')->select('client_portal_url')->first();
  if($request->file){
    $document_type="ID Proof";

    $file = 'IdProof-'.time().'.'.$request->file->getClientOriginalExtension();

    $request->file->move(public_path('/documents/'), $file);
    $intIds=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
    $intId=$intIds->intId;
    DB::table('cms_verification')->insert([
      'document_type'=>$document_type,
      'document'=>$client_url->client_portal_url.'/documents/'.$file,
      'date_time'=>date("Y-m-d H:i:s"),
      'status'=>'0',
      'email'=>session('login_email'),
      'userId'=>$intId
    ]);
  }

}

public function residentDocumentUpload(Request $request)
{
  $this->validate($request, [

    'file' => 'mimes:jpeg,png,jpg,gif,tif,tiff,pdf|max:3072'

  ]);
  $client_url = DB::table('general_information')->select('client_portal_url')->first();
  if($request->file){
    $document_type="Address Proof";

    $file = 'ResProof-'.time().'.'.$request->file->getClientOriginalExtension();

    $request->file->move(public_path('/documents/'), $file);
    $intIds=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
    $intId=$intIds->intId;
    DB::table('cms_verification')->insert([
      'document_type'=>$document_type,
      'document'=>$client_url->client_portal_url.'/documents/'.$file,
      'date_time'=>date("Y-m-d H:i:s"),
      'status'=>'0',
      'email'=>session('login_email'),
      'userId'=>$intId
    ]);
  }

}
public function notVerified(){
  return view ('backEnd.'.app()->getLocale().'.crm.profile.not-verified');
}

public function bankFunds(Request $request){
  if($request->ac){
    $selected_account=$request->ac;
  }
  else{
    $selected_account="";
  }
  $accounts = DB::table('cms_account')->join('mt4_users','mt4_users.LOGIN','=','cms_account.account_no')->select(['cms_account.account_no','mt4_users.BALANCE as balance',DB::raw('CONCAT(cms_account.account_no," ( ",cms_account.act_type," )") as acc_no')])->where([['cms_account.act_type','<>','DEMO'],['cms_account.act_type','<>','NULL'],['cms_account.email','=',session('login_email')]])->orderBy('cms_account.account_no','desc')->get();
  $bank_info = DB::table('broker_bank_information')->select('*')->orderBy('id','desc')->first();
  return view ('backEnd.'.app()->getLocale().'.crm.deposit.bank-transfer-funds',compact('bank_info','accounts','selected_account'));
}
public function bankWithdrawFunds(Request $request){
  if($request->ac){
    $selected_account=$request->ac;
  }
  else{
    $selected_account="";
  }
  $accounts = DB::table('cms_account')->join('mt4_users','mt4_users.LOGIN','=','cms_account.account_no')->select(['cms_account.account_no','mt4_users.BALANCE as balance',DB::raw('CONCAT(cms_account.account_no," ( ",cms_account.act_type," )") as acc_no')])->where([['cms_account.act_type','<>','DEMO'],['cms_account.act_type','<>','NULL'],['cms_account.email','=',session('login_email')]])->orderBy('cms_account.account_no','desc')->get();
  $bank_info = DB::table('broker_bank_information')->select('*')->orderBy('id','desc')->first();
  $info=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
  $countries=DB::table('countries')->get();

  return view ('backEnd.'.app()->getLocale().'.crm.withdraw.bank-withdraw-funds1',compact('bank_info','accounts','selected_account','info','countries'));
}


public function postBankWithdrawFunds(BankInformationRequest $request){

  $balance=DB::table('mt4_users')->where('LOGIN',$request->transfer_from)->first();
  if($balance){
    $BALANCE=$balance->BALANCE;
  }
  else{
    $BALANCE=0;
  }
  
  if(is_numeric($request->amount)==false){
    return redirect('/bank-withdraw-funds')->withErrors(['Please Enter a valid amount']);
  }
  
  elseif($request->amount<1){
    return redirect('/bank-withdraw-funds')->withErrors(['Minimum Bank Transfer is 1 usd']);
  }
  elseif($BALANCE>=$request->amount && $request->amount>=1){
    $profile=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
    $name=$profile->fname.' '.$profile->lname;
    $request->payment_type='Bank Wire Transfer';
    $request->net_amount=$request->amount;
    $request->bank_iban=$request->bank_acc_num;
    $request->bank_account=$request->bank_acc_name;
    $request->bank_swift=$request->swift_num;
    $email_adds = $this->email_adds();
    
    $from_email_id=$email_adds->noreply_email;  
    $from_name=config('app.name');
    $user_mail=session('login_email');
    $mail_subject='Verification Code for Withdraw Funds';
    $verification_code=mt_rand(100000, 999999);
    session(['verification_code' => $verification_code]);
    Session::save();
    $data = array('mail_data' => $this->mail_data(), 'name' => $name , 'verification_code' => session('verification_code'));
    Mail::send('backEnd.'.app()->getLocale().'.crm.mail.email-template',
      $data, function($message)use ($from_email_id,$from_name,$user_mail, $name,$mail_subject)
      {
        $message->from($from_email_id,$from_name);
        $message->to($user_mail, $name)->subject($mail_subject);
      });


    return view('backEnd.'.app()->getLocale().'.crm.withdraw.verification_code',compact('request'));
  }

  else {
    return redirect('/bank-withdraw-funds')->withErrors(['Your balance is not sufficient for this withdrawal request']);
  }

}




}
