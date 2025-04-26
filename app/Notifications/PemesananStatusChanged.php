<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Pemesanan;

class PemesananStatusChanged extends Notification
{
    use Queueable;

    private $pemesanan;

    /**
     * Create a new notification instance.
     */
    public function __construct(Pemesanan $pemesanan)
    {
        $this->pemesanan = $pemesanan; // Inisialisasi variabel $pemesanan
    }


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // app/Notifications/PemesananStatusChanged.php

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Status pemesanan Anda telah berubah.')
            ->action('Lihat Pemesanan', url('/pemesanan-saya'))
            ->line('Terima kasih telah menggunakan layanan kami!');
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Status pemesanan Anda telah diperbarui menjadi ' . $this->pemesanan->status,
            'pemesanan_id' => $this->pemesanan->id,
        ];
    }
}
