<?php
namespace App\Controller;
use Cake\Network\Email\Email;
use App\Controller\AppController;
use Cake\Utility\Security;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;



class ScoreController extends AppController
{
public $components = array('Paginator');
    public $paginate = array(
        'limit' => 10,
        'order' => [
            'ScoreRange.rangeid' => 'ASC'
        ]
    );

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Search.Prg', [
            'actions' => ['index']
        ]);
        $this->loadModel('ScoreRange');
        $this->viewBuilder()->layout('admin');
date_default_timezone_set('Asia/Hong_Kong');
    }
    public function index() {        
    
     $article = $this->ScoreRange->newEntity();
  //  $query = $this->Game->find('all', $this->Game->filterParams($this->request->query))->where(['game_type'=>'onsite'])->order(['id' => 'DESC']);
 

     //echo"<pre>";print_r($query);die;
      //  $Onsitegame = $this->paginate($query);

    $article = TableRegistry::get('ScoreRange');
    $this->set('article', $this->Paginator->paginate($article, [
        'limit' => 10,'order' => array('rangeid ASC')
     ])->toArray());


    }
    

    
    public function deleteScore($id){
       $article = TableRegistry::get('ScoreRange');
       $entity = $article->get($id);
       $result = $article->delete($entity);
       if( $result ) {
       	$this->redirect($this->referer());
       }


    }

    public function addGame(){
    	$this->viewBuilder()->layout('admin');
  
    	if($this->request->is('post')) {

        $this->loadModel('ScoreRange');
        $score = $this->ScoreRange->newEntity();
       // $score->raneid = $game_id;
        $score->start_range = $this->request->data['startrange'];
         $score->end_range = $this->request->data['endrange'];
         $score->created = date('Y-m-d H:i:s');
        $Score = $this->ScoreRange->save($score);
        if($Score){
         $this->Flash->success(__('Score Range  Added Successfully'));
                            return $this->redirect(['action' => 'index']);
              }else{
             $this->Flash->error(__('Score Range could not be saved. Please, try again.'));        
              }
        }

    }

 public function dateCompare($start_date,$end_date){
      $date1 = strtotime($start_date);
      $date2 = strtotime($end_date);
      return $date1 < $date2 ? 'true' :'false';
  } 

  public function validateChessman( $data ){


  	       $response = array();
  	       if( !isset( $data['title'] ) || empty( $data['title'] ) ) {
  	       	$response['title'] = 'Please add the title';
  	       }
  	       else if( !isset( $data['password'] ) || empty( $data['password'] ) ) {
  	       	$response['password'] = 'Please add the password';
  	       }
  	       // else if( !isset( $data['adminscore'] ) || empty( $data['adminscore'] ) ) {
  	       // 	$response['adminscore'] = 'Please add the admin score';
  	       // }
  	       //  else if( !is_numeric ( $data['adminscore'] ) ) {
  	       // 	$response['adminscore'] = 'Please add the valid admin score';
  	       // }
  	       else if( !isset( $data['termscondition'] ) || empty( $data['termscondition'] ) ) {
  	       	$response['termscondition'] = 'Please add the terms and condition';
  	       }

  	       if( count( $response ) > 0 ) {
  	       	return $response;
  	       }else{
                       
                      //pr($data);die;    
                     $lenuser = count( $data['data']['user'] );
                     $lenscore = count( $data['data']['score'] );
                     $lenposition = count( $data['data']['position'] );
                     $lenbonous = count( $data['data']['bonous'] );

                    $userarray = $data['data']['user'];
	             	$scorearray = $data['data']['score'];
	             	$positionarray = $data['data']['position'];
	             	$bonousarray = $data['data']['bonous'];


                     /* foreach ($data['data'] as $key => $value) {
                      	 
                              
                         if( 
                         	! isset( $value['user'] )
                         	||
                         	! isset( $value['score'] )
                         	|| 
                         	! isset( $value['position'] )
                         	||
                         	! isset( $value['bonous'] ) 
                         	) {
                         	$response['cloneerror'] = 'Please add the values properly';
                         }*/
                         if(
                                  
                               $lenuser != $lenscore
                               || 
                               $lenposition != $lenbonous
                               ||
                               $lenuser != $lenbonous
                               ||
                               $lenscore != $lenposition 

                         	)
                         {
                         	$response['cloneerror'] = 'Please add the values properly';
                         }
                         else{


                         	foreach ($userarray as $key => $value) {
                         		
                         		if( ! is_numeric( $value ) ) {

                         			$response['userid'] = 'Please select the user properly';

                         		}    

                         	}
                         	foreach ($scorearray as $key => $value) {
                         		
                         		if( ! is_numeric( $value ) ) {

                         			$response['score'] = 'Please enter the score properly';

                         		}    

                         	}
                         	foreach ($bonousarray as $key => $value) {
                         		
                         		if( ! is_numeric( $value ) ) {

                         			$response['score'] = 'Please enter the Bonous properly';

                         		}    

                         	}


                         }


                      //}



  	       }
  	       return $response;

  }
  public function editScore($id)
    {
      $this->loadModel('ScoreRange');
        $game = $this->ScoreRange->newEntity();
        if($this->request->is('POST')){
            
         $updateall= $this->ScoreRange->updateAll(array('start_Range'=>$this->request->data['startrange'],'end_Range'=>$this->request->data['endrange']),array('rangeid'=>$this->request->data['id']));                                         
         if($updateall){
         $this->Flash->success(__('Score Range  Updated Successfully'));
                            return $this->redirect(['action' => 'index']);
              }else{
             $this->Flash->error(__('Score Range could not be updated. Please, try again.'));        
              }
      }
        $data = $this->ScoreRange->find()->where(['ScoreRange.rangeid'=>$id])->first(); 

     // echo"<pre>";print_r($data);die;       
        
        $this->set(compact('data'));
        $this->set('_serialize', ['data']);
    }




//
//    public function imageValidate($data){
//        if(isset($data) && !empty($data['name'])){
//            $file = $data;
//            $dimension=getimagesize($file['tmp_name']);
//            $allowed =  array('gif','png' ,'jpg','jpeg','JPG');
//            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
//            $width=$dimension[0];
//            $height=$dimension[1];
//            if(in_array($ext, $allowed)){   
//                if($width > 100 && $height > 80){
//                    return array('error'=>'false');
//                }else{
//                    return array('error'=>'Invalid Image Size. Image must be atleast 85X70.');
//                }
//            }else{
//                return array('error'=>'Invalid Image format. Allowed Format(gif,png ,jpg,jpeg).');
//            }    
//        }else{
//            return array('error'=>'Image should not be empty.');
//        }
//    }
//     public function uploadImage($game_id,$data){
//        $dest='../webroot/img/uploads';
//        $file = $data;
//        $dimension=getimagesize($file['tmp_name']);
//        $allowed =  array('gif','png' ,'jpg','jpeg','JPG');
//        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
//        $width=$dimension[0];
//        $height=$dimension[1];
//        $logo_image = $this->upload_image($dest,$file,'');
//        chmod($dest.'/'.$logo_image,0777);
//        $data['image'] = $logo_image;
//        if(is_uploaded_file($file['tmp_name'])) {
//            $n_height=200;
//            $ratio=($width/$height);
//            $n_width=$ratio*$n_height;
//            $result = $this->resize($file['tmp_name'],$logo_image,$ext,$width,$height,$n_width,$n_height);
//        }
//        $this->loadModel('GameImages');
//        $game_images = $this->GameImages->newEntity();
//        $game_images->game_id = $game_id;
//        $game_images->image = $data['image'];
//        $game_images->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
//        
//        $game_images = $this->GameImages->patchEntity($game_images, array());
//        return $this->GameImages->save($game_images) ? true : false;       
//    }






} 
