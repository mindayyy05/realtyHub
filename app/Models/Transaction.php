<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'user_id',
        'cardNumber',
        'expiryMonth',
        'cvv',
        'cardName',
        'property_id',
        'price'
    ];

    // Encrypt card details when saving
    public function setCardNumberAttribute($value)
    {
        $this->attributes['cardNumber'] = Crypt::encryptString($value);
    }

    public function setExpiryMonthAttribute($value)
    {
        $this->attributes['expiryMonth'] = Crypt::encryptString($value);
    }

    public function setCvvAttribute($value)
    {
        $this->attributes['cvv'] = Crypt::encryptString($value);
    }

    public function setCardNameAttribute($value)
    {
        $this->attributes['cardName'] = Crypt::encryptString($value);
    }

    // Decrypt card details when retrieving
    public function getCardNumberAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    public function getExpiryMonthAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    public function getCvvAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    public function getCardNameAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
