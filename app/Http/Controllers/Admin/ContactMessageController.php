<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of contact messages.
     */
    public function index(): View
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.contact-messages.index', [
            'messages' => $messages,
        ]);
    }

    /**
     * Display a single message.
     */
    public function show(ContactMessage $message): View
    {
        return view('admin.contact-messages.show', [
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified message.
     */
    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()
            ->route('admin.contact-messages.index')
            ->with('success', 'Mensaje eliminado exitosamente.');
    }
}
