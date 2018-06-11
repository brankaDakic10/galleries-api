<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function gallery() {
        return $this->belongsTo(Gallery::class);
    }
}
