<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'sessions';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $attributes = [
        'id' => null,
        'user_id' => null,
        'ip_address' => null,
        'user_agent' => null,
        'payload' => null,
        'last_activity' => null,
    ];
}