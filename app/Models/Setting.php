<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use APP\Models\Setting as SettingModel; 

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'description'];

public static function getValue(string $key, $default = null)
{
    return static::where('key', $key)->value('value') ?? $default;
}
}
