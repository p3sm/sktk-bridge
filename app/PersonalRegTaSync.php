<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalRegTaSync extends Model
{
  protected $connection = 'mysql';
  protected $table = 'personal_reg_ta_sync';
  protected $primaryKey = 'id';
}
