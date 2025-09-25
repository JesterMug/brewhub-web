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
use Cake\Datasource\ModelAwareTrait;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/5/en/controllers.html#the-app-controller
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

    use ModelAwareTrait; // Allows PageController.php to use loadModel
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/5/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // for all controllers in our application, make index and view
        // actions public, skipping the authentication check
        $this->Authentication->addUnauthenticatedActions(['display']);
    }

    /**
     * Authorization check for Admin OR Superuser.
     * Call this at the start of any action that requires admin rights.
     * Returns the Redirect object if auth fails, or TRUE if it passes.
     *
     * @return bool|\Cake\Http\Response|null
     */
    protected function checkAdminAuth()
    {
        $identity = $this->request->getAttribute('identity');
        if (!$identity) {
            $this->Flash->error('You must be logged in.');
            return $this->redirect(['controller' => 'Auth', 'action' => 'login']);
        }

        if (!in_array($identity->user_type, ['admin', 'superuser'])) {
            $this->Flash->error('You are not authorised to access that page.');
            return $this->redirect('/'); // Redirect customers to homepage
        }

        // User is 'admin' or 'superuser', allow access
        return true;
    }

    /**
     * Authorization check for Superuser ONLY.
     * Call this for actions only a superuser can perform (like deleting other admins).
     * @return bool|\Cake\Http\Response|null
     */
    protected function checkSuperuserAuth()
    {
        $identity = $this->request->getAttribute('identity');
        if (!$identity) {
            $this->Flash->error('You must be logged in.');
            return $this->redirect(['controller' => 'Auth', 'action' => 'login']);
        }

        if ($identity->user_type !== 'superuser') {
            $this->Flash->error('You are not authorised to access that page.');
            return $this->redirect(['controller' => 'Pages', 'action' => 'dashboard']);
        }

        return true;
    }
}
