@extends('backEnd.'.app()->getLocale().'.dashboard.layout') 
@section('title', '开放投资者账户') 
@section ('page-level-css')
@endsection


@section('content')
<div id="content" class="bg-container">
  <header class="head">
    <div class="main-bar">
      <div class="row no-gutters">
        <div class="col-6">
          <h4 class="m-t-5">
            <i class="fa fa-globe"></i> 经理列表
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
                <th scope="col">秩</th>
                <th scope="col">用户名</th>
                <th scope="col">年龄（天）
                </th>
                <th scope="col">利润（所有时间）</th>
                <th scope="col">利润（本月）</th>
                <th scope="col">投资者</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($managers as $key => $manager)
              <tr>
                <th scope="row">{{ $key+1 }}</th>
                <td>
                  <a href="/managers/detail/{{ $manager->int_id }}">
                                    {{ $manager->fname }} {{ $manager->lname }}
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