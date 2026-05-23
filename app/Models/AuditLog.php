<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditLog extends Model
{
    protected $fillable = [
        'user_name',
        'action',
        'module',
        'target',
    ];

    /**
     * Create an audit log entry safely.
     */
    public static function log(?string $userName, string $action, string $module, string $target): void
    {
        static::create([
            'user_name' => $userName ?? (Auth::check() ? Auth::user()->name : 'زائر / نظام'),
            'action'    => $action,
            'module'    => $module,
            'target'    => $target,
        ]);
    }
}
