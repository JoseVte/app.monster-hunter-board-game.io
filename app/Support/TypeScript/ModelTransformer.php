<?php

namespace App\Support\TypeScript;

use Illuminate\Database\Eloquent\Model;
use Spatie\TypeScriptTransformer\PhpNodes\PhpClassNode;
use Spatie\TypeScriptTransformer\Transformed\Transformed;
use Spatie\TypeScriptTransformer\Transformers\Transformer;
use Spatie\TypeScriptTransformer\Data\TransformationContext;
use Spatie\TypeScriptTransformer\Transformed\Untransformable;
use Spatie\TypeScriptTransformer\References\PhpClassReference;
use Spatie\TypeScriptTransformer\TypeScriptNodes\TypeScriptRaw;
use Spatie\TypeScriptTransformer\TypeScriptNodes\TypeScriptAlias;
use Spatie\TypeScriptTransformer\TypeScriptNodes\TypeScriptObject;
use Spatie\TypeScriptTransformer\TypeScriptNodes\TypeScriptProperty;

/**
 * Adapter from ModelShape to Spatie's node API, and nothing else.
 *
 * Spatie's own ClassTransformer cannot do this: it iterates real public PHP
 * properties, and an Eloquent model declares none for its attributes. All the
 * judgement lives in ModelShape, which is plain PHP and testable on its own.
 */
class ModelTransformer implements Transformer
{
    public function transform(
        PhpClassNode $phpClassNode,
        TransformationContext $context,
    ): Transformed|Untransformable {
        $reflection = $phpClassNode->reflection;

        if ($reflection->isAbstract() || ! $reflection->isSubclassOf(Model::class)) {
            return Untransformable::create();
        }

        $properties = array_map(
            fn (ModelProperty $property): TypeScriptProperty => new TypeScriptProperty(
                $property->name,
                new TypeScriptRaw($property->type),
                isOptional: $property->optional,
            ),
            array_values(ModelShape::for($reflection->getName())),
        );

        return new Transformed(
            new TypeScriptAlias($context->name, new TypeScriptObject($properties)),
            new PhpClassReference($phpClassNode),
            $context->nameSpaceSegments,
            true,
        );
    }
}
