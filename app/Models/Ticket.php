<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasUuids;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'uuid';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ticket_code',
        'title',
        'description',
        'status',
        'priority',
        'client_id',
        'assigned_to',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the client that owns the ticket.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Get the technician assigned to the ticket.
     */
    public function assignedTechnician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the responses for the ticket.
     */
    public function responses(): HasMany
    {
        return $this->hasMany(TicketResponse::class, 'ticket_id', 'uuid');
    }

    /**
     * Get all attachments for the ticket.
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(TicketAttachment::class, 'ticket_id', 'uuid');
    }

    /**
     * Scope a query to only include open tickets.
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    /**
     * Scope a query to only include unassigned tickets.
     */
    public function scopeUnassigned($query)
    {
        return $query->whereNull('assigned_to');
    }

    /**
     * Scope a query to only include assigned tickets.
     */
    public function scopeAssigned($query)
    {
        return $query->whereNotNull('assigned_to');
    }

    /**
     * Scope a query to only include pending tickets (not resolved or closed).
     */
    public function scopePending($query)
    {
        return $query->whereNotIn('status', ['resolved', 'closed']);
    }
}