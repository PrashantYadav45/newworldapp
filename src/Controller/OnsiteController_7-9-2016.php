<?php
namespace App\Controller;
use Cake\Network\Email\Email;
use App\Controller\AppController;
use Cake\Utility\Security;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class OnsiteController extends AppController
{

    public $components = array('Paginator');
    public $paginate = array(
        'limit' => 10,
        'order' => [
            'Game.id' => 'desc'
        ]
    );

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Search.Prg', [
            'actions' => ['index']
        ]);
        $this->loadModel('Game');
        $this->viewBuilder()->layout('admin');
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {        
    
     $Onsitegame = $this->Game->newEntity();
  //  $query = $this->Game->find('all', $this->Game->filterParams($this->request->query))->where(['game_type'=>'onsite'])->order(['id' => 'DESC']);
 

     //echo"<pre>";print_r($query);die;
      //  $Onsitegame = $this->paginate($query);

    $Onsitegame = TableRegistry::get('game');
    $this->set('Onsitegame', $this->Paginator->paginate($Onsitegame, [
        'limit' => 10,'order' => array('id DESC'),'conditions' => array('game_type' => 'onsite'),
     ])->toArray());











           // $chessman = TableRegistry::get('game');
    //$this->set('chessmanlistings', $this->Paginator->paginate($chessman, [
      //  'limit' => 10,'order' => array('id DESC'),'conditions' => array('game_type' => 'craftsman'),
    // ])->toArray());
      //  if(!empty($this->request->query))
       // {
        /*    if(count($Onsitegame)>0)
            {
                $this->set(compact('Onsitegame'));
                $this->set('_serialize', ['Onsitegame']); 
            }
       }
        else
        {


        $this->set(compact('Onsitegame'));

        $this->set('_serialize', ['Onsitegame']); 


        }
        */
    }
    

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $this->request->allowMethod(['post', 'delete']);
        $Onsitegame = $this->Game->get($id);
        if ($this->Game->delete($Onsitegame)) {          
            $this->Flash->success(__('The onsite game has been deleted.'));        
        } else {
            $this->Flash->error(__('The onsite game could not be deleted. Please, try again.'));
        }
        
            return $this->redirect(['action' => 'index']); 
       
       
    }




  public function edit($id = null)
    {
      $this->loadModel('Game');
        $game = $this->Game->newEntity();
        if($this->request->is('POST')){

   
                if (!empty($this->request->data['image']['name'])) {
                    $validateImage = $this->imageValidate($this->request->data['image']); 
                }else{
                    $validateImage['error'] = 'false';
                }
                if($validateImage['error'] == 'false'){
                 //   $game->startdate = $startdatetime;
                  //  $game->enddate = $enddatetime;
         $game->description = $this->request->data['editor1'];
                                    unset($this->request->data['editor1']);
                                    $game->cat_id = '4';


                    $game = $this->Game->patchEntity($game, $this->request->data);
                    if($this->Game->save($game)){
                        if (!empty($this->request->data['image']['name'])) {
                            $this->loadModel('GameImages');
                            $query = $this->GameImages->deleteAll(array('game_id'=>$this->request->data['id']));
                            $this->uploadImage($this->request->data['id'],$this->request->data['image']);
                        }
                        
                            return $this->redirect(['action' => 'index']);
                        
                    }else{
                        $this->Flash->error(__('Records could not be saved. Please, try again.'));        
                    }
                }else{
                    $this->Flash->error(__($validateImage['error']));
                }   
       
        }
        $data = $this->Game->find()->contain(['GameImages','UsersScore'])->where(['Game.id'=>$id])->first(); 

       // echo"<pre>";print_r($data);die;       
        
        $this->set(compact('data'));
        $this->set('_serialize', ['data']);
    }


    public function addonsietGame(){
     
        if($this->request->is('POST')){
           // $startdatetime =  $this->request->data['start_date']." ".$this->request->data['start_time'];
            //$enddatetime =  $this->request->data['end_date']." ".$this->request->data['end_time'];
           // $dateCheck = $this->dateCompare($startdatetime,$enddatetime);
                $validateImage = $this->imageValidate($this->request->data['image']);
                if($validateImage['error'] == 'false'){
                    $this->loadModel('Game');
                    $game = $this->Game->newEntity();
                   // $game->startdate = $startdatetime;
                  ////  $game->enddate = $enddatetime;
$game->created=date("Y-m-d H:i:s");
               //     $game->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
                     $game->description = $this->request->data['editor1'];
                                    unset($this->request->data['editor1']);

                   $game->cat_id = '4';
                    $game = $this->Game->patchEntity($game, $this->request->data);
                    if($gameId = $this->Game->save($game)){
                                 

                   //echo"<pre>";print_r($game);die;
                            $this->uploadImage($gameId->id,$this->request->data['image']);
                            $this->saveIdentityScore($gameId->id ,$this->request->data['onsite_score'],$this->request->data['identity']);

                            $this->Flash->success(__('Onsite Records Added Successfully'));
                            return $this->redirect(['action' => 'index']);
                       
                    }else{
                        $this->Flash->error(__('Records could not be saved. Please, try again.'));        
                    } 
                }else{
                    $this->Flash->error(__($validateImage['error']));
                } 
          
                     
        }  
    
        }

        public function dateCompare($start_date,$end_date){
      $date1 = strtotime($start_date);
      $date2 = strtotime($end_date);
      return $date1 < $date2 ? 'true' :'false';
    } 


     public function saveIdentityScore($gameId, $score, $identity){
        $this->loadModel('UsersScore');
        for ($i=0; $i < count($score); $i++) { 
            $userScore = $this->UsersScore->newEntity();
            $userScore->game_id = $gameId;
            $userScore->score = $score[$i];
            $userScore->identity = $identity[$i];
$userScore->created=date("Y-m-d H:i:s");
            //$userScore->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
            $userScore = $this->UsersScore->patchEntity($userScore, array());
            $this->UsersScore->save($userScore);
        }
        return true;
    }
    public function imageValidate($data){
        if(isset($data) && !empty($data['name'])){
            $file = $data;
            $dimension=getimagesize($file['tmp_name']);
            $allowed =  array('gif','png' ,'jpg','jpeg','JPG');
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $width=$dimension[0];
            $height=$dimension[1];
            if(in_array($ext, $allowed)){   
                if($width > 100 && $height > 80){
                    return array('error'=>'false');
                }else{
                    return array('error'=>'Invalid Image Size. Image must be atleast 85X70.');
                }
            }else{
                return array('error'=>'Invalid Image format. Allowed Format(gif,png ,jpg,jpeg).');
            }    
        }else{
            return array('error'=>'Image should not be empty.');
        }
    }
     public function uploadImage($game_id,$data){
        $dest='../webroot/img/uploads';
        $file = $data;
        $dimension=getimagesize($file['tmp_name']);
        $allowed =  array('gif','png' ,'jpg','jpeg','JPG');
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $width=$dimension[0];
        $height=$dimension[1];
        $logo_image = $this->upload_image($dest,$file,'');
        chmod($dest.'/'.$logo_image,0777);
        $data['image'] = $logo_image;
        if(is_uploaded_file($file['tmp_name'])) {
            $n_height=200;
            $ratio=($width/$height);
            $n_width=$ratio*$n_height;
           // $result = $this->resize($file['tmp_name'],$logo_image,$ext,$width,$height,$n_width,$n_height);
        }
        $this->loadModel('GameImages');
        $game_images = $this->GameImages->newEntity();
        $game_images->game_id = $game_id;
        $game_images->image = $data['image'];
        $game_images->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
        
        $game_images = $this->GameImages->patchEntity($game_images, array());
        return $this->GameImages->save($game_images) ? true : false;       
    }

}

