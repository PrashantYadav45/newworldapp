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
class GiftPurchaseController extends AppController
{

    public $components = array('Paginator');
      public $paginate = array(
        'limit' => 10,
        'order' => [
            'PurchaseItem.id' => 'desc'
        ]

    );

 public function initialize()
    {
        parent::initialize();

        $this->viewBuilder()->layout('admin');
      $this->loadModel('Items');
       $this->loadModel('Users');
         $this->loadModel('PurchaseItem');
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {      
        if($this->request->is('post')){
          $NotAssigned=$this->request->data['NotAssigned'];
        

          for($i=0;$i<count($NotAssigned);$i++){
           $query_status=$this->PurchaseItem->updateAll(array('status'=>'1'),array('id'=>$NotAssigned[$i]));
          // return $query_status;
          }
        }
        
    if($this->request->is('get')){
      // $purchaseitem=$this->PurchaseItem->find('all')->contain(['Item'])->where(['Item.id'=>'PurchaseItem.game_id'])->order(['Game.id'=>'DESC'])->hydrate(false)->toArray();

      
 $purchaseitem = $this->PurchaseItem->find('all')->where(['status'=>'0'])->hydrate(false)->toArray();

               
	$arr = array();
         foreach ($purchaseitem as $key => $value) {
              $user = $this->Users->find('all')
                                      ->where(['Users.id'=>$value['user_id']])
                                      ->first()
                                      ->toArray();
              $item = $this->Items->find('all')
                                      ->where(['Items.id'=>$value['game_id']])
                                      ->first()
                                      ->toArray();
            $itemname = $this->PurchaseItem->find('all')->where(['status'=>'0'])->hydrate(false)->toArray();
                            array_push($arr,array('date' =>$value['createddate'],
                               'name' =>$user['name'],
                               'itemname'=>$item['item_title'],
                                'id'=>$value['id']
                            
                            )); 
                $this->set('result',$arr);     
              }
        
         
           
             $purchaseitem1 = $this->PurchaseItem->find('all')->where(['status'=>'1'])->hydrate(false)->toArray();
               
	$arrdept = array();
         foreach ($purchaseitem1 as $key => $value) {
 $user = $this->Users->find('all')
                                      ->where(['Users.id'=>$value['user_id']])
                                      ->first()
                                      ->toArray();
 $item = $this->Items->find('all')
                                      ->where(['Items.id'=>$value['game_id']])
                                      ->first()
                                      ->toArray();
                            array_push($arrdept,array('date' =>date($value['createddate']),
                               'name' =>$user['name'],
                               'itemname'=>$item['item_title']
                            
                            )); 
                     
              }
      $results = $this->paginate('PurchaseItem')->toArray();
           $this->set('result',$arr);
            $this->set('resultdata',$arrdept);
        }

   }//end of index

 public function update() {   
  if($this->request->is('post')):
        $this->response->body($categories);
    endif;
//      if($this->request->is('post')){
//         $data= explode(',', $this->request->$data['NotAssigned']);
//         print_r($data);
//         for($i=0;$i<count($data);$i++){
//         //  $query_status=$this->PurchaseItem->updateAll(array('status'=>'1'),array('id'=>$data['']));
//         }
//      }
 }
}
