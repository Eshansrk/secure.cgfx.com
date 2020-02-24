<?php

namespace App\Http\Controllers\API;

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

	/* post request from the  websites */
	public function registration3rdParty(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'fname'=> 'required',
			'lname'=> 'required',
			'email'=> 'required|email|unique:cms_liveaccount',
			'country'=> 'required',
			'mobile'=> 'required',
			// 'dob'=> 'required|date_format:Y-m-d',
			'ib_code'=> 'required|numeric',
			'signature'=> 'required'
		],
		[
			'fname.required' => 'First name missing',
			'lname.required' => 'Last name missing',
			'email.required' => 'Email missing',
			'email.email' => 'Email is invalid',
			'email.unique' => 'Email already used',
			'country.required' => 'Country missing',
			'mobile.required' => 'Mobile missing',
			// 'dob.required' => 'Date of birth missing',
			// 'dob.date_format' => 'Date of birth is invalid',
			'ib_code.required' => 'Promo code missing',
			'ib_code.numeric' => 'IB code invalid',
			'signature.required' => 'Signature is missing',

		]
	);

		// validation failed
		if ($validator->fails()) {

			$errors = $validator->errors()->all();

			foreach ($errors as $key => $error) {

				$response = array(
					'code' => "00",
					'message' => $error,
				);
				
				return (json_encode($response));
			}

		}

		// post data
		$fname = $request->fname;
		$lname = $request->lname;
		$email = $request->email;
		$country = $request->country;
		$mobile = $request->mobile;
		$dob = $request->dob;
		$ib_code = $request->ib_code;

		$signature = $request->signature;

		// validation passes
		$signatureCalc = strtoupper(md5($fname.$lname.$email.$country.$mobile.$dob.$ib_code));


		if ($signature == $signatureCalc) {

			
			//return "successful.";

			if($this->postRegistration($request->all()) == 'successful'){

				// logging in automatically

		$dat=DB::table('cms_Liveaccount')->where('email',$email)->first();

		if($dat){

			auth()->guard('admin')->loginUsingId($dat->intId);

			
			session(['login_email' => $dat->email]);
			
			session(['lname' => $dat->lname,'fname' => $dat->fname, 'id' => $dat->referred_by]);
			
			Session::save();

			//return auth()->guard('admin')->user();

			return redirect()->intended('/dashboard');

			return "successful";

		}
			}
			else{

				$response = array(
					'code' => "00",
					'message' => "System error.",
				);

				return (json_encode($response));
			}
		}
		else{

			$response = array(
				'code' => "00",
				'message' => "Invalid signature.",
			);

			return (json_encode($response));
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

		$time = strtotime($newUser['dob']);

		$newAccount->dob = date('Y-m-d',$time);
		$newAccount->email = $newUser['email'];
        //$password = $newUser['password'];
		$password = str_random(8);
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
				$newAffiliateAccountLvl1->child_ib = $newAccount->referred_by;
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
}
