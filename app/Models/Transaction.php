<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'datetime', 'amount', 'type', 'details', 'balance'];

    public static function recordTransaction($user, $type, $details, $amount, $balance)
    {
        return self::create([
            'user_id' => $user->id,
            'datetime' => now(),
            'amount' => $amount,
            'type' => $type,
            'details' => $details,
            'balance' => $balance,
        ]);
    }
}
