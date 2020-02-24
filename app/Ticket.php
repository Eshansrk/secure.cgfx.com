<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
	protected $table = 'tickets';
    protected $fillable = ['subject','description','user_id','ticket_status'];
}
