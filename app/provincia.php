<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class provincia extends Model
{
	protected $table = 'provincias';
	public $primaryKey = 'id';

    function getEmails()
    {
        $this->emails = $this->hasMany('App\emails','rel_id','id')->where('rel_tipo', '=', '0')->get();
    }
}
