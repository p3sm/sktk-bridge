<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimProduksi extends Model
{
  protected $connection = 'mysql';
  protected $table = 'tim_produksi';
  protected $primaryKey = 'id';
    
  public function parent()
  {
    return $this->belongsTo('App\TimProduksi', 'parent_id');
  }

  public function pjk()
  {
    return $this->belongsTo('App\PjkLpjk', 'pjk_lpjk_id');
  }

  public function jenis_usaha()
  {
    return $this->belongsTo('App\JenisUsaha', 'jenis_usaha_id');
  }
    
  public function provinsi()
  {
    return $this->belongsTo('App\Provinsi', 'provinsi_id');
  }
    
  public function level()
  {
    return $this->belongsTo('App\TimProduksiLevel', 'level_id');
  }
    
  public function marketing()
  {
    return $this->hasMany('App\TimMarketing', 'tim_produksi_id');
  }
}
