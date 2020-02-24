<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CMS_Account extends Model
{
    protected $table = 'cms_account';

    public $timestamps = false;

    protected $primaryKey = 'int_id';
}