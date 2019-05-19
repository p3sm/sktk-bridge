<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SikiRegta extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'personal_reg_ta';
  protected $primaryKey = 'ID_Registrasi_TK_Ahli';
    
  public function personal()
  {
    return $this->belongsTo('App\SikiPersonal', 'ID_Personal');
  }
    
  public function sync()
  {
    return $this->hasOne('App\PersonalRegTaSync', 'registrasi_tk_ahli_id');
  }
}
