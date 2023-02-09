<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferenceExchangeDirections extends Model
{
    use HasFactory;

    /**
     * Возвращает направление обмена в виде 'X -> Y'
     * @return string
     */
    public function getDirectionStringAttribute(): string
    {
        $parts = explode('|', $this->title);
        return trim($parts[0]) .' &rarr; '. trim($parts[1]);
    }
}
