@extends('backEnd.'.app()->getLocale().'.dashboard.layout')
@section('title', '修改杠杆')
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
                        <i class="fa fa-pencil-square-o"></i>
                        修改杠杆
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
            <div class="card">
                <div class="card-block m-t-35">
                    <!-- <div class="row">
                        <div class="col-md-6">
                            <div class="show-transfer">
                                <span><i class="fa fa-lightbulb-o" aria-hidden="true"></i></span>
                                <a href="#">演示操作</a>
                                <span class="down"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                                <span class="up"><i class="fa fa-chevron-up" aria-hidden="true"></i></span>
                            </div>
                            <div class="show-transfer-hide">
                                <a href=""><span><i class="fa fa-play" aria-hidden="true"></i></span>视频</a>
                                <span>如何开户</span>
                            </div>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="up-barcurb">
                                <li class="first-li selected"> 1. 选择您的杠杆账户</li>
                                <li class="second-li"> 2. 自定义您的交易账户 </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row-fluid trade">
                    <div class="span12 grey_bg">
                        <div class="padding15">
                            <div class="form-part">
                                <div class="row-fluid">
                                    @if(Session::has('msg'))
                                    <div class="col-md-12">
                                        <div class="alert alert-success"><h3 style="color: #fff;padding-top: 5px;">{{Session::get('msg')}}</h3>
                                        </div>
                                    </div>
                                    @endif
                                    @if($errors->any())
                                    <div class="col-md-12">
                                     <div class="alert alert-danger"><h3 style="color: #fff;padding-top: 5px;">{{$errors->first()}}</h3>
                                     </div>
                                 </div>
                                 @endif
                                 {!! Form::open(['method' => 'POST','files' => true, 'url' => LaravelLocalization::localizeURL('/change-leverage'), 'name' => 'withdrawForm','id' => 'withdrawForm','class'=>'col-md-7 form form-horizontal']) !!}
                                 <div class="form-group">
                                    <div class="span3 " style="margin-top: 5px;"><label class="control-label">选择账户:</label></div>
                                    <div class="span4 form-group">
                                        <select name="account" class="form-control" id="account_type" style="width: 60%">
                                            <option value="">选择账户</option>
                                            @foreach($accounts as $account)
                                            <option act_type="{{$account->act_type}}" value="{{$account->account_no}}" @if($selected_account==$account->account_no) selected="selected" @endif>{{$account->account_no}}  ( 1:{{$account->leverage}} )</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="span4"></div>
                                </div>
                                <div class="form-group ">
                                    <div class="span4 "><label class="control-label">新杠杆:</label></div>
                                    <div class="span4 form-group">
                                        <select name="leverage" class="form-control" id="leverage"  style="width: 60%">
                                            <option value="">选择杠杆</option>
                                            @foreach($leverage as $lev)
                                            <option value="{{$lev->leverage}}">1:{{$lev->leverage}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="span4"></div>
                                </div>
                                <br> 
                                <div class="control-group">
                                 <div class="span4"></div>
                                 <div class="span4 form-group">
                                     <input type="submit" id="submit" class="btn btn-primary" value="更改" name="submit"> 
                                 </div> 
                             </div>
                             {!!Form::close()!!}
                             <div class="col-md-5">
                                <div class="">
                                    <div class="">
                                        <h5>概要</h5>
                                        <div class="bank-table">
                                            <table class="table" id="myTable">
                                                <tbody>
                                                    <tr>
                                                        <td class="left">账户类型</td>
                                                        <td class="left" id="leverage_show_acoount"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="left">账户号码.</td>
                                                        <td class="left" id="type_account"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="left">账户币种</td>
                                                        <td class="left" id="currency_show">美元</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="left">交易杠杆</td>
                                                        <td class="left" id="leverage_show"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
@endsection
@section ('page-level-js')
<script type="text/javascript">
    $(function(){
        var form = $('#withdrawForm');
        form.validate({
            rules : {
                account : {
                    required : true,
                },
                leverage : {
                    required : true,
                }
            },
            messages : {
                account: {
                    required : "請選擇帳戶"
                },
                leverage: {
                    required : "請選擇槓桿"
                },
            }
        });
        $('.show-transfer-hide').hide();
        $('.up').hide();
        $('.show-transfer').click(function(){
            $(this).toggleClass('green');
            $('.down').toggle('2000');
            $('.show-transfer-hide').toggle('2000');
            $('.up').toggle();
        });
        $('#account_type').on('change',function(){
          $select_val=$('#account_type option:selected').val();
          $('#type_account').html($select_val);
      });
        $select_val=$('#account_type option:selected').val();
        $('#type_account').html($select_val);
        $('#leverage').on('change',function(){
          $select_val1=$('#leverage option:selected').val();
          $('#leverage_show').html($select_val1);
      });
        $select_val1=$('#leverage option:selected').val();
        $('#leverage_show').html($select_val1);
        $('#account_type').on('change',function(){
          $select_val2=$('#account_type option:selected').attr('act_type');
          $('#leverage_show_acoount').html($select_val2);
      });
        $select_val2=$('#account_type option:selected').attr('act_type');
        $('#leverage_show_acoount').html($select_val2);
    });
</script>
@endsection