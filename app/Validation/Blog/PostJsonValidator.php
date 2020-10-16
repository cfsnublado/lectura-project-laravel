<?php

namespace App\Validation\Blog;

use App\Validation\JsonValidator;

class PostJsonValidator extends JsonValidator
{
    protected function schema()
    {
        $schema = '{
            "type": "object",
            "properties": {
                "project_uuid": {
                    "type": "string"
                },
                "project_name": {
                    "type": "string"
                },
                "language": {
                    "type": "string",
                    "minLength": 2,
                    "maxLength": 2
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
            "required": [
                "project_uuid", "project_name", "language",
                "name", "description", "content", "post_audios"
            ],
            "additionalProperties": false
        }';

        return $schema;
    }
}