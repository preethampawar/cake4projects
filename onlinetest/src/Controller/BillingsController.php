<?php

namespace App\Controller;

use App\Model\Table\PatientsTable;
use Cake\Database\Expression\QueryExpression;
use Cake\ORM\Query;

class BillingsController extends AppController
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
        $billings = $this->Paginator->paginate($this->Billings->find('all')->order('Billings.bill_date desc, Billings.id desc'));
        $this->set(compact('billings'));
    }

    public function view($id)
    {
        $billing = $this->Billings->findById($id)->firstOrFail();
        $this->set(compact('billing'));
    }

    public function addStep1()
    {
        $data = $this->request->getData();
        $result = null;

        if (!empty($data['keyword']) && !empty($data['type'])) {
            $keyword = sprintf('%s', $data['keyword']);
            $type = sprintf('%s', $data['type']);
            $this->loadModel('Patients');
            $query = $this->Patients->find()
                ->where(function (QueryExpression $exp, Query $q) use ($keyword, $type) {
                    switch ($type) {
                        case 'name':
                            return $exp->like('name', "%$keyword%");
                            break;
                        case 'phone':
                            return $exp->like('phone', "%$keyword%");
                            break;
                        case 'age':
                            return $exp->like('age', "%$keyword%");
                            break;
                        case 'id':
                            return $exp->like('id', "%$keyword%");
                            break;
                        default:
                            return $exp->like('opd_no', "%$keyword%");
                            break;
                    }
                });

            $result = $query->all()->toArray();
        }

        $this->set('result', $result);
    }

    public function add($patientId = null)
    {
        $this->loadModel(PatientsTable::class);

        $patient = $this->Patients->newEmptyEntity();
        if ($patientId !== null) {
            $patient = $this->Patients->findById($patientId)->firstOrFail();
        }

        $billing = $this->Billings->newEmptyEntity();

        if ($this->request->is('post')) {
            $billing = $this->Billings->patchEntity($billing, $this->request->getData());

            if ($this->Billings->save($billing)) {
                $this->Flash->success(__('Your billing has been saved.'));
                return $this->redirect(['controller' => 'billings', 'action' => 'index']);
            }

            $this->Flash->error(__('Unable to add your billing.'));
        }

        $this->set('patient', $patient);
        $this->set('billing', $billing);
    }

    public function edit($id)
    {
        $billing = $this->Billings
            ->findById($id)
            ->contain(['Patients'])
            ->firstOrFail();

        if ($this->request->is(['post', 'put'])) {
            $this->Billings->patchEntity($billing, $this->request->getData());
            if ($this->Billings->save($billing)) {
                $this->Flash->success(__('Your billing has been updated.'));

                return $this->redirect(['controller' => 'billings', 'action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your billing.'));
        }

        $this->set('billing', $billing);
    }

    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $billing = $this->Billings->findById($id)->firstOrFail();

        if ($this->Billings->delete($billing)) {
            $this->Flash->success(__('The billing dated {0} has been deleted.', $billing->date->format('d/m/Y')));
        }

        return $this->redirect(['controller' => 'billings', 'action' => 'index']);
    }
}
