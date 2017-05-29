<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;
header('Content-Type: application/json');
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Network\Email\Email;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\I18n\Time;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class ApiController extends AppController
{

    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */

     public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadModel('Api');
        $this->loadModel('Users');
     



     }
       
	 public function beforeFilter(Event $event) {
    	parent::beforeFilter($event);
    	$this->Auth->allow(['getAllUser','getscorerange','addChessman','getuserseacrh','editimage','getuser','getranking','getsingleitem','getitems','getscore','itemSearch','redemptionRecords','saveUserScore','getAllInfoCraftman','updateScore','getgamerule','login','getquestions','getcorrectanswer','register','userInformation','getAllGames','getAllItems']);



    }

	
    
   /*---------------------------Register api  code start ----------------------*/        
   public function register(){
       $response=array();
        if($this->request->is('post')){
            $error=$this->Api->validateRegister($_POST);
            if($error['error']){
                $response=$error;
            }else{
                $data=$_POST;
                $data['email']=trim($data['email']);                
                $data['name']=trim($data['name']);
                $data['password']=md5($_POST['password']);                
                $data['role']=trim($data['role']);
                $data['device_id']=trim($data['device_id']);
                $data['login_token']=uniqid();
                $data['contact_no']=trim($data['contact_no']);
                $data['profile_pic']=trim($data['profile_pic']);
                $data['created']=date("Y-m-d H:i:s");

                $image_name=$this->upload_image1($_POST["profile_pic"],'register',WWW_ROOT.'img/uploads/');
                  
                  if ($image_name)
                  {         
                            $data['profile_pic']=$image_name;
                            $user = $this->Users->newEntity();
                            $user = $this->Users->patchEntity($user, $data);               
                            if ($this->Users->save($user)) {
                            unset($data['password']);                            
                            $response['statuscode']=200;
                            $response['msg']="User has been registered successfully.";
                            $data['profile_pic']=$image_name;
                            $response['data']=$data;
                          
                        }else{
                        $response['error']=true;
                        $response['statuscode']=513;
                        $response['msg']="The user could not be signup. Please, try again.";
                    }
                 } else{
                        $response['error']=true;
                        $response['statuscode']=411;
                        $response['msg']="Image format unsupported";
                    }                                      
                
            }
        }else{
           $response['error']=true;
           $response['statuscode']=512;
           $response['msg']="Invalid Request";
        }
        echo json_encode($response);die;
    }


/*----------------------Register api code end-------------------------*/

/*---------------------------Login api  code start ----------------------*/

     public function login(){
               $response = array();
               $error = array(); 
                 if ($this->request->is('post'))
                 {
                    $error = $this->Api->validate_login($_POST);
  
                    if($error['statuscode']==200)
                    {
                        //$query_status=$this->Users->updateAll(array('login_token'=>uniqid(),'device_id'=>$_POST['device_id']),array('email'=>$_POST['email']));
$query_status=$this->Users->updateAll(array('login_token'=>uniqid()),array('email'=>$_POST['email']));
                            $error_DB=$this->Users->find('all')->select(['id','name','email','contact_no','login_token','device_id','profile_pic'])->where(array('email'=>$_POST['email']))->toArray();
$this->loadModel('UserGamePlayed');
  $score = $this->UserGamePlayed->find('all')
                                      ->select(['total'=>'SUM(UserGamePlayed.score)'])
                                      ->where(['UserGamePlayed.user_id'=>$error_DB[0]['id']])
                                      ->first()
                                      ->toArray();
                              $error["statuscode"]= 200;
                             // $error["msg"]= "User has been login successfully.";
 $error["msg"]= "用戶已成功登入";
                              $error['data'] = $error_DB[0];
 $error['data']['score'] = $score['total'];
                              $response = $error;
                    }
                    else{
                    $response = $error;
                    }
                }else
                {
                     $response['msg'] = 'Invalid Request';
                     $response['statuscode'] = 419; 
                }
                 echo json_encode($response);die;
              }
/*-------------------login api code end ---------------------------------*/


/*----------------------Forgot password api code start -------------------*/
    public function forgotPass(){
             $response = array();
                           $error = array(); 
                             if ($this->request->is('post'))
                             {
                                $error = $this->validateUserpass($_POST);
                                $response = $error;
                            }else
                            {
                                 $response['msg'] = 'Invalid Request';
                                 $response['statuscode'] = 419; 
                            }
                             echo json_encode($response);die; 
                }



 public function validateUserpass($login_data){  
                   $error = array();
                   if(empty($login_data['email'])){
                    $error['error']=true;                    
                    $error['statuscode'] =  302;
                   // $error['msg'] = 'Please enter the email.';
$error['msg'] = '用戶名稱錯誤,請重新輸入';
                    }else if (!filter_var($login_data['email'], FILTER_VALIDATE_EMAIL)){
                    $error['error']=true;
                    $error['statuscode']=406;
                   // $error['msg']="Please test enter valid email.";
$error['msg']='用戶名稱錯誤,請重新輸入';
                    }else if(!$this->Api->isExistEmail($login_data['email'])){
                    $error['error']=true;
                    $error['statuscode']=405;
                    $error['msg']="Invalid email.";
                    }
                    else{
                    $email = $this->Users->find('all')->where(['email =' => $login_data['email'],'status'=>'1'])->toArray();
                    if(count($email)){
                    $id=$email[0]->id;
                    $name=$email[0]->name;
                    $rand_url=rand(1000,9000);
                    $rand_url2=rand(1000,9000);
                    $code=$rand_url.$id.$rand_url2;
                    $p_r_code=array('reset_token'=>$code);
                    $this->Users->updateAll($p_r_code,  array('id' => $id)); 
                    $pass_vars = array('code' => $code,'name'=>$name);                    
                     $email = new Email('default');
                     $email->to($login_data['email'])
                    ->template('forgot_pass')
                    ->viewVars($pass_vars)
                    ->emailFormat('html')
                    ->subject('Password Reset')
                    ->from('newworldapp@app.com')
                    ->send();
                        $error['error']=false;
                        $error['statuscode']=200;
                        $error['msg']="Password link has been sent to your email successfully.";
                                          
                        }else{
                        $error['error']=true;
                        $error['statuscode']=513;
                        $error['msg']="Unauthorized user.";
                       }  
                  }
                  return $error;
                }

    /*------------------------forgot password api code end---------------------*/



    /** 
     * Add function to add chessman
     **/
    public function addChessman(){
        $response = array();
        if($this->request->is('POST')){
            $auth = $this->Api->isExistBytoken($this->request->data['login_token']);
            if($auth == true){
                $valRes=$this->Api->validateChessman($this->request->data);
                if($valRes['statuscode'] == 200){
                    $actData =  $this->saveGameChessman($this->request->data);
                    if($actData == 200){
                        $response['statuscode']=200;
                        $response['success']="Chessman data saved successfully";
                    }else{
                        $response['statuscode']=104;
                        $response['error']="Unable to save data";
                    }
                }else{
                    $response = $valRes;
                }
            }else{
                $response['statuscode']=101;
                $response['error']="Token Invalid";    
            }
        }else{
            $response['statuscode']=102;
            $response['error']="Invalid method request";
        }
        echo json_encode($response);die;
    }

    /**
     *Used to save chessman data 
     **/
    public function saveGameChessman($data){
        $this->loadModel('Game');
        $game = $this->Game->newEntity();
        $game->game_type = 'craftsman';
        $game->admin = $data['user_id'];
        $game->terms_condition = $data['terms_condition'];
        $game->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
        $game = $this->Game->patchEntity($game, $data);
        if($gameId = $this->Game->save($game)){
            return $this->savePlayedChessman($gameId->id,$data);
        }else{
            return $response=103;
        }
    }

    /**
     *Used to save user played chessman data 
     **/
    public function savePlayedChessman($game_id,$data){
        $this->loadModel('UserGamePlayed');
        foreach ($this->request->data['user'] as $key => $value) {
          $userGame = $this->UserGamePlayed->newEntity();
          $userGame->game_id = $game_id;
          $userGame->user_id = $value;
          $userGame->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
          $userGame = $this->Game->patchEntity($userGame, $data);
          $this->UserGamePlayed->save($userGame);
        }
        return $this->saveScoreChessman($game_id,$data);
    }

    /**
     *Used to save user score chessman data 
     **/
    public function saveScoreChessman($game_id,$data){
        $this->loadModel('UsersScore');
        for ($i=0; $i < count($this->request->data['user_id']); $i++) { 
            $userScore = $this->UsersScore->newEntity();
            $userScore->game_id = $game_id;
            $userScore->user_id = $data['user_id'][$i];
            $userScore->score = $data['score'][$i];
            $userScore->position = $data['position'][$i];
            $userScore->bonus = $data['bonus'][$i];
            $userScore->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
            $userScore = $this->UsersScore->patchEntity($userScore, array());
            $this->UsersScore->save($userScore);   
        }
        return $response=200;     
        
    }




    //mss updated 15 //

    public function getuserseacrh(){
        $this->loadModel('UsersScore');
        $this->loadModel('Users');

        $response = array();
        if($this->request->is('POST')){
            $auth = $this->Api->isExistBytoken($this->request->data['login_token']);
              if($auth == true){
                  $data=$this->request->data;
               $correct_user = $this->Api->validate_user($this->request->data['login_token']);
          if(!empty($data['user_name'])){
               if($correct_user){
                $data = $this->Users->find('all')->where(['Users.name LIKE'=> '%'.$data['user_name'].'%'])->hydrate(false)->toArray();

            if($data){

                    $response['error']=false;
                    $response['statuscode']=200;
                    $response['msg']="Success";
                   $response['total_score']=$data;

            }else{

                    $response['error']=true;
                    $response['statuscode']=787;
                    $response['msg']="Data not found";   

            }
               }else{

                     $response['error']=true;
                    $response['statuscode']=777;
                    $response['msg']="You have no permission";   

               }


               }else{

                    $response['error']=true;
                    $response['statuscode']=789;
                    $response['msg']="Your serach field is empty";   

               }

             }else{

                    $response['error']=true;
                    $response['statuscode']=636;
                    $response['msg']="Invalid user";   
                    }
          }else{

            $response['error']=true;
            $response['statuscode']=635;
            $response['msg']="Invalid Request"; 

          }
  echo json_encode($response);die;
}



//

   /**
     *Used to save user score chessman data 
     *
    public function saveScoreChessman($game_id,$data){
        $this->loadModel('UsersScore');
        for ($i=0; $i < count($this->request->data['user_id']); $i++) { 
            $userScore = $this->UsersScore->newEntity();
            $userScore->game_id = $game_id;
            $userScore->user_id = $data['user_id'][$i];
            $userScore->score = $data['score'][$i];
            $userScore->position = $data['position'][$i];
            $userScore->bonus = $data['bonus'][$i];
            $userScore->created=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
            $userScore = $this->UsersScore->patchEntity($userScore, array());
            $this->UsersScore->save($userScore);   
        }
        return $response=200;        
    }

    /**
     * Used to get all user score for the game
     **/
    public function userInformation(){
      $response = array();
      if($this->request->is('GET')){
        $auth = $this->Api->isExistBytoken($_GET['login_token']);
        if($auth == true){
          $this->loadModel('UsersScore');
          $score = $this->UsersScore->find('all')
                ->select(['total'=>'SUM(UsersScore.score + UsersScore.bonus - UsersScore.score_deduction)'])
                ->where(['UsersScore.user_id'=>$_GET['user_id']])
                ->hydrate(false)
                ->toArray();

           $data = $this->UsersScore->find('all')
                ->select(['id','user_id','game_id','score','score_deduction','item_id','position','bonus','created','Game.title','Game.game_type','Game.terms_condition','GameImages.image'])
                ->contain(['Game'=>['GameImages']]) 
                ->where(['UsersScore.user_id'=>$_GET['user_id']])
                ->hydrate(false)
                ->toArray();
          if($data){
            $response['statuscode']=200;
            $response['total_score']=$score[0]['total'];
            $response['success']="User Scores Listing";
            $response['score_listing']=$data;
          }else{
            $response['statuscode']=510;
            $response['error']="No Listing Found"; 
          }
        }else{
          $response['statuscode']=511;
          $response['error']="Token Invalid";    
        }
      }else{
        $response['statuscode']=512;
        $response['error']="Invalid method request";
      }
      echo json_encode($response);die;
    }



/* USER edit image */


public function editimage(){
        $response = array();
        if($this->request->is('POST')){
            $auth = $this->Api->isExistBytoken($this->request->data['login_token']);
             if($auth == true){
                $data=$_POST;
                $token=  $data['login_token']; 
                $data['profile_pic']=trim($data['profile_pic']);
		$image_name=$this->upload_image1($_POST["profile_pic"],'editimage',WWW_ROOT.'img/uploads/');
                if($image_name){
                 $path= Router::url('/img/uploads/', true);
                 $actData =  $this->editimages($this->request->data,$image_name);
                    if($actData == 200){
                        $response['statuscode']=200;
                        $response['success']="Image has been uploaded  successfully";
                        $response['updated_image'] =  $path.'/'.$image_name;

                    }else{
                        $response['statuscode']=604;
                        $response['error']="Unable to upload image";
                    }
                    }
            }else{
		$response['error']=true;
		$response['statuscode']=607;
		$response['msg']="Invalid user";  
            }
        }else{
		$response['error']=true;
		$response['statuscode']=606;
		$response['msg']="Invalid Request";
            }

  echo json_encode($response);die;


}

      public function editimages($data,$image_name){

        $token=$data['login_token'];
	$this->loadModel('Users');
        $Users = $this->Users->newEntity();
        $users = TableRegistry::get('Users');
        $query = $users->query();
                    if($query->update()
                    ->set(['profile_pic' => $image_name])
                    ->where(['login_token' => $token])
                    ->execute()){
                    return $response=200; 
            }else{
            return $response=605;
        }

        
        

    }
/* End */

  /**
    *GET user detail
    **/
  public function getuser(){
    $this->loadModel('UsersScore');
    $response = array();
    if($this->request->is('GET')){
      $auth = $this->Api->isExistBytokenandId($_GET['login_token'],$_GET['id']);
        if($auth == true){
                $token=  $_GET['login_token']; 
          $score = $this->UsersScore->find('all')->select(['total'=>'SUM(UsersScore.score)'])->where(['UsersScore.user_id'=>$_GET['id']])->hydrate(false)->toArray();

          $query = $this->Users->find()->select(['id','email','name','profile_pic'])->where(['login_token' => $token])->where(['id' => $_GET['id']])->order(['id' => 'DESC'])->first()->toArray();

          if($query){
            $query['profile_pic']=Router::url('/img/uploads/'.$query['profile_pic'], true); 
            $query['user_total_score']=$score[0]['total'];

            $this->loadModel('Items');
            $items = $this->Items->find('all')->select(['id','item_title','image','score'])->where(['Items.score <'=>$score[0]['total']])->hydrate(false)->toArray();
            foreach ($items as $key => $value) {
              $items[$key]['image'] = Router::url('/img/uploads/'.$value['image'], true);
            }
            $response['statuscode']=200;
            $response['msg']="Success";   
            $response['user_info']=$query; 
            $response['items'] = $items;

          }else{
            $response['statuscode']=618;
            $response['msg']="No records Found";   
          }           
      }else{
           $response['error']=true;
           $response['statuscode']=616;
           $response['msg']="Invalid user";         
      }
    }else{
      $response['error']=true;
      $response['statuscode']=617;
      $response['msg']="Invalid Request";       
    }
    echo json_encode($response);die;
  }

/* USER_REDDEM _ITEMS*/
public function getranking(){
   $this->loadModel('UsersScore');
        $this->loadModel('Items');
        $response = array();
        if($this->request->is('GET')){
        $data=$_GET;
//print_r($data);die;
        $auth = $this->Api->isExistBytokenandId($_GET['login_token'],$_GET['id']);
              if($auth){
               $score = $this->UsersScore->find('all')
                              ->select(['total'=>'SUM(UsersScore.score + UsersScore.bonus - UsersScore.score_deduction)'])
                              ->where(['UsersScore.user_id'=>$data['id']])
                              ->hydrate(false)
                              ->toArray();
                              $scores= $score[0];
                              $totalscore=$scores['total'];
                              $query = $this->Items->find('all')->where(['Items.score <='=> $totalscore])->hydrate(false)->toArray();
	
                          if($query){
                          $response['error']=false;
                          $response['statuscode']=200;
                          $response['msg']="Sccess";
                          $response['usercan_redeem_items']=$query;  
                          $response['user_total_score']=$score;   

                          }else{

                          $response['error']=true;
                          $response['statuscode']=620;
                          $response['msg']="Score Not Found, Please try again later";   

                          }

              }else{
                    $response['error']=true;
                    $response['statuscode']=621;
                    $response['msg']="Invalid User";   
              }

        }else{

           $response['error']=true;
           $response['statuscode']=622;
           $response['msg']="Invalid Request";   
                
      }

  echo json_encode($response);die;


}

/* END */
/* Get item information */

public function getsingleitem(){
        $this->loadModel('Items');
        $response = array();
        if($this->request->is('GET')){
            $auth = $this->Api->isExistBytoken($_GET['login_token']);
              if($auth == true){
                  $data=$_GET;
                  $items_id= $data['item_id'];
                  $query = $this->Items->find('all')->where(['id' => $items_id])->count();
                  if($query){
                    $query = $this->Items->find('all')->where(['id' => $items_id])->first()->toArray();
		    $profilepic=$query['image'];
		    $path= Router::url('/img/uploads/'.$profilepic, true);
                      if($query){
				$query['image']=$path;  
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Sccess";
                                $response['item_info']=$query;
                                }
                              }else{
                                $response['error']=true;
                                $response['statuscode']=625;
                                $response['msg']="Items Not Found, Please try again later";   
                            }
                    }else{

                    $response['error']=true;
                    $response['statuscode']=626;
                    $response['msg']="Invalid user";   
                    }
            }else{
            $response['error']=true;
            $response['statuscode']=627;
            $response['msg']="Invalid Request";   
          }
  echo json_encode($response);die;
}
/* End */

/* Get redeem item */
public function getitems(){
        $this->loadModel('Items');
        $response = array();
        if($this->request->is('POST')){
            $auth = $this->Api->isExistBytoken($this->request->data['login_token']);
              if($auth == true){
                  $data=$this->request->data;
                  $items_id= $data['item_id'];
                  $query = $this->Items->find()->select(['method_redemmption', 'terms_conditions'])->where(['id' => $items_id])->count();
                  if($query){
                    $query = $this->Items->find()->select(['method_redemmption', 'terms_conditions'])->where(['id' => $items_id])->hydrate(false)->toArray();
                    $method_redemmption=$query[0]['method_redemmption'];
                    $terms_conditions=$query[0]['terms_conditions'];
                  if($method_redemmption||$terms_conditions){
                     $query = $this->Items->find()->select(['method_redemmption', 'terms_conditions'])->where(['id' => $items_id])->hydrate(false)->toArray();
                      if($query){
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Sccess";
                                $response['redeem_item_information']=$query;  
                                }
                              }else{
                                $response['error']=true;
                                $response['statuscode']=628;
                                $response['msg']=" Empty, Please try again later";   
                                  }}
                                  else{

                                 $response['error']=true;
                                $response['statuscode']=631;
                                $response['msg']="Items Not Found , Please try again later";  
                                  }
                    }else{

                    $response['error']=true;
                    $response['statuscode']=629;
                    $response['msg']="Invalid user";   
                    }
            }else{
            $response['error']=true;
            $response['statuscode']=630;
            $response['msg']="Invalid Request";   
          }
  echo json_encode($response);die;
}
/* End*/


/* Get user score */

public function getscore(){
        $this->loadModel('UsersScore');
        $this->loadModel('Game');
        $this->loadModel('Items');

        $response = array();
        if($this->request->is('POST')){
            $auth = $this->Api->isExistBytoken($this->request->data['login_token']);
              if($auth == true){
                  $data=$this->request->data;
                    $game_id=$data['game_id'];
                   	$user_id= $data['user_id'];
					$scorerequest=$data['score'];
					$type=$data['type'];
					$score_id=$data['score_id'];
					     $query = $this->Game->find('all')->where(['id' => $game_id])->count();
                                                            //print_r($query);die;


                      if($query){
						  $this->loadModel('UserGamePlayed');
						  if($type==5){
									
									$usergameplayedquery = $this->UserGamePlayed->find('all')
													  ->select(['UserGamePlayed.score'])
													  ->where(['UserGamePlayed.user_id'=>$user_id,'UserGamePlayed.game_id'=>$game_id])
													->hydrate(false)
													  ->toArray();
									$total_scoredata=$usergameplayedquery[0]['score']+$scorerequest;
									if($usergameplayedquery){
												$updateall= $this->UserGamePlayed->updateAll(array('score'=>$total_scoredata),array('game_id'=>$game_id,'user_id'=>$user_id));                                         
				
									}else{
											$UserGamePlayeddata = $this->UserGamePlayed->newEntity();
											$UserGamePlayeddata->user_id = $user_id;
											$UserGamePlayeddata->game_id = $game_id;
											$UserGamePlayeddata->score_id = 0;
											$UserGamePlayeddata->score = $scorerequest;
											$UserGamePlayeddata->created = date('Y-m-d H:i:s');
											$UserGamePlayeddata->updated = date('Y-m-d H:i:s');
											$UserGamePlayedinsert = $this->UserGamePlayed->save($UserGamePlayeddata);
									}
					}//end if of type
					else{
						$usergameplayedquery = $this->UserGamePlayed->find('all')
													  ->select(['UserGamePlayed.score'])
													  ->where(['UserGamePlayed.user_id'=>$user_id,'UserGamePlayed.game_id'=>$game_id,'UserGamePlayed.score_id'=>$score_id])
													->hydrate(false)
													  ->toArray();
									//$total_scoredata=$usergameplayedquery[0]['score']+$scorerequest;
									if($usergameplayedquery){
												$updateall= $this->UserGamePlayed->updateAll(array('updated'=>date('Y-m-d H:i:s')),array('game_id'=>$game_id,'user_id'=>$user_id));                                         
				
									}else{
						$UserGamePlayeddata = $this->UserGamePlayed->newEntity();
						$UserGamePlayeddata->user_id = $user_id;
						$UserGamePlayeddata->game_id = $game_id;
						$UserGamePlayeddata->score_id = $score_id;
						$UserGamePlayeddata->score =$scorerequest ;
						$UserGamePlayeddata->created = date('Y-m-d H:i:s');
						$UserGamePlayeddata->updated = date('Y-m-d H:i:s');
						$UserGamePlayedinsert = $this->UserGamePlayed->save($UserGamePlayeddata);
									}
					}               
                      $score = $this->UserGamePlayed->find('all')
                                      ->select(['total'=>'SUM(UserGamePlayed.score)'])
                                      ->where(['UserGamePlayed.user_id'=>$user_id])
                                      ->first()
                                      ->toArray();
									  // $this->Game->find('all')->contain(['Category'])
								  
								
						//	$scoretotal=$score['total']+$scoredata['total']+$scoregame['total'];		  
                        $query = $this->Items->find('all')->where(['Items.score <='=> $score['total']])->hydrate(false)->toArray();
						//$query = $this->Items->find('all')->where(['Items.score <='=> $scoretotal])->hydrate(false)->toArray();

                        if($query){
                                $response['error']=false;
                                $response['statuscode']=200;
                                $response['msg']="Success";
                                $response['isredeem']=1;
                                $response['items_with_score']=$query; 
                               $response['Total_score']=$score['total']; 

                        }else{

                    $response['error']=false;
                    $response['statuscode']=638;
                    $response['msg']="You haven’t got enough marks to redeem the goods";
                    $response['isredeem']=0 ;
                        }

                      }else{

                    $response['error']=true;
                    $response['statuscode']=637;
                    $response['msg']="Your Information is not correct";
              }
             }else{

                    $response['error']=true;
                    $response['statuscode']=636;
                    $response['msg']="Invalid user";   
                    }
          }else{

            $response['error']=true;
            $response['statuscode']=635;
            $response['msg']="Invalid Request"; 

          }
  echo json_encode($response);die;
}


   
   /**
     * Used to search item name functionality
     **/
    public function itemSearch(){
      $response = array();
      if($this->request->is('POST')){

        $auth = $this->Api->isExistBytoken($this->request->data['login_token']);
        if($auth == true){
          $this->loadModel('Items');

   $score=$this->request->data['score'];
if($score==1)
{
 $this->loadModel('UsersScore');

 $userscoredata=$this->UsersScore->find('all')->where(['UsersScore.user_id'=>$this->request->data['user_id'] ])->hydrate(false)->toArray();
  $data = $this->Items->find('all')->where(['Items.item_title LIKE'=> '%'.$this->request->data['search'].'%', 'Items.score <='=>$userscoredata[0]['score'],'Items.score >='=> $this->request->data['start_range'], 'Items.score <='=> $this->request->data['end_range']])->hydrate(false)->toArray();
  if($data )
{
$arr = array();
              foreach ($data as $key => $value) {
                array_push($arr, array('id' =>$value['id'],
                                       'item_title' =>$value['item_title'],
                                       'description' =>$value['description'],
                                       'image' => HTTP_ROOT.'img/uploads/'.$value['image'],
                                       'score' =>$value['score'],
// 'scoresearch' => $useriddata,
                                       'created' =>$value['created']));  
              }
              $response['statuscode']=200;
              $response['success']="Items Listing";
              $response['items'] = $arr;
            }else{
              $response['statuscode']=523;
              $response['items'] = "No records Found";  
            }

}
else
{

               if(!empty($this->request->data) && (!empty($this->request->data['search']) || (!empty($this->request->data['start_range']) && !empty($this->request->data['end_range']) ) ) ){
                if( !empty($this->request->data) && !empty($this->request->data['search']) && empty($this->request->data['start_range']) && empty($this->request->data['end_range']) ) {
                  $data = $this->Items->find('all')->where(['Items.item_title LIKE'=> '%'.$this->request->data['search'].'%'])->hydrate(false)->toArray();
                }else if(!empty($this->request->data) && !empty($this->request->data['start_range']) && !empty($this->request->data['end_range']) && empty($this->request->data['search'])) {
                  $data = $this->Items->find('all')->where(['Items.score >='=> $this->request->data['start_range'], 'Items.score <='=> $this->request->data['end_range']])->hydrate(false)->toArray();
                }else if(!empty($this->request->data) && !empty($this->request->data['search']) && !empty($this->request->data['start_range']) && !empty($this->request->data['end_range']) ){
                  $data = $this->Items->find('all')->where(['Items.item_title LIKE'=> '%'.$this->request->data['search'].'%', 'Items.score >='=> $this->request->data['start_range'], 'Items.score <='=> $this->request->data['end_range']])->hydrate(false)->toArray();
                }

            if($data){
	      $arr = array();
              foreach ($data as $key => $value) {
                array_push($arr, array('id' =>$value['id'],
                                       'item_title' =>$value['item_title'],
                                       'description' =>$value['description'],
                                       'image' => HTTP_ROOT.'img/uploads/'.$value['image'],
                                       'score' =>$value['score'],
// 'scoresearch' => $useriddata,
                                       'created' =>$value['created']));  
              }
              $response['statuscode']=200;
              $response['success']="Items Listing";
              $response['items'] = $arr;
            }else{
              $response['statuscode']=523;
              $response['items'] = "No records Found";  
            }
          }else{
            $response['statuscode']=522;
            $response['error']="Invalid search params";
          }
}//Elsescore
        }else{
          $response['statuscode']=521;
          $response['error']="Token Invalid";      
        }
      }else{
        $response['statuscode']=520;
        $response['error']="Invalid method request";
      }
      echo json_encode($response);die;
    }

    /**
    * Used to get games and redeemption records
    **/ 
    public function redemptionRecords(){
      $response = array();
      if($this->request->is('GET')){
        $this->loadModel('UsersScore');
        $auth = $this->Api->isExistBytokenandId($_GET['login_token'],$_GET['user_id']);
        if($auth == true){
          $data = $this->UsersScore->find('all')
                  ->contain(['Items'])
                  ->select(['id','user_id','game_id','score','score_deduction','item_id','bonus','created','Items.item_title'])
                  ->where(['user_id'=>$_GET['user_id']])->hydrate(false)->toArray();

          if(!empty($data)){
            $arr = array();
            foreach ($data as $key => $value) {
              array_push($arr, array('id'=>$value['id'],
                                     'score_deduction'=> $value['score_deduction'] > 0 ? $value['score_deduction'] : 0,
                                     'collected'=> $value['score_deduction'] > 0 ? 'yes':'No',
                                     'item_title'=>isset($value['item']['item_title']) ? $value['item']['item_title'] : '',
                                     'added_marks' => $value['score_deduction'] < 1 ? $value['score'] + $value['bonus'] : 0
                                    ));
          }
            $response['statuscode']=200;
            $response['success']="Items Listing";
            $response['items'] = $arr;
          }else{
            $response['statuscode']=523;
            $response['items'] = "No records Found"; 
          }
        }else{
          $response['statuscode']=521;
          $response['error']="Token Invalid";
        }
      }else{
        $response['statuscode']=520;
        $response['error']="Invalid method request";
      }
      echo json_encode($response);die;
    }

    /**
     * Function updating score_deduction value acc to user_id and item_id
     **/
    public function saveUserScore(){
      $response = array();
      if($this->request->is('POST')){
        $this->loadModel('UsersScore');
        $auth = $this->Api->isExistBytokenandId($this->request->data['login_token'],$this->request->data['user_id']);
        if($auth == true){
          $dataValidate = $this->Api->userScoreValidate($this->request->data);
          if($dataValidate){
            $query_status=$this->UsersScore->updateAll(array('score_deduction'=>$this->request->data['score']),array('user_id'=>$this->request->data['user_id'],'item_id'=>$this->request->data['item_id']));
            if($query_status){
              $response['statuscode']=200;
              $response['success']="Score Updated successfully";
            }else{
              $response['statuscode']=532;
              $response['success']="No Fields Changed";
            }
          }else{
            $response = $dataValidate;
          }
        }else{
          $response['statuscode']=531;
          $response['error']="Token Invalid";
        }
      }else{
        $response['statuscode']=530;
        $response['error']="Invalid method request";
      }
      echo json_encode($response);die;
    } 

// Get game_rule by using game_type //

public function getgamerule(){
  $this->loadModel('GameRules');
        $response = array();
        if($this->request->is('POST')){
            $auth = $this->Api->isExistBytoken($this->request->data['login_token']);
             if($auth == true){
                      $data=$_POST;
                      $game_type= $data['game_type'];
                      $query = $this->GameRules->find('all')->where(['game_type' => $game_type])->count();
                      if($query){
                        $query = $this->GameRules->find('all')->where(['game_type' => $game_type])->first()->toArray();
                          if($query){
                            $response['error']=false;
                            $response['statuscode']=200;
                            $response['msg']="Success";  
                            $response['game_rule']=$query;   
                          }else{
                            $response['error']=false;
                            $response['statuscode']=642;
                            $response['msg']="Error to find details ,Please try again"; 
                          }
                      }else{
                      $response['error']=true;
                      $response['statuscode']=643;
                      $response['msg']="Empty Details ,Please try again"; 
                      }

              }else{
                    $response['error']=true;
                    $response['statuscode']=641;
                    $response['msg']="Invalid user";   
                }
        }else{
               $response['error']=true;
               $response['statuscode']=640;
               $response['msg']="Invalid Request";   
                    
                }
  echo json_encode($response);die;
}
//end//


//Get correct answer api //
public function getcorrectanswer(){
      $this->loadModel('UsersScore');
        $this->loadModel('Items');
        $this->loadModel('Questions');
        $response = array();
        if($this->request->is('POST')){
            $auth = $this->Api->isExistBytoken($this->request->data['login_token']);

              if($auth == true){
                    $data=$this->request->data;
                     $questionanswer_id=$data['question_answer_id'];
                     $questionanswers_count = $this->Questions->Questionanswersoptions->find()->select(['rightanswer'])->where(['id' => $questionanswer_id])->count();
                      $this->set(compact('questionanswersoptions'));

                        if($questionanswers_count){
                            $questionanswers_alldata = $this->Questions->Questionanswersoptions->find('all')->where(['id' => $questionanswer_id])->hydrate(false)->toArray();

                                $this->set(compact('questionanswersoptions'));
                                $checkanswer=$questionanswers_alldata[0]['rightanswer'];
                                $ques_id=$questionanswers_alldata[0]['questions_id'];

                                  if($checkanswer){
                                      $questionanswers_marks = $this->Questions->find()->select(['marks','game_id'])->where(['id' => $ques_id])->hydrate(false)->toArray();
                                      $user_id=$data['user_id'];
                                      $total_marks=$questionanswers_marks[0]['marks'];
                                      $game_id=$questionanswers_marks[0]['game_id'];
                                          $questionanswers_marks[0]['score']=$total_marks;
                                          $questionanswers_marks[0]['user_id']=$user_id;
                                          $total_scores=$questionanswers_marks[0];
                                          $user = $this->UsersScore->newEntity();
                                          $user = $this->UsersScore->patchEntity($user, $total_scores);               
                                          $updated_score=    $this->UsersScore->save($user);

                                            if(!empty($updated_score)){

                                            $response['error']=false;
                                            $response['statuscode']=200;
                                            $response['msg']="Right answer";   
                                            }else{
                                            $response['error']=false;
                                            $response['statuscode']=664;
                                            $response['msg']="Score not updated,please check your credentials";   
                                            }
                                    
                                  }else{

                                  $response['error']=true;
                                  $response['statuscode']=663;
                                  $response['msg']="Wrong answer";   

                                  }

                            }else{

                            $response['error']=true;
                            $response['statuscode']=662;
                            $response['msg']="answer_id is not correct";   

                            }
                    }else{
                    $response['error']=true;
                    $response['statuscode']=661;
                    $response['msg']="Invalid user";   
                    }
            }else{
            $response['error']=true;
            $response['statuscode']=660;
            $response['msg']="Invalid Request";   
          }
  echo json_encode($response);die;
}
//End//

// GET QUESTION api//
public function getquestions(){
      $this->loadModel('UsersScore');
        $this->loadModel('Items');
        $this->loadModel('Questions');
        $response = array();
        if($this->request->is('POST')){
            $auth = $this->Api->isExistBytoken($this->request->data['login_token']);
              if($auth == true){
                  $data=$this->request->data;

              $gameid=$data['game_id'];
              $allquestion=$this->Questions->find('all')->where(['game_id' => $gameid])->hydrate(false)->toArray();

              $allquestions=array();
          foreach ($allquestion as $key => $value) {
                $qusetion_id=$value['id'];
                $questionanswers = $this->Questions->Questionanswersoptions->find('all')->where(['questions_id' => $qusetion_id])->hydrate(false)->toArray();
                $allanswers = array();
          foreach ($questionanswers as $keey => $valeue) {
                      $allanswers[] = $valeue;
                      }
                      $value['ques_answers'] = $allanswers;
                      $allquestions[]=$value;
                }

              $total_count_from_db = $this->Questions->find('all')->count();
              if($allquestions&&$allanswers){

                  $response['error']=false;
                  $response['statuscode']=200;
                  $response['msg']="Sccess";
                  $response['total_question_count']=$total_count_from_db;
                 // $response['currentpage'] = $totalcounts_from_user;
                  $response['question']=$allquestions; 
                 // $response['question_answer_options']=$allanswers;  

                    }else{
                    $response['error']=true;
                    $response['statuscode']=652;
                    $response['msg']="Invalid page";
                    }
                  }else{
                    $response['error']=true;
                    $response['statuscode']=651;
                    $response['msg']="Invalid user";   
                    }
            }else{
            $response['error']=true;
            $response['statuscode']=650;
            $response['msg']="Invalid Request";   
          }
  echo json_encode($response);die;
}
//End//

   /**
     * Function used to return all information about craftsmann game. 
     **/
    public function getAllInfoCraftman(){
      $response = array();
      if($this->request->is('GET')){
        $auth = $this->Api->isExistBytoken($_GET['login_token']);
        if($auth == true){
          $this->loadModel('Game');
          $data = $this->Game->find('all', array('contain'=>array('UsersScore'=>array('Users')),'conditions'=>array('game_type'=>'craftsman','game_status'=>'will_play'),'order' => array('id' => 'DESC'),'limit'=>1 ))->hydrate(false)->toArray();
          if($data){
            $game_data = array('id'=>$data[0]['id'],'title'=>$data[0]['title'],'game_type'=>$data[0]['game_type'],'terms_condition'=>$data[0]['terms_condition'],'startdate'=>$data[0]['startdate'],'enddate'=>$data[0]['enddate']);
            $user_score_data = array();
            foreach ($data[0]['users_score'] as $key => $value) {
                array_push($user_score_data, array(
                                                  'id'=>$value['id'],
                                                  'user_id'=>$value['user_id'],
                                                  'score'=>$value['score'],
                                                  'user'=>array(
                                                                'id'=>$value['user']['id'],
                                                                'name'=>$value['user']['name']
                                                                )
                                                  )
                            );
            }
            $response['statuscode']=200;
            $response['success']="Craftman Listing";
            $response['craftman'] = array_merge($game_data,array('game_player'=>$user_score_data));
          }else{
            $response['statuscode']=543;
            $response['items'] = "No Records Found";                 
          }
        }else{
          $response['statuscode']=542;
          $response['error']="Token Invalid";
        }
      }else{
        $response['statuscode']=541;
        $response['error']="Invalid method request";
      }
      echo json_encode($response);die;
    }

    /**
     * Function used to update user score
     **/
    public function updateScore(){
      $response = array();
      if($this->request->is('POST')){
        $this->loadModel('UsersScore');
        $auth = $this->Api->isExistBytokenandId($this->request->data['login_token'],$this->request->data['user_id']);
        if($auth == true){
          $dataValidate = $this->Api->updateUserScoreValidate($this->request->data);
          if($dataValidate['statuscode'] == 200){
            $this->loadModel('Game');
            $game = $this->Game->newEntity();
            $game->id = $this->request->data['game_id'];
            $game->game_status = 'played';
            $game = $this->Game->patchEntity($game, array()); 
            if($this->Game->save($game)){
                $user_score = $this->UsersScore->newEntity();
                //$user_score->id = $this->request->data['score_id'];
                $user_score->score = $this->request->data['score'];
                $updateall= $this->UsersScore->updateAll(array('score'=>$this->request->data['score']),array('game_id'=>$this->request->data['game_id']));                     

               if ($updateall) {
                  $response['statuscode']=200;
                  $response['success']="Score Updated successfully";
$response['score']=$this->request->data['score'];
                }else{
                  $response['statuscode']=532;
                  $response['success']="Unable to update records";
                }
            }else{
                $response['statuscode']=533;
                $response['success']="Unable to update records";
            }
          }else{
            $response = $dataValidate;
          }
        }else{
          $response['statuscode']=531;
          $response['error']="Token Not Matched";
        }
      }else{
        $response['statuscode']=530;
        $response['error']="Invalid method request";
      }
      echo json_encode($response);die;
    }
function getLastQuery($model) {
  
}
    /**
     * Function used to display all Games in homepage 
     **/
    public function getAllGames(){
      $response = array();
      if($this->request->is('GET')){
        $this->loadModel('UsersScore');
        $auth = $this->Api->isExistBytokenandId($_GET['login_token'],$_GET['user_id']);
        if($auth == true){
          $this->loadModel('Game');
        $game = $this->Game->find('all')->contain(['Category'])->order(['Game.id'=>'DESC'])->hydrate(false)->toArray();
 
       // print_r($game);die;
 
          if($game){
            $res = array();
            foreach ($game as $key => $value) {

 $login= $this->Game->find('all')->contain(['GameImages'])->where(['GameImages.game_id'=>$value['id']])->hydrate(false)->toArray();

if($login){

  $image=(isset($login[0]['game_image']['image']) && !empty($login[0]['game_image']['image'])) ? HTTP_ROOT.'img/uploads/'.$login[0]['game_image']['image'] : '';
}else{
$image="";
}
              array_push($res, array('category'=> $value['category']['cat_name'],
                                     'game_title'=> $value['title'],
                                     'game_id'=> $value['id'],
   
'image'=> $image,
'categoryid'=> $value['cat_id'],
                                     'description'=> $value['description']
                                    ));
	$Userdata= $this->UsersScore->find('all')->contain(['Game'])->where(['UsersScore.game_id'=>$value['id'],'Game.cat_id'=>4])->hydrate(false)->toArray();
			$onsitegame=array();
			if($Userdata)
			{
			
				  foreach ($Userdata as $keyonsite => $onsitevalue) {
					  array_push($onsitegame,array('identity'=> $onsitevalue['identity'],
                                     'score'=> $onsitevalue['score'],
                                     'game_id'=> $onsitevalue['game_id'],
									'password'=>$value['password'],
									'score_id'=>$onsitevalue['id']
                                    ));
								
				  }
				 
			}
			else{
				 //array_push($onsitegame,array());
			}$res[$key]['Onsitedata']=$onsitegame;							
			
			//For CraftMans
			
			$Userdatacraft= $this->UsersScore->find('all')->contain(['Game'])->where(['UsersScore.game_id'=>$value['id'],'Game.cat_id'=>1])->hydrate(false)->toArray();
			$craftmangame=array();
			if($Userdatacraft)
			{
			
				  foreach ($Userdatacraft as $keycraft => $craftvalue) {
					  array_push($craftmangame,array('host_score'=> $value['host_score'],
                                     'score'=> $craftvalue['score'],
                                     'game_id'=> $craftvalue['game_id'],
									'participant_score'=>$value['participant_score'],
									'password'=>$value['password'],
									'score_id'=>$craftvalue['id']
                                    ));
								
				  }
				 
			}
			else{
				 //array_push($onsitegame,array());
			}$res[$key]['Craftman']=$craftmangame;
			
			
            }
			
            $response['statuscode']=200;
            $response['success']="Game Listing";
            $response['game'] = $res;
			//$response['onsite']=$onsitegame;
          }else{
            $response['statuscode']=552;
            $response['game'] = "No Records Found";      
          }
        }else{
          $response['statuscode']=551;
          $response['error']="Token Not Matched";
        }
      }else{
        $response['statuscode']=550;
        $response['error']="Invalid method request";
      }
      echo json_encode($response);die;
    }
	
	
	 /**
     * Function used to display all Games in homepage 
     **/
    public function getAllUser(){
      $response = array();
      if($this->request->is('GET')){
        $this->loadModel('Users');
        $auth = $this->Api->isExistBytokenandId($_GET['login_token'],$_GET['user_id']);
        if($auth == true){
          $this->loadModel('Game');
        $game = $this->Users->find('all')->where(['Users.id !='=>$_GET['user_id']])->order(['Users.id'=>'DESC'])->hydrate(false)->toArray();
 
       // print_r($game);die;
 
          if($game){
            $res = array();
            foreach ($game as $key => $value) {

        array_push($res, array('id'=> $value['id'],
                                    'email'=> $value['email'],
									'name'=> $value['name'],
   									'role_id'=> $value['role_id'],
                                    'department_id'=> $value['department_id'],
									'profile_pic'=> (isset($value['profile_pic']) && !empty($value['profile_pic'])) ? HTTP_ROOT.'img/uploads/'.$value['profile_pic'] : '',
									'contact_no'=> $value['contact_no']
                                    ));
	
			
            }
			
            $response['statuscode']=200;
            $response['success']="User Listing";
            $response['game'] = $res;
			//$response['onsite']=$onsitegame;
          }else{
            $response['statuscode']=552;
            $response['game'] = "No Records Found";      
          }
        }else{
          $response['statuscode']=551;
          $response['error']="Token Not Matched";
        }
      }else{
        $response['statuscode']=550;
        $response['error']="Invalid method request";
      }
      echo json_encode($response);die;
    }

 /**
     * Function used to display all Score  Rang in Gift Page 
     **/
    public function getscorerange(){
      $response = array();
      if($this->request->is('GET')){
        $this->loadModel('UsersScore');
        $auth = $this->Api->isExistBytokenandId($_GET['login_token'],$_GET['user_id']);
        if($auth == true){
          $this->loadModel('ScoreRange');
        $game = $this->ScoreRange->find('all')->order(['ScoreRange.rangeid'=>'ASC'])->hydrate(false)->toArray();
 
     
 
          if($game){
            $res = array();
            foreach ($game as $key => $value) {
         array_push($res, array('start_range'=> $value['start_range'],
                                     'end_range'=> $value['end_range'],
                                     
                                    ));
            }
            $response['statuscode']=200;
            $response['success']="Score Range Listing";
            $response['game'] = $res;
          }else{
            $response['statuscode']=552;
            $response['game'] = "No Records Found";      
          }
        }else{
          $response['statuscode']=551;
          $response['error']="Token Not Matched";
        }
      }else{
        $response['statuscode']=550;
        $response['error']="Invalid method request";
      }
      echo json_encode($response);die;
    }

   /**
     * Used to get all items 
     **/ 
    public function getAllItems(){
      $response = array();
      if($this->request->is('GET')){
        $this->loadModel('UsersScore');
        $auth = $this->Api->isExistBytokenandId($_GET['login_token'],$_GET['user_id']);
        if($auth == true){
          $this->loadModel('Items');
if($_GET['score']==0){

          $items = $this->Items->find('all')->select(['id','item_title','image','score'])->where(['Items.score >='=> $_GET['start_range'], 'Items.score <='=> $_GET['end_range']])->order(['Items.id'=>'DESC'])->hydrate(false)->toArray();
}else{
$userscoredata=$this->UsersScore->find('all')->where(['UsersScore.user_id'=>$_GET['user_id'] ])->hydrate(false)->toArray();
  
          $items = $this->Items->find('all')->select(['id','item_title','image','score'])->where(['Items.score <='=>$userscoredata[0]['score']])->order(['Items.id'=>'DESC'])->hydrate(false)->toArray();
}
          if($items){
            foreach ($items as $key => $value) {
              $items[$key]['image'] = !empty($value['image'])? Router::url('/img/uploads/'.$value['image'], true) : '' ; 
            }
            $response['statuscode']=200;
            $response['success']="Items Listing";
            $response['items'] = $items;
          }else{
            $response['statuscode']=552;
            $response['items'] = "No Records Found";      
          }
        }else{
          $response['statuscode']=551;
          $response['error']="Token Not Matched";
        }
      }else{
        $response['statuscode']=550;
        $response['error']="Invalid method request";
      }
      echo json_encode($response);die;
    }

}
