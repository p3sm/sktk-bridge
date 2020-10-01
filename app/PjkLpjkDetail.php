<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PjkLpjkDetail extends Model
{
  protected $table = 'pjk_lpjk_detail';
    
  public function parent()
  {
    return $this->belongsTo('App\PjkLpjk', 'pjk_lpjk_id');
  }
}
