
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Change Leverage')
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
                        Change Leverage
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
                                <a href="#">Show me how</a>
                                <span class="down"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                                <span class="up"><i class="fa fa-chevron-up" aria-hidden="true"></i></span>
                            </div>
                            <div class="show-transfer-hide">
                                <a href=""><span><i class="fa fa-play" aria-hidden="true"></i></span>Video</a>
                                <span>How to Open Account</span>
                            </div>
                        </div>
                    </div> -->

                    <div class="row">
                        <div class="col-md-12">
                            <ul class="up-barcurb">
                                <li class="first-li selected"> 1. Select Your Leverage Account</li>
                                <li class="second-li"> 2. Customise your Leverage account </li>
                            </ul>
                        </div>
                    </div>
                </div>
            <!--top section widgets-->
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
                            <!-- <h4 style="color:red;">{{$errors->first()}}</h4> -->
                            @endif
                            {!! Form::open(['method' => 'POST','files' => true, 'url' => LaravelLocalization::localizeURL('/change-leverage'), 'name' => 'withdrawForm','id' => 'withdrawForm','class'=>'col-md-7 form form-horizontal']) !!}

                                    <div class="form-group">
                                        <div class="span3 " style="margin-top: 5px;"><label class="control-label">Select Account:</label></div>
                                        <div class="span4 form-group">
                                            <select name="account" class="form-control" id="account_type" style="width: 60%">
                                            <option value="">Select Account</option>
                                               @foreach($accounts as $account)
                                                    <option act_type="{{$account->act_type}}" value="{{$account->account_no}}" @if($selected_account==$account->account_no) selected="selected" @endif>{{$account->account_no}}  ( 1:{{$account->leverage}} )</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="span4"></div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="span4 "><label class="control-label">New Leverage:</label></div>
                                        <div class="span4 form-group">
                                            <select name="leverage" class="form-control" id="leverage"  style="width: 60%">
                                                <option value="">Select Leverage</option>
                                                
                                               @foreach($leverage as $lev)
                                               
                                                
                                                    
                                                
                                              
                                                    <option value="{{$lev->leverage}}">1:{{$lev->leverage}}</option>
                                             
                                               @endforeach
                                            </select>
                                        </div>
                                        <div class="span4"></div>
                                    </div>
                                    
                                    <!-- <div class="control-group">
                                        <div class="span4"><label class="control-label">Create a Phone Password:</label></div>
                                        <div class="span5">
                                          <input type="password" name="password" id="Password" placeholder="Password">
                                        </div>
                                        <div class="span3"></div>
                                    </div> -->
                                   <br> 
                                  <div class="control-group">
                                     <div class="span4"></div>
                                     <div class="span4 form-group">
                                     <input type="submit" id="submit" class="btn btn-primary" value="Change" name="submit"> 
                                      <!--<button type="submit" class="btn">Continue</button>-->
                                     
                                     </div> 
                                  </div>

                               {!!Form::close()!!}
                               <div class="col-md-5">
                        <div class="">
                            <div class="">
                                <h5>Summary</h5>
                                <div class="bank-table">
                                    <table class="table" id="myTable">
                                        <tbody>
                                            <tr>
                                                <td class="left">Account Type</td>
                                                <td class="left" id="leverage_show_acoount"></td>
                                            </tr>
                                            <tr>
                                                <td class="left">Account No.</td>
                                                <td class="left" id="type_account"></td>
                                            </tr>
                                            <tr>
                                                <td class="left">Account Currency</td>
                                                <td class="left" id="currency_show">USD</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Leverage</td>
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
    <!-- /.inner -->
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
                        required : "Select account please"
                    },
                    leverage: {
                        required : "Select leverage please"
                    },
                }
            });

            //how to transfer section
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
