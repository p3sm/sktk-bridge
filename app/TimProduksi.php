<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class TimProduksi extends Model
{
  use SoftDeletes;

  protected $connection = 'mysql';
  protected $table = 'tim_produksi';
  protected $primaryKey = 'id';

  public static function boot() {
    parent::boot();
    
    static::deleted(function($obj) {
      $obj->deleted_by = Auth::id();
      $obj->save();
    });
  }

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
    
  public function kota()
  {
    return $this->belongsTo('App\Kota', 'kota_id');
  }
    
  public function level()
  {
    return $this->belongsTo('App\TimProduksiLevel', 'level_id');
  }
    
  public function marketing()
  {
    return $this->hasMany('App\TimMarketing', 'tim_produksi_id');
  }
    
  public function users()
  {
    return $this->hasMany('App\User', 'team_id');
  }
}
