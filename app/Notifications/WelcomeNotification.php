<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $user;
    public function __construct($user) { $this->user = $user; }
    public function via($notifiable) { return ['database']; } // Hanya database dulu untuk test
    public function toDatabase($notifiable) {
        return [
            'title' => 'Selamat Datang',
            'message' => 'Selamat datang ' . $this->user->nama_lengkap . '!',
            'url' => url('/dashboard')
        ];
    }
}