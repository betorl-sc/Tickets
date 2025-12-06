<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class TicketAttachmentController extends Controller
{
    /**
     * Handle file upload from Trix editor
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // Max 10MB
        ]);

        $file = $request->file('file');
        $path = $file->store('ticket-attachments', 'public');
        $url = asset('storage/' . $path);

        return response()->json([
            'url' => $url,
            'href' => $url,
        ]);
    }
}
