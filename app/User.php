<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table =  'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'name',
        'last_login',
        'role_id',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function role()
    {
      return $this->belongsTo('App\Role');
    }
    
    public function team()
    {
      return $this->belongsTo('App\TimProduksi', 'team_id');
    }
    
    public function asosiasi()
    {
      return $this->hasOne('App\UserAsosiasi');
    }
    
    public function pjk()
    {
      return $this->belongsTo('App\PjkLpjk', 'pjk_lpjk_id');
    }
    
    public function produksi()
    {
      return $this->belongsTo('App\TimProduksi', 'team_id');
    }
    
    public function marketing()
    {
      return $this->belongsTo('App\TimMarketing', 'marketing_id');
    }

    public function myAsosiasi()
    {
      if($this->tipe_akun == 1){
        return $this->asosiasi ? $this->asosiasi->detail : null;
      } else if ($this->tipe_akun == 2){
        return $this->produksi->pjk->badanUsaha->asosiasi;
      } else if ($this->tipe_akun == 3) {
        return $this->marketing->produksi->pjk->badanUsaha->asosiasi;
      } else {
        return $this->asosiasi ? $this->asosiasi->detail : null;
      }
    }

    public function myProvinsi()
    {
      // if($this->tipe_akun == 1){
      //   return $this->asosiasi ? $this->asosiasi->provinsi : null;
      // } else if ($this->tipe_akun == 2){
      //   return $this->produksi->provinsi;
      // } else if ($this->tipe_akun == 3) {
      //   return $this->marketing->provinsi;
      // } else {
      //   return $this->asosiasi ? $this->asosiasi->provinsi : null;
      // }
      return $this->asosiasi ? $this->asosiasi->provinsi : null;
    }

    public function myTeam()
    {
      if($this->tipe_akun == 1){
        return null;
      } else if ($this->tipe_akun == 2){
        return $this->produksi;
      } else if ($this->tipe_akun == 3) {
        return $this->marketing->produksi;
      } else {
        return null;
      }
    }
}
