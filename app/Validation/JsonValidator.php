<?php

namespace App\Validation;

use Opis\JsonSchema\Validator as SchemaValidator;
use Opis\JsonSchema\Schema;
use Illuminate\Support\Facades\Log;

abstract class JsonValidator
{
    /**
     *
     */
    abstract protected function schema();

    /**
     *
     */
    public function schemaValidation($json)
    {
        $validator = new SchemaValidator();
        $schema = Schema::fromJsonString($this->schema());

        return $validator->schemaValidation($json, $schema);
    }
}