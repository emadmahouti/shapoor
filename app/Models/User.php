<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\User
 *
 * @property integer $id
 * @property string $name
 * @property string $phone_number
 * @property boolean $active
 * @property integer $last_verify_code
 * @property string $last_verify_code_date
 * @property integer $last_seen
 * @property string $created_at
 * @property string $updated_at
 */
class User extends Model
{
    protected $table = 'user_auth';

    protected $hidden = [
        'last_verify_code',
        'last_verify_code_date',
        'updated_at'
    ];

    public function auth()
    {
        return
            $this->hasMany(UserAuth::class, 'user_id')
                ->orderByDesc('created_at');

    }


    public function messages()
    {
        return
            $this->hasMany(Message::class, 'user_id')
                ->orderByDesc('created_at');

    }

    public function limitMessages() {
            return $this->messages()->take(12);
    }
}