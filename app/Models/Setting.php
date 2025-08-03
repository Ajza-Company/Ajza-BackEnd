<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    
    protected $fillable = ['key', 'value'];
    
    /**
     * Get a setting value by key
     */
    public static function getValue($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
    
    /**
     * Set a setting value by key
     */
    public static function setValue($key, $value)
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
    
    /**
     * Get multiple settings as key-value array
     */
    public static function getMultiple(array $keys)
    {
        $settings = self::whereIn('key', $keys)->get();
        $result = [];
        
        foreach ($keys as $key) {
            $setting = $settings->where('key', $key)->first();
            $result[$key] = $setting ? $setting->value : null;
        }
        
        return $result;
    }
    
    /**
     * Get all settings as key-value array
     */
    public static function getAll()
    {
        return self::pluck('value', 'key')->toArray();
    }
}
