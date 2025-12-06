<?php

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Support\Str;

class TicketCodeService
{
    /**
     * Generate a unique ticket code.
     *
     * Format: TKT-YYYY-XXXX
     * Example: TKT-2024-0001
     *
     * @return string
     */
    public static function generate(): string
    {
        $year = now()->year;
        $prefix = "TKT-{$year}-";
        
        // Get the last ticket code for this year
        $lastTicket = Ticket::where('ticket_code', 'like', "{$prefix}%")
            ->orderBy('ticket_code', 'desc')
            ->first();
        
        if ($lastTicket) {
            // Extract the number part
            $lastNumber = (int) Str::after($lastTicket->ticket_code, $prefix);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }
        
        // Format with leading zeros (4 digits)
        $formattedNumber = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        
        return "{$prefix}{$formattedNumber}";
    }
}
