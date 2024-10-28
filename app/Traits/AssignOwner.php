<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait AssignOwner
{
    /**
     * Boot the AssignOwner trait to automatically assign the owner.
     */
    protected static function bootAssignOwner()
    {
        static::creating(function ($model) {
            if (Auth::check() && empty($model->user_id)) {
                $model->user_id = Auth::id();
            }
        });
    }
}
