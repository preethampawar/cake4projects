<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<h1><i class="fa fa-chart-pie"></i> Transactions Report</h1>

<?php
echo $this->Form->create(null);
?>
<div class="mt-3 p-2 bg-light rounded border">
    <div class="row">
        <div class="col-sm-4 col-md-3">
            <?php

            use App\Model\Table\TransactionsTable;

            echo $this->Form->control('fromDate',
                [
                    'label' => 'From Date',
                    'type' => 'date',
                    'required' => true,
                    'class' => 'form-control form-control-sm mb-3',
                    'default' => $defaultFromDate
                ]);
            ?>
        </div>
        <div class="col-sm-4 col-md-3">
            <?php
            echo $this->Form->control('toDate',
                [
                    'label' => 'To Date',
                    'type' => 'date',
                    'required' => true,
                    'class' => 'form-control form-control-sm mb-3',
                    'default' => $defaultToDate
                ]);
            ?>
        </div>
        <div class="col-sm-4 col-md-3">
            <?php
            echo $this->Form->control('transactionType',
                [
                    'type' => 'select',
                    'label' => 'Transaction Type',
                    'required' => false,
                    'class' => 'form-select form-select-sm',
                    'empty' => 'All',
                    'options' => TransactionsTable::TRANSACTION_TYPES,
                    'default' => $selectedTransactionType,
                ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 mt-3">
            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
        </div>
    </div>
</div>

<?php
echo $this->Form->end();
?>

<?php
if ($formSumitted) {
    ?>
    <div class="fw-bold small mt-3">
        Results from "<?= date('d M Y', strtotime($defaultFromDate)) ?>" to "<?= date('d M Y', strtotime($defaultToDate)) ?>"
    </div>
    <?php
}
?>

<div class="accordion accordion-flush" id="accordionFlushExample">
    <div class="accordion-item">
        <div class="accordion-header" id="flush-headingOne">
            <button class="accordion-button expanded" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                Visual Report
            </button>
        </div>
        <div id="flush-collapseOne" class="accordion-collapse expand" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body px-0">

                <div class="" id="visualReport">
                    <?php
                    if ($transactionsInfo) {
                        ?>
                        <div class="border p-1 rounded">
                            <div class="text-start bg-light p-2 border rounded">
                                <span class="fs-5 text-purple-dark"><i class="fa fa-chart-pie"></i> Complete Report</span>
                            </div>

                            <table class="table mt-2">
                                <thead>
                                <tr>
                                    <th class="text-success text-center">Income</th>
                                    <th class="text-danger text-center">Expense</th>
                                    <th class="text-center">Balance</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="text-success text-center"><?= $transactionsInfo['income'] ?></td>
                                    <td class="text-danger text-center"><?= $transactionsInfo['expense'] ?></td>
                                    <td class="text-center">
                                        <?php
                                        $bal = $transactionsInfo['income'] - $transactionsInfo['expense'];

                                        echo $bal > 0
                                            ? '<span class="text-success">'.$bal.'</span>'
                                            : '<span class="text-danger">'.$bal.'</span>';
                                        ?>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <div>
                                <div class="row">
                                    <div class="col-md-8 col-lg-5">
                                        <div id="piechart" style="width: 100%; height: 300px;"></div>
                                        <br>
                                    </div>
                                </div>

                                <script type="text/javascript">
                                    google.charts.load('current', {'packages':['corechart']});
                                    google.charts.setOnLoadCallback(drawChart);

                                    function drawChart() {

                                        var data = google.visualization.arrayToDataTable([
                                            ['Report', 'Amount'],
                                            ['Income', <?= $transactionsInfo['income'] ?>],
                                            ['Expense', <?= $transactionsInfo['expense'] ?>],
                                        ]);

                                        var options = {
                                            title: 'From "<?= date('d M y', strtotime($defaultFromDate)) ?>" to "<?= date('d M y', strtotime($defaultToDate)) ?>"',

                                            chartArea:{left:20,top:40,width:'100%',height:'100%'},
                                            colors: ['#00c186', '#f55667']
                                        };

                                        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                                        chart.draw(data, options);
                                    }
                                </script>

                            </div>
                        </div>

                        <?php
                        if ($transactionsMonthWiseInfo) {
                            ?>
                            <div class="p-1 rounded border mt-3">
                                <div class="text-start bg-light p-2 border rounded">
                                    <span class="fs-5 text-purple-dark"><i class="fa fa-chart-line"></i> Month Wise Report</span>
                                </div>


                                <div class="px-1">
                                    <table class="table table-sm text-center small mt-2">
                                        <thead>
                                        <tr>
                                            <th>Month</th>
                                            <th class="text-success">Income</th>
                                            <th class="text-danger">Expense</th>
                                            <th>Balance</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($transactionsMonthWiseInfo as $date => $row) {
                                            ?>
                                            <tr>
                                                <td class="text-capitalize text-nowrap small"><?= date('M y', strtotime($date)) ?></td>
                                                <td class="text-success small"><?= $row['income'] ?? 0 ?></td>
                                                <td class="text-danger small"><?= $row['expense'] ?? 0 ?></td>
                                                <td class="small">
                                                    <?php
                                                    $amount = (float)($row['income'] ?? 0) - (float)($row['expense'] ?? 0);

                                                    echo $amount > 0 ?
                                                        '<span class="text-success">'.$amount.'</span>' :
                                                        '<span class="text-danger">'.$amount.'</span>';

                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>

                                    <div class="mt-4 table-responsive-md">
                                        <div class="">
                                            <div class="">
                                                <?php
                                                $count = count($transactionsMonthWiseInfo);
                                                $height = $count === 1 ? 150 : (100*$count);
                                                $width = 100*$count.'px';
                                                ?>
                                                <div id="curve_chart" class="small" style="width:100%; height: <?= $height ?>px;"></div>
                                                <br>
                                                <div id="area_chart_div" class="small"  style="width: 100%; height: 500px;"></div>
                                            </div>
                                        </div>

                                        <script type="text/javascript">
                                            google.charts.load('current', {'packages':['bar']});
                                            google.charts.setOnLoadCallback(drawChart2);

                                            function drawChart2() {
                                                var data = new google.visualization.DataTable();
                                                data.addColumn('string', '');
                                                data.addColumn('number', 'Income');
                                                data.addColumn('number', 'Expense');

                                                data.addRows([
                                                    <?php
                                                    foreach ($transactionsMonthWiseInfo as $date => $row) {
                                                    ?>
                                                    [
                                                        '<?= date('M y', strtotime($date)) ?>',
                                                        <?= $row['income'] ?? 0 ?>,
                                                        <?= $row['expense'] ?? 0 ?>
                                                    ],
                                                    <?php
                                                    }
                                                    ?>
                                                ]);

                                                var options = {
                                                    chart: {
                                                        title: 'Monthly Performance',
                                                        subtitle: 'Income & Expense',
                                                    },
                                                    bars: 'horizontal', // Required for Material Bar Charts.
                                                    legend: { position: 'none'},
                                                    hAxis: {format: ''},
                                                    // axes: {
                                                    //     x: {
                                                    //         0: { side: 'top', label: 'Amount'} // Top x-axis.
                                                    //     }
                                                    // },
                                                    colors: ['#00c186', '#f55667']

                                                };

                                                var chart = new google.charts.Bar(document.getElementById('curve_chart'));

                                                chart.draw(data, google.charts.Bar.convertOptions(options));

                                            }
                                        </script>

                                        <script type="text/javascript">
                                            google.charts.load('current', {'packages':['corechart']});
                                            google.charts.setOnLoadCallback(drawChartArea);

                                            function drawChartArea() {
                                                var data = new google.visualization.DataTable();
                                                data.addColumn('string', 'Month');
                                                data.addColumn('number', 'Income');
                                                data.addColumn('number', 'Expense');

                                                data.addRows([
                                                    <?php
                                                    $totalIncome = 0;
                                                    $totalExpense = 0;

                                                    foreach ($transactionsMonthWiseInfo as $date => $row) {
                                                    $totalIncome += $row['income'] ?? 0;
                                                    $totalExpense += $row['expense'] ?? 0;
                                                    ?>
                                                    [
                                                        '<?= date('M y', strtotime($date)) ?>',
                                                        <?= $totalIncome ?>,
                                                        <?= $totalExpense ?>
                                                    ],
                                                    <?php
                                                    }
                                                    ?>
                                                ]);

                                                var options = {
                                                    title: 'Total Income & Expense (Growth)',
                                                    vAxis: {minValue: 0},
                                                    colors: ['#00c186', '#f55667']
                                                };

                                                var chart = new google.visualization.AreaChart(document.getElementById('area_chart_div'));
                                                chart.draw(data, options);
                                            }
                                        </script>
                                    </div>
                                </div>

                            </div>

                            <?php
                        }
                        ?>
                        <?php
                    } elseif($formSumitted) {
                        ?>
                        No records found.
                        <?php
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>
    <div class="accordion-item">
        <div class="accordion-header" id="flush-headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                Results
            </button>
        </div>
        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
                Coming soon.
            </div>
        </div>
    </div>
</div>

