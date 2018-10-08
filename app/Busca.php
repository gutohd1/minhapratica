<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Busca extends Eloquent {

     //protected $connection = 'mongodb';
	protected $connection = 'mongodb';
	protected $collection = 'buscas';

}