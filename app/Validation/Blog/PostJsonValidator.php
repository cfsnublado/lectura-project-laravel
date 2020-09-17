<?php

namespace App\Validation\Blog;

use Opis\JsonSchema\Validator as SchemaValidator;
use Opis\JsonSchema\Schema;

class PostJsonValidator
{
    /**
     *
     */
    public function schemaValidation($json)
    {
        $validator = new SchemaValidator();
        $schema = Schema::fromJsonString($this->schema());

        return $validator->schemaValidation($json, $schema);
    }

    private function schema()
    {
        $schema = '{
            "type": "object",
            "properties": {
                "project_name": {
                    "type": "string"
                },
                "name": {
                    "type": "string"
                },
                "description": {
                    "type": "string"
                },
                "content": {
                    "type": "string"
                },
                "post_audios": {
                    "type": "array",
                    "items": {
                        "type": "object",
                        "properties": {
                            "name": {
                                "type": "string"
                            },
                            "audio_url": {
                                "type": "string",
                                "format": "uri"
                            }
                        },
                        "required": ["name", "audio_url"],
                        "additionalProperties": false
                    }
                }
            },
            "required": ["project_name", "name", "content", "post_audios"],
            "additionalProperties": false
        }';

        return $schema;
    }
}