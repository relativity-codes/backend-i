<?php

namespace App\Models;

use App\Traits\AssignOwner;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasUuids, AssignOwner;

    protected $fillable = [
        'user_id',
        'balance',
    ];

    protected $table = 'wallets';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
