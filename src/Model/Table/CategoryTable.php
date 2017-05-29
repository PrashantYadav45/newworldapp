<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Manager;

/**
 * Users Model
 *
 */
class CategoryTable extends Table
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
        $this->table('category');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Search.Search');
         }

    public function searchConfiguration()
    {
        $search = new Manager($this);
            $search->like('cat_name', [
                'before' => true,
                'after' => true,
                'field' => [$this->aliasField('cat_name')]
            ])
            ->callback('foo', [
                'callback' => function ($query, $args, $manager) {
                    // Modify $query as required
                }
            ]);

        return $search;
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
}
