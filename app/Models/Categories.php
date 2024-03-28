<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;
use App\Models\Note;
use App\Models\User;

class Categories extends Model
{
    use HasFactory;


    protected $fillable = ['name', 'user_id','category_id'];

    public function Note(): hasMany
    {
        return $this->hasMany(Note::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
