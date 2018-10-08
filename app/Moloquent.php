<?php
namespace App;
 
use Moloquent;
 
/**
 * Category Model
 *
 * @author Hafiz Waheeduddin
 */
class Category extends Moloquent
{
 public function tasks()
 {
// return $this->hasMany('App\Models\Task', 'category_id');
 }
}