<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    use HasFactory;

    protected $guarded = ['id']; // Memperbolehkan semua field diisi kecuali ID

    // Mengubah JSON di database menjadi Array di PHP/Frontend
    protected $casts = [
        'assigned' => 'array',
        'references' => 'array',
    ];
}
