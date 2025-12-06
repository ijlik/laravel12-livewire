<?php

namespace App\Broadcasting;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Whatsapp
{
    protected string $baseUrl;
    protected string $session;
    protected ?string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.waha.url', 'http://192.168.1.52:3000');
        $this->session = config('services.waha.session', 'default');
        $this->apiKey = config('services.waha.api_key');
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return array|null
     */
    public function send($notifiable, Notification $notification)
    {
        // Get the WhatsApp message data from the notification
        if (!method_exists($notification, 'toWhatsapp')) {
            return null;
        }

        $data = $notification->toWhatsapp($notifiable);

        // Get the recipient's phone number
        $phone = $notifiable->routeNotificationFor('whatsapp', $notification)
            ?? $notifiable->phone
            ?? null;

        if (!$phone) {
            Log::warning('Whatsapp notification failed: No phone number found for notifiable.');
            return null;
        }

        // Format phone number for WhatsApp (remove + and add @c.us)
        $chatId = $this->formatPhoneNumber($phone);

        // Build request
        $request = Http::baseUrl($this->baseUrl)
            ->acceptJson()
            ->asJson();

        // Add API key if configured
        if ($this->apiKey) {
            $request->withHeaders(['X-Api-Key' => $this->apiKey]);
        }

        try {
            $response = $request->post('/api/sendText', [
                'session' => $this->session,
                'chatId' => $chatId,
                'text' => $data['message'] ?? $data['text'] ?? $data,
            ]);

            if ($response->failed()) {
                Log::error('Whatsapp notification failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'chatId' => $chatId,
                ]);
                return null;
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Whatsapp notification exception', [
                'message' => $e->getMessage(),
                'chatId' => $chatId,
            ]);
            return null;
        }
    }

    /**
     * Format phone number to WhatsApp chatId format.
     *
     * @param string $phone
     * @return string
     */
    protected function formatPhoneNumber(string $phone): string
    {
        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Remove leading zeros
        $phone = ltrim($phone, '0');

        return $phone . '@c.us';
    }
}
