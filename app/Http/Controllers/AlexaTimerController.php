<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AlexaTimerController extends Controller
{
    /**
     * Recibe comandos de Alexa para controlar el cronómetro
     * y notifica a la app Android via FCM
     */
    public function controlTimer(Request $request)
    {
        try {
            $action = $request->input('action');
            $duration = $request->input('duration', 0);
            $userId = $request->input('user_id'); // Si Alexa envía el ID del usuario
            
            Log::info("Alexa timer control", [
                'action' => $action,
                'duration' => $duration,
                'user_id' => $userId
            ]);
            
            // Validar acción
            $validActions = ['start', 'pause', 'resume', 'reset', 'complete'];
            if (!in_array($action, $validActions)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid action'
                ], 400);
            }
            
            // Aquí enviarías una notificación FCM a la app Android
            // Por ahora, solo confirmamos que se recibió
            
            // TODO: Implementar FCM
            // $this->sendFCMNotification($userId, $action, $duration);
            
            return response()->json([
                'success' => true,
                'message' => 'Timer control command received',
                'data' => [
                    'action' => $action,
                    'duration' => $duration
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in timer control: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error processing timer control: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Enviar notificación FCM a la app Android
     * (Requiere configurar Firebase Cloud Messaging)
     */
    private function sendFCMNotification($userId, $action, $duration)
    {
        // TODO: Implementar FCM
        // 1. Obtener el FCM token del usuario desde la BD
        // 2. Construir el payload
        // 3. Enviar via Firebase Admin SDK
        
        /*
        $fcmToken = User::find($userId)->fcm_token;
        
        $notification = [
            'title' => 'Control de Cronómetro',
            'body' => 'Comando desde Alexa: ' . $action
        ];
        
        $data = [
            'action' => $action,
            'duration' => $duration,
            'timestamp' => time()
        ];
        
        // Enviar usando Firebase Admin SDK o Guzzle HTTP
        */
    }
}
