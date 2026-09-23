<?php

namespace App\Support\TypeScript;

/** One property of a model as the frontend receives it. */
final readonly class ModelProperty
{
    public function __construct(
        public string $name,
        public string $type,
        public bool $optional = false,
    ) {}
}
