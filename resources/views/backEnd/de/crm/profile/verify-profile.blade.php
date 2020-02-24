
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Profil Verifizieren')
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
                        <i class="fa fa-check-square-o"></i>
                        Profil Verifizieren
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
 

            <!--top section widgets-->
            <div class="card">      
                            
                <div class="row">

                    <div class="col-md-12">
                        <div class="varification">
                            <h4>Profilverifizierung : 
                            @if($status==2)
                           
                            <span style="color: green">Bestätigt<i class="fa fa-check profile-verification-icon" aria-hidden="true"></i></span>
                           
                            @elseif($status==0)
                            <span style="color: tomato">nicht Bestätigt<i class="fa fa-times profile-verification-icon" aria-hidden="true"></i></span>
                            
                             @else
                            <span style="color: #fc2">Teilweise Bestätigt<i class="fa fa-info profile-verification-icon" aria-hidden="true"></i></span>
                             @endif
                        </h4>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="identity-verification m-b-20">
                                                <div class="col-md-1">
                                                    <div class="left-img">
                                                        <img src="/img/user-avatar-with-check-mark.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="des-identity">
                                                        <p>Identitätsprüfung</p>
                                                        <p>Farbig hochauflösende Scan-Kopien oder Foto eines Dokuments, die Ihre Persönlichkeit mit vollem Namen, Foto, Unterschrift, Geburtsdatum, Ablaufdatum ist klar ersichtlich und das ist gültig für mindestens 6 Monate ab dem Zeitpunkt der Anwendung.</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3" style="position: relative;">
                                                    <div class="details-button">
                                                        <a href="/identity-documents-details">Einzelheiten</a>
                                                    </div>
                                                    <div class="verify-button">
                                                        <a href="/not-verified">Jetzt Prüfen</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="identity-verification">
                                                <div class="col-md-1">
                                                    <div class="left-img">
                                                        <img src="/img/house.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="des-identity">
                                                        <p>Residenz Verifikation</p>
                                                        <p>Kopieren Sie hochaufgelöste Scan-Kopien oder Foto eines Dokuments, in dem Ihr vollständiger Name und Ihre Adresse deutlich zu sehen sind und mit den in Ihrem Profil angegebenen Daten übereinstimmen. Das Dokument sollte nicht später als 3 Monate ausgegeben werden.</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3" style="position: relative;">
                                                    <div class="details-button">
                                                        <a href="/resident-documents-details">Einzelheiten</a>
                                                    </div>
                                                    <div class="verify-button">
                                                        <a href="/not-verified">Jetzt Prüfen</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                    </div>
                                    
                                </div>
                            
                        </div>

                        <div class="card" style="margin-top: 5%">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="varification">
                                        <h4>Hochgeladene Dokumente</h4>
                                    </div>
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Datum</th>
                                                        <th>Typ</th>
                                                        <th>Status</th>
                                                        <th>Kommentar</th>
                                                        <th>Dokument anzeigen</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($doc as $key => $documents)
                                                    <tr>
                                                        <td>{{ Carbon\Carbon::parse($documents->date_time)->format('d-m-Y') }}</td>
                                                        <td>{{$documents->document_type}}</td>
                                                        <td>
                                                            @if($documents->status == 0)
                                                            <span style="color: #fc2">Anstehend<i class="fa fa-info profile-verification-icon" aria-hidden="true"></i></span>
                                                            @elseif($documents->status == 1) 
                                                            <span style="color: green">Genehmigt<i class="fa fa-check profile-verification-icon" aria-hidden="true"></i></span> 

                                                            @else  
                                                            <span style="color: tomato">Abgebrochen<i class="fa fa-times profile-verification-icon" aria-hidden="true"></i></span>
                                                            @endif
                                                        </td>
                                                        <td>{!!$documents->reason!!}</td>
                                                        <td>
                                                            <a href="{{$documents->document}}"><img src="/img/picture.png" width="10%"></a></td><img src="{{$documents->document}}" alt="" class="image-show lazy">

                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
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
@endsection

@section('page-level-js')

<script type="text/javascript">
    $(function(){
        $('.image-show').hide();
        $('.image-icon').click(function(){
        $('.image-show').show();
        $('.image-show').hide();
    });
        $('.lazy').Lazy();
});
</script>

    

@endsection
