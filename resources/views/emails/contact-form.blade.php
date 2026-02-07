<x-mail::message>
# Nuevo mensaje de contacto

Has recibido un nuevo mensaje desde el formulario de contacto.

**Nombre:** {{ $contactMessage->name }}

**Correo electrónico:** {{ $contactMessage->email }}

**Mensaje:**

{{ $contactMessage->message }}

---

*Mensaje recibido el {{ $contactMessage->created_at->format('d/m/Y \a \l\a\s H:i') }}*

</x-mail::message>
