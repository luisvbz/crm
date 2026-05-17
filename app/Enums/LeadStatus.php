<?php

namespace App\Enums;

enum LeadStatus: string
{
    case NEW = 'NEW';
    case CONTACTED = 'CONTACTED';
    case INTERESTED = 'INTERESTED';
    case PROPOSAL = 'PROPOSAL';
    case WON = 'WON';
    case LOST = 'LOST';

    public function label(): string
    {
        return match ($this) {
            self::NEW => 'Nuevo',
            self::CONTACTED => 'Contactado',
            self::INTERESTED => 'Interesado',
            self::PROPOSAL => 'Propuesta',
            self::WON => 'Ganado',
            self::LOST => 'Perdido',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::NEW => 'bg-gray-500',
            self::CONTACTED => 'bg-blue-500',
            self::INTERESTED => 'bg-yellow-500',
            self::PROPOSAL => 'bg-purple-500',
            self::WON => 'bg-green-500',
            self::LOST => 'bg-red-500',
        };
    }
}
