<?php

namespace App\Console\Commands;

use Str;
use InvalidArgumentException;
use Illuminate\Routing\Console\ControllerMakeCommand;

class MakeController extends ControllerMakeCommand
{
    /**
     * @inerhitDoc
     */
    protected function resolveStubPath($stub): string
    {
        return file_exists($customPath = $this->laravel->resourcePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.$stub;
    }

    /**
     * @inerhitDoc
     */
    protected function buildClass($name): array|string
    {
        $replace = [];

        if ($this->option('model')) {
            $replace = $this->buildRequestReplacements();
        }

        return str_replace(
            array_keys($replace),
            array_values($replace),
            parent::buildClass($name)
        );
    }

    /**
     * Build the replacements for a parent controller.
     */
    protected function buildRequestReplacements(): array
    {
        $requestClass = $this->parseRequest($this->option('model')).'Request';

        if (!class_exists($requestClass) && $this->confirm("A $requestClass model does not exist. Do you want to generate it?", true)) {
            $this->call('make:request', ['name' => $requestClass]);
        }

        return [
            'RequestClass' => class_basename($requestClass),
            '{{ requestClass }}' => class_basename($requestClass),
            '{{requestClass}}' => class_basename($requestClass),
        ];
    }

    /**
     * Build the model replacement values.
     */
    protected function buildModelReplacements(array $replace): array
    {
        $modelClass = $this->parseModel($this->option('model'));

        if (!class_exists($modelClass) && $this->confirm("A $modelClass model does not exist. Do you want to generate it?", true)) {
            $this->call('make:model', ['name' => $modelClass]);
        }

        return array_merge($replace, [
            'DummyFullModelClass' => $modelClass,
            '{{ namespacedModel }}' => $modelClass,
            '{{namespacedModel}}' => $modelClass,
            'DummyModelClass' => class_basename($modelClass),
            '{{ model }}' => class_basename($modelClass),
            '{{model}}' => class_basename($modelClass),
            'DummyModelVariable' => lcfirst(class_basename($modelClass)),
            '{{ modelVariable }}' => lcfirst(class_basename($modelClass)),
            '{{modelVariable}}' => lcfirst(class_basename($modelClass)),

            'DummyTextSingular' => ucfirst(Str::snake(class_basename($modelClass), ' ')),
            '{{ textSingular }}' => ucfirst(Str::snake(class_basename($modelClass), ' ')),
            '{{textSingular}}' => ucfirst(Str::snake(class_basename($modelClass), ' ')),
            'DummyTextPlural' => ucfirst(Str::plural(Str::snake(class_basename($modelClass), ' '))),
            '{{ textPlural }}' => ucfirst(Str::plural(Str::snake(class_basename($modelClass), ' '))),
            '{{textPlural}}' => ucfirst(Str::plural(Str::snake(class_basename($modelClass), ' '))),
            'DummyModelSingular' => lcfirst(class_basename($modelClass)),
            '{{ modelSingular }}' => lcfirst(class_basename($modelClass)),
            '{{modelSingular}}' => lcfirst(class_basename($modelClass)),
            'DummyModelPlural' => Str::plural(lcfirst(class_basename($modelClass))),
            '{{ modelPlural }}' => Str::plural(lcfirst(class_basename($modelClass))),
            '{{modelPlural}}' => Str::plural(lcfirst(class_basename($modelClass))),
            'DummyModelPluralUc' => ucfirst(Str::plural(lcfirst(class_basename($modelClass)))),
            '{{ modelPluralUc }}' => ucfirst(Str::plural(lcfirst(class_basename($modelClass)))),
            '{{modelPluralUc}}' => ucfirst(Str::plural(lcfirst(class_basename($modelClass)))),
            'DummyRepositoryClass' => class_basename($modelClass).'Repository',
            '{{ repositoryClass }}' => class_basename($modelClass).'Repository',
            '{{repositoryClass}}' => class_basename($modelClass).'Repository',
            'DummyRepositoryModel' => lcfirst(class_basename($modelClass)).'Repository',
            '{{ repositoryModel }}' => lcfirst(class_basename($modelClass)).'Repository',
            '{{repositoryModel}}' => lcfirst(class_basename($modelClass)).'Repository',
        ]);
    }

    /**
     * Get the fully-qualified model class name.
     *
     * @throws InvalidArgumentException
     */
    protected function parseRequest(string $model): string
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Request name contains invalid characters.');
        }

        return $this->rootNamespace().'Http\\Requests\\'.$model;
    }
}
