<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Manager;
use Cake\ORM\TableRegistry;
/**
 * Users Model
 *
 */
class ApiTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('users');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
      }


     
    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        //$rules->add($rules->isUnique(['username']));
        return $rules;
    }

 public function isExistEmail($email,$role=null,$password=null){
    
          if($role){
            $condition = array(
                         
                          'email'=>$email,
                          'role'=>$role
                       );
           }
            else if($password){

            $password = md5($password);
             $condition = array(
                         
                          'email'=>$email,
                          'password'=>$password
                       );
           }else{
               $condition = array(
                          'email'=>$email
                       );
           }
             
              $data=$this->find('all')->where($condition)->toArray();
              if(count($data)>0){
                 return true;
                  }else{  

                    return false;
                  }

  }
  

public function validateRegister($data=null){
       $error=array('error'=>false);
        $reg='/^[A-Za-z0-9 _]+$/';
        $latlong='/^[0-9.+-]+$/';
        $regex = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i"; 
        $regphone = "/^[1-9][0-9]*/";
        if (!isset($data['email']) || strlen(trim($data['email'])) <= 0) {
                $error['error']=true;
                $error['statuscode']=302;
                $error['msg']="Please enter the email.";
            }else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                    $error['error']=true;
                    $error['statuscode']=406;
                    $error['msg']="Please enter valid email.";
            }else if (!preg_match($regex, $data['email'])){
                    $error['error']=true;
                    $error['statuscode']=406;
                    $error['msg']="Please enter valid email.";
            }else if($this->isExistEmail($data['email'])){
                    $error['error']=true;
                    $error['statuscode']=401;
                    $error['msg']="Email is already registered.";
             }else if (!isset($data['name']) || strlen(trim($data['name'])) <= 0){
                $error['error']=true;
                $error['statuscode']=303;
                $error['msg']="Please enter the name.";
            }else if (strlen($data['name'])<2 || strlen($data['name'])>20){
                    $error['error']=true;
                    $error['statuscode']=404;
                    $error['msg']="Name should be within 2-20 characters.";
            }else if (!preg_match($reg,$data['name'])){
                    $error['error']=true;
                    $error['statuscode']=405;
                    $error['msg']="Please enter valid name.";
            }else if(!isset($data['password']) || strlen(trim($data['password'])) <= 0){
                $error['error']=true;
                $error['statuscode']=304;
                $error['msg']="Please enter the password.";
            }else if(preg_match('/\s/',$data['password'])){
              $error['error']=true;
              $error['statuscode']=356;
              $error['msg']="Please enter the valid password.";
              }else if(!isset($data['contact_no'])){
                $error['error']=true;
                $error['msg'] = 'Contact number is required.';
                $error['statuscode'] = 313;
            }else if(!preg_match($regphone, $data['contact_no']) && !empty($data['contact_no'])){ 
                $error['error']=true; 
                $error['statuscode']=409;
                $error['msg']="Please enter valid contact number.";
            }else if(strlen($data['contact_no'])!=10 && !empty($data['contact_no'])){  
                $error['error']=true;
                $error['statuscode']=408;
                $error['msg']="Contact number should be of 10 digit long.";
            }else if (strlen($data['password'])<6 || strlen($data['password'])>18){
                    $error['error']=true;
                    $error['statuscode']=410;
                    $error['msg']="Password should be within 6-18 characters long.";
            }else if(!isset($data['role']) || strlen(trim($data['role'])) <= 0){
                $error['error']=true;
                $error['statuscode']=305;
                $error['msg']="User role is required.";
            }else if (!in_array($data['role'], array('user'))){
                    $error['error']=true;
                    $error['statuscode']=413;
                    $error['msg']="User role is not valid.";
            }else if (!isset($data['profile_pic']) || strlen(trim($data['profile_pic'])) <= 0){
                $error['error']=true;
                $error['statuscode']=303;
                $error['msg']="Please enter the Profile Picture.";
            }else if (!isset($data['device_id']) || empty($data['device_id'])) {
                $error['error']=true;
                $error['statuscode']=723;
                $error['msg']="Please enter the device id.";
            }else if(!isset($data['role']) || strlen(trim($data['role'])) <= 0){
                $error['error']=true;
                $error['statuscode']=305;
                $error['msg']="User role is required.";
            }else if (!in_array($data['role'], array('user'))){
                    $error['error']=true;
                    $error['statuscode']=413;
                    $error['msg']="User role is not valid.";
            }
           
            else{
                $error['error']=false;
            }
        
        return $error;
    }




public function validate_login($login_data){  
                   $error = array();
                   if(empty($login_data['email'])){
                    $error['msg'] = 'Please enter the email.';
                    $error['statuscode'] =  302;
                    }else if (!filter_var($login_data['email'], FILTER_VALIDATE_EMAIL)){
                    $error['error']=true;
                    $error['statuscode']=406;
                    $error['msg']="Please enter valid email.";
                    }else if(empty($login_data['password'])){
                    $error['msg'] = 'Please enter the password.';
                    $error['statuscode'] =  304;
                    }
		    //else if(empty($login_data['role'])){
                    //$error['statuscode']=305;
                    //$error['msg']="Please enter the user role.";
                    //}
		    //else if (!isset($login_data['device_id']) || empty($login_data['device_id'])) {
                    //$error['error']=true;
                    //$error['statuscode']=723;
                    //$error['msg']="Please enter the device id.";
                    //}
		    //else if (!in_array($login_data['role'], array('user'))){
                   // $error['error']=true;
                    //$error['statuscode']=413;
                    //$error['msg']="User role is not valid.";
                     //}
                   else{                              
                           $error_DB = $this->isExistEmail($login_data['email'],null,$login_data['password']);
                           //print_r($error_DB);die;

                          if(!$error_DB){                                   
                            $error['statuscode'] = 421;
                            $error['msg'] = 'Invalid email or password.'; 
                        }
                        else{

                           
                              $error["statuscode"]= 200;
                              
                          }
                        
                  }
                  return $error;
                }


  /**
   * Used to verify the token for api request
   **/
  public function isExistBytoken($token){
    $data = $this->find()->where(['login_token' => $token])->count();
    if($data == 1){ 
        return true ;
    }else{
        return false ;       
    }
  }

  public function isExistBytokenandId($token,$user_id){
 //return true ;
    $data = $this->find()
    ->where(['login_token' => $token])
    ->where(['id' => $user_id])
    ->count();
    if($data == 1){ 
        return true ;
    }else{
        return false ;       
    }
  }
   public function validate_user($token){
    $data = $this->find()->where(['login_token' => $token,'OR' => [['role_id' => 1], ['role_id' => 2]]])->count();
 //print_r($data);die;
    if($data == 1){ 
        return true ;
    }else{
        return false ;       
    }
  }
  /**
   * Used to validate the data for api request
   **/
  public function validateChessman($data){
    $response = array();
      if( !isset( $data['title'] ) || empty( $data['title'] ) ) {
          $response['statuscode'] = 201;
          $response['error'] = 'Please add the title';
      }else if( !isset( $data['password'] ) || empty( $data['password'] ) ) {
          $response['statuscode'] = 202;
          $response['error'] = 'Please add the password';
      }else if( !isset( $data['terms_condition'] ) || empty( $data['terms_condition'] ) ) {
          $response['statuscode'] = 203;
          $response['error'] = 'Please add the terms and condition';
      }else if (!isset( $data['user_id'] ) || count($data['user']) < 2) {
          $response['statuscode'] = 204;
          $response['error'] = 'Users should be greater than or equal to 2' ;
      }else if (!isset( $data['user_id'] ) || count($data['user']) > 10 ) {
          $response['statuscode'] = 211;
          $response['error'] = 'Users should be less than or equal to 10' ;
      }else if (!isset( $data['score'] ) || count($data['score']) == 0) {
          $response['statuscode'] = 205;
          $response['error'] = 'Please add a score' ;
      }else if (!isset( $data['position'] ) || count($data['position']) == 0) {
          $response['statuscode'] = 206;
          $response['error'] = 'Please add a position' ;
      }else if (!isset( $data['bonus'] ) || count($data['bonus']) == 0) {
          $response['statuscode'] = 207;
          $response['error'] = 'Please add a bonus' ;
      }else if(ctype_digit(implode('',$data['user'])) != 1){
          $response['statuscode'] = 208;
          $response['error'] = 'user id should be numeric' ;
      }else if(ctype_digit(implode('',$data['score'])) != 1){
          $response['statuscode'] = 209;
          $response['error'] = 'score should be numeric' ;
      }else if(ctype_digit(implode('',$data['bonus'])) != 1){
          $response['statuscode'] = 210;
          $response['error'] = 'bonus should be numeric' ;
      }else{
          $response['statuscode'] = 200;
          $response['error'] = 'success' ;
      }
      return $response;
  }

 /**
   * Used to validate user score api request
   **/
  public function userScoreValidate($data){
    $response = array();
      if(!isset($data['user_id'] ) || count($data['user_id']) == 0) {
          $response['statuscode'] = 541;
          $response['error'] = 'Users cannot be empty' ;
      }else if(!isset( $data['score'] ) || count($data['score']) == 0) {
          $response['statuscode'] = 542;
          $response['error'] = 'Please add a score' ;
      }else if (!isset( $data['item_id'] ) || count($data['item_id']) == 0) {
          $response['statuscode'] = 543;
          $response['error'] = 'Item cannot be empty' ;
      }else if(empty($data['user_id']) || !is_numeric($data['user_id']) ){
          $response['error'] = 'Invalid User ID.';
          $response['statuscode'] = 544;
      }else if(empty($data['score']) || !is_numeric($data['score']) ){
          $response['error'] = 'Invalid score.';
          $response['statuscode'] = 545;
      }else if(empty($data['item_id']) || !is_numeric($data['item_id']) ){
          $error['error'] = 'Invalid Item ID.';
          $error['statuscode'] = 546;
      }else{
          $response['statuscode'] = 200;
          $response['error'] = 'success' ;
      }
      return $response;
  }


 /**
   * function used to update user score validation
   **/
  public function updateUserScoreValidate($data){
    $response = array();
    if(!isset($data['user_id'] ) || count($data['user_id']) == 0) {
          $response['statuscode'] = 541;
          $response['error'] = 'Users cannot be empty' ;
      }else if(!isset( $data['score'] ) || count($data['score']) == 0) {
          $response['statuscode'] = 542;
          $response['error'] = 'Please add a score' ;}
     /* }else if(!isset( $data['score_id'] ) || count($data['score_id']) == 0) {
          $response['statuscode'] = 543;
          $response['error'] = 'Score id cannot be empty' ;
      }*/else if(!isset( $data['game_id'] ) || count($data['game_id']) == 0) {
          $response['statuscode'] = 547;
          $response['error'] = 'game id cannot be empty' ;
      }else if(empty($data['user_id']) || !is_numeric($data['user_id']) ){
          $response['error'] = 'Invalid User ID.';
          $response['statuscode'] = 544;
      }else if(empty($data['score']) || !is_numeric($data['score']) ){
          $response['error'] = 'Invalid score.';
          $response['statuscode'] = 545;}
      /*}else if(empty($data['score_id']) || !is_numeric($data['score_id']) ){
          $response['error'] = 'Invalid score id.';
          $response['statuscode'] = 546;
      }*/else if(empty($data['game_id']) || !is_numeric($data['game_id']) ){
          $response['error'] = 'Invalid game id.';
          $response['statuscode'] = 548;
      }else{
          $response['statuscode'] = 200;
          $response['error'] = 'success' ;
      }
      return $response;
  }


  



}
