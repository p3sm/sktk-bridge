<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PengajuanHapus99 extends Model
{
  protected $table = 'pengajuan_delete_99';
    
  public function user()
  {
    return $this->belongsTo('App\User', 'created_by');
  }
}
