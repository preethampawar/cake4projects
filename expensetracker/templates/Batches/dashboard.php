<div class="alert alert-warning p-3">
    <h6>Quick Add</h6>
    <?php
    echo $this->Form->create(null, ['action'=>'/Transactions/quickAdd', 'id'=>'quickAddForm'])
    ?>
        <div>
            <input
                type="number"
                id="transactionAmount"
                name="transaction_amount"
                class="form-control"
                step="0.01"
                placeholder="Amount">
            <input type="hidden" name="transaction_date" value="<?= date('Y-m-d') ?>">
            <input type="hidden" name="transaction_type" id="quickAddTransactionType">
        </div>
        <div class="mt-3 text-center">
            <button type="button" class="btn btn-success me-3" onclick="addTransaction('income')"><i class="fa fa-plus-circle"></i> Income</button>
            <button type="button" class="btn btn-danger" onclick="addTransaction('expense')"><i class="fa fa-minus-circle"></i> Expense</button>
        </div>
    <?php
    echo $this->Form->end();
    ?>

    <script>
        function addTransaction(type) {
            if (type == 'income') {
                $('#quickAddTransactionType').val('income')
            }
            if (type == 'expense') {
                $('#quickAddTransactionType').val('expense')
            }

            $('#quickAddForm').submit()
        }
    </script>
</div>

<div class="d-flex justify-content-between mt-5">
    <div class="text-center text-primary fs-5">
        <i class="fa fa-asterisk"></i> UPDATES
    </div>
    <?php
    if ($this->getRequest()->getSession()->check('Batch.id') && $this->getRequest()->getSession()->read('Batch.active') == 1) {
    ?>
    <a href="#" class="btn btn-sm btn-orange rounded-pill small" data-bs-toggle="offcanvas" data-bs-target="#selectTransactionMenu">
        <i class="fa fa-plus-circle small"></i> <span class="small">NEW TRANSACTION</span>
    </a>
    <?php
    }
    ?>
</div>

<?php
$noTransactions = true;
$thisMonth = date('M Y');

if ($transactionsDailyInfo) {
    foreach($transactionsDailyInfo as $date => $dailyTransactions) {

        // show transactions for this month only
        if ($date == $thisMonth) {
            $noTransactions = false;
            $totalIncome = 0;
            $totalExpenses = 0;
        ?>
            <div class="p-1 rounded shadow border mt-4">
                <div class="text-start bg-light p-2 border rounded">
                    <span class="fs-5 text-purple-dark text-uppercase"><i class="fa fa-rupee-sign"></i> <?= $thisMonth ?></span>
                </div>

                <div class="px-1 mt-2">
                    <table class="table table-sm text-end small">
                        <thead>
                            <tr>
                                <th class="text-center">Date</th>
                                <th class="text-success">Income</th>
                                <th class="text-danger">Expense</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($dailyTransactions as $day => $row) {
                            $totalIncome += (float)($row['income'] ?? 0);
                            $totalExpenses += (float)($row['expense'] ?? 0);
                            ?>
                            <tr>
                                <td class="text-uppercase text-nowrap small text-center"><?= date('d', strtotime($day. ' ' .$date)) ?></td>
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
                        <tfoot>
                        <tr>
                            <th class="small text-center">Total</th>
                            <th class="small text-success"><?= $totalIncome ?></th>
                            <th class="small text-danger"><?= $totalExpenses ?></th>
                            <th class="small">
                                <?php
                                $totalAmount = $totalIncome - $totalExpenses;

                                echo $totalAmount > 0 ?
                                    '<span class="text-success">'.$totalAmount.'</span>' :
                                    '<span class="text-danger">'.$totalAmount.'</span>';
                                ?>
                            </th>
                        </tr>
                        </tfoot>
                    </table>
                </div>

            </div>

        <?php
            break;
        }
    }
}

if ($noTransactions) {
    ?>
    <div class="p-1 rounded shadow border mt-4">
        <div class="text-start bg-light p-2 border rounded">
            <span class="fs-5 text-purple-dark text-uppercase"><i class="fa fa-rupee-sign"></i> <?= $thisMonth ?></span>
        </div>

        <div class="px-1 mt-2">
            <table class="table table-sm text-end small">
                <thead>
                <tr>
                    <th class="text-center">Date</th>
                    <th class="text-success">Income</th>
                    <th class="text-danger">Expense</th>
                    <th>Balance</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="text-uppercase text-nowrap small text-center">-</td>
                    <td class="text-success small">-</td>
                    <td class="text-danger small">-</td>
                    <td class="small">-</td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th class="small">Total</th>
                    <th class="small text-success">0</th>
                    <th class="small text-danger">0</th>
                    <th class="small">0</th>
                </tr>
                </tfoot>
            </table>
        </div>

    </div>
    <?php
}
?>

<?php
if ($transactionsMonthlyInfo) {
    ?>
    <div class="p-1 rounded shadow border mt-4">
        <div class="text-start bg-light p-2 border rounded">
            <span class="fs-5 text-purple-dark"><i class="fa fa-rupee-sign"></i> Monthly Tracker</span>
        </div>

        <div class="px-1 mt-2">
            <table class="table table-sm text-end small">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-success">Income</th>
                        <th class="text-danger">Expense</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($transactionsMonthlyInfo as $date => $row) {
                    ?>
                    <tr>
                        <td class="text-uppercase text-nowrap small text-center"><?= date('M y', strtotime($date)) ?></td>
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
        </div>

    </div>

    <?php
}
?>


