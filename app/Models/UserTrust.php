<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserTrust
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $trust_user_id
 * @property boolean $active
 * @property string $created_at
 * @property string $updated_at
 */
class UserTrust extends Model
{
    protected $table = "trust_user";


    function user() {
        return $this->belongsTo('App\Models\User');
    }
}