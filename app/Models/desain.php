<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class desain extends Model
{
    /** @use HasFactory<\Database\Factories\DesainFactory> */
    use HasFactory;

    protected $fillable = [
        'id_user',
        'judul',
        'luas',
        'harga',
        'imageUrl'
    ];

    protected $primaryKey = "id_desain";
}
