<?php
use App\Model\Table\TransactionsTable;
?>
<h1>Manage Finance</h1>

<div class="text-end">
    <a class="btn btn-orange btn-sm rounded-pill" href="/Transactions/select"><i class="fa fa-plus-circle"></i> NEW TRANSACTION</a>
</div>

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
            <th>Description</th>
            <th class="text-center">Amount</th>
            <th></th>
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
                    <span class="text-nowrap"><?= $transaction->transaction_date->format('d-M') ?></span>
                </td>
                <!--
                <td>
                    <?= TransactionsTable::TRANSACTION_TYPES[$transaction->transaction_type] ?></span>
                </td>
                -->
                <td>
                    <?= $transaction->name ?>
                </td>
                <td class="text-center">
                    <?= $transaction->transaction_type == 'income' ? '<span class="text-success">'.$transaction->transaction_amount.'</span>' : '<span class="text-danger">'.$transaction->transaction_amount.'</span>' ?>
                </td>
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
            </tr>

        <?php
        endforeach;

        if (empty($transactions->toArray())) {
            ?>
            <tr><td colspan="4">No transactions found.</td></tr>
            <?php
        }

        ?>
        </tbody>
    </table>
</div>
