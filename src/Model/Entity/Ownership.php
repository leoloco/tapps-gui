<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Ownership Entity
 *
 * @property int $id
 * @property int $device_id
 * @property int $user_id
 * @property int $tapp_id
 * @property \Cake\I18n\FrozenTime $creation_date
 * @property \Cake\I18n\FrozenTime $modified_date
 * @property string $href
 * @property bool $activation
 *
 * @property \App\Model\Entity\Device $device
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Tapp $tapp
 */
class Ownership extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
