<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Ownerships Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Devices
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Tapps
 *
 * @method \App\Model\Entity\Ownership get($primaryKey, $options = [])
 * @method \App\Model\Entity\Ownership newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Ownership[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Ownership|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Ownership patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Ownership[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Ownership findOrCreate($search, callable $callback = null, $options = [])
 */
class OwnershipsTable extends Table
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

        $this->setTable('ownerships');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Devices', [
            'foreignKey' => 'device_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Tapps', [
            'foreignKey' => 'tapp_id',
            'joinType' => 'INNER'
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->dateTime('creation_date')
            ->allowEmpty('creation_date');

        $validator
            ->dateTime('modified_date')
            ->allowEmpty('modified_date');

        $validator
            ->allowEmpty('href');

        $validator
            ->boolean('activation')
            ->allowEmpty('activation');

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
        $rules->add($rules->existsIn(['device_id'], 'Devices'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['tapp_id'], 'Tapps'));

        return $rules;
    }
}
