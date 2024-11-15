<?php

namespace App\Http\Controllers;

use App\Mail\MensajeUsuario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NotificacionController extends Controller
{
    public function enviarCorreosAdministrativos()
    {
        try {
            // Obtener todos los usuarios con el rol "administrativo"
            $users = User::role('administrativo')->get();

            if ($users->isEmpty()) {
                return response()->json(['message' => 'No hay usuarios con el rol administrativo.'], 404);
            }

            foreach ($users as $user) {
                $details = [
                    'subject' => 'Notificación Importante',
                    'body' => "Hola, {$user->name}. Este es un correo enviado automáticamente para usuarios administrativos.",
                ];

                Mail::to($user->email)->send(new MensajeUsuario($details));
            }

            return response()->json(['message' => 'Correos enviados correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al enviar correos: ' . $e->getMessage()], 500);
        }
    }
}
