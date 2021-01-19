<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Message
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $text
 * @property string $phone_number
 * @property string $created_at
 * @property string $updated_at
 */
class Message extends Model
{
    protected $table = "messages";

    protected $hidden = ['id', 'user_id', 'updated_at'];
}