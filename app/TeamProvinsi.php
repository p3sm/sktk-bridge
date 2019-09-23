<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamProvinsi extends Model
{
  protected $connection = 'mysql';
  protected $table = 'team_provinsi';
  protected $primaryKey = 'id';
    
  public function team()
  {
    return $this->belongsTo('App\Team', 'team_id');
  }
}
