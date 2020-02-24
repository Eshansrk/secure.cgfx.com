<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // Trading Accounts
        view()->composer(['backEnd.en.dashboard.layout','backEnd.de.dashboard.layout','backEnd.zh.dashboard.layout','backEnd.tr.dashboard.layout','backEnd.zhHant.dashboard.layout'], function ($view) {
            $accounts = \DB::table('cms_account')->join('mt4_users','mt4_users.LOGIN','=','cms_account.account_no')->select(['cms_account.account_no','mt4_users.BALANCE as balance',\DB::raw('CONCAT(cms_account.account_no," (",cms_account.act_type,")") as acc_no')])->where([['cms_account.act_type','<>','DEMO'],['cms_account.act_type','<>','NULL'],['cms_account.email','=',session('login_email')]])->orderBy('cms_account.account_no','desc')->get();
            $view->accounts = $accounts;


        });



            //General Info for all languages

        view()->composer('*', function ($view) {

           $general_info=\DB::table('general_information')->first();
           $view->general_info = $general_info;

       });

            // for english language only
            view()->composer(['backEnd.en.auth.*','backEnd.en.dashboard.layout','backEnd.en.crm.mail.*'], function ($view) {

            $general_info_others=\DB::table('general_information')->first();
            $view->general_info_others = $general_info_others;

        });
     

       // for german language only
        view()->composer(['backEnd.de.auth.*','backEnd.de.dashboard.layout','backEnd.de.crm.mail.*'], function ($view) {

           $general_info_others=\DB::table('general_information_others')->where('language','de')->first();
           $view->general_info_others = $general_info_others;

       });

        // for chinese language only
        view()->composer(['backEnd.zh.auth.*','backEnd.zh.dashboard.layout','backEnd.zh.crm.mail.*'], function ($view) {

           $general_info_others=\DB::table('general_information_others')->where('language','zh')->first();
           $view->general_info_others = $general_info_others;

       });

       // for Turkish language only
       view()->composer(['backEnd.tr.auth.*','backEnd.tr.dashboard.layout','backEnd.tr.crm.mail.*'], function ($view) {

        $general_info_others=\DB::table('general_information_others')->where('language','tr')->first();
        $view->general_info_others = $general_info_others;

    });

    // for Traditional chinese language only
    view()->composer(['backEnd.zhHant.auth.*','backEnd.zhHant.dashboard.layout','backEnd.zhHant.crm.mail.*'], function ($view) {

        $general_info_others=\DB::table('general_information_others')->where('language','zhHant')->first();
        $view->general_info_others = $general_info_others;

    });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
