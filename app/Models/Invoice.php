<?php

namespace App\Models;

use App\States\Invoices\DraftState;
use App\States\Invoices\InvoiceState;
use App\States\Invoices\ReadyState;
use App\States\Invoices\SentState;
use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStates\HasStates;

class Invoice extends Model
{
    use HasFactory, HasStates;

    protected $fillable = ['title', 'due_at'];

    protected $dates = ['due_at', 'sent_when', 'updated_at', 'created_at'];

    protected function registerStates(): void
    {
        $this
            ->addState('state', InvoiceState::class)
            ->default(DraftState::class)
            ->allowTransition(DraftState::class, ReadyState::class)
            ->allowTransition(ReadyState::class, SentState::class);
    }

    public function salesman() {
        return $this->belongsTo(User::class);
    }

    public function recipient() {
        return $this->belongsTo(User::class);
    }

    public function items() {
        return $this->belongsToMany(InvoiceItem::class);
    }

    public function calcTotal() {
        $total = Money::EUR(0);
        foreach($this->items as $item) {
            $total = $total->add($item->price);
        }
        return $total;
    }
}
