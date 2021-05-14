<h1>Patients List</h1>

<div class="text-end">
    <a class="btn btn-primary btn-sm" href="/patients/add">+ Add New Patient</a>
</div>

<div>
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

<div class="table-responsive">
    <table class="table table-sm table-hover small mt-3">
    <thead>
    <tr>
        <th style="width:30px;">Id</th>
        <th style="width:75px;">OPD No.</th>
        <th>Registered On</th>
        <th>Name</th>
        <th>Age</th>
        <th>Sex</th>
        <th>Phone</th>
        <th></th>
    </tr>
    </thead>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <tbody>
    <?php
    foreach ($patients as $patient):
        ?>

        <tr>
            <td class="text-center">
                <a href="/patients/view/<?= $patient->id ?>" title="Details - <?= $patient->name ?>"
                   class=""><?= $patient->id ?></a>
            </td>
            <td class="text-center">
                <?= $patient->opd_no ?>
            </td>
            <td>
                <?= $patient->join_date->format('d/m/Y') ?>
            </td>
            <td>
                <?= $patient->name ?>
            </td>
            <td>
                <?= $patient->age ?>
            </td>
            <td>
                <?= $patient->sex ?>
            </td>
            <td>
                <?= $patient->phone ?>
            </td>
            <td>
                <div class="dropdown text-end text-primary">
                    <span class="px-3 hoverHighlight" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </span>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li>
                            <a class="dropdown-item" href="/billings/add/<?= $patient->id ?>" title="Create new bill for - <?= $patient->name ?>">+Create Bill</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/CaseSheets/add/<?= $patient->id ?>" title="Add Case Sheet - <?= $patient->name ?>">+Add Case Sheet</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/patients/edit/<?= $patient->id ?>" title="Edit - <?= $patient->name ?>">Edit</a>
                        </li>
                        <li>
                            <a href="/patients/view/<?= $patient->id ?>" title="Details - <?= $patient->name ?>"
                               class="dropdown-item">Details</a>
                        </li>
                    </ul>
                </div>
            </td>

        </tr>

    <?php
    endforeach;
    ?>
    </tbody>
</table>
</div>
