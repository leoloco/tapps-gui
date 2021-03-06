<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tapp Entity
 *
 * @property int $id
 * @property string $tpid
 * @property string $name
 * @property string $version_latest
 * @property string $cdn_uri
 * @property string $cdn_login
 * @property string $cdn_password
 * @property int $user_id
 * @property string $type
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Ownership[] $ownerships
 */
class Tapp extends Entity
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
