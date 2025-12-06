<?php

namespace App\Notifications;

use App\Broadcasting\Whatsapp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class OneTimePassword extends Notification
{
    use Queueable;

    private string $otp;
    private string $channel;

    public function __construct(string $otp, string $channel = 'email')
    {
        $this->otp = $otp;
        $this->channel = $channel;
    }

    public function via(): array
    {
        if ($this->channel === 'whatsapp') {
            return [Whatsapp::class];
        }
        
        return ['mail'];
    }

    public function toWhatsapp($notifiable): array
    {
        return [
            'message' => "🔐 *Kode Verifikasi Anda*\n\n"
                . "Kode OTP Anda adalah: *{$this->otp}*\n\n"
                . "⏰ Kode ini akan kedaluwarsa dalam 30 menit.\n\n"
                . "⚠️ Jangan bagikan kode ini kepada siapa pun.",
        ];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->otp . ' adalah kode verifikasi anda.')
            ->greeting('Kode verifikasi anda adalah')
            ->line(new HtmlString('<h1 style="text-align: center; color: #262626; font-size: 40px; border: 2px solid #cfcfcf; border-radius: 25px; padding: 10px;">' . $this->otp . '</h1>'))
            ->line('Kode verifikasi kedaluwarsa setelah 30 menit');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
