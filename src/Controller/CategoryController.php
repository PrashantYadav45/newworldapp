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
class CategoryController extends AppController
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
date_default_timezone_set('Asia/Hong_Kong');
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        
        $query = $this->Category->find('search', $this->Category->filterParams($this->request->query));
        $category = $this->paginate($query);
        if(!empty($this->request->query))
        {
            if(count($category)>0)
            {
                $this->set(compact('category'));
                $this->set('_serialize', ['category']); 
            }
       }
        else
        {
        $this->set(compact('category'));
        $this->set('_serialize', ['category']); 
        }
        
    }
    
    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        
        $category = $this->Category->newEntity();
        if ($this->request->is('post')) {
            $post_data=$this->request->data;
//            $post_data['created']=Time::parseDateTime(date("Y-m-d H:i:s"), 'yyyy/MM/dd HH:mm:ss');
 $post_data['created']=date("Y-m-d H:i:s");
            $category = $this->Category->patchEntity($category, $post_data);
            if ($this->Category->save($category)) {                
                    $this->Flash->success(__('Category Added Successfully'));                
                    return $this->redirect(['controller'=>'Category','action' => 'index']);
            }else{
                $this->Flash->error(__('The Category could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('category'));
        $this->set('_serialize', ['category']);
       
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
            $category = $this->Category->get($id, [
                'contain' => []
            ]);
            
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
		    $post_data=$this->request->data;

            $category = $this->Category->patchEntity($category, $post_data);
            if ($this->Category->save($category)) {                
                $this->Flash->success(__('The category has been updated.'));                
                return $this->redirect(['controller'=>'category','action' => 'index']);              
            } else {
                $this->Flash->error(__('The category could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('category'));
        $this->set('_serialize', ['category']);
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
