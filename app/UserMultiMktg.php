<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMultiMktg extends Model
{
  protected $connection = 'mysql';
  protected $table = 'user_multi_mktg';
  protected $primaryKey = 'id';
  public $timestamps = false;
    
  public function user()
  {
    return $this->belongsTo('App\User');
  }
  
  public function mktg()
  {
    return $this->belongsTo('App\TimMarketing', 'team_id');
  }
}
