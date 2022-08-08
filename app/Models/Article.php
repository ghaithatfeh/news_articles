<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'user_id'];

    public function blocks()
    {
        return $this->hasMany(Block::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
