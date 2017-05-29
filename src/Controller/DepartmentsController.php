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
class DepartmentsController extends AppController
{

    public $components = array('Paginator');
    public $paginate = array(
        'limit' => 10,
        'order' => [
            'Departments.id' => 'desc'
        ]
    );

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Search.Prg', [
            'actions' => ['index']
        ]);
        $this->viewBuilder()->layout('admin');
 //date_default_timezone_set('Asia/Calcutta');
date_default_timezone_set('Asia/Hong_Kong');
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
 
        $query = $this->Departments->find('search', $this->Departments->filterParams($this->request->query));
        $departments = $this->paginate($query)->toArray();
        $this->set(compact('departments'));
    }
    

    public function delete($id = null) {

    $this->request->allowMethod(['post', 'delete']);
    $Departments = $this->Departments->get($id);
    if ($this->Departments->delete($Departments)) {          
    $this->Flash->success(__('The Department has been deleted.'));        
    } else {
    $this->Flash->error(__('The Department could not be deleted. Please, try again.'));
    }

    return $this->redirect(['action' => 'index']); 

    }




     public function edit($id = null)
    {
        $this->loadModel('Departments');
        if(!empty($id)){
         $Departments = $this->Departments->get($id, [
        'contain' => []
            ]); 
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $post_data=$this->request->data;

            if(!empty($post_data['image']['name'])){
                $dest='../webroot/img/uploads';
                $file = $post_data['image'];
                $dimension=getimagesize($file['tmp_name']);
                $allowed =  array('gif','png' ,'jpg','jpeg','JPG');
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $width=$dimension[0];
                $height=$dimension[1];

                if(in_array($ext, $allowed)){
                    if($width > 100 && $height > 80){
                        $logo_image = $this->upload_image($dest,$file,'');
                        chmod($dest.'/'.$logo_image,0777);
                        $post_data['image'] = $logo_image;
                        if(is_uploaded_file($file['tmp_name'])) {
                            $n_height=200;
                            $ratio=($width/$height);
                            $n_width=$ratio*$n_height;
                           // $result = $this->resize($file['tmp_name'],$logo_image,$ext,$width,$height,$n_width,$n_height);
                        }
                    }else{
                        $this->Flash->error(__('Invalid Image Size. Image must be atleast 85X70.','error'));
                        return $this->redirect(['action' => 'edit',$id]);
                    }
                }else{
                    $this->Flash->error(__('Invalid Image format. Allowed Format(gif,png ,jpg,jpeg).','error'));
                    return $this->redirect(['action' => 'edit',$id]);
                } 
            }else{
                $post_data['image'] = $post_data['image1'] ;
            }
           
            $Departments = $this->Departments->patchEntity($Departments, $post_data);
            if ($this->Departments->save($Departments)) {                
                $this->Flash->success(__('The Department has been updated.'));                
                return $this->redirect(['controller'=>'Departments','action' => 'index']);              
            } else {
                $this->Flash->error(__('The Department could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('Departments'));
        $this->set('_serialize', ['Departments']);
    }



   public function adddepartment(){
    //die('hi');
      $this->loadModel('Departments');
            $Departments = $this->Departments->newEntity();
            $Departments->admin = $this->Auth->user('id');

        if ($this->request->is('post')) {
            $post_data=$this->request->data;

            if(!empty($post_data['image']['name'])){
                $dest='../webroot/img/uploads';
                $file = $post_data['image'];
                $dimension=getimagesize($file['tmp_name']);
                $allowed =  array('gif','png' ,'jpg','jpeg','JPG');
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $width=$dimension[0];
                $height=$dimension[1];

                if(in_array($ext, $allowed)){
                    if($width > 100 && $height > 80){
                        $logo_image = $this->upload_image($dest,$file,'');
                        chmod($dest.'/'.$logo_image,0777);
                        $post_data['image'] = $logo_image;
                        if(is_uploaded_file($file['tmp_name'])) {
                            $n_height=200;
                            $ratio=($width/$height);
                            $n_width=$ratio*$n_height;
                           // $result = $this->resize($file['tmp_name'],$logo_image,$ext,$width,$height,$n_width,$n_height);
                        }
                    }else{
                        $this->Flash->error(__('Invalid Image Size. Image must be atleast 85X70.','error'));
                        return $this->redirect(['action' => 'index']);
                    }
                }else{
                    $this->Flash->error(__('Invalid Image format. Allowed Format(gif,png ,jpg,jpeg).','error'));
                    return $this->redirect(['action' => 'index']);
                } 
            }

            $alldata= $this->request->data;
            $Departments = $this->Departments->patchEntity($Departments, $post_data);
            if ($this->Departments->save($Departments)) {                
                    $this->Flash->success(__('Department Added Successfully'));                
                    return $this->redirect(['action' => 'index']);
            }else{
                $this->Flash->error(__('The Department could not be saved. Please, try again.'));

        }
    }




}
    }
