<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_sensor',
        'data'
    ];

    public function getUnitAttribute()
    {
        $nama = strtolower($this->nama_sensor);

        if (strpos($nama, 'dht') !== false || strpos($nama, 'suhu') !== false) {
            return '°C';
        } elseif (strpos($nama, 'kelembaban') !== false || strpos($nama, 'humidity') !== false) {
            return '%';
        } elseif (strpos($nama, 'cahaya') !== false || strpos($nama, 'lux') !== false) {
            return 'lux';
        } elseif (strpos($nama, 'tekanan') !== false) {
            return 'hPa';
        } else {
            return ''; // default tanpa satuan
        }
    }
}
