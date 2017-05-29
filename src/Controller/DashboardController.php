<?php
namespace App\Controller;
use Cake\Network\Email\Email;
use App\Controller\AppController;
use Cake\Utility\Security;
use Cake\I18n\Time;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class DashboardController extends AppController
{

    public $components = array('Paginator');
    public $paginate = array(
        'limit' => 10,
        'order' => [
            'Users.id' => 'desc'
        ]
    );

 public function initialize()
    {
        parent::initialize();
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Users');
        $this->loadModel('Dashboard');
        $this->loadModel('Items');
 //date_default_timezone_set('Asia/Calcutta');
date_default_timezone_set('Asia/Hong_Kong');
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {      
      $users_score=$this->Dashboard->find('all')->contain(['Users'])->limit(4)->select(['Users.name'])->select(['Dashboard.score'])->hydrate(false)->toArray();
      $this->set(compact('users_score'));   

      $new_users=$this->Users->find('all')->select(['id','name'])->limit(4)->order(['id'=>'desc'])->hydrate(false)->toArray();
      $this->set(compact('new_users')); 

      $new_items=$this->Items->find('all')->select(['id','item_title','image'])->limit(4)->order(['id'=>'desc'])->hydrate(false)->toArray();
      $this->set(compact('new_items'));        
    }
    

   




}
