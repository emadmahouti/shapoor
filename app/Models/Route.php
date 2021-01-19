<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Visitor
 * @property integer id
 * @property string title
 * @property string link
 * @property string created_at
 * @property string updated_at
 */
class Route extends  Model
{
    protected $table = 'routes';
}