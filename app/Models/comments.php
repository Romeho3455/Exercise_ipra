<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ticket;

class comments extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'parent_comment_id',
        'comment',
    ];

      public function ticket()
      {
          return $this->belongsTo(ticket::class);
      }

      public function parentComment()
      {
          return $this->belongsTo(comment::class, 'parent_comment_id');
      }

      public function replies()
      {
          return $this->hasMany(comment::class, 'parent_comment_id');
      }

}
