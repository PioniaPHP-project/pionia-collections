<?php

namespace Pionia\Collections\Contracts;

use Pionia\Collections\Collection;

interface CollectionContract
{
    /**
     * Get all items from the collection.
     * @return array
     */
    public function all(): array;

    /**
     * Get the size of the collection.
     * @return mixed
     */
    public function size(): int;

    /**
     * Check if the collection is empty.
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Check if the collection is not empty.
     * @return bool
     */
    public function isNotEmpty(): bool;

    /**
     * Remove all items from the collection.
     */
    public function clear(): Collection;

}
