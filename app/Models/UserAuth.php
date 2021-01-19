<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\User
 *
 * @property integer $id
 * @property integer $user_id
 * @property boolean $active
 * @property string $jwt_token
 * @property string $last_login
 * @property string $created_at
 * @property string $updated_at
 */
class UserAuth extends Model
{
    protected $table = 'user_auth_token';


    protected function user() {
        return $this->belongsTo('App\Models\User');
    }
}