<?php
declare(strict_types=1);

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

        if (!empty($data['keyword'])) {
            $keyword = sprintf('%s', $data['keyword']);
            $type = sprintf('%s', $data['type']);

            $this->loadModel(PatientsTable::class);

            if (!empty($type)) {
                $conditions = [];
                switch ($type) {
                    case 'name':
                        $conditions[] = ['name like' => "%$keyword%"];
                        break;
                    case 'opd_no':
                        $conditions[] = ['opd_no like' => "%$keyword%"];
                        break;
                    case 'age':
                        $conditions[] = ['age like' => "%$keyword%"];
                        break;
                    case 'phone':
                        $conditions[] = ['phone like' => "%$keyword%"];
                        break;
                }
                $query = $this->Patients->find()
                    ->where($conditions);
            } else {
                $query = $this->Patients->find()
                    ->where([
                        'OR' => [
                            'name like' => "%$keyword%",
                            'opd_no like' => "%$keyword%",
                            'age like' => "%$keyword%",
                            'phone like' => "%$keyword%",
                        ],
                    ]);
            }

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

    public function report()
    {
        $fromDate = date('Y-m-', strtotime('-1 month')) . '01';
        $toDate = date('Y-m-d');
        $billings = null;
        $treatmentType = null;

        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $fromDate = isset($data['from']) && !empty($data['from']) ? $data['from'] : $fromDate;
            $toDate = isset($data['to']) && !empty($data['to']) ? $data['to'] : $toDate;
            $treatmentType = $data['treatment_type'];

            $conditions = ['Billings.bill_date >= ' => $fromDate, 'Billings.bill_date <= ' => $toDate];

            if (!empty($treatmentType)) {
                $conditions[] = ['Billings.treatment_type' => $treatmentType];
            }

            $billings = $this->Billings->find('all')
                ->select(['Billings.id', 'Billings.patient_id', 'Billings.opd_no', 'Billings.bill_date', 'Billings.patient_name', 'Billings.amount', 'Billings.treatment_type'])
                ->where($conditions)
                ->order('Billings.bill_date asc')
                ->all();
        }

        $this->set('billings', $billings);
        $this->set('fromDate', $fromDate);
        $this->set('toDate', $toDate);
        $this->set('treatmentType', $toDate);
    }

    public function download()
    {
        $this->viewBuilder()->setLayout('ajax');

        $filename = 'Billing_List_' . date('d_m_Y') . '.csv';
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');

        if ($this->request->getSession()->read('loggedIn') != true) {
            return $this->redirect('/', 401);
        }

        $billings = $this->Billings->find('all')->order('Billings.bill_date desc')->all();

        $out = fopen('php://output', 'w');

        $csvData = [
            'Id', 'OPD No.', 'Bill Date', 'Amount', 'Name', 'Age', 'Sex', 'Treatment', 'Seatings', 'Consultation Fee', 'Treatment Type',
        ];

        fputcsv($out, $csvData);

        foreach ($billings as $billing) {
            $csvData = [
                $billing->id,
                $billing->opd_no,
                ' ' . $billing->bill_date->format('d-m-Y'),
                (int)$billing->amount,
                addslashes($billing->patient_name ? $billing->patient_name : ''),
                $billing->age,
                addslashes($billing->sex ? $billing->sex : ''),
                addslashes($billing->treatment ? $billing->treatment : ''),
                addslashes($billing->seatings ? $billing->seatings : ''),
                $billing->consultation_fee,
                $billing->treatment_type,
            ];

            fputcsv($out, $csvData);
        }

        fpassthru($out);
        //fclose($out);
        exit;
    }
}
