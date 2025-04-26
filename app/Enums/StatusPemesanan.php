<?php

namespace App\Enums;

enum StatusPemesanan: string
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case CHECKED_IN = 'checked_in';
    case CHECKED_OUT = 'checked_out';
    case CANCELLED = 'cancelled';
    case PAID = 'paid';
    case EXPIRED = 'expired';
    case MENUNGGU_KONFIRMASI = 'menunggu_konfirmasi'; // Tambahan

    public function toIndonesian(): string
    {
        return match($this) {
            self::PENDING => 'Menunggu',
            self::CONFIRMED => 'Dikonfirmasi',
            self::CHECKED_IN => 'Check-In',
            self::CHECKED_OUT => 'Check-Out',
            self::CANCELLED => 'Dibatalkan',
            self::PAID => 'Lunas',
            self::EXPIRED => 'Kedaluwarsa',
            self::MENUNGGU_KONFIRMASI => 'Menunggu Konfirmasi', // Tambahan
        };
    }
}
