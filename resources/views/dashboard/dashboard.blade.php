@extends('root')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-6 col-xs-6">
          <form method="POST" id="dashboard-filter">
            {{ csrf_field() }}
            <div class="form-group">
              <label>Filter</label>
              <select name="filter" onchange="event.preventDefault();
                  document.getElementById('dashboard-filter').submit();">
                <option value="0">Semua</option>
                @if($property != null)
                  @foreach($property as $p)
                    <option {{ $p->property_id==$active?'selected':'' }} value="{{$p->property_id}}">{{$p->name}}</option>
                  @endforeach
                @endif
              </select>
            </div>
          <form>
          </div>
      </div>
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ $dashboard['count_upcoming_rent'] }}</h3>
              <p>Upcoming Rent</p>
              <p>Rp. {{ $dashboard['total_upcoming_rent'] }}</p>
            </div>
            <div class="icon">
              <i class="ion ion-home"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>
              {{ $dashboard['count_overdue_rent'] }}
              <!-- <sup style="font-size: 20px">%</sup> -->
              </h3>

              <p>Overdue Rent</p>
              <p>Rp. {{ $dashboard['total_overdue_rent'] }}</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-calendar"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ $dashboard['count_upcoming_expenses'] }}</h3>

              <p>Upcoming Expenses</p>
              <p>Rp. {{ $dashboard['total_upcoming_expenses'] }}</p>
            </div>
            <div class="icon">
              <i class="ion ion-hammer"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ $dashboard['count_overdue_expenses'] }}</h3>

              <p>Overdue Expense</p>
              <p>Rp. {{ $dashboard['total_overdue_expenses'] }}</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-md-6">
          <!-- <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title">Donut Chart</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <canvas id="pieChart" style="height: 145px; width: 291px;" width="291" height="145"></canvas>
              </div>
          </div> -->
          <!-- Donut chart -->
          @if($active==0)
          <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title">Occupancy</h3>

              <div class="box-tools pull-right">
                <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
              </div>
            </div>
            <div class="box-body">
              <div id="donut-chart" style="height: 300px;">
                @if($total_property == 0)
                  <center>NO DATA</center>
                @endif
              </div>
            </div>
          </div>
          @endif
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-12">
        <!-- BAR CHART -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Cash Flow</h3>

              <div class="box-tools pull-right">
                <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                @if($total_property == 0)
                  <center>NO DATA</center>
                @endif
                <canvas id="barChart" style="height:230px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
      </section>
@endsection

@section('js')
<!-- FLOT CHARTS -->
<script src="{{ asset('plugin/bower_components/Flot/jquery.flot.js') }}"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="{{ asset('plugin/bower_components/Flot/jquery.flot.resize.js') }}"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="{{ asset('plugin/bower_components/Flot/jquery.flot.pie.js') }}"></script>
<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
<script src="{{ asset('plugin/bower_components/Flot/jquery.flot.categories.js') }}"></script>

<script>
  var areaChartData = {
        labels  :  @json($dashboard['months']),
        
        datasets: [
          {
            label               : 'Pemasukan',
            fillColor           : 'rgba(210, 214, 222, 1)',
            strokeColor         : 'rgba(210, 214, 222, 1)',
            pointColor          : 'rgba(210, 214, 222, 1)',
            pointStrokeColor    : '#c1c7d1',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data                :  @json($dashboard['incomes'])
          },
          {
            label               : 'Pengeluaran',
            fillColor           : 'rgba(60,141,188,0.9)',
            strokeColor         : 'rgba(60,141,188,0.8)',
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                :  @json($dashboard['outcomes'])
          }
        ]
  }
</script>
<script src="{{ asset('js/dashboard/dashboard.bar-chart.js') }}"></script>

@if($active==0 && $total_property != 0 )
  <script>
    var donutData = [
            { label: 'Terhuni', data: {{$occupied}}, color: '#3c8dbc' },
            { label: 'Kosong', data: {{$total_property-$occupied}}, color: '#0073b7' }
          ];
  </script>
  <script src="{{ asset('js/dashboard/dashboard.donut-chart.js') }}"></script>
@endif
@endsection