@extends('backEnd.'.app()->getLocale().'.dashboard.layout') 
@section('title', '经理细节') 
@section ('page-level-css')
@endsection


@section('content')
<div id="content" class="bg-container">
  <header class="head">
    <div class="main-bar">
      <div class="row no-gutters">
        <div class="col-6">
          <h4 class="m-t-5">
            <i class="fa fa-globe"></i> 经理细节
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
          <!-- Manager Detail -->
          <p> 所有时间的利润: {{ $totalProfit }}</p>
          <p> 年龄（天）: {{ Carbon\Carbon::parse($managerDetail->date_time)->day }} days</p>
          <p> 本月盈利: {{ $thisMonthProfit }}</p>
          <p> 投资者: {{ $totalInvestors }}</p>
          <p> 货币: {{ ($managerDetail->account_currency) ? $managerDetail->account_currency : 'USD' }}</p>
          <p> 分享利益: {{ ($managerSettings && $managerSettings->profit_sharing) ? $managerSettings->profit_sharing : 0 }} %</p>
        </div>
      </div>
      <!-- End of Manager Detail -->
      <!-- Graph Portion One for just graph-->
      <div class="card">
        <div class="card-block">
          <div id="justGraph1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
      </div>
      <!-- End of Graph portion One for just graph-->
      <!-- Graph Portion One-->
      <div class="card">
        <div class="card-block">
          <div id="monthlyStatistics" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
      </div>
      <!-- End of Graph portion One-->

      <!-- Graph Portion two-->
      <div class="card">
        <div class="card-block">
          <div id="dailyStatistics" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
      </div>
      <!-- End of Graph portion two -->
      <!-- Trades History-->
      <div class="card">
        <div class="card-block">
          <p> 总交易量: {{ array_sum($weekDayTrades) }}</p>
          <p> 有利可图的交易: {{ $profitableTrade }} ({{ ($totalTrades > 0) ? round(($profitableTrade*100)/$totalTrades, 2) : 0 }} %)</p>
          <p> 非盈利行业: {{ $nonProfitableTrade }} ({{ ($totalTrades > 0) ? round(($nonProfitableTrade*100)/$totalTrades, 2) : 0
            }} %)</p>
          <p> 购买: {{ $buyTrades }} ({{ ($totalTrades > 0) ? round(($buyTrades*100)/$totalTrades, 2) : 0 }} %)</p>
          <p> 卖: {{ $sellTrades }} ({{ ($totalTrades > 0) ? round(($sellTrades*100)/$totalTrades, 2) : 0 }} %)</p>
          <p>
            最大。利润: {{ round($maxPipsProfit, 2) }} pips</p>
          <p> 闵。利润: {{ round($minPipsProfit, 2) }} pips</p>
          <p> 最大。失利: -{{ round($minPipsLoss, 2) }} pips</p>
          <p> 闵。失利: -{{ round($maxPipsLoss, 2) }} pips</p>
          <p> 平均。交易时间: {{ date('H:i', $sumOfTotalTradeTime) }} Hour</p>
        </div>
      </div>
      <!-- End of Trades History -->
      <!-- Graph Portion three-->
      <div class="card">
        <div class="card-block">
          <div id="totalTrades" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
      </div>
      <!-- End of Graph portion three -->

      <!-- Graph Portion Four-->
      <div class="card">
        <div class="card-block">
          <div id="weekDayTrades" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
      </div>
      <!-- End of Graph portion Four -->
      <!-- Graph Portion Four-->
      <div class="card">
        <div class="card-block">
          <div id="hourlyTrades" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
      </div>
      <!-- End of Graph portion Four -->
      <!-- Graph Portion Four-->
      <div class="card">
        <div class="card-block">
          <div id="currencyWiseTradesPIE" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
      </div>
      <!-- End of Graph portion Four -->
      <!-- Graph Portion Four-->
      <div class="card">
        <div class="card-block">
          <div id="currencyWiseProfitsPIE" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
      </div>
      <!-- End of Graph portion Four -->
    </div>
    <!-- /.inner -->
  </div>
</div>
</div>
</div>
@endsection
 
@section('page-level-js') {{--
<script src="https://code.highcharts.com/stock/highstock.js"></script> --}}
<script src="https://code.highcharts.com/highcharts.js"></script>

<script type="text/javascript">
  $(document).ready(function(){

     // Garph for Daily Profit/Loss
     Highcharts.chart('justGraph1', {
      chart: {
        type: 'spline',
      },
      title: {
        text: ''
      },
      xAxis: {
        lineWidth: 0,
        minorGridLineWidth: 0,
        lineColor: 'transparent',
        minorTickLength: 0,
        tickLength: 0,
        labels: {
          enabled: false
        },
        categories: <?php echo json_encode($sakil1); ?>
      },
      yAxis: {
        gridLineWidth: 0,
        minorGridLineWidth: 0,
        labels: {
          enabled: false
        },
        title: {
          text: null
        }
      },
      legend: {
        enabled: false
      },
      credits: {
        enabled: false
      },
      series: [{
        //type: 'spline',
        name: 'All Time Profit',
        data: <?php echo json_encode($sakilArray); ?>
      }]
    });

    // Highcharts.stockChart('justGraph1', {

    //     rangeSelector: {
    //         selected: 1
    //     },

    //     title: {
    //         text: 'AAPL Stock Price'
    //     },

    //     series: [{
    //         name: 'AAPL',
    //         data: <?php echo json_encode($justGraph); ?>,
    //         tooltip: {
    //             valueDecimals: 2
    //         }
    //     }]
    // });
    // End of Graph for daily Profit/Loss

    // Graph for Monthly profit/Loss
    Highcharts.chart('monthlyStatistics', {
      chart: {
        type: 'column'
      },
      title: {
        text: 'Month VS P/L'
      },
      xAxis: {
        title: {
          text: 'Months'
        },
        categories: <?php  echo json_encode($categories); ?>
      },
      yAxis: {
        title: {
          text: 'Profits'
        },
        plotLines:[{
          value:0,
          color: '#000000',
          width:2,
          zIndex:4,
        }]
      },
      credits: {
        enabled: false
      },
      series: [
      {
        name: "Monthly profit",
        data: <?php echo json_encode($profits); ?>
      }
      ]
    });
    // End of Monthly Profit/Loss Graph


    // Garph for Daily Profit/Loss
    Highcharts.chart('dailyStatistics', {
      chart: {
        zoomType: 'x'
      },
      title: {
        text: 'Day VS P/L'
      },
      subtitle: {
        text: document.ontouchstart === undefined ?
        'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
      },
      xAxis: {
        title: {
          text: 'Date'
        },
        type: 'datetime'
      },
      yAxis: {
        title: {
          text: 'Profit/Loss (P/L)'
        },
        plotLines:[{
          value:0,
          color: '#000000',
          width:2,
          zIndex:4,
        }]
      },
      legend: {
        enabled: true
      },
      plotOptions: {
        area: {
          fillColor: {
            linearGradient: {
              x1: 0,
              y1: 0,
              x2: 0,
              y2: 1
            },
            stops: [
            [0, Highcharts.getOptions().colors[0]],
            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
            ]
          },
          marker: {
            radius: 2
          },
          lineWidth: 1,
          states: {
            hover: {
              lineWidth: 1
            }
          },
          threshold: null
        }
      },
      credits: {
        enabled: false
      },
      series: [{
        type: 'area',
        name: 'Datewise P/L',
        data: <?php echo json_encode($dailyTrades); ?>
      }]
    });
    // End of Graph for daily Profit/Loss

    // Graph for Monthly profit/Loss
    Highcharts.chart('totalTrades', {
      chart: {
        type: 'column'
      },
      title: {
        text: 'Symbols VS Trades'
      },
      xAxis: {
        title: {
          text: 'Symbols'
        },
        categories: <?php  echo json_encode($symbols); ?>
      },
      yAxis: {
        title: {
          text: 'Total Trades'
        },
        plotLines:[{
          value:0,
          color: '#000000',
          width:2,
          zIndex:4,
        }]
      },
      credits: {
        enabled: false
      },
      series: [
      {
        name: "Total Trades",
        data: <?php echo json_encode($trades); ?>
      }
      ]
    });
    // End of Monthly Profit/Loss Graph

    // Graph for Monthly profit/Loss
    Highcharts.chart('weekDayTrades', {
      chart: {
        type: 'column'
      },
      title: {
        text: 'Weekday VS Trades'
      },
      xAxis: {
        categories: <?php  echo json_encode($weekDays); ?>
      },
      yAxis: {
        title: {
          text: 'Total Trades'
        },
        plotLines:[{
          value:0,
          color: '#000000',
          width:2,
          zIndex:4,
        }]
      },
      credits: {
        enabled: false
      },
      series: [
      {
        name: "Trades",
        data: <?php echo json_encode($weekDayTrades); ?>
      },
      {
        name: "Buy",
        data: <?php echo json_encode($weekDayBuyTrades); ?>
      },
      {
        name: "Sale",
        data: <?php echo json_encode($weekDaySellTrades); ?>
      }
      ]
    });
    // End of Monthly Profit/Loss Graph

    // Graph for Monthly profit/Loss
    Highcharts.chart('hourlyTrades', {
      chart: {
        type: 'column'
      },
      title: {
        text: 'Hours VS Trades'
      },
      xAxis: {
        title: {
          text: 'Hours'
        },
        categories: <?php  echo json_encode($hours); ?>
      },
      yAxis: {
        title: {
          text: 'Total Trades'
        },
        plotLines:[{
          value:0,
          color: '#000000',
          width:2,
          zIndex:4,
        }]
      },
      credits: {
        enabled: false
      },
      series: [
      {
        name: "Trades",
        data: <?php echo json_encode($hourlyTrades); ?>
      },
      {
        name: "Buy",
        data: <?php echo json_encode($hourlyBuyTrades); ?>
      },
      {
        name: "Sale",
        data: <?php echo json_encode($hourlySellTrades); ?>
      }
      ]
    });
    // End of Monthly Profit/Loss Graph

    
    // PIE the chart
    Highcharts.chart('currencyWiseTradesPIE', {
      chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
      },
      title: {
        text: 'Browser market shares in January, 2018'
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      plotOptions: {
        pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          dataLabels: {
            enabled: false
          },
          showInLegend: true
        }
      },
      series: [{
        name: 'Trades',
        colorByPoint: true,
        data: <?php echo json_encode($pieChart); ?>
      }]
    });

    // PIE the chart
    // Highcharts.chart('currencyWiseProfitsPIE', {
    //   chart: {
    //     plotBackgroundColor: null,
    //     plotBorderWidth: null,
    //     plotShadow: false,
    //     type: 'pie'
    //   },
    //   title: {
    //     text: 'Browser market shares in January, 2018'
    //   },
    //   tooltip: {
    //     pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    //   },
    //   plotOptions: {
    //     pie: {
    //       allowPointSelect: true,
    //       cursor: 'pointer',
    //       dataLabels: {
    //         enabled: false
    //       },
    //       showInLegend: true
    //     }
    //   },
    //   series: [{
    //     name: 'Trades',
    //     colorByPoint: true,
    //     data: <?php echo json_encode($profitsFromCurrency); ?>
    //   }]
    // });

  })

</script>
@endsection