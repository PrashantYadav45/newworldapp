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
class IworldController extends AppController
{

    public $components = array('Paginator');
    public $paginate = array(
        'limit' => 10,
        'order' => [
            'Iworld.id' => 'desc'
        ]
    );

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Search.Prg', [
            'actions' => ['index']
        ]);
        $this->viewBuilder()->layout('admin');
date_default_timezone_set('Asia/Hong_Kong');
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        
        $query = $this->Iworld->find('search', $this->Iworld->filterParams($this->request->query))->where(['game_type'=>'iworld']);
        $iworld = $this->paginate($query)->toArray();
        $this->set(compact('iworld'));
        
    }


         /**
     * Used to add Tabloid data
     */
    public function add(){
        $this->viewBuilder()->layout('admin');
        if($this->request->is('POST')){
            $startdatetime =  $this->request->data['start_date']." ".$this->request->data['start_time'];
            $enddatetime =  $this->request->data['end_date']." ".$this->request->data['end_time'];
            $dateCheck = $this->dateCompare($startdatetime,$enddatetime);
            if($dateCheck == 'true'){
            $validateImage = $this->imageValidate($this->request->data['image']);
            if($validateImage['error'] == 'false'){                   
            $this->loadModel('Game');
            $game = $this->Game->newEntity();
            $game->startdate = $startdatetime;
            $game->enddate = $enddatetime;
$game->created=date("Y-m-d H:i:s");
            //$game->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
           $game->cat_id = '9';
                           
            $game = $this->Game->patchEntity($game, $this->request->data);

                if($gameId = $this->Game->save($game)){
                     $this->uploadImage($gameId->id,$this->request->data['image']);
                            
                    $data = $this->saveQuestion($gameId->id,$this->request->data);
                    if($data == 'true'){
                        $this->Flash->success(__('I-world Records Added Successfully'));
                        return $this->redirect(['action' => 'index']);
                    }else{
                        $this->Flash->error(__('Records could not be saved. Please, try again.'));
                    }
                }else{
                    $this->Flash->error(__('Records could not be saved. Please, try again.'));        
                }
                  
                  }else{
                    $this->Flash->error(__($validateImage['error']));
                }
            }else{
                $this->Flash->error(__('Please check date and time .'));        
            }         
        }    
    }

    public function dateCompare($start_date,$end_date){
      $date1 = strtotime($start_date);
      $date2 = strtotime($end_date);
      return $date1 < $date2 ? 'true' :'false';
  } 
  public function saveQuestion($game_id,$data){
        $this->loadModel('Questions');
        if(isset($data) && array_filter($data['question_text'])){    
     // echo "<pre>";print_r($data);
            foreach ($data['question_text'] as $key => $value) {
                $question = $this->Questions->newEntity();
                $question->game_id = $game_id;
                $question->question_text = $data['question_text'][$key][0];
$question->created=date("Y-m-d H:i:s");
                //$question->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
                $question = $this->Questions->patchEntity($question, array());
                if($questionId = $this->Questions->save($question)){
                    $this->saveQuestionAnswer($questionId->id,$data['option'][$key],$data['score'][$key]);
                }else{
                    return false;
                }        
            }
        }
        return true;
    }

    public function saveQuestionAnswer($question_id,$option,$score){
        $this->loadModel('Questionanswersoptions');
        if(isset($option) && array_filter($option)){

            foreach ($option as $key => $value) {


                $questionAnswer = $this->Questionanswersoptions->newEntity();
                $questionAnswer->questions_id = $question_id;
                $questionAnswer->answer_option_text = $value;
                $questionAnswer->score = $score[$key];
 $questionAnswer->created=date("Y-m-d H:i:s");
                //$questionAnswer->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
                $questionAnswer = $this->Questions->patchEntity($questionAnswer, array());
                $this->Questionanswersoptions->save($questionAnswer);        
            }
      }
        return true;       
    }

    /**
     *Used to edit tabloid data
     */ 
    public function edit($id=null){
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Game');
        $this->loadModel('Questions');
        $game = $this->Game->newEntity();
        if($this->request->is('POST')){
            $startdatetime =  $this->request->data['start_date']." ".$this->request->data['start_time'];
            $enddatetime =  $this->request->data['end_date']." ".$this->request->data['end_time'];
            $dateCheck = $this->dateCompare($startdatetime,$enddatetime);
            if($dateCheck == 'true'){
                if (!empty($this->request->data['image']['name'])) {
                    $validateImage = $this->imageValidate($this->request->data['image']); 
                }else{
                    $validateImage['error'] = 'false';
                }
                $game->startdate = $startdatetime;
                $game->enddate = $enddatetime;
                $game->cat_id = '9';
                $game = $this->Game->patchEntity($game, $this->request->data);
                if($this->Game->save($game)){
                    if (!empty($this->request->data['image']['name'])) {
                            $this->loadModel('GameImages');
                            $query = $this->GameImages->deleteAll(array('game_id'=>$this->request->data['id']));
                            $this->uploadImage($this->request->data['id'],$this->request->data['image']);
                        }
                          $deletequestion = $this->Questions->deleteAll(array('game_id'=>$this->request->data['id']));
                        $data = $this->saveQuestion($this->request->data['id'],$this->request->data);
                    //$data = $this->editQuestion($this->request->data);
                   // if($data['resp'] == 'true'){
                        $this->Flash->success(__('I-world Records Updated Successfully'));
                        return $this->redirect(['action' => 'index']);
                    //}else{
                       // $this->Flash->error(__('Records could not be saved. Please, try again.'));
                   // }
                }else{
                    $this->Flash->error(__('Records could not be saved. Please, try again.'));        
                }
            }else{
                $this->Flash->error(__('Please check date and time .'));  
            }      
        }
 $data = $this->Game->find()->contain(['Questions'=>['Questionanswersoptions'],'GameImages'])->where(['Game.id'=>$id])->hydrate(false)->toArray();  
       // echo"<pre>";print_r($data);die;        
        $this->set(compact('data'));
    }
 
    public function editQuestion($data){
        $this->loadModel('Questions');
        $this->Questions->updateAll(array('question_text'=>$data['question_text'],'marks'=>$data['marks']),array('game_id'=>$data['id']));
        $answer_option_text = array($data['answer_a'],$data['answer_b'],$data['answer_c'],$data['answer_d']);
        return $this->editQuestionAnswer($data['question_id'],$answer_option_text,$data['rightanswer']);      
    }

    public function editQuestionAnswer($question_id,$options,$right){
        $this->loadModel('Questionanswersoptions');
        $query = $this->Questionanswersoptions->deleteAll(array('questions_id'=>$question_id));
        if($query){      
            foreach ($options as $key => $value) {
                $questionAnswer = $this->Questionanswersoptions->newEntity();
                $questionAnswer->questions_id = $question_id;
                $questionAnswer->answer_option_text = $value;
                if($right[0] == $key)
                    $questionAnswer->rightanswer = 1;
                $questionAnswer->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
                $questionAnswer = $this->Questions->patchEntity($questionAnswer, array());
                $this->Questionanswersoptions->save($questionAnswer);
            }
            return array('resp'=>'true');   
        }else{
            return array('resp'=>'false');
        }     
    }
    
    

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $this->loadModel('Game');        
        $iworld = $this->Game->get($id);
        if ($this->Game->delete($iworld)) {          
            $this->Flash->success(__('The iworld game has been deleted.'));        
        } else {
            $this->Flash->error(__('The iworld game could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);      
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
          //  $result = $this->resize($file['tmp_name'],$logo_image,$ext,$width,$height,$n_width,$n_height);
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
