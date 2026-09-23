<?php

namespace App\Providers;

use App\Support\TypeScript\ModelTransformer;
use App\Support\TypeScript\PureEnumProvider;
use Spatie\TypeScriptTransformer\Transformers\EnumTransformer;
use Spatie\TypeScriptTransformer\Writers\GlobalNamespaceWriter;
use Spatie\TypeScriptTransformer\TypeScriptTransformerConfigFactory;
use Spatie\TypeScriptTransformer\Transformers\AttributedClassTransformer;
use Spatie\LaravelTypeScriptTransformer\TypeScriptTransformerApplicationServiceProvider as BaseTypeScriptTransformerServiceProvider;

class TypeScriptTransformerServiceProvider extends BaseTypeScriptTransformerServiceProvider
{
    protected function configure(TypeScriptTransformerConfigFactory $config): void
    {
        $config
            ->outputDirectory(resource_path('js/types'))
            ->transformer(new ModelTransformer)
            ->transformer(AttributedClassTransformer::class)
            ->transformer(new EnumTransformer(enumProvider: new PureEnumProvider))
            ->transformDirectories(app_path())
            ->writer(new GlobalNamespaceWriter('generated.d.ts'));
    }
}
