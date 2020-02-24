@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Bank Information')
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
                        Banka bilgisi
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
                            
                                        {!! Form::label('bank_acc_name', 'Bank Account Name *') !!}
                                    {!! Form::text('bank_acc_name', $info->bank_acc_name, ['class' => 'form-control input-lg', '' => '', 'placeholder' => 'Enter Bank Account Name']) !!}
                                    <small class="text-danger">{{ $errors->first('bank_acc_name') }}</small>
                                    </div>
                               
                                
                                    <div class="form-group col-md-6">
                                
                                        {!! Form::label('bank_acc_num', 'Account No (IBAN) *') !!}
                                    {!! Form::text('bank_acc_num', $info->bank_acc_num, ['class' => 'form-control input-lg', '' => '', 'placeholder' => 'Enter Bank Account No']) !!}
                                    <small class="text-danger">{{ $errors->first('bank_acc_num') }}</small>
                                    </div> 
                                
                            

                        <div class="form-group col-md-6">
                        
                            {!! Form::label('bank_name', 'Bank Name *') !!}
                        {!! Form::text('bank_name', $info->bank_name, ['class' => 'form-control input-lg', '' => '', 'placeholder' => 'Enter Bank Name']) !!}
                        <small class="text-danger">{{ $errors->first('bank_name') }}</small>
                        </div>

                        <div class="form-group col-md-6">
                        
                            {!! Form::label('bank_residence_country', 'Bank Country *') !!}
                        
                        <select name="bank_residence_country" id="country" class="form-control" >
                            <option disabled="disabled" selected="selected">Banka Ülkesi Seç</option>
                            @foreach($countries as $country)
                            <option id="{{$country->countries_id}}" value="{{$country->countries_name}}" {{($info->bank_residence_country==$country->countries_name)?'selected=selected':''}}>{{$country->countries_name}}</option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('bank_residence_country') }}</small>
                        </div>


                        <div class="form-group col-md-6">
                        
                            {!! Form::label('bank_residence_state', 'State Province *') !!}

                            <select name="bank_residence_state" id="state" class="form-control" >
                            
                        </select>

                        <small class="text-danger">{{ $errors->first('bank_residence_state') }}</small>
                        </div>

                        <div class="form-group col-md-6">
                        
                            {!! Form::label('bank_residence_city', 'City *') !!}
                            <select name="bank_residence_city" id="city" class="form-control" >
                            
                        </select>
                        
                        <small class="text-danger">{{ $errors->first('bank_residence_city') }}</small>
                        </div>

                        <div class="form-group col-md-6">
                        
                            {!! Form::label('bank_residence_code', 'Postal Code *') !!}
                        {!! Form::text('bank_residence_code', $info->bank_residence_code, ['rows'=>'5','class' => 'form-control input-lg', '' => '', 'placeholder' => 'Enter Bank Postal Code']) !!}
                        <small class="text-danger">{{ $errors->first('bank_residence_code') }}</small>
                        </div>
                        <div class="form-group col-md-6">
                        
                            {!! Form::label('swift_num', 'Bank Swift Code *') !!}
                        {!! Form::text('swift_num', $info->swift_num, ['class' => 'form-control input-lg', '' => '', 'placeholder' => 'Enter Bank Swift Code']) !!}
                        <small class="text-danger">{{ $errors->first('swift_num') }}</small>
                        </div>

                        <div class="form-group col-md-6">
                        
                            {!! Form::label('bank_address', 'Bank Address *') !!}
                        {!! Form::textarea('bank_address', $info->bank_address, ['rows'=>'5','class' => 'form-control input-lg', '' => '', 'placeholder' => 'Enter Bank Address']) !!}
                        <small class="text-danger">{{ $errors->first('bank_address') }}</small>
                        </div>

                        
      

                        <div class="form-group col-md-12">
                            {!!Form::submit('Update',['class'=>'btn btn-primary'])!!}
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




