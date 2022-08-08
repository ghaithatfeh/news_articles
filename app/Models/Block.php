<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'article_id', 'value'];

    public function gifs()
    {
        return $this->hasMany(Gif::class);
    }
}
