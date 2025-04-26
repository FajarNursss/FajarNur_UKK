<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusPemesanan;

class Pemesanan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'kamar_id', 'checkin', 'checkout', 'jumlah_kamar', 'status'];

    protected $casts = [
        'status' => StatusPemesanan::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    public function checkPemesananTime($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $timeLimit = Carbon::parse($pemesanan->created_at)->addMinutes(3);

        if (Carbon::now()->greaterThan($timeLimit)) {
            $pemesanan->update(['status' => StatusPemesanan::CANCELLED]);
            return redirect()->route('resepsionis.pemesanan')
                ->with('status', 'Pemesanan dibatalkan karena batas waktu pembayaran telah lewat.');
        }

        return redirect()->route('resepsionis.pemesanan')
            ->with('status', 'Pemesanan masih dalam batas waktu.');
    }

    public function getStatusAttribute($value)
    {
        return StatusPemesanan::from($value);
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value instanceof StatusPemesanan
            ? $value->value
            : $value;
    }
}
