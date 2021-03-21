<?php

namespace App\Controller;

use App\Model\Table\PatientsTable;

class CaseSheetsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent
    }

    public function index()
    {
        $this->redirect('/patients');

        $this->loadComponent('Paginator');
        $caseSheets = $this->Paginator->paginate($this->CaseSheets->find('all', ['contain' => ['Patients']]));
        $this->set(compact('caseSheets'));
    }

    public function view($id)
    {
        $caseSheet = $this->CaseSheets->findById($id)->firstOrFail();
        $this->set(compact('caseSheet'));
    }

    public function add($patientId)
    {
        $this->loadModel(PatientsTable::class);
        $patient = $this->Patients->findById($patientId)->firstOrFail();

        $caseSheet = $this->CaseSheets->newEmptyEntity();
        if ($this->request->is('post')) {
            $caseSheet = $this->CaseSheets->patchEntity($caseSheet, $this->request->getData());

            if ($this->CaseSheets->save($caseSheet)) {
                $this->Flash->success(__('Your case sheet has been saved.'));
                return $this->redirect(['controller' => 'patients', 'action' => 'view', $patientId]);
            }
            $this->Flash->error(__('Unable to add your caseSheet.'));
        }

        $this->set('patient', $patient);
        $this->set('caseSheet', $caseSheet);
    }

    public function edit($id)
    {
        $caseSheet = $this->CaseSheets
            ->findById($id)
            ->contain(['Patients'])
            ->firstOrFail();

        if ($this->request->is(['post', 'put'])) {
            $this->CaseSheets->patchEntity($caseSheet, $this->request->getData());
            if ($this->CaseSheets->save($caseSheet)) {
                $this->Flash->success(__('Your case sheet has been updated.'));

                return $this->redirect(['controller' => 'patients', 'action' => 'view', $caseSheet->patient_id]);
            }
            $this->Flash->error(__('Unable to update your case sheet.'));
        }

        $this->set('caseSheet', $caseSheet);
    }

    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $caseSheet = $this->CaseSheets->findById($id)->firstOrFail();

        if ($this->CaseSheets->delete($caseSheet)) {
            $this->Flash->success(__('The case sheet dated {0} has been deleted.', $caseSheet->date->format('d/m/Y')));
        }

        return $this->redirect(['controller' => 'patients', 'action' => 'view', $caseSheet->patient_id]);
    }
}
