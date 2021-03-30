<div class="mt-4">
    Page:
    <?= $paginator->counter() ?>
</div>
<div class="d-flex mt-2">
    <div class="pagination text-end d-flex">
        <ul class="list-unstyled btn btn-secondary">
            <?= $paginator->prev('« Previous') ?>
        </ul>
        <ul class="list-unstyled mx-3 btn btn-primary">
            <?= $paginator->next('Next »') ?>
        </ul>
    </div>
</div>
