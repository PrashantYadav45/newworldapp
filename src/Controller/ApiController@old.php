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

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Network\Email\Email;
use Cake\Routing\Router;
use Cake\Event\Event;
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
       
	 public function beforeFilter(Event $event) 
     	  {
        	parent::beforeFilter($event);
        	$this->Auth->allow();

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
                        $query_status=$this->Users->updateAll(array('login_token'=>uniqid(),'device_id'=>$_POST['device_id']),array('email'=>$_POST['email']));
                              $error_DB=$this->Users->find()->select(['id','name','email','contact_no','login_token','device_id','profile_pic'])->where(array('email'=>$_POST['email']))->toArray();
                              $error["statuscode"]= 200;
                              $error["msg"]= "User has been login successfully.";
                              $error['data'] = $error_DB[0];
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
                    $error['msg'] = 'Please enter the email.';
                    }else if (!filter_var($login_data['email'], FILTER_VALIDATE_EMAIL)){
                    $error['error']=true;
                    $error['statuscode']=406;
                    $error['msg']="Please enter valid email.";
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







}
