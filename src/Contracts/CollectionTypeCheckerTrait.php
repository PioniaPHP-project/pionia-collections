<?php

namespace Pionia\Collections\Contracts;

trait CollectionTypeCheckerTrait
{
    /**
     * Holds the type of the collection we are working with
     * @var string
     */
    private string $collectionType;

    /**
     * Determine the type of the collection
     */
    public function type(): string
    {
        return $this->collectionType;
    }

    /**
     * Detect the type of the array
     * @param array|null $array
     * @return string
     */
    private static function arrayType(?array $array = null): string {
        // Check if the array is empty
        if (empty($array)) return CollectionType::EMPTY->name;

        // Helper function to check if an array is associative
        $isAssociative = function(array $arr): bool {
            return array_keys($arr) !== range(0, count($arr) - 1);
        };

        // Check if the array is multi-dimensional
        $isMultiDimensional = is_array($array[0] ?? null);

        if (!$isMultiDimensional) {
            // For a one-dimensional array, determine if it's associative or indexed
            return $isAssociative($array) ? CollectionType::ASSOCIATIVE->name : CollectionType::INDEXED->name;
        }

        // For a multi-dimensional array, determine if it's matrix-indexed or matrix-associative
        $isMatrixIndexed = true;
        $isMatrixAssociative = true;

        foreach ($array as $subArray) {
            if (!is_array($subArray)) {
                // If an element is not an array, treat as a generic multi-dimensional array
                return CollectionType::MULTI_DIMENSIONAL->name;
            }

            if ($isAssociative($subArray)) {
                $isMatrixIndexed = false;
            } else {
                $isMatrixAssociative = false;
            }
        }

        // Determine the matrix type
        if ($isMatrixIndexed) return CollectionType::MATRIX_INDEXED->name;
        if ($isMatrixAssociative) return CollectionType::MATRIX_ASSOCIATIVE->name;

        // If mixed, return as a general multi-dimensional array
        return CollectionType::MULTI_DIMENSIONAL->name;
    }

    /**
     * Check if the collection is associative.
     * @return bool
     */
    private function isAssociative(): bool
    {
        return $this->collectionType === CollectionType::ASSOCIATIVE->name;
    }

    /**
     * Check if the collection is indexed.
     * @return bool
     */
    private function isIndexed(): bool
    {
        return $this->collectionType === CollectionType::INDEXED->name;
    }

    /**
     * Check if the collection is multi-dimensional.
     * @return bool
     */
    private function isMultiDimensional(): bool
    {
        return $this->collectionType === CollectionType::MULTI_DIMENSIONAL->name;
    }

    /**
     * Check if the collection is a matrix-indexed.
     * @return bool
     */
    private function isMatrixIndexed(): bool
    {
        return $this->collectionType === CollectionType::MATRIX_INDEXED->name;
    }

    /**
     * Check if the collection is a matrix-associative.
     * @return bool
     */
    private function isMatrixAssociative(): bool
    {
        return $this->collectionType === CollectionType::MATRIX_ASSOCIATIVE->name;
    }

    /**
     * Check if the collection is empty.
     * @return bool
     */
    private function isEmpty(): bool
    {
        return $this->collectionType === CollectionType::EMPTY->name;
    }

    /**
     * Check if the collection is not empty.
     * @return bool
     */
    private function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

}
