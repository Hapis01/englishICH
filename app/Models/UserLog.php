<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $fillable = [
        'user_id',
        'causer_id',
        'action',
        'description',
        'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function causer()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }

    public static function record($userId, $action, $description = null, $causerId = null)
    {
        return self::create([
            'user_id' => $userId,
            'causer_id' => $causerId ?? (auth()->id() ?? null),
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
        ]);
    }
}
