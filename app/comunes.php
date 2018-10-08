<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class comunes extends Model
{
    protected $table = 'comunes';
	public $primaryKey = 'id';

    function getEmails()
    {
        $this->emails = $this->hasMany('App\emails','rel_id','id')->where('rel_tipo', '=', '1')->get();
    }
}
