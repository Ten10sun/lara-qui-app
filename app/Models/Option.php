<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Testing\Fluent\Concerns\Has;

class Option extends Model
{
  use HasFactory;

  public function quiz()
  {
    return $this->belongsTo(Quiz::class);
  }
}
