<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalRegTtSync extends Model
{
  protected $connection = 'mysql';
  protected $table = 'personal_reg_tt_sync';
  protected $primaryKey = 'id';
}
