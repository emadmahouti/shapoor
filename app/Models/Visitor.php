<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Visitor
 * @property integer id
 * @property string document
 * @property string referrer
 * @property string address
 * @property string created_at
 * @property string updated_at
 */
class Visitor extends Model
{
    protected $table = 'visitors';
}