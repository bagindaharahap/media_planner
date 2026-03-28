<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromptNote extends Model
{
    use HasFactory;

    // Menentukan kolom apa saja yang boleh diisi
    protected $fillable = [
        'title',
        'category',
        'description',
        'log_action', // Tambahkan ini
        'log_user',   // Tambahkan ini
    ];
}