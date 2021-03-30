<div id="addSubject" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none p-2" id="addSubjectErrorDiv"></div>
                <?php
                echo $this->Form->control('name',
                    [
                        'id' => 'addSubjectField',
                        'type' => 'text',
                        'label' => 'Enter Subject Name *',
                        'class' => 'form-control form-control-sm mb-3',
                        'required' => true,
                    ]);
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" id="closeAddSubjectPopup" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="subjects.add()">Save changes</button>
            </div>
        </div>
    </div>
</div>
