<?php

namespace App\Inspections;

class InvalidKeydown
{
    /**
     * @var array
     */
    protected $keywords = [
        'yahoo customer support',
    ];

    /**
     * Определить наличие некорректных слов в теле
     *
     * @param string $body
     * @throws \Exception
     */
    public function detect(string $body): void
    {
        foreach ($this->keywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new \Exception('Your reply contains spam.');
            }
        }
    }
}
