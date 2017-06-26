<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tapps Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\HasMany $Ownerships
 *
 * @method \App\Model\Entity\Tapp get($primaryKey, $options = [])
 * @method \App\Model\Entity\Tapp newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Tapp[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tapp|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tapp patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Tapp[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tapp findOrCreate($search, callable $callback = null, $options = [])
 */
class TappsTable extends Table
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

        $this->setTable('tapps');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Ownerships', [
            'foreignKey' => 'tapp_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('version_latest', 'create')
            ->notEmpty('version_latest');

        $validator
            ->requirePresence('cdn_uri', 'create')
            ->notEmpty('cdn_uri');

        $validator
            ->requirePresence('cdn_login', 'create')
            ->notEmpty('cdn_login');

        $validator
            ->requirePresence('cdn_password', 'create')
            ->notEmpty('cdn_password');

        return $validator;
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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
