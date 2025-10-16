<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'transaction_id',
        'sender_id',
        'receiver_id',
        'status',
        'amount'
    ];

    public function transaction() {
        return $this->belongsTo(Transaction::class);
    }
}
