<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\SiteSetting;
use App\Mail\ContactFormSubmitted;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Display the contact page.
     */
    public function show(): View
    {
        $settings = SiteSetting::instance();

        return view('public.contact', [
            'settings' => $settings,
        ]);
    }

    /**
     * Handle contact form submission.
     */
    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ], [
            'name.required' => 'Por favor, ingresa tu nombre.',
            'name.max' => 'El nombre no puede exceder 255 caracteres.',
            'email.required' => 'Por favor, ingresa tu correo electrónico.',
            'email.email' => 'Por favor, ingresa un correo electrónico válido.',
            'email.max' => 'El correo electrónico no puede exceder 255 caracteres.',
            'message.required' => 'Por favor, escribe tu mensaje.',
            'message.max' => 'El mensaje no puede exceder 5000 caracteres.',
        ]);

        // Save to database
        $contactMessage = ContactMessage::create($validated);

        // Send email notification
        $settings = SiteSetting::instance();
        
        try {
            Mail::to($settings->contact_email)->send(new ContactFormSubmitted($contactMessage));
        } catch (\Exception $e) {
            // Log the error but don't fail the request
            \Log::error('Failed to send contact email: ' . $e->getMessage());
        }

        return redirect()
            ->route('contact.show')
            ->with('success', '¡Gracias por tu mensaje! Nos pondremos en contacto contigo pronto.');
    }
}
