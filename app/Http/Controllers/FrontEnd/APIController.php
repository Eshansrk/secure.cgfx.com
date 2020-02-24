<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\APIRegistrationRequest;
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

use Validator;

class APIController extends Controller
{

	private function email_adds(){
		$email_adds=DB::table('cms_email_addresses')->first();
		return $email_adds;
	}

	private function mail_data(){

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

	/* Auto Login */
	public function login(Request $request)
	{
		$validator = Validator::make($request->all(), 
			[
				'email'=> 'required|email',
				'ib_code'=> 'required|numeric',
				'signature'=> 'required'
			],
			[
				
				'email.required' => 'Email missing',
				'email.email' => 'Email is invalid',
				
				'ib_code.required' => 'Promo code missing',
				'ib_code.numeric' => 'IB code invalid',
				'signature.required' => 'Signature is missing',

			]
		);

		if ($validator->fails()) {

			$errors = $validator->errors()->all();

			foreach ($errors as $key => $error) {

				return response()->json([
					'code' => "00",
					'message' => $error,
				], 200, array(), JSON_PRETTY_PRINT);
			}

		}

		// post data
		
		$email = $request->email;
		
		$ib_code = $request->ib_code;

		$signature = $request->signature;

		// validation passes

		// calculating the signature for this user
		$api_key =  DB::table('api_promosecret')->where('affiliate_prom_code', $ib_code)->first();

		//$signatureCalc = strtoupper(md5("Netcoden"."Inc"."netcoden@netcoden.com"."Canada"."12345678"."1992-08-29"."1234"."abcdefghijklmnopqrstuvwxyz"));

		//return $signatureCalc;

		//return $api_key->api_key;

		if (!$api_key || !$api_key->api_key) {
			
			return response()->json([
				'code' => "00",
				'message' => "You are not subscribed",
			], 200, array(), JSON_PRETTY_PRINT);
		}

		$signatureCalc = strtoupper(md5($email.$ib_code.$api_key->api_key));

		// return $signatureCalc;
		// return $signature.'<br>'.$signatureCalc;


		if ($signature == $signatureCalc) {

			
			//return "successful.";

			

				// logging in automatically

			$dat=DB::table('cms_liveaccount')
			->join('cms_ib_level','cms_liveaccount.affiliate_prom_code','cms_ib_level.child_ib')
			->where('cms_ib_level.parent_ib',$ib_code)
			->where('cms_liveaccount.email',$email)
			->first();

			if($dat){

				session()->flush();

				auth()->guard('admin')->loginUsingId($dat->intId);


				session(['login_email' => $dat->email]);

				session(['lname' => $dat->lname,'fname' => $dat->fname, 'id' => $dat->affiliate_prom_code]);

				Session::save();

					// return auth()->guard('admin')->user();

				return redirect()->intended('/dashboard');

					// return "successful";
					// return $dat->affiliate_prom_code;
					// return response()->json([
					// 	'code' => "01",
					// 	'message' => "Successful.",
					// 	'ID' => $dat->affiliate_prom_code,
					// ], 200, array(), JSON_PRETTY_PRINT);

			}
			else{

				return response()->json([
					'code' => "00",
					'message' => "Client does not exist",
				], 200, array(), JSON_PRETTY_PRINT);
			}
			
		}
		else{			
			return response()->json([
				'code' => "00",
				'message' => "Invalid signature.",
			], 200, array(), JSON_PRETTY_PRINT);
		}
	}	

	/*
	* Registration function
	*
	* @param userInfo
	*/
	public function registration3rdParty(Request $request)
	{
		$validator = Validator::make($request->all(), 
			[
				'fname'=> 'required',
				'lname'=> 'required',
				'email'=> 'required|email|unique:cms_liveaccount',
				'country'=> 'required',
				'mobile'=> 'required',
				'dob'=> 'required|date_format:Y-m-d',
				'ib_code'=> 'required|numeric',
				'signature'=> 'required'
			],
			[
				'fname.required' => 'First name missing',
				'lname.required' => 'Last name missing',
				'email.required' => 'Email missing',
				'email.email' => 'Email is invalid',
				'email.unique' => 'Email already exists',
				'country.required' => 'Country missing',
				'mobile.required' => 'Mobile missing',
				'dob.required' => 'Date of birth missing',
				'dob.date_format' => 'Date of birth is invalid',
				'ib_code.required' => 'Promo code missing',
				'ib_code.numeric' => 'IB code invalid',
				'signature.required' => 'Signature is missing',

			]
		);

		if ($validator->fails()) {

			$errors = $validator->errors()->all();

			foreach ($errors as $key => $error) {

				return response()->json([
					'code' => "00",
					'message' => $error,
				], 200, array(), JSON_PRETTY_PRINT);
			}

		}

		// post data
		$fname = $request->fname;
		$lname = $request->lname;
		$email = $request->email;
		if(isset($request->password) && $request->password!=''){
		$password = $request->password;
		}
		$country = $request->country;
		$mobile = $request->mobile;
		$dob = $request->dob;
		$ib_code = $request->ib_code;

		$signature = $request->signature;

		// validation passes

		// calculating the signature for this user
		$api_key =  DB::table('api_promosecret')->where('affiliate_prom_code', $ib_code)->first();

		//$signatureCalc = strtoupper(md5("Netcoden"."Inc"."netcoden@netcoden.com"."Canada"."12345678"."1992-08-29"."1234"."abcdefghijklmnopqrstuvwxyz"));

		//return $signatureCalc;

		//return $api_key->api_key;

		if (!$api_key || !$api_key->api_key) {
			
			return response()->json([
				'code' => "00",
				'message' => "You are not subscribed",
			], 200, array(), JSON_PRETTY_PRINT);
		}

// return $fname.$lname.$email.$password.$country.$mobile.$dob.$ib_code.$api_key->api_key;
		// if(isset($request->password) && $request->password!=''){
			$signatureCalc = strtoupper(md5($fname.$lname.$email.$password.$country.$mobile.$dob.$ib_code.$api_key->api_key));
		// }

	// 	else{

	// 	$signatureCalc = strtoupper(md5($fname.$lname.$email.$country.$mobile.$dob.$ib_code.$api_key->api_key));
	// }

		// return $signatureCalc;
		//return $signature;


		if ($signature == $signatureCalc) {

			
			//return "successful.";

			if($this->postRegistration($request->all()) == 'successful'){

				// logging in automatically

				$dat=DB::table('cms_Liveaccount')->where('email',$email)->first();

				if($dat){

					// session()->flush();

					// auth()->guard('admin')->loginUsingId($dat->intId);


					// session(['login_email' => $dat->email]);

					// session(['lname' => $dat->lname,'fname' => $dat->fname, 'id' => $dat->referred_by]);

					// Session::save();

					//return auth()->guard('admin')->user();

					// return redirect()->intended('/dashboard');

					// return "successful";
					// return $dat->affiliate_prom_code;
					return response()->json([
						'code' => "01",
						'message' => "Successful.",
						'ID' => $dat->affiliate_prom_code,
					], 200, array(), JSON_PRETTY_PRINT);

				}
				else{
					
					return response()->json([
						'code' => "00",
						'message' => "System error.",
					], 200, array(), JSON_PRETTY_PRINT);
				}
			}
			else{

				
				return response()->json([
					'code' => "00",
					'message' => "System error.",
				], 200, array(), JSON_PRETTY_PRINT);
			}
		}
		else{			
			return response()->json([
				'code' => "00",
				'message' => "Invalid signature.",
			], 200, array(), JSON_PRETTY_PRINT);
		}
	}

	// registering the user
	private function postRegistration($newUser)
	{
		//return $newUser['fname'];

        // inserting the user in the cms_liveaccount table

		// finding the max user id from cms_liveaccount table
		$maxUserId = CMS_Liveaccount::max('user_id');

		// finding the max affiliate promo code from cms_liveaccount table
		$maxAffiliate_prom_code = CMS_Liveaccount::max(DB::raw('CAST(affiliate_prom_code AS SIGNED)'));

		// return $maxAffiliate_prom_code+1;

		$newAccount = new CMS_Liveaccount;

		$token = str_random(50);

		$newAccount->fname = preg_replace('/[^ a-zA-Z0-9,+-]/', '', $newUser['fname']);
		$newAccount->lname = preg_replace('/[^ a-zA-Z0-9,+-]/', '', $newUser['lname']);

		if (array_key_exists('dob', $newUser)) {
			$time = strtotime($newUser['dob']);
			$newAccount->dob = date('Y-m-d',$time);
		}
		
		$newAccount->email = $newUser['email'];

        //$password = $newUser['password'];

        // checking password is provided by the requester with the request or not
		if (isset($newUser['password']) && $newUser['password'] != '') {

			$password = $newUser['password'];
		}
		else{
			$password = str_random(8);
		}
        // end of password checking

		//$password = str_random(8);

		// $newAccount->password = md5(str_random(8));
		$newAccount->password = password_hash($password, PASSWORD_BCRYPT);
		$newAccount->mobile = preg_replace('/[^ a-zA-Z0-9,+-]/', '', $newUser['mobile']);
		$newAccount->country = $newUser['country'];
		$newAccount->state = "";
		$newAccount->city = "";
		$newAccount->address = "";
		$newAccount->user_id = $maxUserId + 1;
		$newAccount->affiliate_prom_code = $maxAffiliate_prom_code + 1;
		$newAccount->reg_time = Carbon::now();
		if($newUser['ib_code']){
			$newAccount->referred_by=$newUser['ib_code'];
		}
		//$newAccount->postal_code = "";
		$newAccount->reference_no = time();
		$newAccount->email_status = 1;
		$newAccount->remember_token = $token;
		$newAccount->save();
		
		// Notifications
		DB::table('admins')
		->where([
			'country_access'=>'All',
			'manager'=>0
		])
		->orWhere([
			'country_access'=>$newUser['country'],
			'manager'=>0
		])
		->increment('registration', 1);

		// checking the referal id
		if ($newUser['ib_code']) {
			$exist=CMS_Liveaccount::where('affiliate_prom_code',$newUser['ib_code'])->first();
			if($exist){
			// populating the cms_ib_account
				$newAffiliateAccountLvl1 = new CMS_Iblevel;
				$newAffiliateAccountLvl1->parent_ib = $newUser['ib_code'];
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
		Mail::send('backEnd.en.crm.mail.send_API_account_detail_mail', ['newAccount' => $newAccount, 'token' => $token,'mail_data'=>$mail_data, 'password' => $password], function ($message) use($newAccount,$from_email_id, $from_name) {
			$message->from($from_email_id, $from_name);
			$message->to($newAccount->email, $newAccount->fname." ".$newAccount->lname);
			$message->subject('Account Details');
		});

		return 'successful';
	}

	/* responsing all the clients under an IB Account */

	public function getAllClients(Request $request)
	{

		$validator = Validator::make($request->all(), 
			[
				'email'=> 'required|email',
				'ib_code'=> 'required|numeric',
				'signature'=> 'required'
			],
			[	
				'email.required' => 'Email missing',
				'email.email' => 'Email is invalid',
				'ib_code.required' => 'Promo code missing',
				'ib_code.numeric' => 'IB code invalid',
				'signature.required' => 'Signature is missing',
			]
		);

		if ($validator->fails()) {

			$errors = $validator->errors()->all();

			foreach ($errors as $key => $error) {

				return response()->json([

					'code' => "00",

					'message' => $error,

				], 200, array(), JSON_PRETTY_PRINT);
			}

		}
		else{

			// post data
			$email = $request->email;
			$ib_code = $request->ib_code;
			$signature = $request->signature;

			// calculating the signature for this user
			$api_key =  DB::table('api_promosecret')->where('affiliate_prom_code', $ib_code)->first();

			if (!$api_key || !$api_key->api_key) {
				
				return response()->json([

					'code' => "00",

					'message' => "You are not subscribed",

				], 200, array(), JSON_PRETTY_PRINT);
			}

			$signatureCalc = strtoupper(md5($email.$ib_code.$api_key->api_key));
            // return $signatureCalc;
			//$ib_code = 5374;
			if ($signature == $signatureCalc) {

				// fetching all the clients under the provided partner ($ib_code)
				$clients = DB::table('cms_ib_level')
				->whereparent_ib($ib_code)
				->join('cms_liveaccount', 'cms_liveaccount.affiliate_prom_code', '=', 'cms_ib_level.child_ib')
				->orderBy('cms_liveaccount.intId', 'ASC')
				->select('cms_liveaccount.affiliate_prom_code as ID','cms_liveaccount.fname as FirstName','cms_liveaccount.lname as LastName','cms_liveaccount.email as Email','cms_liveaccount.country as Country','cms_liveaccount.mobile as Mobile','cms_liveaccount.reg_time as RegistrationTime', 'cms_liveaccount.comment as Comment','cms_liveaccount.email_contact as EmailContact','cms_liveaccount.phone_contact as PhoneContact','cms_ib_level.level as Level')
				->get();

				return response()->json([

					'clients' => $clients

				], 200, array(), JSON_PRETTY_PRINT);
				
			}
			else{

				return response()->json([

					'code' => "00",

					'message' => "Invalid signature.",

				], 200, array(), JSON_PRETTY_PRINT);
			}
		}
	}

	/* responsing all the clients under an IB Account filterd by Date */

	public function getAllClientsFilter(Request $request)
	{

		$validator = Validator::make($request->all(), 
			[
				'email'=> 'required|email',
				'ib_code'=> 'required|numeric',
				'start_date'=> 'required|date_format:Y-m-d',
				'end_date'=> 'required|date_format:Y-m-d',
				'signature'=> 'required'
			],
			[	
				'email.required' => 'Email missing',
				'email.email' => 'Email is invalid',
				'ib_code.required' => 'Promo code missing',
				'ib_code.numeric' => 'IB code invalid',
				'start_date.required' => 'Start Date Required',
				'start_date.date_format' => 'Start Date Invalid',
				'end_date.required' => 'End Date Required',
				'end_date.date_format' => 'End Date Invalid',
				'signature.required' => 'Signature is missing',
			]
		);

		if ($validator->fails()) {

			$errors = $validator->errors()->all();

			foreach ($errors as $key => $error) {

				return response()->json([

					'code' => "00",

					'message' => $error,

				], 200, array(), JSON_PRETTY_PRINT);
			}

		}
		else{

			// post data
			$email = $request->email;
			$ib_code = $request->ib_code;
			$start_date = $request->start_date;
			$end_date = $request->end_date;
			$signature = $request->signature;

			// calculating the signature for this user
			$api_key =  DB::table('api_promosecret')->where('affiliate_prom_code', $ib_code)->first();

			if (!$api_key || !$api_key->api_key) {
				
				return response()->json([

					'code' => "00",

					'message' => "You are not subscribed",

				], 200, array(), JSON_PRETTY_PRINT);
			}

			$signatureCalc = strtoupper(md5($email.$ib_code.$start_date.$end_date.$api_key->api_key));
            // return $signatureCalc;
			//$ib_code = 5374;
			if ($signature == $signatureCalc) {

				// fetching all the clients under the provided partner ($ib_code)
				$clients = DB::table('cms_ib_level')
				->whereparent_ib($ib_code)
				->join('cms_liveaccount', 'cms_liveaccount.affiliate_prom_code', '=', 'cms_ib_level.child_ib')
				->orderBy('cms_liveaccount.intId', 'ASC')
				->whereBetween('cms_liveaccount.reg_time',[$start_date,$end_date])
				->select('cms_liveaccount.affiliate_prom_code as ID','cms_liveaccount.fname as FirstName','cms_liveaccount.lname as LastName','cms_liveaccount.email as Email','cms_liveaccount.country as Country','cms_liveaccount.mobile as Mobile','cms_liveaccount.reg_time as RegistrationTime', 'cms_liveaccount.comment as Comment','cms_liveaccount.email_contact as EmailContact','cms_liveaccount.phone_contact as PhoneContact','cms_ib_level.level as Level')
				->get();

				return response()->json([

					'clients' => $clients

				], 200, array(), JSON_PRETTY_PRINT);
				
			}
			else{

				return response()->json([

					'code' => "00",

					'message' => "Invalid signature.",

				], 200, array(), JSON_PRETTY_PRINT);
			}
		}
	}

	// Get Single Client Details
	
	public function getClientDetails(Request $request){

		$validator = Validator::make($request->all(), 
			[
				'email'=> 'required|email',
				'ib_code'=> 'required|numeric',
				'user_id'=>'required|numeric',
				'signature'=> 'required'
			],
			[	
				'email.required' => 'Email missing',
				'email.email' => 'Email is invalid',
				'ib_code.required' => 'Promo code missing',
				'ib_code.numeric' => 'IB code invalid',
				'user_id.required' => 'User ID missing',
				'user_id.numeric' => 'User ID invalid',
				'signature.required' => 'Signature is missing',
			]
		);

		if ($validator->fails()) {

			$errors = $validator->errors()->all();

			foreach ($errors as $key => $error) {

				return response()->json([

					'code' => "00",

					'message' => $error,

				], 200, array(), JSON_PRETTY_PRINT);
			}

		}
		else{

			// post data
			$email = $request->email;
			$ib_code = $request->ib_code;
			$user_id = $request->user_id;
			$signature = $request->signature;

			// calculating the signature for this user
			$api_key =  DB::table('api_promosecret')->where('affiliate_prom_code', $ib_code)->first();

			if (!$api_key || !$api_key->api_key) {
				
				return response()->json([

					'code' => "00",

					'message' => "You are not subscribed",

				], 200, array(), JSON_PRETTY_PRINT);
			}

			// Check if userID Exists

			$userExists =  DB::table('cms_liveaccount')
			->where('affiliate_prom_code', $user_id)->first();

			if (!$userExists) {
				return response()->json([

					'code' => "00",

					'message' => "User ID invalid",

				], 200, array(), JSON_PRETTY_PRINT);
			}

			// Check if has access to requested user

			$hasAccessUser =  DB::table('cms_ib_level')
			->whereparent_ib($ib_code)
			->wherechild_ib($user_id)
			->first();

			if (!$hasAccessUser) {
				
				return response()->json([

					'code' => "00",

					'message' => "User ID invalid",

				], 200, array(), JSON_PRETTY_PRINT);
			}

			$signatureCalc = strtoupper(md5($email.$ib_code.$user_id.$api_key->api_key));
            // return $signature.'<br>'.$signatureCalc;
            // return $signatureCalc;
			//$ib_code = 5374;
			if ($signature == $signatureCalc) {

				$client = DB::table('cms_ib_level')
				->whereparent_ib($ib_code)
				->wherechild_ib($user_id)
				->join('cms_liveaccount', 'cms_liveaccount.affiliate_prom_code', '=', 'cms_ib_level.child_ib')
				->select('cms_liveaccount.affiliate_prom_code as ID','cms_liveaccount.fname as FirstName','cms_liveaccount.lname as LastName','cms_liveaccount.email as Email','cms_liveaccount.country as Country','cms_liveaccount.mobile as Mobile','cms_liveaccount.reg_time as RegistrationTime','cms_liveaccount.comment as Comment','cms_liveaccount.email_contact as EmailContact','cms_liveaccount.phone_contact as PhoneContact','cms_ib_level.level as Level')
				->first();

				$clientAccounts = DB::table('cms_ib_level')
				->whereparent_ib($ib_code)
				->wherechild_ib($user_id)
				->join('cms_liveaccount', 'cms_liveaccount.affiliate_prom_code', '=', 'cms_ib_level.child_ib')
				->join('cms_account','cms_account.email','cms_liveaccount.email')
				->join('mt4_users','cms_account.account_no','mt4_users.LOGIN')
				->select('cms_liveaccount.affiliate_prom_code as ID','mt4_users.LOGIN as TradingAccount','mt4_users.BALANCE as Balance','mt4_users.EQUITY as Equity','mt4_users.MARGIN as Margin','mt4_users.MARGIN_LEVEL as MarginLevel','mt4_users.MARGIN_FREE as MarginFree')
				->get();
				foreach($clientAccounts as $ca){
					$totalDeposit = DB::table('mt4_trades')
					->where('mt4_trades.LOGIN','=',$ca->TradingAccount)
					->where('mt4_trades.CMD','=',6)
					->where('mt4_trades.PROFIT','>',0)
					->SUM('mt4_trades.PROFIT');
					$ca->TotalDeposit = $totalDeposit;
				}

				// Detect client First deposit time
				$isFTD_time = DB::table('cms_ib_level')
				->whereparent_ib($ib_code)
				->wherechild_ib($user_id)
				->join('cms_liveaccount', 'cms_liveaccount.affiliate_prom_code', '=', 'cms_ib_level.child_ib')
				->leftJoin('cms_deposit', 'cms_deposit.email', '=', 'cms_liveaccount.email')
				->where('cms_deposit.status', 1)
				->select(DB::raw("min(cms_deposit.transaction_time) as isFTD"))
				->first();
				$isFTDTime = $isFTD_time->isFTD;

				$clientWithDeposit = DB::table('cms_ib_level')
				->whereparent_ib($ib_code)
				->wherechild_ib($user_id)
				->join('cms_liveaccount', 'cms_liveaccount.affiliate_prom_code', '=', 'cms_ib_level.child_ib')
				->join('cms_deposit', 'cms_deposit.email', '=', 'cms_liveaccount.email')
				->where('cms_deposit.status', 1)
				->select('cms_liveaccount.affiliate_prom_code as ID','cms_liveaccount.fname as FirstName','cms_liveaccount.lname as LastName','cms_liveaccount.email as Email','cms_liveaccount.country as Country','cms_liveaccount.mobile as Mobile', 'cms_deposit.payment_type as PaymentMethod', 'cms_deposit.payment_email as PaymentEmail', 'cms_deposit.account_no as TradingAccount', 'cms_deposit.amount as Amount', 'cms_deposit.reference_no as ReferrenceNo', 'cms_deposit.transaction_time as TransactionTime', 'cms_ib_level.level as Level',
					DB::raw("(CASE cms_deposit.transaction_time WHEN '$isFTDTime' THEN 1 ELSE 0 END) AS isFTD"))
				->get();

				return response()->json([

					'profile' => $client,

					'tradingAccounts' => $clientAccounts,

					'deposits' => $clientWithDeposit

				], 200, array(), JSON_PRETTY_PRINT);
				
			}
			else{

				return response()->json([

					'code' => "00",

					'message' => "Invalid signature.",

				], 200, array(), JSON_PRETTY_PRINT);
			}
		}
	}

	// Get Single Client Details with date filter
	
	public function getClientDetailsFilter(Request $request){

		$validator = Validator::make($request->all(), 
			[
				'email'=> 'required|email',
				'ib_code'=> 'required|numeric',
				'user_id'=>'required|numeric',
				'start_date'=> 'required|date_format:Y-m-d',
				'end_date'=> 'required|date_format:Y-m-d',
				'signature'=> 'required'
			],
			[	
				'email.required' => 'Email missing',
				'email.email' => 'Email is invalid',
				'ib_code.required' => 'Promo code missing',
				'ib_code.numeric' => 'IB code invalid',
				'user_id.required' => 'User ID missing',
				'user_id.numeric' => 'User ID invalid',
				'start_date.required' => 'Start Date Required',
				'start_date.date_format' => 'Start Date Invalid',
				'end_date.required' => 'End Date Required',
				'end_date.date_format' => 'End Date Invalid',
				'signature.required' => 'Signature is missing',
			]
		);

		if ($validator->fails()) {

			$errors = $validator->errors()->all();

			foreach ($errors as $key => $error) {

				return response()->json([

					'code' => "00",

					'message' => $error,

				], 200, array(), JSON_PRETTY_PRINT);
			}

		}
		else{

			// post data
			$email = $request->email;
			$ib_code = $request->ib_code;
			$user_id = $request->user_id;
			$start_date = $request->start_date;
			$end_date = $request->end_date;
			$signature = $request->signature;

			// calculating the signature for this user
			$api_key =  DB::table('api_promosecret')->where('affiliate_prom_code', $ib_code)->first();

			if (!$api_key || !$api_key->api_key) {
				
				return response()->json([

					'code' => "00",

					'message' => "You are not subscribed",

				], 200, array(), JSON_PRETTY_PRINT);
			}

			// Check if userID Exists

			$userExists =  DB::table('cms_liveaccount')->where('affiliate_prom_code', $user_id)->first();

			if (!$userExists) {
				return response()->json([

					'code' => "00",

					'message' => "User ID invalid",

				], 200, array(), JSON_PRETTY_PRINT);
			}

			// Check if has access to requested user

			$hasAccessUser =  DB::table('cms_ib_level')
			->whereparent_ib($ib_code)
			->wherechild_ib($user_id)
			->first();

			if (!$hasAccessUser) {
				
				return response()->json([

					'code' => "00",

					'message' => "User ID invalid",

				], 200, array(), JSON_PRETTY_PRINT);
			}

			$signatureCalc = strtoupper(md5($email.$ib_code.$user_id.$start_date.$end_date.$api_key->api_key));
            // return $signature.'<br>'.$signatureCalc;
            // return $signatureCalc;
			//$ib_code = 5374;
			if ($signature == $signatureCalc) {

				$client = DB::table('cms_ib_level')
				->whereparent_ib($ib_code)
				->wherechild_ib($user_id)
				->join('cms_liveaccount', 'cms_liveaccount.affiliate_prom_code', '=', 'cms_ib_level.child_ib')
				->select('cms_liveaccount.affiliate_prom_code as ID','cms_liveaccount.fname as FirstName','cms_liveaccount.lname as LastName','cms_liveaccount.email as Email','cms_liveaccount.country as Country','cms_liveaccount.mobile as Mobile','cms_liveaccount.reg_time as RegistrationTime','cms_liveaccount.comment as Comment','cms_liveaccount.email_contact as EmailContact','cms_liveaccount.phone_contact as PhoneContact','cms_ib_level.level as Level')
				->first();

				$clientAccounts = DB::table('cms_ib_level')
				->whereparent_ib($ib_code)
				->wherechild_ib($user_id)
				->join('cms_liveaccount', 'cms_liveaccount.affiliate_prom_code', '=', 'cms_ib_level.child_ib')
				->join('cms_account','cms_account.email','cms_liveaccount.email')
				->join('mt4_users','cms_account.account_no','mt4_users.LOGIN')
				->select('cms_liveaccount.affiliate_prom_code as ID','mt4_users.LOGIN as TradingAccount','mt4_users.BALANCE as Balance','mt4_users.EQUITY as Equity','mt4_users.MARGIN as Margin','mt4_users.MARGIN_LEVEL as MarginLevel','mt4_users.MARGIN_FREE as MarginFree')
				->get();
				foreach($clientAccounts as $ca){
					$totalDeposit = DB::table('mt4_trades')
					->where('mt4_trades.LOGIN','=',$ca->TradingAccount)
					->where('mt4_trades.CMD','=',6)
					->where('mt4_trades.PROFIT','>',0)
					->SUM('mt4_trades.PROFIT');
					$ca->TotalDeposit = $totalDeposit;
				}

				// Detect client First deposit time
				$isFTD_time = DB::table('cms_ib_level')
				->whereparent_ib($ib_code)
				->wherechild_ib($user_id)
				->join('cms_liveaccount', 'cms_liveaccount.affiliate_prom_code', '=', 'cms_ib_level.child_ib')
				->leftJoin('cms_deposit', 'cms_deposit.email', '=', 'cms_liveaccount.email')
				->where('cms_deposit.status', 1)
				->select(DB::raw("min(cms_deposit.transaction_time) as isFTD"))
				->first();
				$isFTDTime = $isFTD_time->isFTD;

				$clientWithDeposit = DB::table('cms_ib_level')
				->whereparent_ib($ib_code)
				->wherechild_ib($user_id)
				->join('cms_liveaccount', 'cms_liveaccount.affiliate_prom_code', '=', 'cms_ib_level.child_ib')
				->join('cms_deposit', 'cms_deposit.email', '=', 'cms_liveaccount.email')
				->where('cms_deposit.status', 1)
				->whereBetween('cms_deposit.transaction_time',[$start_date,$end_date])
				->select('cms_liveaccount.affiliate_prom_code as ID','cms_liveaccount.fname as FirstName','cms_liveaccount.lname as LastName','cms_liveaccount.email as Email','cms_liveaccount.country as Country','cms_liveaccount.mobile as Mobile', 'cms_deposit.payment_type as PaymentMethod', 'cms_deposit.payment_email as PaymentEmail', 'cms_deposit.account_no as TradingAccount', 'cms_deposit.amount as Amount', 'cms_deposit.reference_no as ReferrenceNo', 'cms_deposit.transaction_time as TransactionTime', 'cms_ib_level.level as Level',
					DB::raw("(CASE cms_deposit.transaction_time WHEN '$isFTDTime' THEN 1 ELSE 0 END) AS isFTD"))
				->get();

				return response()->json([

					'profile' => $client,

					'tradingAccounts' => $clientAccounts,

					'deposits' => $clientWithDeposit

				], 200, array(), JSON_PRETTY_PRINT);
				
			}
			else{

				return response()->json([

					'code' => "00",

					'message' => "Invalid signature.",

				], 200, array(), JSON_PRETTY_PRINT);
			}
		}
	}


	/* responsing all the clients' deposits under an IB Account */

	public function getAllDeposits(Request $request)
	{

		$validator = Validator::make($request->all(), 
			[
				'email'=> 'required|email',
				'ib_code'=> 'required|numeric',
				'signature'=> 'required'
			],
			[	
				'email.required' => 'Email missing',
				'email.email' => 'Email is invalid',
				'ib_code.required' => 'Promo code missing',
				'ib_code.numeric' => 'IB code invalid',
				'signature.required' => 'Signature is missing',
			]
		);

		if ($validator->fails()) {

			$errors = $validator->errors()->all();

			foreach ($errors as $key => $error) {

				return response()->json([

					'code' => "00",

					'message' => $error,

				], 200, array(), JSON_PRETTY_PRINT);
			}

		}
		else{

			// post data
			$email = $request->email;
			$ib_code = $request->ib_code;
			$signature = $request->signature;

			// calculating the signature for this user
			$api_key =  DB::table('api_promosecret')->where('affiliate_prom_code', $ib_code)->first();

			if (!$api_key || !$api_key->api_key) {
				
				return response()->json([

					'code' => "00",

					'message' => "You are not subscribed",

				], 200, array(), JSON_PRETTY_PRINT);
			}

			$signatureCalc = strtoupper(md5($email.$ib_code.$api_key->api_key));
            // return $signatureCalc;
			//$ib_code = 5374;
			if ($signature == $signatureCalc) {

				// fetching all the clients' deposits under the provided partner ($ib_code)
				$deposits = DB::table('cms_ib_level')
				->whereparent_ib($ib_code)
				->join('cms_liveaccount', 'cms_liveaccount.affiliate_prom_code', '=', 'cms_ib_level.child_ib')
				->join('cms_deposit', 'cms_deposit.email', '=', 'cms_liveaccount.email')
				->where('cms_deposit.status', 1)
				->select('cms_liveaccount.affiliate_prom_code as ID','cms_liveaccount.fname as FirstName','cms_liveaccount.lname as LastName','cms_liveaccount.email as Email','cms_liveaccount.country as Country','cms_liveaccount.mobile as Mobile', 'cms_deposit.payment_type as PaymentMethod', 'cms_deposit.payment_email as PaymentEmail', 'cms_deposit.account_no as TradingAccount', 'cms_deposit.amount as Amount', 'cms_deposit.reference_no as ReferrenceNo', 'cms_deposit.transaction_time as TransactionTime', 'cms_ib_level.level as Level')
				->get();

				return response()->json([

					'deposits' => $deposits

				], 200, array(), JSON_PRETTY_PRINT);
				
			}
			else{

				return response()->json([

					'code' => "00",

					'message' => "Invalid signature.",

				], 200, array(), JSON_PRETTY_PRINT);
			}
		}
	}

	/* responsing all the clients' deposits under an IB Account filterd by Date */

	public function getAllDepositsFilter(Request $request)
	{

		$validator = Validator::make($request->all(), 
			[
				'email'=> 'required|email',
				'ib_code'=> 'required|numeric',
				'start_date'=> 'required|date_format:Y-m-d',
				'end_date'=> 'required|date_format:Y-m-d',
				'signature'=> 'required'
			],
			[	
				'email.required' => 'Email missing',
				'email.email' => 'Email is invalid',
				'ib_code.required' => 'Promo code missing',
				'ib_code.numeric' => 'IB code invalid',
				'start_date.required' => 'Start Date Required',
				'start_date.date_format' => 'Start Date Invalid',
				'end_date.required' => 'End Date Required',
				'end_date.date_format' => 'End Date Invalid',
				'signature.required' => 'Signature is missing',
			]
		);

		if ($validator->fails()) {

			$errors = $validator->errors()->all();

			foreach ($errors as $key => $error) {

				return response()->json([

					'code' => "00",

					'message' => $error,

				], 200, array(), JSON_PRETTY_PRINT);
			}

		}
		else{

			// post data
			$email = $request->email;
			$ib_code = $request->ib_code;
			$start_date = $request->start_date;
			$end_date = $request->end_date;
			$signature = $request->signature;

			// calculating the signature for this user
			$api_key =  DB::table('api_promosecret')->where('affiliate_prom_code', $ib_code)->first();

			if (!$api_key || !$api_key->api_key) {
				
				return response()->json([

					'code' => "00",

					'message' => "You are not subscribed",

				], 200, array(), JSON_PRETTY_PRINT);
			}

			$signatureCalc = strtoupper(md5($email.$ib_code.$start_date.$end_date.$api_key->api_key));
            // return $signatureCalc;
			//$ib_code = 5374;
			if ($signature == $signatureCalc) {

				// fetching all the clients' deposits under the provided partner ($ib_code)
				$deposits = DB::table('cms_ib_level')
				->whereparent_ib($ib_code)
				->join('cms_liveaccount', 'cms_liveaccount.affiliate_prom_code', '=', 'cms_ib_level.child_ib')
				->join('cms_deposit', 'cms_deposit.email', '=', 'cms_liveaccount.email')
				->where('cms_deposit.status', 1)
				->whereBetween('cms_deposit.transaction_time',[$start_date,$end_date])
				->select('cms_liveaccount.affiliate_prom_code as ID','cms_liveaccount.fname as FirstName','cms_liveaccount.lname as LastName','cms_liveaccount.email as Email','cms_liveaccount.country as Country','cms_liveaccount.mobile as Mobile', 'cms_deposit.payment_type as PaymentMethod', 'cms_deposit.payment_email as PaymentEmail', 'cms_deposit.account_no as TradingAccount', 'cms_deposit.amount as Amount', 'cms_deposit.reference_no as ReferrenceNo', 'cms_deposit.transaction_time as TransactionTime', 'cms_ib_level.level as Level')
				->get();

				return response()->json([

					'deposits' => $deposits

				], 200, array(), JSON_PRETTY_PRINT);
				
			}
			else{

				return response()->json([

					'code' => "00",

					'message' => "Invalid signature.",

				], 200, array(), JSON_PRETTY_PRINT);
			}
		}
	}


	// API Test

	// Getting all the deposits of all clients under an IB
	// public function allDeposits(Request $request)
	// {
	// 	return 'sakil';
	// }

	// end of depopsit fetching


	// public function test(){
	// 	$url = 'https://secure.stellamarkets.com/api/3rdParty/clients';
	// 	$fields = array(
	// 		'email' => 'mkhassan25@gmail.com',
	// 		'ib_code' => '5374',
	// 		'signature' => '6FEE5A2682A21008484B5841DD820D56'
	// 	);
	// 	$fields_string='';
	// 	//url-ify the data for the POST
	// 	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	// 	rtrim($fields_string, '&');

	// 	//open connection
	// 	$ch = curl_init();

	// 	//set the url, number of POST vars, POST data
	// 	curl_setopt($ch,CURLOPT_URL, $url);
	// 	curl_setopt($ch,CURLOPT_POST, count($fields));
	// 	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

	// 	//execute post
	// 	$result = curl_exec($ch);

	// 	//close connection
	// 	curl_close($ch);

	// 	echo $result;
	// }

	// public function test1(){
	// 	$url = 'https://secure.stellamarkets.com/api/3rdParty/client/details';
	// 	// $url = 'localhost:8000/api/3rdParty/client/details';
	// 	$fields = array(
	// 		'email' => 'mkhassan25@gmail.com',
	// 		'ib_code' => '5374',
	// 		'user_id' => '5511',
	// 		'signature' => 'E4E8A07DD5E71804E4ECCCF452FD72A11'
	// 	);
	// 	$fields_string='';
	// 	//url-ify the data for the POST
	// 	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	// 	rtrim($fields_string, '&');

	// 	//open connection
	// 	$ch = curl_init();

	// 	//set the url, number of POST vars, POST data
	// 	curl_setopt($ch,CURLOPT_URL, $url);
	// 	curl_setopt($ch,CURLOPT_POST, count($fields));
	// 	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

	// 	//execute post
	// 	$result = curl_exec($ch);

	// 	//close connection
	// 	curl_close($ch);

	// 	dd($result);
	// }

	// public function test2(){
	// 	// return "fsd";
	// 	$url = 'http://127.0.0.1:8000/api/3rdParty/clients/filter';
	// 	$fields = array(
	// 		'email' => 'mkhassan25@gmail.com',
	// 		'ib_code' => '5374',
	// 		'signature' => '6FEE5A2682A21008484B5841DD820D56'
	// 	);
	// 	$fields_string='';
	// 	//url-ify the data for the POST
	// 	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	// 	rtrim($fields_string, '&');

	// 	//open connection
	// 	$ch = curl_init();

	// 	//set the url, number of POST vars, POST data
	// 	curl_setopt($ch,CURLOPT_URL, $url);
	// 	curl_setopt($ch,CURLOPT_POST, count($fields));
	// 	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

	// 	//execute post
	// 	$result = curl_exec($ch);

	// 	//close connection
	// 	curl_close($ch);

	// 	echo $result;
	// }

}
