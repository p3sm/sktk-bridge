<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalRegTaDeleted extends Model
{
  protected $table = 'personal_reg_ta_deleted';

  public function personal()
  {
    return $this->belongsTo('App\Personal', 'ID_Personal');
  }
    
  public function asosiasi()
  {
    return $this->belongsTo('App\Asosiasi', 'ID_Asosiasi_Profesi');
  }
    
  public function ustk()
  {
    return $this->belongsTo('App\Ustk', 'id_unit_sertifikasi');
  }
    
  public function kualifikasi()
  {
    return $this->belongsTo('App\Kualifikasi', 'ID_Kualifikasi');
  }
    
  public function provinsi()
  {
    return $this->belongsTo('App\Provinsi', 'ID_Propinsi_reg');
  }
    
  public function user()
  {
    return $this->belongsTo('App\User', 'created_by');
  }
}
