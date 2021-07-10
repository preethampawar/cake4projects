<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Datasource\ConnectionManager;
use Cake\Event\EventInterface;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event); // TODO: Change the autogenerated stub

        $whiteListActions = [
            'login',
            'register',
            'list',
            'select',
            'logout',
            'continueAsGuest',
            'appRequestLogin'
        ];

        if (!in_array($this->request->getParam('action'), $whiteListActions) && $this->request->getSession()->check('User.id') === false) {
            if (! $this->request->is('ajax')) {
                return $this->redirect('/Users/login');
            }
        }
    }

    protected function getDbConnection()
    {
        return ConnectionManager::get('default');
    }

    protected function query($query)
    {
        return $this->getDbConnection()
            ->execute($query)
            ->fetchAll('assoc');
    }

    /**
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        if($this->request->getSession()->check('User.id') === true) {
           return true;
        }

        return false;
    }

    public function isAdmin()
    {
        if($this->request->getSession()->check('User.isAdmin') == true) {
           return $this->request->getSession()->read('User.isAdmin') == true;
        }

        return false;
    }

    public function allowAdmin()
    {
        if (! $this->isAdmin()) {
            $this->Flash->error('You are not authorized to access this page');
            return $this->redirect('/');
        }
    }

    protected function setLayout($layout = null)
    {
        if ($layout !== null) {
            $this->viewBuilder()->setLayout($layout);
            return;
        }

        if ($this->isAdmin()) {
            $this->viewBuilder()->setLayout('admin');
            return;
        }

        $this->viewBuilder()->setLayout('default');
    }

    protected function getUserId()
    {
        if ($this->isLoggedIn()) {
            return $this->request->getSession()->read('User.id');
        }

        $this->Flash->error('Please login to continue.');
        return $this->redirect('/Users/login');
    }


}
