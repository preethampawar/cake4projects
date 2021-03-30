<div id="addEducationLevel" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Education Level</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none p-2" id="addEducationLevelErrorDiv"></div>
                <?php
                echo $this->Form->control('name',
                    [
                        'id' => 'addEducationLevelField',
                        'type' => 'text',
                        'label' => 'Enter Education Level *',
                        'class' => 'form-control form-control-sm mb-3',
                        'required' => true,
                    ]);
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" id="closeAddEducationLevelPopup" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="educationLevels.add()">Save changes</button>
            </div>
        </div>
    </div>
</div>
