<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * Display the settings form.
     */
    public function edit(): View
    {
        $settings = SiteSetting::instance();

        return view('admin.settings.edit', [
            'settings' => $settings,
        ]);
    }

    /**
     * Update the settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'youtube_url' => ['nullable', 'url', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'hero_title' => ['nullable', 'string', 'max:255'],
            'hero_subtitle' => ['nullable', 'string', 'max:500'],
        ], [
            'company_name.required' => 'El nombre de la empresa es obligatorio.',
            'company_name.max' => 'El nombre no puede exceder 255 caracteres.',
            'contact_email.required' => 'El correo de contacto es obligatorio.',
            'contact_email.email' => 'Ingresa un correo electrónico válido.',
            'instagram_url.url' => 'Ingresa una URL de Instagram válida.',
            'facebook_url.url' => 'Ingresa una URL de Facebook válida.',
            'youtube_url.url' => 'Ingresa una URL de YouTube válida.',
        ]);

        $settings = SiteSetting::instance();
        $settings->update($validated);

        return redirect()
            ->route('admin.settings.edit')
            ->with('success', 'Configuración actualizada exitosamente.');
    }
}
