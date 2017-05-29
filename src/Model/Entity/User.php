<?php
namespace App\Model\Entity;
use App\Auth\LegacyPasswordHasher ;
use Cake\ORM\Entity;
class User extends Entity
{

    // Make all fields mass assignable except for primary key field "id".
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    protected function _setPassword($password){
       // prx($password);
    	   // return md5($password);
        return (new LegacyPasswordHasher)->hash($password);
    }

    
}