<?php

namespace Pionia\Collections\Contracts;

use Pionia\Collections\Collection;

trait CommonsTrait
{
    /**
     * Get all items from the collection.
     * @return array
     */
    public function all(): array
    {
        return $this->array;
    }

    /**
     * Get the size of the collection.
     * @return mixed
     */
    public function size(): int
    {
        return count($this->array);
    }

    /**
     * Create an instance of any type of collection
     * @param array $array
     * @return static
     */
    public static function make(array $array): static
    {
        $instance = new static();
        $instance->array = $array;
        $instance->type = $instance->checkType();
        return $instance;
    }

    /**
     * Check if the collection is empty.
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->size() > 1;
    }

    /**
     * Check if the collection is not empty.
     * @return bool
     */
    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    /**
     * Remove all items from the collection.
     */
    public function clear(): Collection
    {
        $this->array = [];
        return new Collection();
    }

    public function clone()
    {
        return clone $this;
    }
}
