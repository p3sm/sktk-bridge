<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BidangSub extends Model
{
  protected $table = 'master_bidang_sub';

  protected $primaryKey = 'id_sub_bidang';

  protected $casts = ['id_sub_bidang' => 'string'];

  public function bidang()
  {
    return $this->belongsTo('App\Bidang', 'bidang_id');
  }
}
