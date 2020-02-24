@extends('backEnd.'.app()->getLocale().'.dashboard.layout')
@section('title', 'Withdraw Funds Success')
@section ('page-level-css')
<link type="text/css" rel="stylesheet" href="/css/components2.css" />
@endsection
@section('content')
<div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar row">
                    <div class="col-lg-6">
                        <a href="/withdraw"><h4 class="nav_top_align skin_txt">
                            <i class="fa fa-user"></i>
                            Fon Başarısını Geri Çekmek
                        </h4>
                        </a>
                    </div>
                    
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container">
                    <div class="card">

                        <div class="card-block ">
							
                            <h3 style="color:green;">Para çekmeyi başarıyla talep ettiniz</h3>
							
					</div>
                        </div>
                    </div>
					</div>
                </div>
                    
                    @endsection
                