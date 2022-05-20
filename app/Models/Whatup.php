<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Whatup extends Model
{
    use HasFactory;

    protected $fillable = [
        "wp_title",
        "wp_excerpt",
        "wp_body",
        "user_id",
        "is_public",
        "wp_cover",
    ];

    protected $with = ["user"];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
