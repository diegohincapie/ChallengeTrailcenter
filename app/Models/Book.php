<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Author;
use App\Models\Library;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;

    public function author() {
        return $this->belongsTo(Author::class);
    }

    public function libraries()
    {
        return $this->belongsToMany(Library::class);
    }
}
