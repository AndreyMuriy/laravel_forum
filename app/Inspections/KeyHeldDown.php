<?php

namespace App\Inspections;

class KeyHeldDown
{
    /**
     * Определение текста при зажатии клавиши
     *
     * @param string $body
     * @throws \Exception
     */
    public function detect(string $body): void
    {
        if (preg_match('/(.)\\1{4,}/', $body)) {
            throw new \Exception('Your reply contains spam');
        }
    }
}
