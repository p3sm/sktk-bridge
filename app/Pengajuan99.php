<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengajuan99 extends Model
{
  protected $table = 'pengajuan_99';
    
  public function user()
  {
    return $this->belongsTo('App\User', 'created_by');
  }
}
