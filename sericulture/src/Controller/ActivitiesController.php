<?php

namespace App\Controller;

use App\Model\Table\ActivitiesTable;
use App\Model\Table\BatchesTable;
use Cake\Event\EventInterface;

class ActivitiesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        if (!$this->isLoggedIn()) {
            return $this->redirect('/Users/login');
        }
    }

    public function index()
    {
        $this->loadComponent('Paginator');

        $conditions = [];
        if ($this->request->getSession()->read('User.isAdmin') === false) {
            $conditions['Activities.user_id'] = $this->request->getSession()->read('User.id');
        }

        $activities = $this->Paginator->paginate(
            $this->Activities->find('all')
                ->contain(['Batches'])
                ->where($conditions),
            [
                'limit' => 100,
                'order' => [
                    'Activities.activity_date' => 'desc'
                ]
            ]
        );

        $this->set(compact('activities'));
    }

    public function selectActivity($batchId)
    {
        $userId = $this->request->getSession()->read('User.id');

        $recentActivity = $this->Activities
            ->findByBatchId($batchId)
            ->order(['Activities.activity_date desc', 'Activities.activity_time desc'])
            ->first();

        $this->loadModel('Batches');
        $batchInfo = $this->Batches
            ->findById($batchId)
            ->first();

        $this->set('batchInfo', $batchInfo);
        $this->set('batchId', $batchId);
        $this->set('recentActivity', $recentActivity);
    }

    public function selectBatch()
    {
        $userId = $this->request->getSession()->read('User.id');
        $this->loadModel('Batches');
        $batchInfo = $this->Batches
            ->find('all')
            ->where(['Batches.user_id' => $userId])
            ->order(['Batches.status desc', 'Batches.created desc'])
            ->all();
        $this->set('batchInfo', $batchInfo);
    }

    public function add($batchId, $selectedActivityType = null)
    {
        $this->loadModel('Batches');
        $batchInfo = $this->Batches->findById($batchId)->firstOrFail();
        $activity = $this->Activities->newEmptyEntity();
        $recentActivity = $this->Activities
            ->findByBatchId($batchId)
            ->order(['Activities.activity_date desc', 'Activities.activity_time desc'])
            ->first();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['batch_id'] = $batchId;
            $data['user_id'] = $this->request->getSession()->read('User.id');
            $data['name'] = ActivitiesTable::ACTIVITY_TYPES[$data['activity_type']];
            $selectedActivityType = $data['activity_type'];

            $error = $this->validateActivity($data);

            if (!$error) {
                $activity = $this->Activities->patchEntity($activity, $data);

                if ($activityInfo = $this->Activities->save($activity)) {

                    $this->Flash->success(__('Activity has been saved.'));

                    return $this->redirect('/Batches/details/'.$batchId);
                }

                $this->Flash->error(__('Unable to create new activity.'));
            } else {
                $this->Flash->error($error);
            }
        }

        $this->set('activity', $activity);
        $this->set('recentActivity', $recentActivity);
        $this->set('batchInfo', $batchInfo);
        $this->set('selectedActivityType', $selectedActivityType);
    }

    private function validateActivity($data)
    {
        if (empty(trim($data['name']))) {
            return 'Please enter the activity name.';
        }

        return null;
    }

    public function edit($id)
    {
        $activity = $this->Activities
            ->findById($id)
            ->firstOrFail();
        $this->loadModel('Batches');
        $batchInfo = $this->Batches->findById($activity->batch_id)->firstOrFail();

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $data['name'] = ActivitiesTable::ACTIVITY_TYPES[$data['activity_type']];

            $this->Activities->patchEntity($activity, $data);

            if ($this->Activities->save($activity)) {
                $this->Flash->success(__('Activity details have been updated successfully.'));

                return $this->redirect('/Activities/');
            }

            $this->Flash->error(__('Unable to update activity details.'));
        }

        $this->set('activity', $activity);
        $this->set('batchInfo', $batchInfo);
    }

    public function delete($id)
    {
        $activity = $this->Activities->findById($id)->firstOrFail();

        $this->Activities->delete($activity);

        $this->Flash->success(__($activity->name . ' has been deleted'));

        return $this->redirect(['controller' => 'Activities', 'action' => 'index']);
    }
}
