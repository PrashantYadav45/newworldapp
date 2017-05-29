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
class AllGamesController extends AppController
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
        $this->viewBuilder()->layout('admin');
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $this->loadModel('Game');
        $query = $this->Game->find('search', $this->Game->filterParams($this->request->query))->where(['game_status'=>'will_play']);
        $games = $this->paginate($query)->toArray();
        $this->set(compact('games'));
    }

    /**
     * Used to add Game data
     **/
    public function add(){
        $this->viewBuilder()->layout('admin');
        if($this->request->is('POST')){
            $this->loadModel('Game');
            if(!empty($this->request->data['cat_id']) && $this->request->data['cat_id'] != 4){
                $this->request->data['startdatetime'] =  $this->request->data['start_date']." ".$this->request->data['start_time'];
                $this->request->data['enddatetime'] =  $this->request->data['end_date']." ".$this->request->data['end_time'];
                unset($this->request->data['start_date'],$this->request->data['end_date'],$this->request->data['start_time'],$this->request->data['end_time']);
                $dateCheck = $this->dateCompare($this->request->data['startdatetime'],$this->request->data['enddatetime']); 
            }else{
                $dateCheck = 'true';                
            }

            if($dateCheck == 'true'){
                $img = $this->imageValidate($this->request->data['image']);
                if($img['error'] == 'false'){
                    $upImg = $this->uploadImage($this->request->data['image']);
                    if($upImg == true){
                        switch ($this->request->data['cat_id']) {
                            case 1:
                                $data = $this->saveCraftman($this->request->data);
                                break;

                            case 4:
                                $data = $this->saveOnSite($this->request->data);
                                break;

                            case 5:
                                $data = $this->saveTabloid($this->request->data);
                                break;

                            case 9:
                                $data = $this->saveTabloid($this->request->data);
                                break;

                            default:
                                $data = $this->saveCraftman($this->request->data);
                                break;
                        }
                        if($data == true){
                            $this->Flash->success(__('Game Records Added Successfully'));
                            return $this->redirect(['action' => 'index']);
                        }else{
                            $this->Flash->error(__('Unable to save data ,Please try again'));
                        }
                    }else{
                        $this->Flash->error(__('Unable to save Image ,Please try again'));
                    }
                }else{
                    $this->Flash->error(__($img['error']));
                }
            }else{
                $this->Flash->error(__('Please check Date and Time'));
            }
        }
        $this->loadModel('Category');
        $cats = $this->Category->find('all')->select(['id','cat_name'])->hydrate(false)->toArray();   
        $this->set(compact('cats'));
    }

    /**
     * Save craftman data
     **/
    public function saveCraftman($data){
        $data['image'] = $data['image']['name'];
        $game = $this->Game->newEntity(); 
        $game->game_type = 'craftsman';
        $game->admin = $this->Auth->user('id');
        $game->startdate = $data['startdatetime'];
        $game->enddate = $data['enddatetime'];
        $game->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
        $data = $this->Game->patchEntity($game, $data);
        if($lastId = $this->Game->save($data)){
            return $this->saveRankScore($lastId->id ,$data['rank_score']);
        }else{
            return false;
        }
    }

    /**
     * Used to save rank in user_score table
     **/
    public function saveRankScore($gameId,$score){
        $this->loadModel('UsersScore');
        for ($i=0; $i < count($score); $i++) { 
            $userScore = $this->UsersScore->newEntity();
            $userScore->game_id = $gameId;
            $userScore->score = $score[$i];
            $userScore->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
            $userScore = $this->UsersScore->patchEntity($userScore, array());
            $this->UsersScore->save($userScore);
        }
        return true;
    } 

    /**
     * Save OnSiteGame data
     **/
    public function saveOnSite($data){
       // echo "<pre>";print_r($data);die;
        $data['image'] = $data['image']['name'];
        $game = $this->Game->newEntity(); 
        $game->game_type = 'onsite';
        $game->admin = $this->Auth->user('id');
        $game->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
        $game = $this->Game->patchEntity($game, $data);
        if($lastId = $this->Game->save($game)){
            return $this->saveIdentityScore($lastId->id ,$data['onsite_score'],$data['identity']);
        }else{
            return false;
        }
    }

    /**
     * Used to save rank in user_score table
     **/
    public function saveIdentityScore($gameId, $score, $identity){
        $this->loadModel('UsersScore');
        for ($i=0; $i < count($score); $i++) { 
            $userScore = $this->UsersScore->newEntity();
            $userScore->game_id = $gameId;
            $userScore->score = $score[$i];
            $userScore->identity = $identity[$i];
            $userScore->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
            $userScore = $this->UsersScore->patchEntity($userScore, array());
            $this->UsersScore->save($userScore);
        }
        return true;
    }


    /**
     * Save Tabloid Game data
     **/
    public function saveTabloid($data){
        $data['image'] = $data['image']['name'];
        $game = $this->Game->newEntity(); 
        $game->game_type = 'tabloid';
        $game->admin = $this->Auth->user('id');
        $game->startdate = $data['startdatetime'];
        $game->enddate = $data['enddatetime'];
        $game->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
        $game = $this->Game->patchEntity($game, $data);
        if($lastId = $this->Game->save($game)){
            return $this->saveQuestion($lastId->id ,$data);
        }else{
            return false;
        }
    }

    /**
     * Image validation before saving data
     **/
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

    /**
     * Upload Image function to save Image in dir
     **/
    public function uploadImage($data){
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
            $result = $this->resize($file['tmp_name'],$logo_image,$ext,$width,$height,$n_width,$n_height);
            return true;
        }else{
            return false;
        }
    }

    /** 
     * Used to validate dates
     **/
    public function dateCompare($start_date,$end_date){
      $date1 = strtotime($start_date);
      $date2 = strtotime($end_date);
      return $date1 < $date2 ? 'true' :'false';
    } 

    public function saveQuestion($game_id,$data){
        $this->loadModel('Questions');
        if(isset($data) && array_filter($data['question_text'])){    
            // echo "<pre>";print_r($data['question_text']);die;       
            foreach ($data['question_text'] as $key => $value) {
                $question = $this->Questions->newEntity();
                $question->game_id = $game_id;
                $question->question_text = $value;
                $question->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
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
        if(isset($data) && array_filter($option)){
            foreach ($option as $key => $value) {
                $questionAnswer = $this->Questionanswersoptions->newEntity();
                $questionAnswer->questions_id = $question_id;
                $questionAnswer->answer_option_text = $value;
                $questionAnswer->score = $score[$key];
                $questionAnswer->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
                $questionAnswer = $this->Questions->patchEntity($questionAnswer, array());
                $this->Questionanswersoptions->save($questionAnswer);        
            }
        }
        return ;       
    }


    /**
     *Used to edit tabloid data
     */ 
    public function edit($id=null){
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Game');
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
                if($validateImage['error'] == 'false'){
                    $game->startdate = $startdatetime;
                    $game->enddate = $enddatetime;
                    $game = $this->Game->patchEntity($game, $this->request->data);
                    if($this->Game->save($game)){
                        if (!empty($this->request->data['image']['name'])) {
                            $this->loadModel('GameImages');
                            $query = $this->GameImages->deleteAll(array('game_id'=>$this->request->data['id']));
                            $this->uploadImage($this->request->data['id'],$this->request->data['image']);
                        }
                        $data = $this->editQuestion($this->request->data);
                        if($data['resp'] == 'true'){
                            $this->Flash->success(__('Tabloid Records Updated Successfully'));
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
        $this->loadModel('Category');
        $cats = $this->Category->find('all')->select(['id','cat_name'])->hydrate(false)->toArray();   
        $game = $this->Game->find()->where(['Game.id'=>$id])->first();
        echo "<pre>";print_r($game);die;
        $this->set(compact('cats','game'));

        $data = $this->Game->find()->contain(['Questions'=>['Questionanswersoptions'],'GameImages'])->where(['Game.id'=>$id])->first();        
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
        $tabloid = $this->Game->get($id);
        if ($this->Game->delete($tabloid)) {          
            $this->Flash->success(__('The tabloid game has been deleted.'));        
        } else {
            $this->Flash->error(__('The tabloid game could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);      
    }

    





}
