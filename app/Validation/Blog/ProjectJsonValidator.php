<?php

namespace App\Validation\Blog;

use App\Validation\JsonValidator;

class ProjectJsonValidator extends JsonValidator
{
    protected function schema()
    {
        $schema = '{
            "type": "object",
            "properties": {
                "uuid": {
                    "type": "string"
                },
                "name": {
                    "type": "string"
                },
                "description": {
                    "type": "string"
                },
                "posts": {
                    "type": "array",
                    "items": {
                        "type": "object",
                        "properties": {
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
                            "language", "name", "description",
                            "content", "post_audios"
                        ],
                        "additionalProperties": false
                    }
                }
            },
            "required": [
                "uuid", "name", "description", "posts"
            ],
            "additionalProperties": false
        }';

        return $schema;
    }
}