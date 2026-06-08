<?php

namespace App\Enums;

enum TaskStatus: string
{
    case READY = "READY";
    case PENDING = "PENDING";
    case IN_PROGRESS = "IN_PROGRESS";
    case COMPLETED = "COMPLETED";
    case CANCELLED = "CANCELLED";

    public function color(): string
    {
        return match($this) {
            self::READY       => 'bg-slate-100 text-slate-700 border-slate-200',
            self::PENDING     => 'bg-amber-50 text-amber-700 border-amber-200',
            self::IN_PROGRESS => 'bg-blue-50 text-blue-700 border-blue-200',
            self::COMPLETED   => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            self::CANCELLED   => 'bg-rose-50 text-rose-700 border-rose-200',
        };
    }

    // Method opsional jika Anda ingin tampilan teks yang lebih rapi
    public function label(): string
    {
        return match($this) {
            self::READY       => 'Siap',
            self::PENDING     => 'Ditunda',
            self::IN_PROGRESS => 'Pengerjaan',
            self::COMPLETED   => 'Selesai',
            self::CANCELLED   => 'Dibatalkan',
        };
    }
}
