<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/Categories/">Categories</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Details</li>
    </ol>
</nav>

<h1>Edit Category</h1>

<?php
echo $this->Form->create($category);
?>

<div class="text-end">
    <a class="btn btn-sm btn-danger" href="/Categories/">Cancel</a>
</div>

<?php
echo $this->Form->control('name',
    [
        'type' => 'text',
        'label' => 'Category Name *',
        'required' => true,
        'class' => 'form-control form-control-sm mb-3'
    ]);

echo $this->Form->control('active',
    [
        'type' => 'checkbox',
        'label' => ' Active (Publish)',
        'value' => '1',
        'default' => '1',
        'class' => 'form-check-input mb-3'
    ]);

?>

<div class="my-4">
    <?= $this->Form->button(__('Update Category Details'), ['class' => 'btn btn-primary btn-sm mt-2']) ?>
</div>

<?php
echo $this->Form->end();
?>
