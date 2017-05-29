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
class ItemsController extends AppController
{

    public $components = array('Paginator');
    public $paginate = array(
        'limit' => 10,
        'order' => [
            'Users.id' => 'desc'
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
        if(!empty($this->request->data) && !empty($this->request->data['range'])) {
            $ran = explode('-', $this->request->data['range']);
           // echo "<pre>";print_r($ran);die;
            $this->paginate = array('conditions'=>array('Items.score >= '=>$ran[0],'Items.score <= '=>$ran[1]),'limit' => 10);
            $item = $this->paginate('Items')->toArray();
        }else{
            $query = $this->Items->find('search', $this->Items->filterParams($this->request->query));
            $item = $this->paginate($query);
        }
        $this->set(compact('item'));

    }
    

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        
        $item = $this->Items->get($id, [
            'contain' => []
        ]);
        $this->set('item', $item);
        $this->set('_serialize', ['item']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        
        $item = $this->Items->newEntity();
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
                          //  $result = $this->resize($file['tmp_name'],$logo_image,$ext,$width,$height,$n_width,$n_height);
                        }
                    }else{
                        $this->Flash->error(__('Invalid Image Size. Image must be atleast 85X70.','error'));
                        return $this->redirect(['action' => 'add']);
                    }
                }else{
                    $this->Flash->error(__('Invalid Image format. Allowed Format(gif,png ,jpg,jpeg).','error'));
                    return $this->redirect(['action' => 'add']);
                } 
            }
$post_data['createdAt']=date("Y-m-d H:i:s");
           // $post_data['createdAt']=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
            $item = $this->Items->patchEntity($item, $post_data);
            if ($this->Items->save($item)) {                
                    $this->Flash->success(__('Gift Added Successfully'));                
                    return $this->redirect(['controller'=>'items','action' => 'index']);
            }else{
                $this->Flash->error(__('The Gift could not be saved. Please, try again.'));
            }
        }
         $this->set(compact('item'));
        $this->set('_serialize', ['item']);
       
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if(!empty($id)){
            $item = $this->Items->get($id, [
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
           
            $item = $this->Items->patchEntity($item, $post_data);
            if ($this->Items->save($item)) {                
                $this->Flash->success(__('The Gift has been updated.'));                
                return $this->redirect(['controller'=>'items','action' => 'index']);              
            } else {
                $this->Flash->error(__('The gift could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('item'));
        $this->set('_serialize', ['item']);
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
        $item = $this->Items->get($id);
        if ($this->Items->delete($item)) {          
            $this->Flash->success(__('The item has been deleted.'));        
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }
        
            return $this->redirect(['action' => 'index']); 
       
       
    }

    





}
