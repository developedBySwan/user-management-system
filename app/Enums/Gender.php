<?php

namespace App\Enums;

enum Gender : string {
    case MALE = 'male';
    case FEMALE = 'female';
    case OTHER = 'other';

    public static function getNames(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function getAllValues(): array
    {
        return array_combine(self::getValues(), self::getNames());
    }
}