@extends('backEnd.'.app()->getLocale().'.dashboard.layout') 
@section('title', 'Open Investor Account') 
@section ('page-level-css')
@endsection
 
@section('content')
<div id="content" class="bg-container">
  <header class="head">
    <div class="main-bar">
      <div class="row no-gutters">
        <div class="col-6">
          <h4 class="m-t-5">
            <i class="fa fa-globe"></i> Manager List
          </h4>
        </div>
      </div>
    </div>
  </header>
  <div class="outer">
    <div class="inner bg-container">

      <!--top section widgets-->
      <div class="card">
        <div class="card-block">
          <!-- ManagerTable -->
          <table class="table table-striped table-responsive">
            <thead>
              <tr>
                <th scope="col">Rank</th>
                <th scope="col">Account Name</th>
                <th scope="col">Age (in days)</th>
                <th scope="col">Profit (All time)</th>
                <th scope="col">Profit (This month)</th>
                <th scope="col">Investors</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($managers as $key => $manager)
              <tr>
                <th scope="row">{{ $key+1 }}</th>
                {{--
                <td>{{ $manager->fname }} {{ $manager->lname }}</td> --}}
                <td>
                  <a href="/managers/detail/{{ $manager->int_id }}">
                                    {{ $manager->st_username }}
                                   </a>
                </td>
                {{--
                <td>{{ Carbon\Carbon::now() }}</td> --}}

                <!-- <td>{{ Carbon\Carbon::parse($manager->date_time)->day }} days</td> -->

                <td>
                  @php $created = new Carbon\Carbon($manager->date_time); $now = Carbon\Carbon::now(); $difference = $created->diffInDays($now);
                  
@endphp {{ $difference }}
                </td>
                {{--
                <td>{{ $manager->date_time }}</td> --}}
                <td>{{ round($manager->totalProfit, 2) }}</td>
                <td>{{ round($manager->totalMonthlyProfit, 2) }}</td>
                <td>{{ ($manager->totalInvestor) ? $manager->totalInvestor : 0 }}</td>
                <td>
                  <a href="/managers/detail/{{ $manager->int_id }}">
                    <button type="button" class="btn btn-primary">
                        Details
                      </button>
                  </a>
                  <a href="/open-investor-account/{{ $manager->int_id }}">
                    <button type="button" class="btn btn-success">
                        Invest
                      </button>
                  </a>
                </td>
              </tr>
              @endforeach

            </tbody>
          </table>
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
@endsection