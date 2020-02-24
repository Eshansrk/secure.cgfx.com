<!doctype html>
<html class="no-js" lang="{{app()->getLocale()}}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <!--IE Compatibility modes-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--Mobile first-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{asset('img/favicon.png')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('css/components.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('css/custom.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('css/pages/new_dashboard.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('vendors/chartist/css/chartist.min.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('vendors/circliful/css/jquery.circliful.css')}}">
    <link href="/css/jquery-ui.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{asset('vendors/fancybox/css/jquery.fancybox.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('vendors/fancybox/css/jquery.fancybox-buttons.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('vendors/fancybox/css/jquery.fancybox-thumbs.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('vendors/imagehover/css/imagehover.min.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('css/pages/widgets.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('css/pages/index.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/flag-icon.min.css')}}">
    @yield('page-level-css')
    <body class="body">
        <div class="preloader" style=" position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 100000;
        backface-visibility: hidden;
        background: #ffffff;">
        <div class="preloader_img" style="max-width: 200px; height:auto;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%,-50%);
        background-position: center;
        z-index: 999999">
        <img src="{{asset('img/loader.gif')}}" style=" max-width: 200px  !important;">
    </div>
</div>
<div id="wrap">
    <div id="top">
        <!-- .navbar -->
        <nav class="navbar navbar-static-top">
            <div class="container-fluid m-0 navbar-flex" style="">
                <a class="navbar-brand float-left text-center" href="/dashboard">
                    <img src="{{asset('img/logo.png')}}" class="admin_img" alt="logo" style="width:{{$general_info->logo_width}};height:{{$general_info->logo_height}};">
                </a>
                <div class="menu">
                    <span class="toggle-left first-icon hide-icon" id="menu-toggle">
                        <i class="fa fa-bars"></i>
                    </span>
                    <span class="toggle-left second-icon" id="menu-toggle">
                        <i class="fa fa-times "></i>
                    </span>
                </div>
                <div class="topnav dropdown-menu-right float-right" style="float: right; width: 100%;margin-top: 15px;">
                    <div class="menu-ul">
                        <ul style="">
                            <li><a href="{{$general_info->live_chat_link}}">在线聊天</a></li>
                            <li><a href="/faqs">常见问题</a></li>
                            {{-- <li><a href="http://www.forexcrm.ca/">FOREXCRM.CA</a></li> --}}
                            <div class="show-language-menu">
                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    @if (LaravelLocalization::getCurrentLocale() == $localeCode) 
                                <a href="#">
                                        @if($localeCode=="en")
                                        <span class="flag-icon flag-icon-us"></span> {{ $properties['native'] }}
                                        @elseif($localeCode=="zh")
                                        <span class="flag-icon flag-icon-cn"></span> {{ $properties['native'] }}
                                        @elseif($localeCode=="zhHant")
                                        <span class="flag-icon flag-icon-cn"></span> {{ $properties['native'] }}
                                        @else                                      
                                        <span class="flag-icon flag-icon-{{$localeCode}}"></span> {{ $properties['native'] }}
                                       @endif
                                       
                                <span class="caret-language"></span>
                                </a>
                                @endif
                                @endforeach 
                                <ul class="menu-language">
                                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        @if(LaravelLocalization::getCurrentLocale() != $localeCode)
                                <li>
                                <a rel="alternate" hreflang="{{$localeCode}}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
                                        @if($localeCode=="en")
                                        <span class="flag-icon flag-icon-us"></span> {{ $properties['native'] }}
                                        @elseif($localeCode=="zh")
                                        <span class="flag-icon flag-icon-cn"></span> {{ $properties['native'] }}
                                        @elseif($localeCode=="zhHant")
                                        <span class="flag-icon flag-icon-cn"></span> {{ $properties['native'] }}
                                        @else                                      
                                        <span class="flag-icon flag-icon-{{$localeCode}}"></span> {{ $properties['native'] }}
                                       @endif 
                                </a>
                                </li>
                                @endif
                                @endforeach
                                </ul>
                                </div>
                                <li><a href="/logout" title="退出"><i class="fa fa-sign-out" aria-hidden="true" style="font-size: 20px"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </nav>
            <!-- /.navbar -->
            <!-- /.head -->
        </div>
        <div class="wrapper">
            <div id="left" style="background:rgb(61, 65, 68) none repeat scroll 0% 0%;padding-top: 50px;">
                <div class="menu_scroll">
                    <div class="left_media">
                        <div class="media user-media bg-dark dker">
                            <a class="navbar-brand float-left text-center" href="/dashboard">
                                <img src="{{asset('img/logo.png')}}" class="admin_img" alt="logo" style="width:{{$general_info->logo_width}};height:{{$general_info->logo_height}};">
                            </a>
                            <div class="user-media-toggleHover">
                                <span class="fa fa-user"></span>
                            </div>
                            <div class="user-wrapper bg-dark">
                                <a class="user-link" href="/profile" style="top:4px">
                                    <img class="media-object img-thumbnail user-img rounded-circle admin_img3" alt="User Picture"
                                    src="{{session('profile_pic')}}">
                                    <p class="user-info menu_hide">欢迎 {{session('fname')}} <br>ID :
                                    {{session('id')}}</p>
                                </a>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <ul id="menu">
                        <li {!! (Request::is('*/dashboard')? 'class="active"' :"") !!}>
                            <a href="/dashboard">
                                <i class="fa fa-home" style=""></i>
                                <span class="link-title menu_hide">&nbsp;账户总览</span>
                            </a>
                        </li>
                        <li {!! (Request::is('*/profile') || Request::is('*/update-profile')|| Request::is('*/change-password')||
                            Request::is('*/verify-profile')|| Request::is('*/bank-information')|| Request::is('*/bank-information')
                            || Request::is('*/identity-documents-details') || Request::is('*/resident-documents-details')?
                            'class="active dropdown_menu list-active"' :" dropdown_menu list-active") !!}>
                            <a href="javascript:;">
                                <i class="fa fa-user-plus" style=""></i>
                                <span class="link-title menu_hide">&nbsp; 账户资料</span>
                                <span class="fa arrow menu_hide"></span>
                            </a>
                            <ul>
                                <li {!! (Request::is('*/profile')? 'class="active"' :"") !!}>
                                    <a href="/profile">
                                        <i class="fa fa-users" style=""></i>
                                        <span class="link-title ">&nbsp;查看资料</span>
                                    </a>
                                </li>
                                <li {!! (Request::is('*/change-password')? 'class="active"' :"") !!}>
                                    <a href="/change-password">
                                        <i class="fa fa-lock" style=""></i>
                                        <span class="link-title">&nbsp;更改密码</span>
                                    </a>
                                </li>
                                <li {!! (Request::is('*/verify-profile') || Request::is('*/identity-documents-details')
                                || Request::is('*/resident-documents-details')? 'class="active"' :"") !!}>
                                <a href="/verify-profile">
                                    <i class="fa fa-check-square-o" style=""></i>
                                    <span class="link-title">&nbsp;验证资料</span>
                                </a>
                            </li>
                            <li {!! (Request::is('*/bank-information')? 'class="active"' :"") !!}>
                                <a href="/bank-information">
                                    <i class="fa fa-info" style=""></i>
                                    <span class="link-title">&nbsp;银行信息</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li {!! (Request::is('*/trading_account-*')? 'class="active dropdown_menu list-active"' :"
                    dropdown_menu list-active") !!}>
                    <a href="javascript:;">
                        <i class="fa fa-th-large" style=""></i>
                        <span class="link-title menu_hide">&nbsp; 实盘账户</span>
                        <span class="fa arrow menu_hide"></span>
                    </a>
                    <ul id="trading_accounts">
                        @foreach($accounts as $account)
                        <li {!! (Request::is('*/trading_account-'.$account->account_no) || Request::is(app()->getLocale().'/trading_account-'.$account->account_no)?
                        'class="active tr-ac-active"':'class="tr-ac-active"') !!}>
                        <a href="/trading_account-{{$account->account_no}}">
                            <i class="fa fa-user"></i>
                            <span class="link-title">&nbsp;{{$account->acc_no}} {{$account->balance}}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </li>
            <li {!! (Request::is('*/all-trading-accounts') || Request::is('*/open-new-account')||
                Request::is('*/live-trades')|| Request::is('*/change-leverage')|| Request::is('*/change-mt4-password')||
                Request::is('*/open-trading-account')|| Request::is('*/open-demo-account')?
                'class="active dropdown_menu list-active"' :" dropdown_menu list-active") !!}>
                <a href="javascript:;">
                    <i class="fa fa-line-chart" style=""></i>
                    <span class="link-title menu_hide">&nbsp; 交易</span>
                    <span class="fa arrow menu_hide"></span>
                </a>
                <ul>
                    <li {!! (Request::is('*/all-trading-accounts')? 'class="active"' :"") !!}>
                        <a href="/all-trading-accounts">
                            <i class="fa fa-university" style=""></i>
                            <span class="link-title ">&nbsp;我的MT4账户</span>
                        </a>
                    </li>
                    <li {!! (Request::is('*/open-new-account')|| Request::is('*/open-trading-account')||
                    Request::is('*/open-demo-account')? 'class="active"' :"") !!}>
                    <a href="/open-new-account">
                        <i class="fa fa-smile-o" style=""></i>
                        <span class="link-title ">&nbsp;开设新账户</span>
                    </a>
                </li>

                <li {!! (Request::is('*/live-trades')? 'class="active"' :"") !!}>
                    <a href="/live-trades">
                        <i class="fa fa-level-up" style=""></i>
                        <span class="link-title">&nbsp;实时交易</span>
                    </a>
                </li>
                <li {!! (Request::is('*/change-leverage')? 'class="active"' :"") !!}>
                    <a href="/change-leverage">
                        <i class="fa fa-pencil-square-o" style=""></i>
                        <span class="link-title">&nbsp;更改杠杆</span>
                    </a>
                </li>
                <li {!! (Request::is('*/change-mt4-password')? 'class="active"' :"") !!}>
                    <a href="/change-mt4-password">
                        <i class="fa fa-compass" style=""></i>
                        <span class="link-title ">&nbsp;更改MT4密码</span>
                    </a>
                </li>
            </ul>
        </li>
        <li {!! (Request::is('*/deposit-funds') || Request::is('*/internal-transfer')|| Request::is('*/withdraw-funds')||
            Request::is('*/transaction-history') || Request::is('*/voguepay_deposit')||Request::is('*/bank-transfer-funds')||Request::is('*/skrill_deposit')||Request::is('*/neteller_deposit')||Request::is('*/perfect_money_deposit')||Request::is('*/bank-withdraw-funds')||Request::is('*/skrill_withdraw')||Request::is('*/neteller_withdraw')||Request::is('*/okpay_withdraw')||Request::is('*/perfect_money_withdraw')?
            'class="active dropdown_menu list-active"' :" dropdown_menu list-active") !!}>
            <a href="javascript:;">
                <i class="fa fa-money" style=""></i>
                <span class="link-title menu_hide">&nbsp; 资金</span>
                <span class="fa arrow menu_hide"></span>
            </a>
            <ul>
                <li {!! (Request::is('*/deposit-funds') || Request::is('*/voguepay_deposit')||Request::is('*/skrill_deposit')||Request::is('*/neteller_deposit')||Request::is('*/perfect_money_deposit')||Request::is('*/bank-transfer-funds')?
                'class="active"' :"") !!}>
                <a href="/deposit-funds">
                    <i class="fa fa-credit-card" style=""></i>
                    <span class="link-title ">&nbsp;入金</span>
                </a>
            </li>
            <li {!! (Request::is('*/internal-transfer')? 'class="active"' :"") !!}>
                <a href="/internal-transfer">
                    <i class="fa fa-exchange" style=""></i>
                    <span class="link-title ">&nbsp;内部转款</span>
                </a>
            </li>
            <li {!! (Request::is('*/withdraw-funds')||Request::is('*/bank-withdraw-funds')||Request::is('*/skrill_withdraw')||Request::is('*/neteller_withdraw')||Request::is('*/okpay_withdraw')||Request::is('*/perfect_money_withdraw')?
            'class="active"' :"") !!}>
            <a href="/withdraw-funds">
                <i class="fa fa-money" style=""></i>
                <span class="link-title ">&nbsp;提款</span>
            </a>
        </li>
        <li {!! (Request::is('*/transaction-history')? 'class="active"' :"") !!}>
            <a href="/transaction-history">
                <i class="fa fa-book" style=""></i>
                <span class="link-title ">&nbsp;交易历史</span>
            </a>
        </li>
    </ul>
</li>

 {{-- STarting the invest section --}}

 <li {!! (Request::is( '*/open-investor-account') || Request::is( '*/open-investor-account/*') || Request::is(
    '*/open-manager-account') || Request::is( '*/manager-list') ? 'class="active dropdown_menu list-active"' :
    " dropdown_menu list-active") !!}>
    <a href="javascript:;">
    <i class="fa fa-ticket" style=""></i>
    <span class="link-title menu_hide">&nbsp; Invest</span>
    <span class="fa arrow menu_hide"></span>
    </a>
    <ul>
        <li {!! (Request::is( '*/accounts/trading/manager')? 'class="active"' : "") !!}>
            <a href="/accounts/trading/manager">
                <i class="fa fa-envelope-open" style=""></i>
                <span class="link-title">&nbsp;Manage Investor Accounts</span>
            </a>
        </li>
        <li {!! (Request::is( '*/open-manager-account')? 'class="active"' : "") !!}>
            <a href="/open-manager-account">
            <i class="fa fa-envelope-open" style=""></i>
            <span class="link-title">&nbsp;Open Manager Account</span>
        </a>
        </li>
        <li {!! (Request::is( '*/open-investor-account') || Request::is( '*/open-investor-account/*') ? 'class="active"' : "") !!}>
            <a href="/manager-list">
            <i class="fa fa-list-ul" style=""></i>
            <span class="link-title ">&nbsp;Open Investor Account</span>
        </a>
        </li>

    </ul>
</li>
{{-- End of invest section --}}

<li {!! (Request::is('*/open-ticket') || Request::is('*/my-tickets')?
'class="active dropdown_menu list-active"' :" dropdown_menu list-active") !!}>
<a href="javascript:;">
    <i class="fa fa-ticket" style=""></i>
    <span class="link-title menu_hide">&nbsp; 服务记录</span>
    <span class="fa arrow menu_hide"></span>
</a>
<ul>
    <li {!! (Request::is('*/open-ticket')? 'class="active"' :"") !!}>
        <a href="/open-ticket">
            <i class="fa fa-envelope-open" style=""></i>
            <span class="link-title">&nbsp;发起记录</span>
        </a>
    </li>
    <li {!! (Request::is('*/my-tickets')? 'class="active"' :"") !!}>
        <a href="/my-tickets">
            <i class="fa fa-list-ul" style=""></i>
            <span class="link-title ">&nbsp;我的记录</span>
        </a>
    </li>
</ul>
</li>

<li {!! (Request::is('*/download-platforms')? 'class="active"' :"") !!}>
    <a href="/download-platforms">
        <i class="fa fa-download" style=""></i>
        <span class="link-title menu_hide">&nbsp;下载平台</span>
    </a>
</li>

<li {!! (Request::is('*/#')? 'class="active"' :"") !!}>
    <a href="{{$general_info->live_chat_link}}">
        <i class="fa fa-comment" style=""></i>
        <span class="link-title menu_hide">&nbsp;在线支持</span>
    </a>
</li>
<li {!! (Request::is('*/faqs')? 'class="active"' :"") !!}>
    <a href="/faqs">
        <i class="fa fa-question-circle" style=""></i>
        <span class="link-title menu_hide">&nbsp;常见问题解答</span>
    </a>
</li>
</ul>
</div>
</div>
<!-- /#left -->
@yield('content')
<div class="footer-section">
    <div class="inner">
        <div class=" footer-last">
            <div class="footer-p footer">
                <p>{!!$general_info_others->legal_information_text!!}</p>

                <p>{{$general_info_others->copyright_text}}</p>
            </div>
        </div>
    </div>
</div>
</div>
<!-- global scripts-->
<script type="text/javascript" src="{{asset('js/components.js')}}"></script>
<script type="text/javascript" src="{{asset('js/custom.js')}}"></script>
<!-- end of global scripts-->
<!-- plugin scripts-->
<script type="text/javascript" src="{{asset('js/pluginjs/jasny-bootstrap.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/holderjs/js/holder.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/bootstrapvalidator/js/bootstrapValidator.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/pages/validation.js')}}"></script>
<!--  plugin scripts -->
<script type="text/javascript" src="{{asset('vendors/countUp.js/js/countUp.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/flip/js/jquery.flip.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/pluginjs/jquery.sparkline.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/chartist/js/chartist.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/pluginjs/chartist-tooltip.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/swiper/js/swiper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/circliful/js/jquery.circliful.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/flotchart/js/jquery.flot.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/flotchart/js/jquery.flot.resize.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.validate.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/holderjs/js/holder.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/fancybox/js/jquery.fancybox.pack.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/fancybox/js/jquery.fancybox-buttons.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/fancybox/js/jquery.fancybox-thumbs.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/fancybox/js/jquery.fancybox-media.js')}}"></script>
@yield('page-level-js')
<script type="text/javascript">
    $(function () {
        if ($(window).width() < 768) {
            $(".first-icon").click(function () {
                $('.first-icon').hide();
                $('.second-icon').show();
            });
            $(".second-icon").click(function () {
                $('.first-icon').show();
                $('.second-icon').hide();
            });
            $('.panel-button').css({
                'padding': '0'
            });
            $('.panel-button a').css({
                'padding': '2px',
                'border': 'none'
            });
            $('#left').css({
                'min-height': '0px'
            });
        }
    });
</script>
<script>
</script>
<script src="/js/jquery-ui-v-1.10.4.js"></script>
<script>
    $('#dp1').datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: '-77:-15',
        dateFormat: 'dd-mm-yy',
        defaultDate: '01-01-1985',
        onSelect: function () {
            var dateObject = $(this).datepicker('getDate');
        }
    });
</script>
<script type="text/javascript">
    $(document).ready(function (e) {
        $('#country-change').on('change', function (event) {
            var code = $('option:selected', this).attr('code');
            if (code != '') {
                $('#phone_with_code').val('+' + code);
            } else {
                $('#phone_with_code').val('');
            }
        });
        $('.menu').click(function () {
            $('#top.fixed').toggleClass('fixed-navber');
        })
    });
</script>
<script type="text/javascript" src="{{asset('js/jquery.lazy.min.js')}}"></script>
<!--end of plugin scripts-->
</div>
</body>
</html>