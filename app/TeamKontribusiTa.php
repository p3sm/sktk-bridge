<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamKontribusiTa extends Model
{
  protected $connection = 'mysql';
  protected $table = 'team_kontribusi_ahli';
  protected $primaryKey = 'id';
  
  public $timestamps = false;
    
  public function team()
  {
    return $this->belongsTo('App\Team', 'team_id');
  }
    
  public function provinsi()
  {
    return $this->belongsTo('App\SikiPropinsi', 'id_propinsi_reg');
  }
}
