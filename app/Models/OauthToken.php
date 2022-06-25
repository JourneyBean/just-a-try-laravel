<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OAuthToken extends Model
{
    protected $table = 'oauth_access_tokens';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $attributes = [
        'id' => null,
        'user_id' => null,
        'client_id' => null,
        'name' => null,
        'scopes' => null,
        'revoked' => null,
        'expires_at' => null,
    ];
}