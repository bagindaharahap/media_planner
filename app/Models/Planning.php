<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Planning extends Model
{
    use HasFactory;

    protected $guarded = ['id']; // Memperbolehkan semua field diisi kecuali ID

    // Mengubah JSON di database menjadi Array di PHP/Frontend
    protected $casts = [
        'assigned' => 'array',
        'references' => 'array',
    ];

    protected function contentType(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (is_array($value)) {
                    return $value;
                }
                $decoded = json_decode($value, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    return $decoded;
                }
                return $value ? [$value] : [];
            },
            set: function ($value) {
                if (is_string($value)) {
                    $value = [$value];
                }
                if (!is_array($value)) {
                    $value = [];
                }
                $cleaned = array_values(array_unique(array_filter($value, fn ($v) => is_string($v) && trim($v) !== '')));
                return json_encode($cleaned);
            }
        );
    }
}
