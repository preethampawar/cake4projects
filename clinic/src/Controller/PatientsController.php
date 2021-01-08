<?php

namespace App\Controller;

use Cake\Database\Expression\QueryExpression;
use Cake\ORM\Query;

class PatientsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent
    }

    public function index()
    {
        $this->loadComponent('Paginator');
        $patients = $this->Paginator->paginate($this->Patients->find());
        $this->set(compact('patients'));
    }

    public function view($id)
    {
        $patient = $this->Patients->findById($id)->contain(['CaseSheets'])->firstOrFail();
        $this->set(compact('patient'));
    }

    public function add()
    {
        $patient = $this->Patients->newEmptyEntity();
        if ($this->request->is('post')) {
            $patient = $this->Patients->patchEntity($patient, $this->request->getData());

            if ($this->Patients->save($patient)) {
                $this->Flash->success(__('Your patient has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your patient.'));
        }
        $this->set('patient', $patient);
    }

    public function edit($id)
    {
        $patient = $this->Patients
            ->findById($id)
            ->firstOrFail();

        if ($this->request->is(['post', 'put'])) {
            $this->Patients->patchEntity($patient, $this->request->getData());
            if ($this->Patients->save($patient)) {
                $this->Flash->success(__('Your patient has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your patient.'));
        }

        $this->set('patient', $patient);
    }

    public function search()
    {
        $data = $this->request->getData();
        $result = null;

        if (!empty($data['keyword']) && !empty($data['type'])) {
            $keyword = sprintf('%s', $data['keyword']);
            $type = sprintf('%s', $data['type']);
            $query = $this->Patients->find()
                ->where(function (QueryExpression $exp, Query $q) use ($keyword, $type) {
                    switch ($type) {
                        case 'name':
                            return $exp->like('name', "%$keyword%");
                            break;
                        case 'opd_no':
                            return $exp->like('opd_no', "%$keyword%");
                            break;
                        case 'age':
                            return $exp->like('age', "%$keyword%");
                            break;
                        default:
                            return $exp->like('phone', "%$keyword%");
                            break;
                    }
                });

            $result = $query->all()->toArray();
        }

        $this->set('result', $result);
    }
}
