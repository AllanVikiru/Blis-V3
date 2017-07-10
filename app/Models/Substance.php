<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
*This resource allows for a material to be represented. 
*The resource can be used to represent either a kind of a substance - 
*e.g. a formulation commonly used for treating patients, 
*or it can be used to describe a particular package of a known substance (e.g. bottle, jar, packet).
*/
class Substance extends Model
{
    public function Status()
    {
    	return $this->belongsTo('App\Models\Status');
    }

    public function Coding()
    {
    	return $this->belongsTo('App\Models\Coding');
    }
}
