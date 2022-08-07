<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Party extends Model
{
    use HasFactory;

    public function games(){
        return $this->belongsTo(Game::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }
}
