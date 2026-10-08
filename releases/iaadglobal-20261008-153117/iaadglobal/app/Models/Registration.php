<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'registration_number',
    'accommodation',
    'sharing',
    'accompanying',
    'workshops',
    'fee_tier',
    'subtotal',
    'gst_amount',
    'total',
    'status',
    'payment_token',
    'paid_at',
    'payment_reference',
    'gateway_order_id',
    'payment_error',
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

    protected static function booted(): void
    {
        static::creating(function (Registration $registration) {
            $registration->registration_number ??= 'DICD2026-' . str_pad((string) $registration->user_id, 4, '0', STR_PAD_LEFT);
        });
    }

    public function lineItems(): array
    {
        $tier = $this->fee_tier;
        $nonRes = collect(config('registration.packages.non_residential.rows'))->keyBy('category');
        $res = collect(config('registration.packages.residential.rows'))->keyBy('category');

        $lines = [];

        if ($this->accommodation === 'double') {
            $lines[] = ['Residential · Double occupancy (delegate + 1 sharing)', $res['Double Occupancy With Accompanying Person']['prices'][$tier]];
        } elseif ($this->accommodation === 'single') {
            $lines[] = ['Residential · Single occupancy', $res['Single Occupancy']['prices'][$tier]];
        } else {
            $lines[] = [$this->user->category, $nonRes[$this->user->category]['prices'][$tier]];
        }

        $acc = count($this->accompanying ?? []);
        if ($acc) {
            $lines[] = ['Accompanying person × ' . $acc, $acc * $nonRes['Accompanying Person']['prices'][$tier]];
        }

        $ws = count($this->workshops ?? []);
        if ($ws) {
            $lines[] = ['Workshops × ' . $ws, $ws * $nonRes['Any Workshop']['flat']];
        }

        return $lines;
    }
}
