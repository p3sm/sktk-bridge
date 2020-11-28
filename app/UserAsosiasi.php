<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAsosiasi extends Model
{
  protected $connection = 'mysql';
  protected $table = 'user_asosiasi';
  protected $primaryKey = 'id';
  public $timestamps = false;
    
  public function user()
  {
    return $this->belongsTo('App\User');
  }
  
  public function apikey()
  {
    return $this->hasOne('App\AsosiasiKey', 'asosiasi_id');
  }

  public function detail()
  {
    return $this->belongsTo('App\Asosiasi', 'asosiasi_id');
  }
}
