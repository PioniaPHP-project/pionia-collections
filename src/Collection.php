<?php

namespace Pionia\Collections;

use Pionia\Collections\Contracts\CollectionTypeCheckerTrait;
use Pionia\Collections\Variants\AssociativeCollection;
use Pionia\Collections\Variants\IndexedCollection;
use Pionia\Collections\Variants\MatrixAssociativeCollection;
use Pionia\Collections\Variants\MatrixIndexedCollection;
use Pionia\Collections\Variants\MixedMatrixCollection;

class Collection
{
    use CollectionTypeCheckerTrait;

    public static function make(?array $array = [])
    {
        $collectionInstance = new static();
        $collectionInstance->collectionType = $collectionInstance::arrayType($array);

        return $collectionInstance->isAssociative()
            ? AssociativeCollection::make($array) : ($collectionInstance->isIndexed()
                ? IndexedCollection::make($array) : ($collectionInstance->isMultiDimensional()
                    ? MixedMatrixCollection::make($array) : ($collectionInstance->isMatrixIndexed()
                        ? MatrixIndexedCollection::make($array) : ($collectionInstance->isMatrixAssociative()
                            ? MatrixAssociativeCollection::make($array) : $collectionInstance))));
    }
}
