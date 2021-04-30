<?php
declare(strict_types=1);

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
        $patients = $this->Paginator->paginate($this->Patients->find()->order('Patients.id desc'));
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
            $data = $this->request->getData();

            if (empty($data['join_date'])) {
                $data['join_date'] = date('Y-m-d');
            }

            $patient = $this->Patients->patchEntity($patient, $data);

            if ($this->Patients->save($patient)) {
                $this->Flash->success(__('Your patient has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Unable to add your patient.'));
        }

        $maxOpd = $this->Patients->query()->order('Patients.opd_no desc')->limit(1)->first();

        $maxOpdNo = 100;
        if ($maxOpd) {
            $maxOpdNo = (int)$maxOpd->opd_no + 1;
        }

        $this->set('patient', $patient);
        $this->set('maxOpdNo', $maxOpdNo);
    }

    public function edit($id)
    {
        $patient = $this->Patients
            ->findById($id)
            ->firstOrFail();

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();

            if (empty($data['join_date'])) {
                $data['join_date'] = date('Y-m-d');
            }

            $this->Patients->patchEntity($patient, $data);

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

    public function download()
    {
        $this->viewBuilder()->setLayout('ajax');

        $filename = 'Patients_List_' . date('d_m_Y') . '.csv';
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');

        if ($this->request->getSession()->read('loggedIn') != true) {
            return $this->redirect('/', 401);
        }

        $patients = $this->Patients->find('all')->order('Patients.join_date desc');

        $out = fopen('php://output', 'w');

        $csvData = [
            'Id', 'OPD No.', 'Join Date', 'Name', 'Age', 'Sex', 'Phone', 'Blood Group', 'Address', 'Referred By',
        ];

        fputcsv($out, $csvData);

        foreach ($patients as $patient) {
            $csvData = [
                $patient->id,
                $patient->opd_no,
                ' ' . $patient->join_date->format('d-m-Y'),
                addslashes($patient->name),
                $patient->age,
                addslashes($patient->sex),
                $patient->phone . ',',
                addslashes($patient->blood_group),
                addslashes($patient->address),
                addslashes($patient->referred_by),
            ];

            fputcsv($out, $csvData);
        }

        fpassthru($out);
        //fclose($out);
        exit;
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $credentials = [
                'user' => 'Subbi',
                'password' => '9848597878',
            ];

            if (
                trim($data['user']) === $credentials['user'] &&
                trim($data['kunji']) === $credentials['password']
            ) {
                $this->request->getSession()->write('loggedIn', true);
                $this->redirect('/');
            } else {
                $this->Flash->error(__('Error! Invalid User or Password.'));
            }
        }
    }

    public function logout()
    {
        $this->request->getSession()->write('loggedIn', false);
        $this->request->getSession()->destroy();

        $this->redirect('/');
    }
}
