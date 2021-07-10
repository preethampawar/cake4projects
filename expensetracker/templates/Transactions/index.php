<?php
use App\Model\Table\TransactionsTable;

$batchActive = false;

if ($this->getRequest()->getSession()->check('Batch.id') && $this->getRequest()->getSession()->read('Batch.active') == 1) {
    $batchActive = true;
}
?>
<h1><i class="fa fa-rupee-sign"></i>  Transactions</h1>

<?php
if ($batchActive) {
?>
    <div class="text-end">
        <a href="#" class="btn btn-sm btn-orange rounded-pill small py-1" data-bs-toggle="offcanvas" data-bs-target="#selectTransactionMenu">
            <i class="fa fa-plus-circle small"></i> <span class="small">NEW TRANSACTION</span>
        </a>
    </div>
<?php
}
?>

<div class="mt-2">
    <div>
        <b><?php echo $this->Paginator->counter(
                'Total Records: {{count}}'
            ); ?></b>
    </div>

    <div class="d-flex mt-3">
        <div class="">
            Page:
            <?= $this->Paginator->counter() ?>
        </div>
        <div class="mx-3">|</div>
        <div class="text-end d-flex">

            <ul class="list-unstyled">
                <?= $this->Paginator->prev('« Previous') ?>
            </ul>

            <ul class="list-unstyled mx-3">
                <?= $this->Paginator->next('Next »') ?>
            </ul>
        </div>
    </div>
</div>

<div class="">
    <table class="table table-sm mt-3 small">
        <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
<!--            <th>Type</th>-->
            <th>Notes</th>
            <th class="text-end">Amount</th>
            <?php
            if ($batchActive) {
            ?>
                <th></th>
            <?php
            }
            ?>
        </tr>
        </thead>

        <!-- Here is where we iterate through our $articles query object, printing out article info -->

        <tbody>
        <?php
        $k = 0;
        foreach ($transactions as $transaction):
            $k++;
            ?>

            <tr>
                <td>
                    <?= $k ?>.
                </td>
                <td>
                    <span class="text-nowrap text-primary text-uppercase"><?= $transaction->transaction_date != null ? $transaction->transaction_date->format('d M') : '-' ?></span>

                </td>
                <!--
                <td>
                    <?= TransactionsTable::TRANSACTION_TYPES[$transaction->transaction_type] ?></span>
                </td>
                -->
                <td>
                    <?= $transaction->name ?>
                </td>
                <td class="text-end">
                    <?= $transaction->transaction_type == 'income' ? '<span class="text-success">'.$transaction->transaction_amount.'</span>' : '<span class="text-danger">'.$transaction->transaction_amount.'</span>' ?>
                </td>
                <?php
                if ($batchActive) {
                ?>
                    <td class="text-end">
                    <div class="dropdown">
                        <a class="" href="#" id="actionsDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-ellipsis-v p-2"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="actionsDropdownMenuLink">
                            <li><a href="/Transactions/edit/<?= $transaction->id ?>" title="Edit Transaction details" class="dropdown-item"><i class="fa fa-edit"></i> Edit</a></li>
                            <li>
                                <?php
                                echo $this->Html->link(
                                    '<i class="fa fa-times-circle"></i> Delete',
                                    ['controller' => 'Transactions', 'action' => 'delete', $transaction->id],
                                    [
                                        'confirm' => 'Are you sure you want to delete this Transaction?',
                                        'class' => 'dropdown-item',
                                        'title' => $transaction->name,
                                        'escape' => false
                                    ]
                                );
                                ?>
                            </li>
                        </ul>
                    </div>
                </td>
                <?php
                }
                ?>
            </tr>

        <?php
        endforeach;

        if (empty($transactions->toArray())) {
            ?>
            <tr><td colspan="5">No transactions found.</td></tr>
            <?php
        }

        ?>
        </tbody>
    </table>
</div>
