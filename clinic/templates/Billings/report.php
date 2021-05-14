<h1>Billing Report</h1>

<div class="alert bg-light border">
    <?= $this->Form->create() ?>
    <div class="row">
        <div class="col-sm-6 col-md-3 col-lg-3 mb-3">
            From Date:
            <input type="date" name="from" id="FromDate" value="<?= $fromDate ?>" class="form-control">
        </div>
        <div class="col-sm-6 col-md-3 col-lg-3 mb-3">
            To Date:
            <input type="date" name="to" id="ToDate" value="<?= $toDate ?>" class="form-control">
        </div>
        <div class="col-sm-6 col-md-3 col-lg-3">
            Treatment Type:
            <?php
            echo $this->Form->control('treatment_type', [
                'type' => 'select',
                'label' => false,
                'div' => false,
                'class' => 'form-control mb-3',
                'options' => ['clinic' => 'Clinic', 'home_visit' => 'Home Visit'],
                'empty' => 'All',
                'default' => $treatmentType ?? '',
            ]);
            ?>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-3 text-start mb-3">
            &nbsp;<br>
            <button type="submit" class="btn btn-primary w-100">Generate Report</button>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>

<?php
if (empty($billings) or count($billings->toArray()) === 0) {
    echo 'No records found';
    return;
}

$totalBillingAmount = 0;
$billingDetails = [];
$i = 0;
foreach ($billings as $billing) :
    $i++;

    $totalBillingAmount += $billing->amount;

    if (isset($billingsDetails[$billing->bill_date->format('Y-m-d')]) and !empty($billingsDetails[$billing->bill_date->format('Y-m-d')])) {
        $billingsDetails[$billing->bill_date->format('Y-m-d')] = (int)$billingsDetails[$billing->bill_date->format('Y-m-d')] + (int)$billing->amount;
    } else {
        $billingsDetails[$billing->bill_date->format('Y-m-d')] = (int)$billing->amount;
    }
endforeach;
?>

<div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        var billingData = [
            <?php
            foreach ($billingsDetails as $date => $amount) :
                $tmpDate = explode('-', $date);
                ?>
                [new Date(<?= $tmpDate[0] ?>, <?= $tmpDate[1] - 1 ?>, <?= $tmpDate[2] ?>), <?= $amount?>],
                <?php
            endforeach;
            ?>
        ];

        function drawChart() {
            //var data = google.visualization.arrayToDataTable(billingData);

            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Date');
            data.addColumn('number', 'Amount');
            data.addRows(billingData);

            var options = {
                title: 'Billed Amount - <?= $totalBillingAmount ?> (From: <?= date('d M y' , strtotime($fromDate)) ?>, To: <?= date('d M y' , strtotime($toDate)) ?>)',
                width: '100%',
                height: '50%',
                hAxis: {
                    format: 'd/M/y',

                },
                vAxis: {
                    gridlines: {color: 'none'},
                    minValue: 0
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

            chart.draw(data, options);
        }
    </script>

    <div id="chart_div" class="w-100" style="height:300px;"></div>

</div>


<div class="table-responsive">
    <table class="table table-sm small mt-3">
        <thead>
        <tr>
            <th>#</th>
            <th>Patient Name</th>
            <th>Treatment Type</th>
            <th>Date</th>
            <th class="text-end">Amount</th>
        </tr>
        </thead>

        <!-- Here is where we iterate through our $articles query object, printing out article info -->

        <tbody>
        <?php
        $i = 0;
        $totalAmount = 0;
        foreach ($billings as $billing) :
            $i++;
            $totalAmount += $billing->amount;
            ?>

            <tr>
                <td>
                    <a href="/billings/view/<?= $billing->id ?>" title="Details - <?= $billing->patient_name ?>" class=""><?= $i ?></a>
                </td>
                <td>
                    <?= $billing->patient_name ?>
                </td>
                <td>
                    <?= $billing->treatment_type == 'clinic' ? 'Clinic' : 'Home Visit' ?>
                </td>
                <td>
                    <?= $billing->bill_date->format('d/m/Y') ?>
                </td>
                <td class="text-end">
                    <?= $billing->amount ?>
                </td>
            </tr>

            <?php
        endforeach;
        ?>
        <tr>
            <td colspan="5" class="text-end">Total Amount: <b><?= $totalAmount ?></b></td>
        </tr>
        </tbody>

    </table>
</div>

