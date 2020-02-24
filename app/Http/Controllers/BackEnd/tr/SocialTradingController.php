<?php
namespace App\Http\Controllers\BackEnd\tr;
use Illuminate\Http\Request;
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

class SocialTradingController extends Controller
{
  /**
   * Constructor function
   */
  public function __construct()
  {
    $this->middleware('adminAccess');
  }
  
  /**
   * Getting Server Configurations
   */
  public function serverConfigs(){
    $server_configs=DB::table('server_configs')->first();
    return $server_configs;
  }
  /**
   * Email Additions
   */
  public function email_adds(){
    $email_adds=DB::table('cms_email_addresses')->first();
    return $email_adds;
  }
  /**
   * Mail Data
   */
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
  }
  /**
   * Showing Managers list for Openning Investor Account 
   */
  public function testChart(){
    return view('backEnd.'.app()->getLocale().'.crm.account.socialTrading.test-chart');
  }
  
  public function showManagers(){
    try {
      // Current Month
      $from = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
      $to = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
      // Previous 6 Months
      $firstDayofPreviousMonth = Carbon::now()->startOfMonth()->subMonth()->toDateString();
      $lastDayofPreviousMonth = Carbon::now()->subMonth()->endOfMonth()->toDateString();
      
      $firstDayofPreviousMonth2 = Carbon::now()->startOfMonth()->subMonths(2)->toDateString();
      $lastDayofPreviousMonth2 = Carbon::now()->subMonths(2)->endOfMonth()->toDateString();

      $firstDayofPreviousMonth3 = Carbon::now()->startOfMonth()->subMonths(3)->toDateString();
      $lastDayofPreviousMonth3 = Carbon::now()->subMonths(3)->endOfMonth()->toDateString();

      $firstDayofPreviousMonth4 = Carbon::now()->startOfMonth()->subMonths(4)->toDateString();
      $lastDayofPreviousMonth4 = Carbon::now()->subMonths(4)->endOfMonth()->toDateString();

      $firstDayofPreviousMonth5 = Carbon::now()->startOfMonth()->subMonths(5)->toDateString();
      $lastDayofPreviousMonth5 = Carbon::now()->subMonths(5)->endOfMonth()->toDateString();

      $firstDayofPreviousMonth6 = Carbon::now()->startOfMonth()->subMonths(6)->toDateString();
      $lastDayofPreviousMonth6 = Carbon::now()->subMonths(6)->endOfMonth()->toDateString();

      $managers = DB::table('cms_account')
      ->where('cms_account.trader_type', 1)
      ->join('cms_liveaccount', 'cms_account.email', '=', 'cms_liveaccount.email')
    // calculating total profit for a manager
      ->leftJoin(DB::raw('(SELECT LOGIN, PROFIT, sum(PROFIT) totalProfit FROM mt4_trades WHERE CMD<2 AND CLOSE_TIME <> "1970-01-01 00:00:00" group by LOGIN ) mt'), 'cms_account.account_no','=','mt.LOGIN')
    // calculating this month profit for a manager
      ->leftJoin(DB::raw('(SELECT LOGIN, PROFIT, sum(PROFIT) totalMonthlyProfit FROM mt4_trades WHERE CMD<2 AND CLOSE_TIME <> "1970-01-01 00:00:00" AND CLOSE_TIME BETWEEN "'.$from.'" AND "'.$to.'" group by LOGIN ) mt1'), 'cms_account.account_no','=','mt1.LOGIN')
    // calculating previous 6 months' profit for a manager
      ->leftJoin(DB::raw('(SELECT LOGIN, PROFIT, sum(PROFIT) totalPreviousMonthlyProfit1 FROM mt4_trades WHERE CMD<2 AND CLOSE_TIME <> "1970-01-01 00:00:00" AND CLOSE_TIME BETWEEN "'.$firstDayofPreviousMonth.'" AND "'.$lastDayofPreviousMonth.'" group by LOGIN ) pvmt1'), 'cms_account.account_no','=','pvmt1.LOGIN')
      ->leftJoin(DB::raw('(SELECT LOGIN, PROFIT, sum(PROFIT) totalPreviousMonthlyProfit2 FROM mt4_trades WHERE CMD<2 AND CLOSE_TIME <> "1970-01-01 00:00:00" AND CLOSE_TIME BETWEEN "'.$firstDayofPreviousMonth2.'" AND "'.$lastDayofPreviousMonth2.'" group by LOGIN ) pvmt2'), 'cms_account.account_no','=','pvmt2.LOGIN')
      ->leftJoin(DB::raw('(SELECT LOGIN, PROFIT, sum(PROFIT) totalPreviousMonthlyProfit3 FROM mt4_trades WHERE CMD<2 AND CLOSE_TIME <> "1970-01-01 00:00:00" AND CLOSE_TIME BETWEEN "'.$firstDayofPreviousMonth3.'" AND "'.$lastDayofPreviousMonth3.'" group by LOGIN ) pvmt3'), 'cms_account.account_no','=','pvmt3.LOGIN')
      ->leftJoin(DB::raw('(SELECT LOGIN, PROFIT, sum(PROFIT) totalPreviousMonthlyProfit4 FROM mt4_trades WHERE CMD<2 AND CLOSE_TIME <> "1970-01-01 00:00:00" AND CLOSE_TIME BETWEEN "'.$firstDayofPreviousMonth4.'" AND "'.$lastDayofPreviousMonth4.'" group by LOGIN ) pvmt4'), 'cms_account.account_no','=','pvmt4.LOGIN')
      ->leftJoin(DB::raw('(SELECT LOGIN, PROFIT, sum(PROFIT) totalPreviousMonthlyProfit5 FROM mt4_trades WHERE CMD<2 AND CLOSE_TIME <> "1970-01-01 00:00:00" AND CLOSE_TIME BETWEEN "'.$firstDayofPreviousMonth5.'" AND "'.$lastDayofPreviousMonth5.'" group by LOGIN ) pvmt5'), 'cms_account.account_no','=','pvmt5.LOGIN')
      ->leftJoin(DB::raw('(SELECT LOGIN, PROFIT, sum(PROFIT) totalPreviousMonthlyProfit6 FROM mt4_trades WHERE CMD<2 AND CLOSE_TIME <> "1970-01-01 00:00:00" AND CLOSE_TIME BETWEEN "'.$firstDayofPreviousMonth6.'" AND "'.$lastDayofPreviousMonth6.'" group by LOGIN ) pvmt6'), 'cms_account.account_no','=','pvmt6.LOGIN')
    // joining with the st_manager_investors table for counting total investors
      ->leftJoin(DB::raw('(SELECT id, manager_id, investor_id, count(investor_id) totalInvestor FROM st_manager_investors) st_m_i'), 'cms_account.int_id','=','st_m_i.manager_id')
    // selecting fields

      ->select('cms_account.int_id', 'cms_account.act_type','cms_account.st_username','cms_account.leverage','cms_account.email','cms_account.account_no','cms_account.account_currency','cms_account.date_time', 'cms_liveaccount.fname','cms_liveaccount.lname', 'mt.LOGIN','mt.totalProfit','mt1.totalMonthlyProfit', 'st_m_i.totalInvestor','pvmt1.totalPreviousMonthlyProfit1','pvmt2.totalPreviousMonthlyProfit2','pvmt3.totalPreviousMonthlyProfit3','pvmt4.totalPreviousMonthlyProfit4','pvmt5.totalPreviousMonthlyProfit5','pvmt6.totalPreviousMonthlyProfit6')
      ->get();

      $managers = $managers->toArray();

      array_multisort( array_column($managers, "totalProfit"), SORT_ASC, $managers);

      return view('backEnd.'.app()->getLocale().'.crm.account.socialTrading.manager-list',compact('managers')); 

    } catch (\Throwable $th) {
      //throw $th;
      return $th->getMessage();
    }
  }


  /**
   * Showing Openning Investor Account  Page
   */
  public function openInvestorAccount(Request $request){
    try {
      $manager_id = $request->manager_id;
      //return $manager_id;
      if (!$manager_id || !is_numeric($manager_id)) {
        return view('errors.'.app()->getLocale().'.404');
      }
      // storing the manager int_id in Session
      //session(['manager_id' => $manager_id]);
      // checking manager exist or not
      $isExist = DB::table('cms_account')->where('int_id', $manager_id)->first();
      //dd ($isExist);
      if(!$isExist) 
        return view('errors.'.app()->getLocale().'.404');
      return view('backEnd.'.app()->getLocale().'.crm.account.socialTrading.open-investor-account',compact('manager_id')); 
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }
  /**
   * Opening Investor Account
   * @param accountInfo
   */
  public function confirmInvestorAccount(Request $request)
  {
    try {
      //return $request->all();
      $manager_id = $request->manager_id;
      $password = $request->password;
      $c_password = $request->c_password;
      if(!$manager_id || !$password || !$c_password || !is_numeric($manager_id)) 
      {
        Session::flash('error','Invalid info');
        return Redirect::back();
      }
      // checking manager exist or not and connecting to the mt4_users table to get the leverage
      //$isExist = DB::table('cms_account')->where('int_id', $manager_id)->first();
      $manager = DB::table('cms_account')
      ->where('cms_account.trader_type', 1)
      ->where('cms_account.int_id', $manager_id)
      ->Join('mt4_users', 'cms_account.account_no','mt4_users.LOGIN')
      ->Join('st_managersettings', 'st_managersettings.cmsaccount_id','cms_account.int_id')
      ->select('cms_account.int_id', 'cms_account.act_type','mt4_users.LEVERAGE','mt4_users.GROUP','cms_account.email','cms_account.account_no','cms_account.account_currency','cms_account.date_time','st_managersettings.profit_sharing')
      ->first();
      if(!$manager) 
        return 'manager missing';
      //return (json_encode($manager->LEVERAGE));
      $leverage = json_encode($manager->LEVERAGE);
      $group = $manager->GROUP; // client group
      // return $group;
      // Openning a investor account
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
      
      if($request->password != $request->c_password){
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

        //return json_encode($data);
      if($city=='' || $address=='' || $postal_code=='' || $state==''){
        Session::flash('profile-error','Please Complete your profile information');
        return redirect('/profile');

      }
        //$group = $request->account_type;

        $max_allowance=DB::table('cms_account_type')->where([
          ['ac_name',$data->email],
          ['mt4_ac_type',$group],
          ['demo_live','live_manager']
        ])->first();
          //return json_encode($max_allowance);
        if(!$max_allowance){
          $max_allowance=DB::table('cms_account_type')->where([
            ['ac_name','Default'],
            ['mt4_ac_type',$group],
            ['demo_live','live_manager']
          ])->first();
      }
        //return json_encode($max_allowance);
      if($data->owner_type=='personal'){
        $allowance=$max_allowance->max_allowance_personal;
      }
      else{
        $allowance=$max_allowance->max_allowance_corporate;
      }
      $act_type = $max_allowance->account_type;
        //return $act_type;
      $accounts_already=DB::table('cms_account')->where([
        ['email',$data->email],
        ['act_type',$act_type],
        ['trader_type', 2],
      ])->get();
        //return $accounts_already;
      $total_accounts=count($accounts_already);
        //return $total_accounts;
      if($total_accounts>=$allowance){
        Session::flash('max_allowance_error','You have excceeded maximum allowance of trading accounts for this account type.');
        return Redirect::back();
      }
      
      $password = "Asdf123$";
      $investor_password= base64_encode($request->password);
      
      $pass=base64_encode($password);
      
        //$leverage = $request->leverage; // assigned before
      $date_time=date("Y-m-d H:i:s");
      
      $server_configs=$this->serverConfigs();

        //return json_encode($server_configs);
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

    $last_id=DB::table('cms_account')->insertGetId([
      'leverage' => $leverage,
      'email' => session('login_email'),
      'affiliate_code'=>$affiliate_code,
      'act_type'=>$act_type,
      'reference_no'=>$reference_no,
      'password'=>$password,
      'investor_password'=>$pass,
      'account_no'=>$login_id,
      'date_time'=>$date_time,
        'trader_type' => 2 // 2 for investor account
      ]); 

    $query=DB::table('cms_account_series')->insert([

      ['account_no'=>$login_id]
      
    ]);

    $email_adds = $this->email_adds();
    $from_mail = $email_adds->noreply_email;
    $user_mail=session('login_email');

    $mail_subject=config('app.name').' investor account Details';
    $mail_data=$this->mail_data();
    $data=array(
      'date'=>$date_time,
      'name'=>$name,
      'login'=>$login_id,
      'investor_password'=>$pass,
      'mail_data'=>$mail_data
    );
      // inserting into the st_manager_investors table
    $investor = DB::table('st_manager_investors')->insert([
      'manager_id' => $manager_id,
        'investor_id' => $last_id,// New inserted investor account
        'profit_sharing' => $manager->profit_sharing,
      ]);
      // End of Inserting
    Mail::send('backEnd.'.app()->getLocale().'.crm.mail.open-investor-account-mail',
      $data, function($message)use ($user_mail, $name,$mail_subject,$from_mail)
      {
        $message->from($from_mail,config('app.name'));
        $message->to($user_mail, $name)->subject($mail_subject);
      });

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

    return view('backEnd.'.app()->getLocale().'.crm.account.socialTrading.open-investor-account-confirmation',compact('request','password','login_id','investor_password','server_client','download_link'));

  } catch (\Throwable $th) {
    return $th->getMessage();
  }
}

  /**
   * Showing the Account Opening Page for Manager Account
   * @param null
   */
  public function openManagerAccount(Request $request)
  {
    try {

      $cms_account = DB::table('cms_account_type')->where([
        ['demo_live','live_manager'],
        ['ac_name','Default'],
        ['status','=',1]
      ])->get();

      //return $cms_account;

      $leverage = DB::table('cms_leverage')->get(['int_id','leverage']);

      //return $leverage;

      return view('backEnd.'.app()->getLocale().'.crm.account.socialTrading.open-manager-account',compact('cms_account','leverage')); 

    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }
    /**
   * Opening Manager Account
   * @param accountInfo
   */
    public function confirmManagerAccount(Request $request)
    {
      try {

      //return $request->all(); 
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

        $username_exists = CMS_Account::where('st_username',$request->username)->first();
        if($username_exists){
          Session::flash('error','This username has already been taken');
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
          ['demo_live','live_manager']
        ])->first();
        if(!$max_allowance){
          $max_allowance=DB::table('cms_account_type')->where([
            ['ac_name','Default'],
            ['mt4_ac_type',$group],
            ['demo_live','live_manager']
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
          ['act_type',$act_type],
        ['trader_type',1] // 1 for manager account
      ])->get();

        $total_accounts=count($accounts_already);


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

      $sql = DB::table('cms_account')->insertGetId([
        'leverage' => $request->leverage,
        'email' => session('login_email'),
        'affiliate_code'=>$affiliate_code,
        'act_type'=>$act_type,
        'reference_no'=>$reference_no,
        'password'=>$password,
        'investor_password'=>$pass,
        'account_no'=>$login_id,
        'date_time'=>$date_time,
        'trader_type' => 1, 
        'st_username' => $request->username
      ]); 


      DB::table('st_managersettings')->insert([
        'profit_sharing' => $request->profit_share,
        'profit_sharing_time' => $request->profit_share_time,
        'cmsaccount_id' => $sql,
        'allocation_type' => 2
      ]);

      $query=DB::table('cms_account_series')->insert([
        ['account_no'=>$login_id]
      ]);

      $email_adds = $this->email_adds();
      $from_mail = $email_adds->noreply_email;
      $user_mail=session('login_email');
      $mail_subject=config('app.nam.socialTradinge').' manager account Details';
      $mail_data=$this->mail_data();
      $data=array(
        'date'=>$date_time,
        'name'=>$name,
        'st_username' => $request->username,
        'login'=>$login_id,
        'password'=>$password,
        'investor_password'=>$pass,
        'mail_data'=>$mail_data
      );
      Mail::send('backEnd.'.app()->getLocale().'.crm.mail.open-manager-account-mail',
        $data, function($message)use ($user_mail, $name,$mail_subject,$from_mail)
        {
          $message->from($from_mail,config('app.name'));
          $message->to($user_mail, $name)->subject($mail_subject);
        });

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
      $st_username = $request->username;
      return view('backEnd.'.app()->getLocale().'.crm.account.socialTrading.open-manager-account-confirmation',compact('request','st_username','password','login_id','investor_password','server_client','download_link'));

    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }

  /**
   * Getting the Details of a strategic Manager
   * @param manager_id
   */
  public function getManagerDetail(Request $request, $manager_id)
  {

    if(!$manager_id || !is_numeric($manager_id)) return "Manager missing";

      // manager detail
    $managerDetail = CMS_Account::where('int_id', $manager_id)->first();

    if(!$managerDetail) return "manager Missing";

      // manager settings
    $managerSettings = DB::table('st_managersettings')->where('cmsaccount_id', $manager_id)->first();

      //return $managerSettings;

      // Closed Trades
    $managerTrades = DB::table('mt4_trades')->where('LOGIN', $managerDetail->account_no)->get();

    //return count($managerTrades);

    //return $managerTrades;

      // Total profit
    $totalProfit = DB::table('mt4_trades')->where('LOGIN', $managerDetail->account_no)->where('CLOSE_TIME', '<>', '1970-01-01 00:00:00')->where('CMD', '<', 2)->sum('PROFIT');

      //return $totalProfit;

      // Total number of investors
    $totalInvestors = DB::table('st_manager_investors')->where('manager_id', $managerDetail->int_id)->count();

      //return $totalInvestors;

      //return $totalInvestors;
      // Current Month
    $from = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');

    $to = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');

    $thisMonthProfit = DB::table('mt4_trades')->where('LOGIN', $managerDetail->account_no)->where('CLOSE_TIME', '<>', '1970-01-01 00:00:00')->where('CMD', '<', 2)->whereBetween('CLOSE_TIME', [$from, $to])->sum('PROFIT');



    $monthsWiseProfit = DB::table("mt4_trades")
        ->select(DB::raw("(SUM(PROFIT)) as totalMonthlyProfit ")) // total PROFIT
        ->where('LOGIN', $managerDetail->account_no)
        ->where('CLOSE_TIME', '<>', '1970-01-01 00:00:00') // only close trades
        ->where('CMD', '<', 2) // only trades
        ->groupBy(DB::raw("MONTH(CLOSE_TIME)")) // monthly
        ->get();

        $categories = array();
        $start    = (new \DateTime($managerDetail->date_time))->modify('first day of this month');
        $end      = (new \DateTime())->modify('last day of this month');
        $interval = \DateInterval::createFromDateString('1 month');
        $period   = new \DatePeriod($start, $interval, $end);

        foreach ($period as $key => $dt) {

          $categories[$key] = $dt->format("Y-m-d H:i:s");

        }

        //return $categories;

        $profits = array ();
        for ($i=0; $i < count($categories); $i++) { 

         $start1 = Carbon::parse($categories[$i])->format('Y-m-d H:i:s');

         $end1 = Carbon::parse($categories[$i])->endOfMonth()->format('Y-m-d H:i:s');

         //return $end1;

         $thisMonthProfit = DB::table('mt4_trades')->where('LOGIN', $managerDetail->account_no)->where('CLOSE_TIME', '<>', '1970-01-01 00:00:00')->where('CMD', '<', 2)->whereBetween('CLOSE_TIME', [$start1, $end1])->sum('PROFIT');

         //return $thisMonthProfit;
         $profits[$i] = $thisMonthProfit;

         $categories[$i] = Carbon::parse($categories[$i])->format('M, Y');

       }
        //return $profits;

        // converting the object to array with only the profit
        //example [1,2,3,-2]
       $onlyMonthlyProfit = array();

       for ($i = 0; $i < count($monthsWiseProfit); $i++) {

        $onlyMonthlyProfit[$i] = $monthsWiseProfit[$i]->totalMonthlyProfit;

      }

      $dayWiseProfit = DB::table("mt4_trades")
        ->select('CLOSE_TIME as ctime',DB::raw("(SUM(PROFIT)) as totalDailyProfit ")) // total PROFIT
        ->where('LOGIN', $managerDetail->account_no)
        ->where('CLOSE_TIME', '<>', '1970-01-01 00:00:00') // only close trades
        ->where('CMD', '<', 2) // only trades
        ->groupBy(DB::raw("DAY(CLOSE_TIME)")) // daily
        ->get();

        //return $dayWiseProfit->toArray();

        $sakil = [];

        $key1 = 0;

        foreach ($dayWiseProfit as $key => $profit) {

          //$sakil[$key][$key1] = Carbon::parse($profit->ctime)->format('Y-m-d');

          $sakil[$key][$key1] = strtotime(Carbon::parse($profit->ctime)->format('Y-m-d H:i:s'))*1000;

          //$sakil[$key][$key1] = $profit->ctime;

          $key1++;

          $sakil[$key][$key1] = $profit->totalDailyProfit;

          $key1 = 0;

        }

        //return $sakil;
      //return $monthsWiseProfit;


        // Date Printing
        $period = new \DatePeriod(new \DateTime($managerDetail->date_time), new \DateInterval('P1D'), new \DateTime());
        $dailyTrades = array();
        $t = 0;
        foreach ($period as $key => $value) {

          $start1 = $value->format('Y-m-d');

          $end1 = Carbon::parse($start1)->endOfMonth()->format('Y-m-d');

          $s = DB::table('mt4_trades')->where('LOGIN', $managerDetail->account_no)->where('CLOSE_TIME', '<>', '1970-01-01 00:00:00')->where('CMD', '<', 2)->whereBetween('CLOSE_TIME', [$start1, $end1])->sum('PROFIT');

          $dailyTrades[$key][$t] = strtotime(Carbon::parse($start1)->format('Y-m-d H:i:s'))*1000;

          $dailyTrades[$key][++$t] = $s;

          $t=0;

          $dailyDates[$key] = strtotime(Carbon::parse($start1)->format('Y-m-d H:i:s'))*1000;

        }

        //return count($dailyTrades);



        // Trade starting time
        $managerTradesCloseTime = DB::table('mt4_trades')
        ->select('TICKET','PROFIT')
        ->where('LOGIN', $managerDetail->account_no)
        ->where('CLOSE_TIME', '<>', '1970-01-01 00:00:00') 
        ->where('CMD', '<', 2) 
        ->get()
        ->toArray();

        $justGraph = array();
        $jg = 0;
        $sakilArray = array();
        foreach ($managerTradesCloseTime as $key => $trade) {

          //return $trade->PROFIT;
          $justGraph[$key][$jg] = $trade->TICKET;
          $justGraph[$key][++$jg] = $trade->PROFIT;
          $jg = 0;

          // total profit till $trade->TICKET
          $totalProfitTillThisTicket = DB::table('mt4_trades')
          ->select(DB::raw("(SUM(PROFIT)) as profitsTillNow"))
          ->where('LOGIN', $managerDetail->account_no)
          ->where('CLOSE_TIME', '<>', '1970-01-01 00:00:00') 
          ->where('CMD', '<', 2)
          ->where('TICKET', '<=', $trade->TICKET)
          ->orderBy('TICKET', 'asc')
          ->get();

          //return $totalProfitTillThisTicket;
          //return $totalProfitTillThisTicket[0]->profitsTillNow;
          array_push($sakilArray, round($totalProfitTillThisTicket[0]->profitsTillNow, 2));
        }

        //return $sakilArray;

        $sakil1 = array_column($managerTradesCloseTime, 'TICKET');

        $sakil2 = array_column($managerTradesCloseTime, 'PROFIT');

        //return $justGraph;


        // Getting the total Number of trades
        $totalTrades = DB::table('mt4_trades')->where('LOGIN', $managerDetail->account_no)->where('CLOSE_TIME', '<>', '1970-01-01 00:00:00')->where('CMD', '<', 2)->count('*');
        //return $totalTrades;


        // Trades VS symbols graph
        $test = DB::table("mt4_trades")
        ->select('SYMBOL', DB::raw("(COUNT(LOGIN)) as totalTrades"))
        ->where('LOGIN', $managerDetail->account_no)
        ->where('CLOSE_TIME', '<>', '1970-01-01 00:00:00') // only close trades
        ->where('CMD', '<', 2) // only trades
        ->groupBy('SYMBOL') // monthly
        ->distinct()
        ->get()
        ->toArray();

        //return $test;
        $symbols = array_column($test, 'SYMBOL');

        $trades = array_column($test, 'totalTrades');

        //print_r( $trades );

        //return $symbols;
        // End of trades vs symbols graph

        // WEEKDAY
        $weekDay = DB::table("mt4_trades")
        ->select('CMD','CLOSE_TIME as ctime',DB::raw("(COUNT(LOGIN)) as totalTrades")) // total PROFIT
        ->where('LOGIN', $managerDetail->account_no)
        ->where('CLOSE_TIME', '<>', '1970-01-01 00:00:00') // only close trades
        ->where('CMD', '<', 2) // only trades
        ->groupBy(DB::raw("WEEKDAY(CLOSE_TIME)")) // weekday monday, tuesday, wednesday, thursday, friday
        ->get()
        ->toArray();


        //return $weekDay;

        $weekDays = array(); $weekDayTrades = array(); $weekDayBuyTrades = array(); $weekDaySellTrades = array();
        foreach ($weekDay as $key => $profit) {
          //return Carbon::parse($profit->ctime)->format('l'); // full day name
          $weekDays[$key] = Carbon::parse($profit->ctime)->format('l');
          $weekDayTrades[$key] = $profit->totalTrades;

          // filtering
          if($profit->CMD == 0)
          {
            array_push($weekDayBuyTrades, $profit->totalTrades);
            array_push($weekDaySellTrades, 0);
          }
          else if($profit->CMD == 1){
            array_push($weekDayBuyTrades, 0);
            array_push($weekDaySellTrades, $profit->totalTrades);
          }

        }

        //return $weekDayBuyTrades;

       // HOURLY TRADE
        $hourlyTrade = DB::table("mt4_trades")
        ->select('CMD','CLOSE_TIME as ctime',DB::raw("(COUNT(LOGIN)) as totalTrades")) // total PROFIT
        ->where('LOGIN', $managerDetail->account_no)
        ->where('CLOSE_TIME', '<>', '1970-01-01 00:00:00') // only close trades
        ->where('CMD', '<', 2) // only trades
        ->groupBy(DB::raw("HOUR(CLOSE_TIME)")) // weekday monday, tuesday, wednesday, thursday, friday
        ->get()
        ->toArray();

        //return $hourlyTrade;

        $hour = array(); $hourlyTrades = array (); 

        $hours = array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23");

        $hourlyBuyTrades = array(); $hourlySellTrades = array();

        for ($i=0; $i < 24; $i++) { 

          $flag = 0; $result = 0; $cmd = 0;
          
          foreach ($hourlyTrade as $key => $profit) {
            //return Carbon::parse($profit->ctime)->format('H'); // full day name

            $h = Carbon::parse($profit->ctime)->format('H');

            //echo $h." ";

            if($hours[$i] == $h) {

              $result = $profit->totalTrades;
              $cmd = $profit->CMD;
              break;

            }


          }

          array_push($hourlyTrades, $result);

          // filtering
          if($cmd == 0)
          {
            array_push($hourlyBuyTrades, $result);
            array_push($hourlySellTrades, 0);
          }
          else if($cmd == 1){
            array_push($hourlyBuyTrades, 0);
            array_push($hourlySellTrades, $result);
          }
          
        }
        //return $hourlyBuyTrades;

        // Finding Profitable trade percentage
        $profitableTrade = DB::table("mt4_trades")
        ->where('LOGIN', $managerDetail->account_no)
        ->where('CLOSE_TIME', '<>', '1970-01-01 00:00:00') // only close trades
        ->where('CMD', '<', 2) // only trades
        ->where('PROFIT', '>', 0)
        ->count();
        

        //return $profitableTrade;

        $nonProfitableTrade = DB::table("mt4_trades")
        ->where('LOGIN', $managerDetail->account_no)
        ->where('CLOSE_TIME', '<>', '1970-01-01 00:00:00') // only close trades
        ->where('CMD', '<', 2) // only trades
        ->where('PROFIT', '<', 0)
        ->count();

        //return $nonProfitableTrade;

        $buyTrades = DB::table("mt4_trades")
        ->where('LOGIN', $managerDetail->account_no)
        ->where('CLOSE_TIME', '<>', '1970-01-01 00:00:00') // only close trades
        ->where('CMD', 0) // only trades
        ->count();

        $sellTrades = DB::table("mt4_trades")
        ->where('LOGIN', $managerDetail->account_no)
        ->where('CLOSE_TIME', '<>', '1970-01-01 00:00:00') // only close trades
        ->where('CMD', 1) // only trades
        ->count();

        //return $sellTrades;

        // PIE CHART FOR  Currency vs Trades
        $pieChart = array();

        for ($i=0; $i < count($test); $i++) { 
          //return $test[$i]->SYMBOL;
          $pieChart[$i]['name'] = $test[$i]->SYMBOL;
          $pieChart[$i]['y'] = $test[$i]->totalTrades;

          // Selecting the maximum trades value
          if(max($trades) == $test[$i]->totalTrades){
            $pieChart[$i]['sliced'] = true;
            $pieChart[$i]['selected'] = true;
          }
        }

        //return $pieChart;

        // Currency wise profits/Loss

        // Trades VS symbols graph
        $currencyWiseProfit = DB::table("mt4_trades")
        ->select('SYMBOL', DB::raw("(SUM(PROFIT)) as totalProfits"))
        ->where('LOGIN', $managerDetail->account_no)
        ->where('CLOSE_TIME', '<>', '1970-01-01 00:00:00') // only close trades
        ->where('CMD', '<', 2) // only trades
        ->groupBy('SYMBOL') // monthly
        ->distinct()
        ->get()
        ->toArray();

        //return $currencyWiseProfit;
        //return $test;
        //$symbols1 = array_column($currencyWiseProfit, 'SYMBOL');

        //$profitsFromCurrency = array_column($currencyWiseProfit, 'totalProfits');
        $profitsFromCurrency = array();

        for ($i=0; $i < count($currencyWiseProfit); $i++) { 
          //return $test[$i]->SYMBOL;
          $profitsFromCurrency[$i]['name'] = $currencyWiseProfit[$i]->SYMBOL;
          $profitsFromCurrency[$i]['y'] = $currencyWiseProfit[$i]->totalProfits;

        }

        //return $profitsFromCurrency;


        $sakil = \DB::table('mt4_trades')
        ->select(DB::raw("(MAX(PROFIT)) as maxProfit"), DB::raw("(MIN(PROFIT)) as minProfit"))
        ->where('LOGIN', $managerDetail->account_no)
        ->where('CLOSE_TIME', '<>', '1970-01-01 00:00:00') // only close trades
        ->where('CMD', '<', 2) // only trades
        ->where('PROFIT', '>', 0)
        ->get();

        //return $sakil[0]->maxProfit;

        $maxProfit = \DB::table('mt4_trades')
        ->select('PROFIT','SYMBOL','OPEN_PRICE','CLOSE_PRICE','TICKET')
        ->where('LOGIN', $managerDetail->account_no)
        ->where('CLOSE_TIME', '<>', '1970-01-01 00:00:00') // only close trades
        ->where('CMD', '<', 2) // only trades
        ->where('PROFIT', $sakil[0]->maxProfit)
        ->get();

        $minProfit = \DB::table('mt4_trades')
        ->select('PROFIT','SYMBOL','OPEN_PRICE','CLOSE_PRICE','TICKET')
        ->where('LOGIN', $managerDetail->account_no)
        ->where('CLOSE_TIME', '<>', '1970-01-01 00:00:00') // only close trades
        ->where('CMD', '<', 2) // only trades
        ->where('PROFIT', $sakil[0]->minProfit)
        ->get();
        
        //return $maxProfit;
        // CHECKING THE CURRENCY HAS JPY
        $maxPipsProfit = 0;

        if(count($maxProfit) > 0) {

          if(stripos($maxProfit[0]->SYMBOL, 'JPY')){

            $firstPIP = $maxProfit[0]->OPEN_PRICE - floor($maxProfit[0]->OPEN_PRICE);
            $secondPIP = $maxProfit[0]->CLOSE_PRICE - floor($maxProfit[0]->CLOSE_PRICE);

          //return abs($firstPIP - $secondPIP);

          //return ($maxProfit[0]->OPEN_PRICE - $maxProfit[0]->CLOSE_PRICE)*100;
            $maxPipsProfit = abs($maxProfit[0]->OPEN_PRICE - $maxProfit[0]->CLOSE_PRICE)*100;

          }
          else if(stripos($maxProfit[0]->SYMBOL, 'XAU') || stripos($maxProfit[0]->SYMBOL, 'XAG')){

          //return ($maxProfit[0]->OPEN_PRICE - $maxProfit[0]->CLOSE_PRICE)*100;

            $maxPipsProfit = abs($maxProfit[0]->OPEN_PRICE - $maxProfit[0]->CLOSE_PRICE)*1000;

          }
          else {

            $maxPipsProfit = abs($maxProfit[0]->OPEN_PRICE - $maxProfit[0]->CLOSE_PRICE)*10000;
          }

        }
        else{

          $maxPipsProfit = 0;
        }


         // CHECKING THE CURRENCY HAS JPY FOR MIN PROFIT
        $minPipsProfit = 0;

        if(count($minProfit) > 0) {

          if(stripos($minProfit[0]->SYMBOL, 'JPY')){


            $firstPIP = $minProfit[0]->OPEN_PRICE - floor($minProfit[0]->OPEN_PRICE);

            $secondPIP = $minProfit[0]->CLOSE_PRICE - floor($minProfit[0]->CLOSE_PRICE);

            $minPipsProfit = abs($minProfit[0]->OPEN_PRICE - $minProfit[0]->CLOSE_PRICE)*100;

          }
          else if(stripos($minProfit[0]->SYMBOL, 'XAU') || stripos($minProfit[0]->SYMBOL, 'XAG')){


            $minPipsProfit = abs($minProfit[0]->OPEN_PRICE - $minProfit[0]->CLOSE_PRICE)*1000;

          }
          else {

            $minPipsProfit = abs($maxProfit[0]->OPEN_PRICE - $maxProfit[0]->CLOSE_PRICE)*10000;
          }

        }
        else{

          $minPipsProfit = 0;
        }



        // LOSS IN PIPS
        $sakil = \DB::table('mt4_trades')
        ->select(DB::raw("(MAX(PROFIT)) as maxProfit"), DB::raw("(MIN(PROFIT)) as minProfit"))
        ->where('LOGIN', $managerDetail->account_no)
        ->where('CLOSE_TIME', '<>', '1970-01-01 00:00:00') // only close trades
        ->where('CMD', '<', 2) // only trades
        ->where('PROFIT', '<', 0)
        ->get();

        //return $sakil[0]->maxProfit;

        $maxProfit = \DB::table('mt4_trades')
        ->select('PROFIT','SYMBOL','OPEN_PRICE','CLOSE_PRICE','TICKET')
        ->where('LOGIN', $managerDetail->account_no)
        ->where('CLOSE_TIME', '<>', '1970-01-01 00:00:00') // only close trades
        ->where('CMD', '<', 2) // only trades
        ->where('PROFIT', $sakil[0]->maxProfit)
        ->get();

        $minProfit = \DB::table('mt4_trades')
        ->select('PROFIT','SYMBOL','OPEN_PRICE','CLOSE_PRICE','TICKET')
        ->where('LOGIN', $managerDetail->account_no)
        ->where('CLOSE_TIME', '<>', '1970-01-01 00:00:00') // only close trades
        ->where('CMD', '<', 2) // only trades
        ->where('PROFIT', $sakil[0]->minProfit)
        ->get();
        

        // CHECKING THE CURRENCY HAS JPY
        $maxPipsLoss = 0;

        if(count($maxProfit) > 0 ){

          if(stripos($maxProfit[0]->SYMBOL, 'JPY')){

            $firstPIP = $maxProfit[0]->OPEN_PRICE - floor($maxProfit[0]->OPEN_PRICE);

            $secondPIP = $maxProfit[0]->CLOSE_PRICE - floor($maxProfit[0]->CLOSE_PRICE);

            $maxPipsLoss = abs($maxProfit[0]->OPEN_PRICE - $maxProfit[0]->CLOSE_PRICE)*100;

          }
          else if(stripos($maxProfit[0]->SYMBOL, 'XAU') || stripos($maxProfit[0]->SYMBOL, 'XAG')){

            $maxPipsLoss = abs($maxProfit[0]->OPEN_PRICE - $maxProfit[0]->CLOSE_PRICE)*1000;

          }
          else {

            $maxPipsLoss = abs($maxProfit[0]->OPEN_PRICE - $maxProfit[0]->CLOSE_PRICE)*10000;
          }
        }
        else{

          $maxPipsLoss = 0;
        }


         // CHECKING THE CURRENCY HAS JPY FOR MIN PROFIT
        $minPipsLoss = 0;

        if(count($minProfit) > 0){

          if(stripos($minProfit[0]->SYMBOL, 'JPY')){


            $firstPIP = $minProfit[0]->OPEN_PRICE - floor($minProfit[0]->OPEN_PRICE);

            $secondPIP = $minProfit[0]->CLOSE_PRICE - floor($minProfit[0]->CLOSE_PRICE);


            $minPipsLoss = abs($minProfit[0]->OPEN_PRICE - $minProfit[0]->CLOSE_PRICE)*100;

          }
          else if(stripos($minProfit[0]->SYMBOL, 'XAU') || stripos($minProfit[0]->SYMBOL, 'XAG')){

            $minPipsLoss = abs($minProfit[0]->OPEN_PRICE - $minProfit[0]->CLOSE_PRICE)*1000;

          }
          else {

            $minPipsLoss = abs($maxProfit[0]->OPEN_PRICE - $maxProfit[0]->CLOSE_PRICE)*10000;
          }

        }
        else{

          $minPipsLoss = 0;
        }



        // AVERAGE TRADING TIME PER TRADE
        $totalTradeTime = DB::table('mt4_trades')
        ->select('OPEN_TIME','CLOSE_TIME')
        ->where('LOGIN', $managerDetail->account_no)
        ->where('CLOSE_TIME', '<>', '1970-01-01 00:00:00') // only close trades
        ->where('CMD', '<', 2) // only trades
        ->orderBy('TICKET', 'desc')
        ->get()
        ->toArray();

        $sumOfTotalTradeTime = 0;
        foreach ($totalTradeTime as $key => $singleTrade) {
          //return $singleTrade->OPEN_TIME;
          // getting the time difference
          $startTime = Carbon::parse($singleTrade->OPEN_TIME);//->format('Y-m-d H:i:s');
          $finishTime = Carbon::parse($singleTrade->CLOSE_TIME);//->format('Y-m-d H:i:s');
          // echo $startTime;
          // echo "---------";
          // echo $finishTime;
          // echo "<br>";

          $totalDuration = $finishTime->diffInSeconds($startTime);
          //return gmdate('H:i:s', $totalDuration);
          //return $totalDuration;
          $sumOfTotalTradeTime += $totalDuration;

        }
        //return 1;
        //return $sumOfTotalTradeTime/$totalTrades;
        //return gmdate('Y-m-d H:i:s', $sumOfTotalTradeTime);
        //return gmdate('Y-m-d H:i:s', $sumOfTotalTradeTime/$totalTrades);

        //return $totalTradeTime;
        $sumOfTotalTradeTime = ($totalTrades > 0) ?round($sumOfTotalTradeTime/$totalTrades, 0) : 0;

        //return $sumOfTotalTradeTime;

        //return $justGraph;

        // Returning to the view
        return view('backEnd.'.app()->getLocale().'.crm.account.socialTrading.manager-detail',compact('managerDetail','managerSettings','totalProfit','thisMonthProfit','totalInvestors', 'monthsWiseProfit', 'categories','onlyMonthlyProfit', 'profits','dayWiseProfit','sakil','dailyTrades','dailyDates', 'symbols', 'trades','weekDayTrades','weekDays','weekDayBuyTrades','weekDaySellTrades','hourlyTrades','hours','hourlyBuyTrades','hourlySellTrades', 'profitableTrade', 'nonProfitableTrade', 'totalTrades', 'buyTrades', 'sellTrades', 'pieChart','profitsFromCurrency', 'maxPipsProfit','minPipsProfit', 'maxPipsLoss','minPipsLoss','sumOfTotalTradeTime','justGraph','sakil1','sakil2','sakilArray')); 

      }

    /*=================================
=      All Trading Accounts related to manager       =
=================================*/

public function allManagerTradingAccounts(){

  $accounts=DB::table('cms_account')->join('mt4_users','mt4_users.LOGIN','=','cms_account.account_no')->where([
    ['cms_account.email','=',session('login_email')],
    ['cms_account.account_no','<>','0'],
    ['cms_account.act_type','<>','IB'],
    ['cms_account.act_type','<>','DEMO'],
    ['cms_account.trader_type', 1]
])->select('cms_account.*','mt4_users.*')->orderBy('cms_account.account_no','desc')->get();

foreach($accounts as $ac){

  $running=DB::table('mt4_trades')->where('mt4_trades.LOGIN',$ac->account_no)->where('mt4_trades.CLOSE_TIME','1970-01-01 00:00:00')->count();

  $totalInvestor = DB::table('st_manager_investors')->where('manager_id',$ac->int_id)->count();

  $ac->total_investor=$totalInvestor;

  $ac->running_trades=$running;

}
 
return view('backEnd.'.app()->getLocale().'.crm.account.socialTrading.manage-investor-accounts',compact('accounts'));

}

/** Function to show the details of a strategic manager account */

public function managerAccountTradingDetails(Request $request){

  $check = CMS_Account::where([
    ['account_no',$request->id],
    ['email',session('login_email')]
  ])->first();
  if(!$check){
    return view('errors.'.app()->getLocale().'.404');
  }

//  $accounts=DB::table('cms_account')->join('mt4_users','mt4_users.LOGIN','=','cms_account.account_no')->leftJoin('st_managersettings', 'st_managersettings.cmsaccount_id', 'cms_account.int_id')->where([
//   ['cms_account.account_no',$request->id]
// ])->select('cms_account.*','mt4_users.*','st_managersettings.cmsaccount_id','cms_account.int_id','st_managersettings.profit_sharing_time','st_managersettings.allocation_type')->first();

 $accounts=DB::table('cms_account')->join('mt4_users','mt4_users.LOGIN','=','cms_account.account_no')->leftJoin('st_managersettings', 'st_managersettings.cmsaccount_id', 'cms_account.int_id')->where([
  ['cms_account.account_no',$request->id]
])->select('cms_account.int_id','cms_account.account_no','cms_account.act_type','mt4_users.BALANCE','mt4_users.CREDIT','mt4_users.EQUITY','mt4_users.CURRENCY','mt4_users.LEVERAGE','st_managersettings.profit_sharing_time','st_managersettings.allocation_type')->first();

 $trades=DB::table('mt4_trades')->orderBy('mt4_trades.TICKET', 'desc')->where([
  ['mt4_trades.CLOSE_TIME','1970-01-01 00:00:00'],
  ['mt4_trades.LOGIN',$request->id]
])->get();

// Getting the list of investor details

$investors = DB::table('st_manager_investors')->join('cms_account', 'st_manager_investors.manager_id', 'cms_account.int_id')->where('cms_account.account_no', $request->id)->pluck('st_manager_investors.investor_id');

$active_accounts = 0;
    $active_balance = 0;
    $active_equity = 0;
    $active_margin = 0;
    $active_running = 0;
    $active_lot = 0;
    $active_percent = 0;

if(count($investors) > 0){
  $investorDetails = DB::table('cms_account')->join('st_manager_investors', 'st_manager_investors.investor_id', 'cms_account.int_id')->join('cms_liveaccount', 'cms_liveaccount.email', 'cms_account.email')->join('mt4_users', 'mt4_users.LOGIN', 'cms_account.account_no')->whereIN('cms_account.int_id', $investors)->where('st_manager_investors.status',1)->select('cms_liveaccount.fname','cms_liveaccount.lname','cms_account.int_id','cms_account.account_no','cms_account.email','mt4_users.BALANCE','mt4_users.EQUITY','mt4_users.MARGIN_FREE','mt4_users.GROUP','st_manager_investors.id','st_manager_investors.lot_allocation','st_manager_investors.percent_allocation','st_manager_investors.is_active')->get()->toArray();

  
    
  if(count($investorDetails) > 0){

    
    foreach($investorDetails as $ac){

      $running=DB::table('mt4_trades')->where('mt4_trades.LOGIN',$ac->account_no)->where('mt4_trades.cmd','<>',2)->where('mt4_trades.CLOSE_TIME','1970-01-01 00:00:00')->count();    
      $ac->running_trades=$running;
 
      if($ac->is_active==1){
        $active_accounts++;
        $active_balance += $ac->BALANCE;
        $active_equity += $ac->EQUITY;
        $active_margin += $ac->MARGIN_FREE;
        $active_running += $running;
        $active_lot += $ac->lot_allocation;
        $active_percent += $ac->percent_allocation;
      }

      
    
    }
  }
}

else{
  $investorDetails = [];
}

 return view('backEnd.'.app()->getLocale().'.crm.account.socialTrading.trading-details',compact('accounts','trades','investorDetails','active_accounts','active_balance','active_equity','active_margin','active_running','active_lot','active_percent'));
}

// enable disable investor for next trade

public function managerEnableDisableInvestor(Request $request){
  $check = DB::table('st_manager_investors')->where('id',$request->id)->first();
  if($check){
    if($check->is_active==0){
      DB::table('st_manager_investors')->where('id',$request->id)->update(['is_active' => 1]);
    }
    else{
      DB::table('st_manager_investors')->where('id',$request->id)->update(['is_active' => 0]);
    }
  }
}

/**
 * @params id , allocation_type
 */
public function managerChangeAllocationType(Request $request){
  // DB::table('cms_account')->where('int_id',$request->id)->update(['allocation_type' => $request->allocation_type]);
  DB::table('st_managersettings')->where('cmsaccount_id',$request->id)->update(['allocation_type' => $request->allocation_type]);
}

/**
 * @params id, allocation, allocation_type
 */
public function updateAllocation(Request $request){
  if($request->allocation_type==0)
  DB::table('st_manager_investors')->where('id',$request->id)->update(['lot_allocation' => $request->allocation]);
  else {
    DB::table('st_manager_investors')->where('id',$request->id)->update(['percent_allocation' => $request->allocation]);
    return $request->id;
  }
}

/**
 * @params id
 */
public function managerInvestorLiveTrades(Request $request){
  $manager_live_trades = DB::table('cms_account')
  ->join('mt4_trades','cms_account.account_no','mt4_trades.LOGIN')
  ->where('cms_account.int_id',$request->id)
  ->where('mt4_trades.CMD','<',2)
  ->where('mt4_trades.CLOSE_TIME','1970-01-01 00:00:00')
  ->where('cms_account.status',1)
  ->where('cms_account.trader_type',1)
  ->select('mt4_trades.TICKET','mt4_trades.LOGIN','mt4_trades.SYMBOL','mt4_trades.COMMENT','mt4_trades.CMD','mt4_trades.VOLUME','mt4_trades.OPEN_TIME','mt4_trades.SL','mt4_trades.TP','mt4_trades.COMMISSION','mt4_trades.SWAPS','mt4_trades.PROFIT')
  ->get();
  if(count($manager_live_trades)==0){
    $data1 = '<tr></tr><td colspan="13">No Running Trade</td></tr>';
  }
  else{
  $data1 = '';
  foreach($manager_live_trades as $mlt){
    $data1 .= '<tr><td>'.$mlt->TICKET.'</td>';
    $data1 .= '<td>'.$mlt->LOGIN.'</td>';
    $data1 .= '<td>'.$mlt->SYMBOL.'</td>';
    $data1 .= '<td>'.$mlt->COMMENT.'</td>';
    $data1 .= '<td>'.($mlt->CMD==0 ? 'Buy' : 'Sell').'</td>';
    $data1 .= '<td>'.($mlt->VOLUME/100).'</td>';
    $data1 .= '<td>'.$mlt->OPEN_TIME.'</td>';
    $data1 .= '<td>'.$mlt->SL.'</td>';
    $data1 .= '<td>'.$mlt->TP.'</td>';
    $data1 .= '<td>'.$mlt->COMMISSION.'</td>';
    $data1 .= '<td>'.$mlt->SWAPS.'</td>';
    $data1 .= '<td>'.$mlt->PROFIT.'</td></tr>';
  }
}
  $investor_live_trades = DB::table('cms_account')
  ->join('st_manager_investors','cms_account.int_id','st_manager_investors.investor_id')
  ->join('mt4_trades','cms_account.account_no','mt4_trades.LOGIN')
  ->where('st_manager_investors.manager_id',$request->id)
  ->where('mt4_trades.CMD','<',2)
  ->where('mt4_trades.CLOSE_TIME','1970-01-01 00:00:00')
  ->where('cms_account.status',1)
  ->where('cms_account.trader_type',2)
  ->where('st_manager_investors.status',1)
  ->select('mt4_trades.TICKET','mt4_trades.LOGIN','mt4_trades.SYMBOL','mt4_trades.COMMENT','mt4_trades.CMD','mt4_trades.VOLUME','mt4_trades.OPEN_TIME','mt4_trades.SL','mt4_trades.TP','mt4_trades.COMMISSION','mt4_trades.SWAPS','mt4_trades.PROFIT')
  ->get();
  if(count($investor_live_trades)==0){
    $data2 = '<tr><td colspan="13">No Running Trade</td></tr>';
  }
  else
  {
  $data2 = '';
  foreach($investor_live_trades as $ilt){
    $data2 .= '<tr><td>'.$ilt->TICKET.'</td>';
    $data2 .= '<td>'.$ilt->LOGIN.'</td>';
    $data2 .= '<td>'.$ilt->SYMBOL.'</td>';
    $data2 .= '<td>'.$ilt->COMMENT.'</td>';
    $data2 .= '<td>'.($ilt->CMD==0 ? 'Buy' : 'Sell').'</td>';
    $data2 .= '<td>'.($ilt->VOLUME/100).'</td>';
    $data2 .= '<td>'.$ilt->OPEN_TIME.'</td>';
    $data2 .= '<td>'.$ilt->SL.'</td>';
    $data2 .= '<td>'.$ilt->TP.'</td>';
    $data2 .= '<td>'.$ilt->COMMISSION.'</td>';
    $data2 .= '<td>'.$ilt->SWAPS.'</td>';
    $data2 .= '<td>'.$ilt->PROFIT.'</td></tr>';
  }
}
  $data = array( 'data1' => "$data1", 
  'data2' => "$data2" );
  return json_encode($data);

}

/**
 * @params id
 */
public function managerReports(Request $request){
  $manager_reports = DB::table('cms_account')
  ->join('mt4_trades','cms_account.account_no','mt4_trades.LOGIN')
  ->where('cms_account.int_id',$request->id)
  ->where('mt4_trades.CMD','<',2)
  ->where('mt4_trades.CLOSE_TIME','<>','1970-01-01 00:00:00')
  ->where('cms_account.status',1)
  ->where('cms_account.trader_type',1)
  ->select('mt4_trades.TICKET','mt4_trades.LOGIN','mt4_trades.SYMBOL','mt4_trades.COMMENT','mt4_trades.CMD','mt4_trades.VOLUME','mt4_trades.OPEN_TIME','mt4_trades.OPEN_PRICE','mt4_trades.CLOSE_TIME','mt4_trades.CLOSE_PRICE','mt4_trades.SL','mt4_trades.TP','mt4_trades.COMMISSION','mt4_trades.SWAPS','mt4_trades.PROFIT')
  ->get();
  if(count($manager_reports)==0){
    $data1 = '<tr></tr><td colspan="16">No Trade History</td></tr>';
  }
  else{
  $data1 = '';
  foreach($manager_reports as $mr){
    $data1 .= '<tr><td>'.$mr->TICKET.'</td>';
    $data1 .= '<td>'.$mr->LOGIN.'</td>';
    $data1 .= '<td>'.$mr->SYMBOL.'</td>';
    $data1 .= '<td>'.$mr->COMMENT.'</td>';
    $data1 .= '<td>'.($mr->CMD==0 ? 'Buy' : 'Sell').'</td>';
    $data1 .= '<td>'.($mr->VOLUME/100).'</td>';
    $data1 .= '<td>'.$mr->OPEN_TIME.'</td>';
    $data1 .= '<td>'.$mr->OPEN_PRICE.'</td>';
    $data1 .= '<td>'.$mr->CLOSE_TIME.'</td>';
    $data1 .= '<td>'.$mr->CLOSE_PRICE.'</td>';
    $data1 .= '<td>'.$mr->SL.'</td>';
    $data1 .= '<td>'.$mr->TP.'</td>';
    $data1 .= '<td>'.$mr->COMMISSION.'</td>';
    $data1 .= '<td>'.$mr->SWAPS.'</td>';
    $data1 .= '<td>'.$mr->PROFIT.'</td></tr>';
  }
}
  $investor_reports = DB::table('cms_account')
  ->join('st_manager_investors','cms_account.int_id','st_manager_investors.investor_id')
  ->join('mt4_trades','cms_account.account_no','mt4_trades.LOGIN')
  ->where('st_manager_investors.manager_id',$request->id)
  ->where('mt4_trades.CMD','<',2)
  ->where('mt4_trades.CLOSE_TIME','<>','1970-01-01 00:00:00')
  ->where('cms_account.status',1)
  ->where('cms_account.trader_type',2)
  // ->where('st_manager_investors.status',1)
  ->select('mt4_trades.TICKET','mt4_trades.LOGIN','mt4_trades.SYMBOL','mt4_trades.COMMENT','mt4_trades.CMD','mt4_trades.VOLUME','mt4_trades.OPEN_TIME','mt4_trades.OPEN_PRICE','mt4_trades.CLOSE_TIME','mt4_trades.CLOSE_PRICE','mt4_trades.SL','mt4_trades.TP','mt4_trades.COMMISSION','mt4_trades.SWAPS','mt4_trades.PROFIT')
  ->get();
  if(count($investor_reports)==0){
    $data2 = '<tr><td colspan="16">No Trade History</td></tr>';
  }
  else
  {
  $data2 = '';
  foreach($investor_reports as $ir){
    $data2 .= '<tr><td>'.$ir->TICKET.'</td>';
    $data2 .= '<td>'.$ir->LOGIN.'</td>';
    $data2 .= '<td>'.$ir->SYMBOL.'</td>';
    $data2 .= '<td>'.$ir->COMMENT.'</td>';
    $data2 .= '<td>'.($ir->CMD==0 ? 'Buy' : 'Sell').'</td>';
    $data2 .= '<td>'.($ir->VOLUME/100).'</td>';
    $data2 .= '<td>'.$ir->OPEN_TIME.'</td>';
    $data2 .= '<td>'.$ir->OPEN_PRICE.'</td>';
    $data2 .= '<td>'.$ir->CLOSE_TIME.'</td>';
    $data2 .= '<td>'.$ir->CLOSE_PRICE.'</td>';
    $data2 .= '<td>'.$ir->SL.'</td>';
    $data2 .= '<td>'.$ir->TP.'</td>';
    $data2 .= '<td>'.$ir->COMMISSION.'</td>';
    $data2 .= '<td>'.$ir->SWAPS.'</td>';
    $data2 .= '<td>'.$ir->PROFIT.'</td></tr>';
  }
}
  $data = array( 'data1' => "$data1", 
  'data2' => "$data2" );
  return json_encode($data);

}

/**
 * @params id
 */
public function managerCommissions(Request $request){
  $commissions = DB::table('cms_account')
  ->join('st_manager_investors','cms_account.int_id','st_manager_investors.investor_id')
  ->leftJoin('st_managersettings','st_manager_investors.manager_id','st_managersettings.cmsaccount_id')
  ->where('st_manager_investors.manager_id',$request->id)
  ->where('cms_account.status',1)
  ->where('cms_account.trader_type',2)
  // ->where('st_manager_investors.status',1)
  ->select('cms_account.account_no','st_manager_investors.profit_sharing','st_managersettings.profit_sharing_time')
  ->get();

    $running_order_sum = 0;
    $running_lot_sum = 0;
    $running_profit_sum = 0;
    $running_commission_sum = 0;

    $total_order_sum = 0;
    $total_lot_sum = 0;
    $total_profit_sum = 0;
    $total_commission_sum = 0;
    $data2 = '';
  if(count($commissions)==0){
    $data1 = '<tr><td colspan="16">No Investor Yet</td></tr>';
  }
  else
  {
  $data1 = '';
  $startOfMonth = new Carbon('first day of this month');
  $fromMonth = Carbon::parse($startOfMonth)->format('Y-m-d 00:00:00');
  $now = Carbon::now();
  $fromWeek = $now->startOfWeek(Carbon::MONDAY);
  // return $startOfWeek;

  foreach($commissions as $commission){
    if($commission->profit_sharing_time == '7'){
      $from = $fromWeek;
    }
    else{
      $from = $fromMonth;
    }
    $running_order = DB::table('mt4_trades')
    ->where('mt4_trades.LOGIN',$commission->account_no)
    ->where('mt4_trades.CMD','<',2)
    ->where('mt4_trades.CLOSE_TIME','>=',$from)
    ->count();

    $running_lot = DB::table('mt4_trades')
    ->where('mt4_trades.LOGIN',$commission->account_no)
    ->where('mt4_trades.CMD','<',2)
    ->where('mt4_trades.CLOSE_TIME','>=',$from)
    ->sum('mt4_trades.VOLUME');

    // $running_profit = DB::table('mt4_trades')
    // ->where('mt4_trades.LOGIN',$commission->account_no)
    // ->where('mt4_trades.CMD','<',2)
    // ->where('mt4_trades.CLOSE_TIME','>',$from)
    // ->sum('mt4_trades.PROFIT');

    $running_pro_com = DB::table('mt4_trades')
    ->join('st_orders','st_orders.investor_order','mt4_trades.TICKET')
    ->where('mt4_trades.LOGIN',$commission->account_no)
    ->where('mt4_trades.CMD','<',2)
    ->where('mt4_trades.CLOSE_TIME','>=',$from)
    ->select('mt4_trades.PROFIT','st_orders.profit_sharing')
    ->get();

    $running_profit = 0;
    $running_commission = 0;
    foreach($running_pro_com as $rpc){
    	$running_profit += $rpc->PROFIT;
    	$running_commission += $rpc->PROFIT*$rpc->profit_sharing/100;
    }

    if($running_commission<=0){
      $running_commission = 0;
    }
    else{
      $running_commission = round($running_commission,2);
    }

    $total_order = DB::table('mt4_trades')
    ->where('mt4_trades.LOGIN',$commission->account_no)
    ->where('mt4_trades.CMD','<',2)
    ->where('mt4_trades.CLOSE_TIME','<>','1970-01-01 00:00:)')
    ->count();
    $total_lot = DB::table('mt4_trades')
    ->where('mt4_trades.LOGIN',$commission->account_no)
    ->where('mt4_trades.CMD','<',2)
    ->where('mt4_trades.CLOSE_TIME','<>','1970-01-01 00:00:)')
    ->sum('mt4_trades.VOLUME');
    // $total_profit = DB::table('mt4_trades')
    // ->where('mt4_trades.LOGIN',$commission->account_no)
    // ->where('mt4_trades.CMD','<',2)
    // ->where('mt4_trades.CLOSE_TIME','<>','1970-01-01 00:00:)')
    // ->sum('mt4_trades.PROFIT');
    $total_pro_com = DB::table('mt4_trades')
    ->join('st_orders','st_orders.investor_order','mt4_trades.TICKET')
    ->where('mt4_trades.LOGIN',$commission->account_no)
    ->where('mt4_trades.CMD','<',2)
    ->where('mt4_trades.CLOSE_TIME','<>','1970-01-01 00:00:)')
    ->select('mt4_trades.PROFIT','st_orders.profit_sharing')
    ->get();
    $total_profit = 0;
    $total_commission = 0;
    foreach($total_pro_com as $tpc){
    	$total_profit += $tpc->PROFIT;
    	$total_commission += $tpc->PROFIT*$tpc->profit_sharing;
    }

    if($total_commission<0){
      $total_commission = 0;
    }
    else{
      $total_commission = round($total_commission,2);
    }
    $running_order_sum = $running_order_sum+=$running_order;
    $running_lot_sum = $running_lot_sum+=$running_lot;
    $running_profit_sum = $running_profit_sum+=$running_profit;
    $running_commission_sum = $running_commission_sum+=$running_commission;

    $total_order_sum = $total_order_sum+=$total_order;
    $total_lot_sum = $total_lot_sum+=$total_lot;
    $total_profit_sum = $total_profit_sum+=$total_profit;
    $total_commission_sum = $total_commission_sum+=$total_commission;

    $data1 .= '<tr><td>'.$commission->account_no.'</td>';
    $data1 .= '<td> '.$running_order.' ( '.$total_order.' )</td>';
    $data1 .= '<td> '.round($running_lot/100,2).' ( '.round($total_lot/100,2).' )</td>';
    $data1 .= '<td> '.round($running_profit,2).' ( '.round($total_profit,2).' )</td>';
    $data1 .= '<td>'.$commission->profit_sharing.' %</td>';
    // $data1 .= '<td> '.round($running_commission,2).' ( '.round($total_commission,2).' )</td></tr>';
    $data1 .= '<td> '.round($running_commission,2).'</td></tr>';
  }
  $data2 .= '<tr><td> '.$running_order_sum.' ( '.$total_order_sum.' )</td>';
    $data2 .= '<td> '.round($running_lot_sum/100,2).' ( '.round($total_lot_sum/100,2).' )</td>';
    $data2 .= '<td>'.round($running_profit_sum,2).' ( '.round($total_profit_sum,2).' )</td>';   
    // $data2 .= '<td> '.round($running_commission_sum,2).' ( '.round($total_commission_sum,2).' )</td></tr>';
    $data2 .= '<td>'.round($running_commission_sum,2).'</td></tr>';
}
    $data = array(
      'data1' => $data1,
      'data2' => $data2
    );
    return json_encode($data);
}

/**
 * @params id
 */
public function managerCommissionHistory(Request $request){
  // return $request->month;
  $month_year = explode("/",$request->month);
  // return $month_year[0];
  // $year = 2000; $month = 4; $day = 19;
  // $hour = 20; $minute = 30; $second = 15; $tz = 'Europe/Madrid';
  // echo Carbon::createFromDate($year, $month, $day, $tz)."\n";
 
  if(!$request->month){
    $start = new Carbon('first day of last month');
  $fromMonth = Carbon::parse($start)->format('Y-m-d 00:00:00');
  }
  else{
    $start = Carbon::create($month_year[1], $month_year[0], '01', '00', '00', '00');
  $fromMonth = Carbon::parse($start)->format('Y-m-d 00:00:00');
  }
  
  $currentMonthStart = new Carbon('first day of this month');
  $currentMonth = Carbon::parse($currentMonthStart)->format('Y-m-d 00:00:00');


  $end = $start->endOfMonth();
  $endMonth = Carbon::parse($end)->format('Y-m-d 23:59:59');
  // return $endMonth;
  $commissions = DB::table('cms_account')
  ->join('st_manager_investors','cms_account.int_id','st_manager_investors.investor_id')
  ->leftJoin('st_managersettings','st_manager_investors.manager_id','st_managersettings.cmsaccount_id')
  ->where('st_manager_investors.manager_id',$request->id)
  ->where('cms_account.status',1)
  ->where('cms_account.trader_type',2)
  // ->where('st_manager_investors.status',1)
  // ->select('cms_account.account_no','st_managersettings.profit_sharing_time')
  ->select('cms_account.account_no','st_manager_investors.profit_sharing','st_managersettings.profit_sharing_time')
  ->get();
 $manager_account = DB::table('cms_account')
                    ->where('int_id',$request->id)
                    ->select('account_no')
                    ->first();
    $running_order_sum = 0;
    $running_lot_sum = 0;
    $running_profit_sum = 0;
    $running_commission_sum = 0;
    $total_order_sum = 0;
    $total_lot_sum = 0;
    $total_profit_sum = 0;
    $total_commission_sum = 0;
    $data2 = '';
  if(count($commissions)==0){
    $data1 = '<tr><td colspan="16">No Commissions for This Month</td></tr>';
  }
  else
  {
  $data1 = '';
  // $startOfMonth = new Carbon('first day of this month');
  // $fromMonth = Carbon::parse($startOfMonth)->format('Y-m-d 00:00:00');
  // $now = Carbon::now();
  // $fromWeek = $now->startOfWeek(Carbon::MONDAY);
  // return $startOfWeek;
  
  foreach($commissions as $commission){
    // if($commission->profit_sharing_time == '7'){
    //   $from = $fromWeek;
    // }
    // else{
    //   $from = $fromMonth;
    // }
    $running_order = DB::table('mt4_trades')
    ->join('st_orders','st_orders.investor_order','mt4_trades.TICKET')
    ->where('mt4_trades.LOGIN',$commission->account_no)
    ->where('mt4_trades.CMD','<',2)
    ->where('mt4_trades.CLOSE_TIME','>=',$fromMonth)
    ->where('mt4_trades.CLOSE_TIME','<=',$endMonth)
    ->count();

    $running_lot = DB::table('mt4_trades')
    ->join('st_orders','st_orders.investor_order','mt4_trades.TICKET')
    ->where('mt4_trades.LOGIN',$commission->account_no)
    ->where('mt4_trades.CMD','<',2)
    ->where('mt4_trades.CLOSE_TIME','>=',$fromMonth)
    ->where('mt4_trades.CLOSE_TIME','<=',$endMonth)
    ->sum('mt4_trades.VOLUME');

    // $running_profit = DB::table('mt4_trades')
    // ->join('st_orders','st_orders.investor_order','mt4_trades.TICKET')
    // ->where('mt4_trades.LOGIN',$commission->account_no)
    // ->where('mt4_trades.CMD','<',2)
    // ->where('mt4_trades.CLOSE_TIME','>',$from)
    // ->sum('mt4_trades.PROFIT');

    $running_pro_com = DB::table('mt4_trades')
    ->join('st_orders','st_orders.investor_order','mt4_trades.TICKET')
    ->where('mt4_trades.LOGIN',$commission->account_no)
    ->where('mt4_trades.CMD','<',2)
    ->where('mt4_trades.CLOSE_TIME','>=',$fromMonth)
    ->where('mt4_trades.CLOSE_TIME','<=',$endMonth)
    ->select('mt4_trades.PROFIT','st_orders.profit_sharing')
    ->get();

    $running_profit = 0;
    $running_commission = 0;
    foreach($running_pro_com as $rpc){
    	$running_profit += $rpc->PROFIT;
    	$running_commission += $rpc->PROFIT*$rpc->profit_sharing/100;
    }

    if($running_commission<=0){
      $running_commission = 0;
    }
    else{
      $running_commission = round($running_commission,2);
    }

    $total_order = DB::table('mt4_trades')
    ->join('st_orders','st_orders.investor_order','mt4_trades.TICKET')
    ->where('mt4_trades.LOGIN',$commission->account_no)
    ->where('mt4_trades.CMD','<',2)
    ->where('mt4_trades.CLOSE_TIME','<>','1970-01-01 00:00:)')
    ->count();
    $total_lot = DB::table('mt4_trades')
    ->join('st_orders','st_orders.investor_order','mt4_trades.TICKET')
    ->where('mt4_trades.LOGIN',$commission->account_no)
    ->where('mt4_trades.CMD','<',2)
    ->where('mt4_trades.CLOSE_TIME','<>','1970-01-01 00:00:)')
    ->sum('mt4_trades.VOLUME');
    // $total_profit = DB::table('mt4_trades')
    // ->join('st_orders','st_orders.investor_order','mt4_trades.TICKET')
    // ->where('mt4_trades.LOGIN',$commission->account_no)
    // ->where('mt4_trades.CMD','<',2)
    // ->where('mt4_trades.CLOSE_TIME','<>','1970-01-01 00:00:)')
    // ->sum('mt4_trades.PROFIT');
    $total_pro_com = DB::table('mt4_trades')
    ->join('st_orders','st_orders.investor_order','mt4_trades.TICKET')
    ->where('mt4_trades.LOGIN',$commission->account_no)
    ->where('mt4_trades.CMD','<',2)
    ->where('mt4_trades.CLOSE_TIME','<>','1970-01-01 00:00:)')
    ->select('mt4_trades.PROFIT','st_orders.profit_sharing')
    ->get();
    $total_profit = 0;
    $total_commission = 0;
    foreach($total_pro_com as $tpc){
    	$total_profit += $tpc->PROFIT;
    	$total_commission += $tpc->PROFIT*$tpc->profit_sharing/100;
    }

    if($total_commission<0){
      $total_commission = 0;
    }
    else{
      $total_commission = round($total_commission,2);
    }
    $running_order_sum = $running_order_sum+=$running_order;
    $running_lot_sum = $running_lot_sum+=$running_lot;
    $running_profit_sum = $running_profit_sum+=$running_profit;
    $running_commission_sum = $running_commission_sum+=$running_commission;

    $total_order_sum = $total_order_sum+=$total_order;
    $total_lot_sum = $total_lot_sum+=$total_lot;
    $total_profit_sum = $total_profit_sum+=$total_profit;
    $total_commission_sum = $total_commission_sum+=$total_commission;

    $data1 .= '<tr><td>'.$commission->account_no.'</td>';
    $data1 .= '<td> '.$running_order.' ( '.$total_order.' )</td>';
    $data1 .= '<td> '.round($running_lot/100,2).' ( '.round($total_lot/100,2).' )</td>';
    $data1 .= '<td> '.round($running_profit,2).' ( '.round($total_profit,2).' )</td>';
    $data1 .= '<td>'.$commission->profit_sharing.' %</td>';
    // $data1 .= '<td> '.round($running_commission,2).' ( '.round($total_commission,2).' )</td>';
    $data1 .= '<td>'.round($running_commission,2).'</td>';
    $commission_history = DB::table('st_commission_history')
                          ->where('manager_account',$manager_account->account_no)
                          ->where('investor_account',$commission->account_no)
                          ->where('start_date',$fromMonth)
                          ->where('end_date',$endMonth)
                          ->first();
    if($running_commission <= 0 || $fromMonth==$currentMonth){
      $data1 .= '<td>-</td></tr>';
    }
    elseif($commission_history){
    // if($running_commission > 0 && $currentMonth!=$fromMonth){
    $data1 .= '<td><button type="button" class="btn btn-success approved">Approved</button></td></tr>';
    }
    else{
    // if($running_commission > 0 && $currentMonth!=$fromMonth){
    $data1 .= '<td><button type="button" class="btn btn-warning pending">Pending</button></td></tr>';
    }
    
  }


  $data2 .= '<tr><td> '.$running_order_sum.' ( '.$total_order_sum.' )</td>';
    $data2 .= '<td> '.round($running_lot_sum/100,2).' ( '.round($total_lot_sum/100,2).' )</td>';
    $data2 .= '<td> '.round($running_profit_sum,2).' ( '.round($total_profit_sum,2).' )</td>';   
    // $data2 .= '<td> '.round($running_commission_sum,2).' ( '.round($total_commission_sum,2).' )</td></tr>';
    $data2 .= '<td>'.round($running_commission_sum,2).'</td></tr>';
}
    $data = array(
      'data1' => $data1,
      'data2' => $data2
    );
    return json_encode($data);
}
// Remove Investor Account
public function managerRemoveInvestorAccount(Request $request){
          DB::table('st_manager_investors')
          ->where('id',$request->id)
          ->update(['status' => 0]);
}

}