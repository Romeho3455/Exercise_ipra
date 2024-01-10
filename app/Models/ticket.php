<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\comment;

class ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'content',
        'creator',
        'tester',
        'artist',
        'status',
        'ticket_type',
    ];

    public function comments()
    {
        return $this->hasMany(comment::class);
    }
}
