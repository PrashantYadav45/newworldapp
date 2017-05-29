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
        'limit' => 10,
        'order' => [
            'Users.id' => 'desc'
        ]
    );

 public function initialize()
    {
        parent::initialize();

        $this->viewBuilder()->layout('admin');
        $this->loadModel('Rank');
        $this->loadModel('Users');
         $this->loadModel('UserGamePlayed');
         $this->loadModel('Departments');
      $this->loadModel('UserGamePlayed');
      $this->loadModel('PurchaseItem');
         
date_default_timezone_set('Asia/Hong_Kong');
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {      
  if($this->request->is('get')){

//      if(!empty($this->request->query['name']))
//      {
//        $this->paginate=array('contain'=>array('Users'),'conditions'=>array('Users.name LIKE'=>'%'.$this->request->query['name'].'%'),'fields'=>array('Users.id','Users.name','Users.rank','Rank.score'),'limit'=>10,'order'=>array('Rank.score'=>'DESC'));
//        }
//        else{
//
//
//      $this->paginate = array('fields'=>array('Users.name', 'user_id','total'=>'SUM(score)/count(DISTINCT `user_id`)'),'contain'=>array('Users'),'group'=>array('user_id'), 'order' => [
//        'total' => 'DESC'
//    ]);
//      
//      $results = $this->paginate('UsersScore')->toArray();
//
//
//     // echo"<pre>";print_r($results);die;
//      $this->set('result',$results);        
//
//      $deptNames = $this->UsersScore->find('all')->select(['Users.id','Departments.dept_name','Users.department_id','id','user_id','total'=>'SUM(score)'])->contain(['Users'=>['Departments']])->group(['dept_name'])->hydrate(false)->toArray();
//      // echo "<pre>";print_r($deptNames);die;
//      $this->set(compact('deptNames'));        
//   
// 
//        }

 
 if($this->request->is('get')){

  $this->paginate = array('limit' => 10);
 if(!empty($this->request->query['name']))
{

//  $this->paginate=array('conditions'=>array('Users.name LIKE'=>'%'.$this->request->query['name'].'%'));
//$this->paginate=array('conditions'=>array('Users.email LIKE'=>'%'.$this->request->query['name'].'%'));
 $this->paginate=array('conditions'=>array('OR' => array('Users.staffid LIKE'=>'%'.$this->request->query['name'].'%','Users.name LIKE'=>'%'.$this->request->query['name'].'%','Users.email LIKE'=>'%'.$this->request->query['name'].'%')));
 
}
            $user = $this->paginate('Users')->toArray();

 //  $this->paginate('Users')->toArray(); 

/* $user = $this->Users->find('all')
                              ->select(['Users.id','Users.name','Users.profile_pic'])
                              ->hydrate(false)->limit(10)
							  ->toArray();*/
               
	$arr = array();
         foreach ($user as $key => $value) {
			  $score = $this->UserGamePlayed->find('all')
				  ->select(['total'=>'SUM(UserGamePlayed.score)'])
				  ->where(['UserGamePlayed.user_id'=>$value['id']])
                                  ->hydrate(false)
				  ->toArray();
                            foreach ($score as $keyscore => $valuescore) {
                                if($valuescore['total']==null){
                                    $scoreuser=0;
                            }else{
                                $scoreuser=$valuescore['total'];
                            }
                            array_push($arr,array('total' =>$scoreuser,
                               'name' =>$value['name'], 'email' =>$value['email'], 'staffid' =>$value['staffid'],
                               'user_id'=>$value['id'],
                               'profile_pic'=> (isset($value['profile_pic']) && !empty($value['profile_pic'])) ? HTTP_ROOT.'img/uploads/'.$value['profile_pic'] : ''
                            )); 
                       }					
              }
        }
}
        $this->set(compact('$arr'));
 
        //Department
         $arrdept=array();
		$deptNames = $this->Departments->find('all')->select(['Departments.id','Departments.dept_name','Departments.image'])->hydrate(false)->toArray();
		foreach($deptNames as $keydept => $valuedept )
		{
			$UsersNames = $this->Users->find('all')->select(['Users.id'])->where(['department_id'=>$valuedept['id']])->hydrate(false)->toArray();
			$totalscore=0;
			foreach($UsersNames as $keyuser =>$valueuser)
			{
				
				$UsersNames = $this->UserGamePlayed->find('all')->select(['total'=>'SUM(UserGamePlayed.score)'])->where(['user_id'=>$valueuser['id']])->hydrate(false)->toArray();
				$totalscore=$totalscore+$UsersNames[0]['total'];

			}
				array_push($arrdept,array('totalscore' =>$totalscore,
								
													   'dept_name' =>$valuedept['dept_name'],
'id'=>$valuedept['id'],'image'=> (isset($valuedept['image']) && !empty($valuedept['image'])) ? HTTP_ROOT.'img/uploads/'.$valuedept['image'] : ''
													   )); 			
													  	
										
		}
$results = $this->paginate('Users')->toArray();
       // $results = $this->paginate('Users')->toArray();
        rsort($arr);
    $this->set('result',$arr); 
      rsort($arrdept);
     $this->set('resultdata',$arrdept); //$this->set(compact('$deptNames'));

   }//end of index

  public function reset() {
$this->UserGamePlayed->deleteAll(array('1 = 1'));
//$this->UserGamePlayed->deleteAll();
//$this->PurchaseItem->deleteAll();
return $this->redirect(['action' => 'index']);
}


}
