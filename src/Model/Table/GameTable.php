<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Manager;
/**
 * Users Model
 *
 */
class GameTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('game');
        
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->addBehavior('Search.Search');

        $this->hasMany('UserGamePlayed', [
            'foreignKey' => 'game_id',
            'dependent' => true
        ]);
        
        $this->hasMany('UsersScore', [
            'foreignKey' => 'game_id',
            'dependent' => true
        ]);

        $this->hasOne('Questions', [
            'foreignKey' => 'game_id',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);

        $this->hasOne('GameImages', [
            'foreignKey' => 'game_id',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);

        $this->belongsTo('Category', [
            'foreignKey' => 'cat_id',
            'joinType' => 'INNER'
        ]);
    }

    public function searchConfiguration() {
        $search = new Manager($this);
            $search->like('name', [
                'before' => true,
                'after' => true,
                'field' => [$this->aliasField('title')]
            ])
            ->callback('foo', [
                'callback' => function ($query, $args, $manager) {
                    
                }
            ]);

        return $search;
    }
}
