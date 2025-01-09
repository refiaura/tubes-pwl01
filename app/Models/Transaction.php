<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'branch_id', 'date', 'total'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branches::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    // Relasi ke TransactionDetail
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
