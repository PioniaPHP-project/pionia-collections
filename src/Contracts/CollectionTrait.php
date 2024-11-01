<?php

namespace Pionia\Collections\Contracts;

trait CollectionTrait
{
    private function resetPointers(): static
    {
        $this->from = null;
        $this->to = null;
        $this->step = null;
        $this->on = null;
        return $this;
    }


    public function from(int $from): static
    {
        $this->from = $from;
        return $this;
    }

    public function to(int $to): static
    {
        $this->to = $to;
        return $this;
    }

    public function step(int $step): static
    {
        $this->step = $step;
        return $this;
    }

    /**
     * Identify the index to interact the item to.
     * @param int $on
     * @return $this
     */
    public function on(int $on): static
    {
        $this->on = $on;
        return $this;
    }

    public function all(): array
    {
        return $this->array;
    }

    public function size(): int
    {
        return count($this->array);
    }

    public function isEmpty(): bool
    {
        return empty($this->array);
    }

    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    public function first(): mixed
    {
        return reset($this->array);
    }

    public function last(): mixed
    {
        return end($this->array);
    }

    /**
     * Detect the type of array.
     * @param array|null $array
     * @return string
     */
    public function arrayType(?array $array = null): string {
        $array = $array ?? $this->array;
        if (array() === $array) return 'EMPTY'; // empty array is not associative

        // check if multi-dimensional array
        if (count($array) !== count($array, COUNT_RECURSIVE)){
            return 'MULTI-DIMENSIONAL';
        }

        if (array_keys($array) !== range(0, count($array) - 1)){
            return 'ASSOCIATIVE';
        } else {
            return 'INDEXED';
        }
    }

    public function get(int | string  $indexOrKey): mixed
    {
        if ($this->isEmpty()) {
            return null;
        }
        $item = $this->first();
        if ($indexOrKey) {
            if (array_key_exists($indexOrKey, $this->array)) {
                $item = $this->array[$indexOrKey];
            }
        } else if ($this->from !== null && $this->to !== null) {
            $item = array_slice($this->array, $this->from, $this->to);
        } else if ($this->from !== null) {
            $item = array_slice($this->array, $this->from);
        } else if ($this->to !== null) {
            $item = array_slice($this->array, 0, $this->to);
        } else if ($this->step !== null) {
            $item = array_chunk($this->array, $this->step);
        } else if ($this->on !== null) {
            $item = $this->array[$this->on];
        }

        $this->resetPointers();
        return $item;
    }

    public function isAssoc(): bool
    {
        return $this->type === 'ASSOCIATIVE';
    }

    public function isIndexed(): bool
    {
        return $this->type === 'INDEXED';
    }

    public function add(mixed $item): CollectionContract
    {
        if ($this->on !== null && array_key_exists($this->on, $this->array)) {
            $this->array[$this->on] = $item;
            $this->resetPointers();
        } else {
            $this->array[] = $item;
        }
        return $this;
    }

    public function remove(mixed $item = null): CollectionContract
    {
        if ($item !== null) {
            if (($key = array_search($item, $this->array)) !== false) {
                unset($this->array[$key]);
                return $this;
            }
        }
        return $this->removeByConditions();
    }

    private function removeByConditions(): CollectionContract
    {
        if ($this->from !== null && $this->to !== null) {
            $this->array = array_slice($this->array, $this->from, $this->to);
        } else if ($this->from !== null) {
            $this->array = array_slice($this->array, $this->from);
        } else if ($this->to !== null) {
            $this->array = array_slice($this->array, 0, $this->to);
        } else if ($this->step !== null) {
            $this->array = array_chunk($this->array, $this->step);
        } else if ($this->on !== null) {
            unset($this->array[$this->on]);
        } else {
            $this->array = [];
        }
        $this->resetPointers();
        return $this;
    }

    public function clear(): CollectionContract
    {
        $this->array = [];
        $this->resetPointers();
        return $this;
    }

    public function contains($item): bool
    {
        // TODO: Implement contains() method.
    }

    public function containsAll(array $items): bool
    {
        // TODO: Implement containsAll() method.
    }

    public function containsAny(array $items): bool
    {
        // TODO: Implement containsAny() method.
    }

}
