<?php
namespace App\Controller;
use Cake\Network\Email\Email;
use Cake\ORM\TableRegistry;
use App\Controller\AppController;
use Cake\Utility\Security;
use Cake\I18n\Time;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class GameRulesController extends AppController
{

    public $components = array('Paginator');
    public $paginate = array(
        'limit' => 10,
        'order' => [
            'id' => 'desc'
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


$this->loadModel('GameRules');
              $GameRules = $this->GameRules->newEntity();
        $query = $this->GameRules->find('all')->order(['id' => 'DESC']);
        $GameRules = $this->paginate($query);
        if(!empty($this->request->query))
        {
            if(count($GameRules)>0)
            {
                $this->set(compact('GameRules'));
                $this->set('_serialize', ['GameRules']); 
            }
       }
        else
        {


        $this->set(compact('GameRules'));

        $this->set('_serialize', ['GameRules']); 


        }
        



    }
    





    public function addrule(){

      $this->loadModel('GameRules');




    }

 public function add() {
        $this->loadModel('GameRules');
        $GameRules = $this->GameRules->newEntity();
        $users = TableRegistry::get('GameRules');
        $post_data=$this->request->data;
//echo"<pre>";print_r($post_data);die;

        $gametype =$post_data['game_type'];
      $ruletext=$post_data['rule_text'];
        $query = $this->GameRules->find('all')->where(['game_type' => $gametype])->order(['id' => 'DESC'])->hydrate(false)->toArray();

            if($query){
                    $query = $users->query();
                    if($query->update()
                    ->set(['rule_text' => $ruletext])
                    ->where(['game_type' => $gametype])
                    ->execute()){

                     $this->Flash->success(__('Rule Updated  Successfully'));

                    }else{
                    $this->Flash->error(__('The Rule could not be saved. Please, try again.'));
                    }

            }else{
                    $GameRules = $this->GameRules->patchEntity($GameRules, $post_data);

            if ($this->GameRules->save($GameRules)) {

                $this->Flash->success(__('Rule Added Successfully'));
                }else{
                $this->Flash->error(__('The Rule could not be saved. Please, try again.'));
                }

            }

            return $this->redirect(
            ['controller' => 'GameRules', 'action' => 'index']
            );



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
             $this->loadModel('GameRules');

        $this->request->allowMethod(['post', 'delete']);
        $GameRules = $this->GameRules->get($id);
        if ($this->GameRules->delete($GameRules)) {          
            $this->Flash->success(__('The Rule has been deleted.'));        
        } else {
            $this->Flash->error(__('The Rule  could not be deleted. Please, try again.'));
        }
        
            return $this->redirect(['action' => 'index']); 
       
       
    }



}
