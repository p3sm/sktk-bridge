<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
  protected $table = 'master_bidang';

  protected $primaryKey = 'id_bidang';

  protected $casts = ['id_bidang' => 'string'];

  public function sub()
  {
    return $this->hasMany('App\BidangSub', 'bidang_id');
  }
}
