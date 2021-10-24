<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {

  protected $table = 'transactions';
  public $timestamps = false;
  protected $primaryKey = 'id';

  protected $fillable = [
    'code',
    'amount',
    'created_by',
    'created_at',
    'updated_by',
    'updated_at'
  ];

}