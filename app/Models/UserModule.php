<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Module;

class UserModule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'module_id',
        'active'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public  function module() {
        return $this->belongsTo(Module::class);
    }
}
