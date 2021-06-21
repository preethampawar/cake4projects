<?php

use App\Model\Table\TransactionsTable;

echo $this->Form->create(null);
?>

<h1>New Transaction</h1>
<?php
$defaultDate = date('Y-m-d');
echo $this->Form->control('transaction_date',
    [
        'label' => 'Date',
        'type' => 'date',
        'required' => true,
        'class' => 'form-control mb-3',
        'default' => $defaultDate
    ]);

echo $this->Form->control('transaction_amount',
    [
        'type' => 'number',
        'label' => 'Amount *',
        'required' => true,
        'min' => 1,
        'max' => 10000000,
        'step' => '0.01',
        'class' => 'form-control mb-3'
    ]);

echo $this->Form->control('name',
    [
        'type' => 'text',
        'label' => 'Description *',
        'required' => true,
        'class' => 'form-control mb-3'
    ]);

echo $this->Form->control('transaction_type',
    [
        'type' => 'select',
        'label' => 'Transaction Type',
        'required' => true,
        'class' => 'form-select mb-3',
        'options' => TransactionsTable::TRANSACTION_TYPES,
        'default' => $isExpense ? 'expense' : 'income',
    ]);
?>

<div class="text-center mt-4">
    <div class="mt-4">
        <?= $this->Form->button(__('Save Transaction'), ['class' => 'btn btn-primary']) ?>
        <a href="/Transactions/" class="btn btn-danger ms-4">Cancel</a>
    </div>
</div>

<?php
    echo $this->Form->end();
?>
