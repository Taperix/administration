<?php

namespace App\Models;

use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = ['price', 'text'];

    protected $touches = ['invoice'];

    public function getPriceAttribute($value) {
        return Money::EUR($value);
    }

    public function invoice() {
        return $this->belongsToMany(Invoice::class);
    }
}
