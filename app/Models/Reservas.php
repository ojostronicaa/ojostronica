<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservas extends Model{
    protected $fillable = ['fecha', 'user_id', 'horario_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function horario(): BelongsTo
    {
        return $this->belongsTo(horarios::class);
    }

}
