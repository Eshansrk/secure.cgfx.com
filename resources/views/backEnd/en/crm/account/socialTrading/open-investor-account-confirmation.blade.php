@extends('backEnd.'.app()->getLocale().'.dashboard.layout') 
@section('title', 'Open Investor Account') 
@section ('page-level-css')
<link type="text/css" rel="stylesheet" href="/css/components2.css" />
@endsection
 
@section('content')

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5">
                        <i class="fa fa-home"></i> Open Investor Account
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">


            <!--top section widgets-->
            <p style="margin-top:50px;line-height: 50px;font-size: 32px;"><span style="color:green;">Congratulations.</span> Your Investor Account Details has been sent to <span style="font-weight: bold;">{{session('login_email')}}</span>.</p>

            <h3>Account Details:</h3>

            <table class="table table-borderd col-md-6">
                <tr>
                    <th>MT4 Login ID: </th>
                    <td>{{$login_id}}</td>

                </tr>
                <tr>
                    <th>MT4 Investor Password: </th>
                    <td>{{$investor_password}}</td>
                </tr>
                <tr>
                    <th>MT4 Server: </th>
                    <td>{{$server_client}}
                    </td>
                </tr>
                <tr>
                    <th>Download MT4:</th>
                    <td><a style="text-decoration: underline;" href="{{$download_link}}">Download Here</a></td>
                </tr>


            </table>


        </div>
        <!-- /.inner -->
    </div>
</div>
</div>
</div>
@endsection