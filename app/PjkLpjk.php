<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PjkLpjk extends Model
{
  protected $table = 'pjk_lpjk';
    
  public function badanUsaha()
  {
    return $this->belongsTo('App\BadanUsaha', 'badan_usaha_id');
  }
    
  public function detail()
  {
    return $this->hasMany('App\PjkLpjkDetail', 'pjk_lpjk_id');
  }
}
