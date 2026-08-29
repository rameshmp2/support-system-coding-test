<?php

namespace App\Models;

use App\Enums\TicketStatus;
use Database\Factories\TicketFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Ticket extends Model
{
    /** @use HasFactory<TicketFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'reference',
        'customer_name',
        'email',
        'phone',
        'ticket_description',
        'status',
        'opened_at',
    ];

    protected function casts(): array
    {
        return [
            'status'    => TicketStatus::class,
            'opened_at' => 'datetime',
        ];
    }

    public function replies(): HasMany
    {
        return $this->hasMany(TicketReply::class);
    }

    
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        return $query->when(
            filled($term),
            fn (Builder $q) => $q->where('customer_name', 'like', '%' . trim($term) . '%')
        );
    }

    public function isNew(): bool
    {
        return $this->status === TicketStatus::New;
    }

    public function isClosed(): bool
    {
        return $this->status === TicketStatus::Closed;
    }
}
