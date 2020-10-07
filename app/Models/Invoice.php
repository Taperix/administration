<?php

namespace App\Models;

use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'is_draft', 'due_at'];

    public function salesman() {
        return $this->belongsTo(User::class);
    }

    public function items() {
        return $this->hasMany(InvoiceItem::class);
    }

    public function calcTotal() {
        $total = Money::EUR(0);
        foreach($this->items as $item) {
            $total = $total->add($item->price);
        }
        return $total;
    }
}
