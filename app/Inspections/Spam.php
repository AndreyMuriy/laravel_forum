<?php

namespace App\Inspections;

class Spam
{
    /**
     * @var array
     */
    protected $inspections = [
        InvalidKeydown::class,
        KeyHeldDown::class,
    ];

    /**
     * Определение спама
     *
     * @param string $body
     * @return bool
     */
    public function detect(string $body): bool
    {
        foreach ($this->inspections as $inspection) {
            app($inspection)->detect($body);
        }
        return false;
    }
}
