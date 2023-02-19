<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Package extends Model
{
    protected $collection = "packages";
    protected $connection = 'mongodb';
    protected $table = "packages";
    protected $primaryKey = "_id";
    protected $guarded = [];
}
