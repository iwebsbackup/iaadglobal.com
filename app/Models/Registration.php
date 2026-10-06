<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'accommodation',
    'sharing',
    'accompanying',
    'workshops',
    'fee_tier',
    'subtotal',
    'gst_amount',
    'total',
    'status',
    'paid_at',
    'payment_reference',
])]
class Registration extends Model
{
    protected function casts(): array
    {
        return [
            'sharing' => 'array',
            'accompanying' => 'array',
            'workshops' => 'array',
            'paid_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }
}
