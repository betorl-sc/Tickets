<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Services\TicketCodeService;

class TicketObserver
{
    /**
     * Handle the Ticket "creating" event.
     * Generate ticket code before creating the ticket.
     */
    public function creating(Ticket $ticket): void
    {
        if (empty($ticket->ticket_code)) {
            $ticket->ticket_code = TicketCodeService::generate();
        }
        
        // Generate UUID if not set
        if (empty($ticket->uuid)) {
            $ticket->uuid = (string) \Illuminate\Support\Str::uuid();
        }
    }
    
    /**
     * Handle the Ticket "created" event.
     */
    public function created(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "updated" event.
     */
    public function updated(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "deleted" event.
     */
    public function deleted(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "restored" event.
     */
    public function restored(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "force deleted" event.
     */
    public function forceDeleted(Ticket $ticket): void
    {
        //
    }
}
