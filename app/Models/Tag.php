<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    protected static function booted(): void
    {
        static::creating(fn (Tag $t) => $t->slug ??= Str::slug($t->name));
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
