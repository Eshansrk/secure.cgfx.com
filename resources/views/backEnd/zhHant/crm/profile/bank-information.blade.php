@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', '銀行帳號資料')
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
                        <i class="fa fa-info"></i>
                        銀行帳號資料
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
 

            <!--top section widgets-->
           <div class="card">

                        <div class="card-block m-t-35">
                            <!-- <h2>Bank Information</h2> -->
                            {!! Form::open(['method' => 'POST','files' => true, 'url' => LaravelLocalization::localizeURL('/bank-information'), 'name' => 'bankForm','class'=>'col-md-10','id'=>'bankInformation']) !!}
                           
                            
                            {{csrf_field()}}
                    
                                @if(Session::has('success'))
                                <span class="text-success">
                                    {{Session::get('success')}}
                                </span>
                                @endif
                       
                      
                                
                            
                               
                                    <div class="form-group col-md-6">
                            
                                        {!! Form::label('bank_acc_name', '銀行帳戶名  *') !!}
                                    {!! Form::text('bank_acc_name', $info->bank_acc_name, ['class' => 'form-control input-lg', '' => '', 'placeholder' => '輸入銀行帳戶名']) !!}
                                    <small class="text-danger">{{ $errors->first('bank_acc_name') }}</small>
                                    </div>
                               
                                
                                    <div class="form-group col-md-6">
                                
                                        {!! Form::label('bank_acc_num', '帳戶號 (IBAN) *') !!}
                                    {!! Form::text('bank_acc_num', $info->bank_acc_num, ['class' => 'form-control input-lg', '' => '', 'placeholder' => '輸入銀行帳戶號']) !!}
                                    <small class="text-danger">{{ $errors->first('bank_acc_num') }}</small>
                                    </div> 
                                
                            

                        <div class="form-group col-md-6">
                        
                            {!! Form::label('bank_name', '銀行名稱 *') !!}
                        {!! Form::text('bank_name', $info->bank_name, ['class' => 'form-control input-lg', '' => '', 'placeholder' => '輸入銀行名稱']) !!}
                        <small class="text-danger">{{ $errors->first('bank_name') }}</small>
                        </div>

                        <div class="form-group col-md-6">
                        
                            {!! Form::label('bank_residence_country', '銀行國家*') !!}
                        
                        <select name="bank_residence_country" id="country" class="form-control" >
                            <option disabled="disabled" selected="selected">選擇 選擇</option>
                            @foreach($countries as $country)
                            <option id="{{$country->countries_id}}" value="{{$country->countries_name}}" {{($info->bank_residence_country==$country->countries_name)?'selected=selected':''}}>{{$country->countries_name}}</option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('bank_residence_country') }}</small>
                        </div>


                        <div class="form-group col-md-6">
                        
                            {!! Form::label('bank_residence_state', '州/省份 *') !!}

                            <select name="bank_residence_state" id="state" class="form-control" >
                            
                        </select>

                        <small class="text-danger">{{ $errors->first('bank_residence_state') }}</small>
                        </div>

                        <div class="form-group col-md-6">
                        
                            {!! Form::label('bank_residence_city', '城市 *') !!}
                            <select name="bank_residence_city" id="city" class="form-control" >
                            
                        </select>
                        
                        <small class="text-danger">{{ $errors->first('bank_residence_city') }}</small>
                        </div>

                        <div class="form-group col-md-6">
                        
                            {!! Form::label('bank_residence_code', '郵政編碼 *') !!}
                        {!! Form::text('bank_residence_code', $info->bank_residence_code, ['rows'=>'5','class' => 'form-control input-lg', '' => '', 'placeholder' => '輸入銀行郵政編碼']) !!}
                        <small class="text-danger">{{ $errors->first('bank_residence_code') }}</small>
                        </div>
                        <div class="form-group col-md-6">
                        
                            {!! Form::label('swift_num', '銀行代碼 *') !!}
                        {!! Form::text('swift_num', $info->swift_num, ['class' => 'form-control input-lg', '' => '', 'placeholder' => '輸入 銀行代碼']) !!}
                        <small class="text-danger">{{ $errors->first('swift_num') }}</small>
                        </div>

                        <div class="form-group col-md-6">
                        
                            {!! Form::label('bank_address', '銀行地址 *') !!}
                        {!! Form::textarea('bank_address', $info->bank_address, ['rows'=>'5','class' => 'form-control input-lg', '' => '', 'placeholder' => '輸入銀行地址']) !!}
                        <small class="text-danger">{{ $errors->first('bank_address') }}</small>
                        </div>

                        
      

                        <div class="form-group col-md-12">
                            {!!Form::submit('更新',['class'=>'btn btn-primary'])!!}
                        </div>
                        {!!Form::close()!!}
                    </div>
                        </div>






    </div>
    <!-- /.inner -->
</div>
</div>
</div>
</div>



@endsection




@section('page-level-js')
   


 <script type="text/javascript">
    
  $(function(){


    var selected_state=<?php echo json_encode($info->bank_residence_state, JSON_HEX_TAG); ?>;
    var selected_city=<?php echo json_encode($info->bank_residence_city, JSON_HEX_TAG); ?>;
   

    var id=$('option:selected', '#country').attr('id');
    
     

    $.ajax({
        url: "{{LaravelLocalization::localizeURL('/get-states')}}",
        type:'post',
        data:{
            _token:$('input[name=_token]').val(),
            id:id
        },
        success: function(data){ 
           

          $('#state').html( data );

          $('#state option').each(function(){
    if($(this).val()==selected_state){ // EDITED THIS LINE
        $(this).attr("selected","selected");    
    }
});


          var id=$('option:selected', '#state').attr('id');

          $.ajax({
            url: "{{LaravelLocalization::localizeURL('/get-cities')}}",
            type:'post',
            data:{
                _token:$('input[name=_token]').val(),
                id:id
            },
            success: function(data){ 

              $('#city').html( data );
              $('#city option').each(function(){
    if($(this).val()==selected_city){ // EDITED THIS LINE
        $(this).attr("selected","selected");    
    }
});


          }
      });

      }
  });
    $(document).on('change','#country',function(){

        var id=$('option:selected', '#country').attr('id');
        $.ajax({
            url: "{{LaravelLocalization::localizeURL('/get-states')}}",
            type:'post',
            data:{
                _token:$('input[name=_token]').val(),
                id:id
            },
            success: function(data){ 

              $('#state').html( data );
              $('#state option').each(function(){
    if($(this).val()==selected_state){ // EDITED THIS LINE
        $(this).attr("selected","selected");    
    }
});

          }
      });
    });


    $(document).on('change','#state',function(){

        var id=$('option:selected', '#state').attr('id');

        $.ajax({
            url: "{{LaravelLocalization::localizeURL('/get-cities')}}",
            type:'post',
            data:{
                _token:$('input[name=_token]').val(),
                id:id
            },
            success: function(data){ 

              $('#city').html( data );
              $('#city option').each(function(){
    if($(this).val()==selected_city){ // EDITED THIS LINE
        $(this).attr("selected","selected");    
    }
});

          }
      });
    });

});
</script>
@endsection




