<?php

namespace App\Models;

use App\Traits\AssignOwner;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasUuids, AssignOwner;

    protected $table = "bills";

    protected $fillable = [
        'amount'
    ];

    protected $guarded = [
        'user_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
