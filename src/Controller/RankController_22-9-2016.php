<?php
namespace App\Controller;
use Cake\Network\Email\Email;
use App\Controller\AppController;
use Cake\Utility\Security;
use Cake\I18n\Time;
use Cake\Datasource\ConnectionManager;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class RankController extends AppController
{

    public $components = array('Paginator');
    public $paginate = array(
        'limit' => 1,
        'order' => [
            'UsersScore.user_id' => 'desc'
        ]
    );

 public function initialize()
    {
        parent::initialize();

        $this->viewBuilder()->layout('admin');
        $this->loadModel('Rank');
        $this->loadModel('Users');
                $this->loadModel('UsersScore');

    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {      
    if($this->request->is('get')){
      if(!empty($this->request->query['name']))
      {
        $this->paginate=array('contain'=>array('Users'),'conditions'=>array('Users.name LIKE'=>'%'.$this->request->query['name'].'%'),'fields'=>array('Users.id','Users.name','Users.rank','Rank.score'),'limit'=>10,'order'=>array('Rank.score'=>'DESC'));
        }
        else{


      $this->paginate = array('fields'=>array('Users.name', 'user_id','total'=>'SUM(score)/count(DISTINCT `user_id`)'),'contain'=>array('Users'),'group'=>array('user_id'), 'order' => [
        'total' => 'DESC'
    ]);
      
      $results = $this->paginate('UsersScore')->toArray();


     // echo"<pre>";print_r($results);die;
      $this->set('result',$results);        

      $deptNames = $this->UsersScore->find('all')->select(['Users.id','Departments.dept_name','Users.department_id','id','user_id','total'=>'SUM(score)'])->contain(['Users'=>['Departments']])->group(['dept_name'])->hydrate(false)->toArray();
      // echo "<pre>";print_r($deptNames);die;
      $this->set(compact('deptNames'));        
   
 
        }

    
    }
    

   }




}
