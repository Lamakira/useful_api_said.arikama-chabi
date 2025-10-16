<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortLink extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'original_url',
        'code',
        'clicks'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
