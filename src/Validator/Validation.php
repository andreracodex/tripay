<?php

namespace Andreracodex\Tripay\Validator;

interface Validation
{
    /**
     * @param array $data
     * @return array
     */
    public static function validate(array $data): array;
}
