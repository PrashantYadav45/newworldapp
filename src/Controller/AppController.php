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

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Routing\Router;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    
 
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

         $this->loadComponent('Auth', [
            
            'loginRedirect' => [
                'controller' => 'Dashboard',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login'
                
            ],
            'authenticate' => [
            'Form' => [
                'fields' => ['username' => 'email', 'password' => 'password'],
                'passwordHasher' => ['className' => 'Legacy',]
            ]
            ]
        ]);



    }



    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
        if(!empty($this->Auth->user('id'))){
	    $this->set('user_login_id',$this->Auth->user('id'));
            $this->set('user_name',$this->Auth->user('name'));
        }
    }

    public function isAuthorized($user)
    {

        // Admin can access every action
        if (isset($user['role_id']) && $user['role_id'] == 1) {

            return true;
        }

        // Default deny
        return false;
    }

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['forgotPass','resetPass','checkEmailExist','display']);

    }

    function upload_image($dest,$file,$oldfile=NULL) {       
        $dest = realpath($dest);
        $name = str_replace(' ','_',$file['name']);
        $name = explode('.',$name);
        $name[0] = $name[0].'-'.time();
        $name = $name['0'].'.'.end($name);
        $location = $dest.'/'.$name;
        if(copy($file['tmp_name'],$location)) {
            if($oldfile) {
                unlink($dest.'/'.$oldfile);
            }
            return $name;
        }
    }

public function upload_image1($content=null,$imgname=null,$dest=null,$extn=null){
        if($content){
                $dataarray=explode('base64,', $content);
                if(count($dataarray)==2){
                    $extn=explode('/', $dataarray[0]);
                    if(count($extn)==2){
                        $extn=rtrim($extn[1],';');
                        if($extn){
                            $img_name = $imgname."-".time();
                            $data = $dataarray[1];
                            $data = str_replace(' ', '+', $data);
                            $data = base64_decode($data);
                            file_put_contents($dest.$img_name.".".$extn, $data);
                            chmod($dest.$img_name.".".$extn, 0777);
                            return $img_name.".".$extn;
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                }else{
                    return false;   
                }
        }else{
            return false;
        }
    }

    public function resize($uploadedfile,$filename,$ext,$width,$height,$newwidth,$newheight){
        if(strtolower($ext) == 'png') {
            $src = imagecreatefrompng($uploadedfile);
        }else if(strtolower($ext) == 'gif') {
            $src = imagecreatefromgif($uploadedfile);
        }else{
            $src = imagecreatefromjpeg($uploadedfile);
        }
        $tmp=imagecreatetruecolor($newwidth,$newheight);
        imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
        $filename = '/var/www/html/newworld/webroot/img/uploads/'.$filename;
        $imgUpload = imagejpeg($tmp, $filename,100);
        chmod($filename,0777);
        imagedestroy($src);
        imagedestroy($tmp);
        return "true";
    }

     
   









}
