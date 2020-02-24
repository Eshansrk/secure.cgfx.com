<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CMS_Iblevel extends Model
{
    protected $table = 'cms_ib_level';

    protected $fillable = [ 'parent_ib', 'child_ib', 'level' ];

    public $timestamps = false;

    protected $primaryKey = 'intid';
}
