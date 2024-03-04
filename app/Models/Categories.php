<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;
use App\Models\Note;

class Categories extends Model
{
    use HasFactory;


    protected $fillable = ['name','category_id'];

    public function Note(): hasMany
    {
        return $this->hasMany(Note::class);
    }
}
