<?php

namespace App\School\Trait;

trait Timestampable
{
    public function updateTimestamps(): void
    {
        // Elimina cualquier lógica relacionada con $createdAt o $updatedAt
        // o deja este método vacío si ya no necesitas actualizar marcas de tiempo
    }
}
