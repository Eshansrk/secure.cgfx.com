<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'cms_liveaccount';

    protected $fillable = [ 'fname','lname','email'];
	
	protected $primaryKey = "intId";
    
    protected $hidden = [
        'password', 'remember_token',
    ];
}
