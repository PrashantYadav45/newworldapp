<?php
namespace App\Controller;
use Cake\Network\Email\Email;
use App\Controller\AppController;
use Cake\Utility\Security;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;



class ChessmanController extends AppController
{
	 public function initialize()
    {
        parent::initialize();  
        $this->loadComponent('Paginator');
        $this->loadComponent('RequestHandler');
 //date_default_timezone_set('Asia/Calcutta');
date_default_timezone_set('Asia/Hong_Kong');
    }
    public function index(){
  	$this->viewBuilder()->layout('admin');
  	$chessman = TableRegistry::get('game');
    $this->set('chessmanlistings', $this->Paginator->paginate($chessman, [
        'limit' => 10,'order' => array('id DESC'),'conditions' => array('game_type' => 'craftsman'),
     ])->toArray());
    }

    
    public function deleteGame($id){
       $chessman = TableRegistry::get('game');
       $entity = $chessman->get($id);
       $result = $chessman->delete($entity);
       if( $result ) {
       	$this->redirect($this->referer());
       }


    }

    public function addGame(){
    	$this->viewBuilder()->layout('admin');
    	$user = TableRegistry::get('users');
    	$this->set('listusers',$user->find('list')->where(['id <>'=>$this->Auth->user('id')])->hydrate(false)->toArray());
    	if($this->request->is('post')) {
        $this->loadModel('Game');
        $startdatetime =  $this->request->data['start_date']." ".$this->request->data['start_time'];
        $enddatetime =  $this->request->data['end_date']." ".$this->request->data['end_time'];
        $dateCheck = $this->dateCompare($startdatetime,$enddatetime);
        if($dateCheck == 'true'){
          $game = $this->Game->newEntity();
          $game->game_type = 'craftsman';
          $game->startdate = $startdatetime;
          $game->enddate = $enddatetime;
          $game->description = $this->request->data['editor1'];
           unset($this->request->data['editor1']);

$game->created=date("Y-m-d H:i:s");
//          $game->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
          $game->cat_id = '1';


          $game = $this->Game->patchEntity($game, $this->request->data);
          
          if($gameId = $this->Game->save($game)) { 
            $this->saveRankScore($gameId->id,$this->request->data['rank_score']);
            $this->Flash->success(__('Game Records Added Successfully'));
            return $this->redirect(['action' => 'index']);
          }else{
            $this->Flash->error(__('Records could not be saved. Please, try again.'));
          } 
        }else{
           $this->Flash->error(__('Records could not be saved. Please, try again.'));  
        } 


        // parse_str($this->request->data['form'],$output);
        //   $image_data = $this->request->data['file'];
        //   $this->request->data = $output;
        //    //print_r($this->request->data);die;
        //    $error = $this->validateChessman($this->request->data);
        //     if(count($error) > 0) {
        //       $error['code'] = 202; 
        //       echo json_encode($error);die;
        //     }else{
        //       $startdatetime =  $this->request->data['start_date']." ".$this->request->data['start_time'];
        //       $enddatetime =  $this->request->data['end_date']." ".$this->request->data['end_time'];
        //       $dateCheck = $this->dateCompare($startdatetime,$enddatetime);
        //       if($dateCheck == 'true'){

        //         $validateImage = $this->imageValidate($image_data);
        //         if($validateImage['error'] == 'false'){
        //         $this->loadModel('Game');
        //         $game = $this->Game->newEntity();
        //         $game->game_type = 'craftsman';
        //         $game->admin = $this->Auth->user('id');
        //         $game->terms_condition = $this->request->data['termscondition'];
        //         $game->startdate = $startdatetime;
        //         $game->enddate = $enddatetime;
        //         $game->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
        //         $game = $this->Game->patchEntity($game, $this->request->data);
        //         if($gameId = $this->Game->save($game)){
        //           $this->loadModel('UserGamePlayed');
        //           $this->uploadImage($gameId->id,$image_data);
        //           foreach ($this->request->data['data']['user'] as $key => $value) {
        //             $userGame = $this->UserGamePlayed->newEntity();
        //             $userGame->game_id = $gameId->id;
        //             $userGame->user_id = $value;
        //             $userGame->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
        //             $userGame = $this->Game->patchEntity($userGame, $this->request->data);
        //             $this->UserGamePlayed->save($userGame);
        //           }
        //           $this->loadModel('UsersScore');
        //           for ($i=0; $i < count($this->request->data['data']['user']); $i++) { 
        //               $userScore = $this->UsersScore->newEntity();
        //               $userScore->game_id = $gameId->id;
        //               $userScore->user_id = $this->request->data['data']['user'][$i];
        //               $userScore->score = $this->request->data['data']['score'][$i];
        //               $userScore->position = $this->request->data['data']['position'][$i];
        //               $userScore->bonus = $this->request->data['data']['bonous'][$i];
        //               $userScore->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
        //               $userScore = $this->UsersScore->patchEntity($userScore, $this->request->data);
        //               $this->UsersScore->save($userScore);   
        //           }
        //           echo json_encode(array('data'=>'true'));die;
        //         }else{
        //           echo json_encode(array('error'=>'Unable to update data ,Please try again'));die;
        //         }

        //         }else{
        //             $this->Flash->error(__($validateImage['error']));
        //         }
        //       }


        //       else{
        //         echo json_encode(array('error'=>'Please check date and time .'));die;
        //       }   
        //     }
     	}

    }

  public function dateCompare($start_date,$end_date){
      $date1 = strtotime($start_date);
      $date2 = strtotime($end_date);
      return $date1 < $date2 ? 'true' :'false';
  } 

  public function saveRankScore($gameId,$score){
    $this->loadModel('UsersScore');
    for ($i=0; $i < count($score); $i++) { 
        $userScore = $this->UsersScore->newEntity();
        $userScore->game_id = $gameId;
        $userScore->score = $score[$i];
$userScore->created=date("Y-m-d H:i:s");
      //  $userScore->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
        $userScore = $this->UsersScore->patchEntity($userScore, array());
        $this->UsersScore->save($userScore);
    }
    return true;
  } 


  public function validateChessman( $data ){
      $response = array();
      if( !isset( $data['title'] ) || empty( $data['title'] ) ) {
       	  $response['error'] = 'Please add the title';
      }else if( !isset( $data['password'] ) || empty( $data['password'] ) ) {
	       	$response['error'] = 'Please add the password';
	    }else if( !isset( $data['termscondition'] ) || empty( $data['termscondition'] ) ) {
          $response['error'] = 'Please add the terms and condition';
      }
  	  if(count($response) > 0 ) {
  	      return $response;
  	  }else{             
          $lenuser = count( $data['data']['user'] );
          $lenscore = count( $data['data']['score'] );
          $lenposition = count( $data['data']['position'] );
          $lenbonous = count( $data['data']['bonous'] );

          $userarray = $data['data']['user'];
         	$scorearray = $data['data']['score'];
         	$positionarray = $data['data']['position'];
         	$bonousarray = $data['data']['bonous'];

          if( $lenuser != $lenscore || $lenposition != $lenbonous || $lenuser != $lenbonous || $lenscore != $lenposition) {
              $response['error'] = 'Please add the values properly';
          }else{
              foreach ($userarray as $key => $value) {
                if(!is_numeric( $value ) ) {
                    $response['error'] = 'Please select the user properly';
                }    
              }
             	foreach ($scorearray as $key => $value) {
             		if(!is_numeric( $value ) ) {
             			$response['error'] = 'Please enter the score properly';
             	  }    
            	}
             	foreach ($bonousarray as $key => $value) {
             		if(!is_numeric( $value ) ) {
             			$response['error'] = 'Please enter the Bonous properly';
             		}    
             	}
          }
  	  }
  	  return $response;
  }


    public function editGame($id=null){
      $this->viewBuilder()->layout('admin');
      $this->loadModel('Game');
      if($this->request->is('post')) {
        $this->loadModel('Game');
        $startdatetime =  $this->request->data['start_date']." ".$this->request->data['start_time'];
        $enddatetime =  $this->request->data['end_date']." ".$this->request->data['end_time'];
        $dateCheck = $this->dateCompare($startdatetime,$enddatetime);
        if($dateCheck == 'true'){
          $game = $this->Game->newEntity();
          $game->id = $this->request->data['id'];
          $game->startdate = $startdatetime;
          $game->enddate = $enddatetime;
          $game->description = $this->request->data['editor1'];
           unset($this->request->data['editor1']);
           $game->cat_id = '1';

          $game = $this->Game->patchEntity($game, $this->request->data);
          if($this->Game->save($game)){
            $this->loadModel('UsersScore');
            $this->UsersScore->deleteAll(array('game_id'=>$this->request->data['id']));
            $this->saveRankScore($this->request->data['id'],$this->request->data['rank_score']);
            $this->Flash->success(__('Game Records Updated Successfully'));
            return $this->redirect(['action' => 'index']);
          }else{
            $this->Flash->error(__('Records could not be saved. Please, try again.'));
          }
        }else{
           $this->Flash->error(__('Records could not be saved. Please, try again.'));
        }

          //echo "<pre>";print_r($this->request->data);die;
          // parse_str($this->request->data['form'],$output);
          // $image_data = $this->request->data['file'];
          // $this->request->data = $output;
          // $error = $this->validateChessman($this->request->data); 
          // if(count($error) > 0) {
          //   $error['code'] = 202; 
          //   echo json_encode($error);die;
          // }else{
          
          //   //print_r($output);die;
          //   $startdatetime =  $this->request->data['start_date']." ".$this->request->data['start_time'];
          //   $enddatetime =  $this->request->data['end_date']." ".$this->request->data['end_time'];
          //   $dateCheck = $this->dateCompare($startdatetime,$enddatetime);
          //   if($dateCheck == 'true'){
          //     if (!empty($image_data)) {
          //         $validateImage = $this->imageValidate($image_data); 
          //       }else{
          //           $validateImage['error'] = 'false';
          //       }
          //       if($validateImage['error'] == 'false'){
          //     $gameId = $this->request->data['id'];
          //     $game = $this->Game->newEntity();
          //     $game->id = $this->request->data['id'];
          //     $game->admin = $this->Auth->user('id');
          //     $game->startdate = $startdatetime;
          //     $game->enddate = $enddatetime;
          //     $game->terms_condition = $this->request->data['termscondition'];
          //     $game->game_type = 'craftsman';
          //     $game = $this->Game->patchEntity($game, $this->request->data);
          //     if($this->Game->save($game)){
          //       if (!empty($image_data)) {
          //                   $this->loadModel('GameImages');
          //                   $query = $this->GameImages->deleteAll(array('game_id'=>$this->request->data['id']));
          //                   $this->uploadImage($this->request->data['id'],$image_data);
          //               }

          //       $this->loadModel('UserGamePlayed');
          //       $this->UserGamePlayed->deleteAll(array('game_id'=>$this->request->data['id']));
          //       foreach ($this->request->data['data']['user'] as $key => $value) {
          //         $userGame = $this->UserGamePlayed->newEntity();
          //         $userGame->game_id = $gameId;
          //         $userGame->user_id = $value;
          //         $userGame->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
          //         $userGame = $this->Game->patchEntity($userGame, array());
          //         $this->UserGamePlayed->save($userGame);
          //       }
          //       $this->loadModel('UsersScore');
          //       $this->UsersScore->deleteAll(array('game_id'=>$this->request->data['id']));
          //       for ($i=0; $i < count($this->request->data['data']['user']); $i++) { 
          //           $userScore = $this->UsersScore->newEntity();
          //           $userScore->game_id = $gameId;
          //           $userScore->user_id = $this->request->data['data']['user'][$i];
          //           $userScore->score = $this->request->data['data']['score'][$i];
          //           $userScore->position = $this->request->data['data']['position'][$i];
          //           $userScore->bonus = $this->request->data['data']['bonous'][$i];
          //           $userScore->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
          //           $userScore = $this->UsersScore->patchEntity($userScore, array());
          //           $this->UsersScore->save($userScore);   
          //       }
          //       echo json_encode(array('data'=>'true'));die;
          //     }else{
          //       echo json_encode(array('error'=>'Unable to update data ,Please try again'));die;
          //     }
          //      }else{
          //           $this->Flash->error(__($validateImage['error']));
          //       }
          //   }else{
          //     echo json_encode(array('error'=>'Please check date and time .'));die;
          //   }
          // }
      }
      $gameData = $this->Game->get($id,[
        'contain'=>['UserGamePlayed','UsersScore','GameImages']
        ]);
      $user = TableRegistry::get('users');
      $this->set('listusers',$user->find('list')->hydrate(false)->toArray());
      $this->set(compact('gameData'));
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
         //   $result = $this->resize($file['tmp_name'],$logo_image,$ext,$width,$height,$n_width,$n_height);
        }
        $this->loadModel('GameImages');
        $game_images = $this->GameImages->newEntity();
        $game_images->game_id = $game_id;
        $game_images->image = $data['image'];
        $game_images->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
        
        $game_images = $this->GameImages->patchEntity($game_images, array());
        return $this->GameImages->save($game_images) ? true : false;       
    }




    public function checkName(){
        $this->loadModel('Game');
        $total = $this->Game->find('all',array('conditions'=>array('Game.title' => $_REQUEST['title'])))->toArray();
        if(count($total) > 0){
            echo "false";die;
        }else{
            echo "true";die;    
        }
    }








} 
