<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodSchedule extends Model
{
  protected $fillable = [
      'user_id', 'title', 'start_time','duration',
      'calories','price','privacy','kind', 'meals'
  ];

  public function user()
  {
    return $this->belongsTo('App\User');
  }
}
