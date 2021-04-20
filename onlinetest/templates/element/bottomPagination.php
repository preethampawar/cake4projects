<div class="mt-4">
    Page:
    <?= $paginator->counter() ?>
</div>
<div class="d-flex mt-2">
    <div class="pagination text-end d-flex">
        <ul class="list-unstyled btn btn-secondary btn-sm">
            <?= $paginator->prev('<i class="fas fa-chevron-circle-left"></i> Back', ['escape' => false]) ?>
        </ul>
        <ul class="list-unstyled ms-3 btn btn-secondary btn-sm">
            <?= $paginator->next('Next <i class="fas fa-chevron-circle-right"></i>', ['escape' => false]) ?>
        </ul>
    </div>
</div>
