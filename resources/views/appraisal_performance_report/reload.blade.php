@if(isset($goalData))
<div class="row">
    <!-- Overall Summary Cards -->
    <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card">
            <div class="header bg-blue">
                <h2>OKR Overall Performance</h2>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-center">{{ number_format($okrOverallAvgPerct, 2) }}%</h1>
                        <p class="text-center">Average Individual Goal Achievement</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card">
            <div class="header bg-green">
                <h2>BSC Unit Overall Performance</h2>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-center">{{ number_format($bscOverallAvgPerct, 2) }}%</h1>
                        <p class="text-center">Average Unit Goal Achievement</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card">
            <div class="header bg-orange">
                <h2>BSC Individaul Overall Performance</h2>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-center">{{ number_format($bscIndividualOverallAvgPerct, 2) }}%</h1>
                        <p class="text-center">Average Bsc Individual Goal Achievement</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Department Performance Chart -->
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="header">
                <h2>Department-wise Performance Overview</h2>
            </div>
            <div class="body">
                <div id="departmentChart" style="height: 520px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- Department Details -->
@foreach($dept as $department)
    @if($department->bscUnitOverallAvgPerct > 0 || $department->overallAvgPerct > 0)
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header bg-grey">
                        <h2>{{ $department->dept_name }} Department</h2>
                        <ul class="header-dropdown">
                            <li>
                                <a href="javascript:void(0);" data-toggle="collapse" data-target="#dept-{{ $department->id }}">
                                    <i class="material-icons">expand_more</i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="body collapse in" id="dept-{{ $department->id }}">
                        <div class="row">
                            <!-- OKR Performance -->
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="card">
                                    <div class="header bg-blue">
                                        <h4>OKR Performance</h4>
                                    </div>
                                    <div class="body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3 class="text-center">{{ number_format($department->overallAvgPerct, 2) }}%</h3>
                                                <p class="text-center">Overall Average</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <small>Objectives</small>
                                                <h5>{{ number_format($department->objAvgPerct, 2) }}%</h5>
                                            </div>
                                            <div class="col-md-4">
                                                <small>Behavioral</small>
                                                <h5>{{ number_format($department->behavAvgPerct, 2) }}%</h5>
                                            </div>
                                            <div class="col-md-4">
                                                <small>Technical</small>
                                                <h5>{{ number_format($department->techAvgPerct, 2) }}%</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- BSC Performance -->
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="card">
                                    <div class="header bg-green">
                                        <h4>BSC Performance</h4>
                                    </div>
                                    <div class="body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3 class="text-center">{{ number_format($department->bscUnitOverallAvgPerct, 2) }}%</h3>
                                                <p class="text-center">Unit Goals Average</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <small>Individual Objectives</small>
                                                <h5>{{ number_format($department->bscIndividualOverallAvgPerct, 2) }}%</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Employee Count -->
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="card">
                                    <div class="header bg-orange">
                                        <h4>Employee Statistics</h4>
                                    </div>
                                    <div class="body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3 class="text-center">{{ $department->empData->count() }}</h3>
                                                <p class="text-center">Total Employees with OKR Goals</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Employee Performance Table -->
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card">

                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab" id="headingOne_1">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapseOne_{{$department->id}}" aria-expanded="false" aria-controls="collapseOne_{{$department->id}}">
                                                    Employee Performance Details (Click to Expand/Collapse)
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseOne_{{$department->id}}" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne_1">
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Employee Name</th>
                                                                <th>Completed</th>
                                                                <th>Objectives (%)</th>
                                                                <th>Behavioral (%)</th>
                                                                <th>Technical (%)</th>
                                                                <th>Overall OKR (%)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($department->empData as $employee)
                                                            
                                                            <tr>
                                                                <td>{{ $employee->indi_user->firstname . ' ' . $employee->indi_user->lastname  }}</td>
                                                                <td>{{ implode(', ', $employee->finishedGoals) }}</td>
                                                                <td>{{ isset($employee->objectives) ? number_format($employee->objectives, 2) . '%' : 'N/A' }}</td>
                                                                <td>{{ isset($employee->behavioral) ? number_format($employee->behavioral, 2) . '%' : 'N/A' }}</td>
                                                                <td>{{ isset($employee->technical) ? number_format($employee->technical, 2) . '%' : 'N/A' }}</td>
                                                                <td>{{ isset($employee->overall) ? number_format($employee->overall, 2) . '%' : 'N/A' }}</td>
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
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

<script>
$(document).ready(function() {
    // Department Performance Chart
    var deptNames = [];
    var okrAverages = [];
    var objAverages = [];
    var behavAverages = [];
    var techAverages = [];
    var bscAverages = [];
    var bscIndividualAverages = [];

    @foreach($dept as $department)
        deptNames.push(@json($department->dept_name ?? $department->name));
        okrAverages.push(@json($department->overallAvgPerct ?? 0));
        objAverages.push(@json($department->objAvgPerct ?? 0));
        behavAverages.push(@json($department->behavAvgPerct ?? 0));
        techAverages.push(@json($department->techAvgPerct ?? 0));
        bscAverages.push(@json($department->bscUnitOverallAvgPerct ?? 0));
        bscIndividualAverages.push(@json($department->bscIndividualOverallAvgPerct ?? 0));
    @endforeach

    Highcharts.chart('departmentChart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Department Performance Comparison'
        },
        xAxis: {
            categories: deptNames,
            title: {
                text: 'Departments'
            }
        },
        yAxis: {
            min: 0,
            max: 100,
            title: {
                text: 'Achievement Percentage (%)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f}%</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'OKR Overall Performance',
            data: okrAverages,
            color: '#6421f3'
        }, {
            name: 'Individual Objectives Average Score',
            data: objAverages,
            color: '#00BCD4'
        }, {
            name: 'Behavioral Average Score',
            data: behavAverages,
            color: '#9C27B0'
        }, {
            name: 'Technical Average Score',
            data: techAverages,
            color: '#FF9800'
        }, {
            name: 'BSC Unit Average Score',
            data: bscAverages,
            color: '#4CAF50'
        }, {
            name: 'BSC Individual Average Score',
            data: bscIndividualAverages,
            color: '#607D8B'
        }]
    });
});
</script>

@else
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="body">
                <h4 class="text-center">Please select a goal set to view the performance report.</h4>
            </div>
        </div>
    </div>
</div>
@endif
