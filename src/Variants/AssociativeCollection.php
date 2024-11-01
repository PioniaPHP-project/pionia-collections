<?php

namespace Pionia\Collections\Variants;


use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;

class AssociativeCollection extends BaseCollection
{
    /**
     * Get the first item from the collection.
     * @return mixed
     */
    public function first(): mixed
    {
        return reset($this->array);
    }

    /**
     * Get the last item from the collection.
     * @return mixed
     */
    public function last(): mixed
    {
        return end($this->array);
    }

    /**
     * Get the item  by index or key.
     * @param int|string $indexOrKey The index or key of the item to get.
     * @return mixed
     */
    public function get(mixed $indexOrKey): static
    {
        return $this->array[$indexOrKey];
    }

    /**
     * Check if the collection has an item by key.
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->array);
    }

    /**
     * Update an item in the collection.
     * This is added for semantic purposes.
     * @param string $key
     * @param mixed $value
     * @param bool $addIfAbsent
     * @return AssociativeCollection
     */
    public function update(string $key, mixed $value, ?bool $addIfAbsent = false): static
    {
        if (!$this->has($key) && !$addIfAbsent) {
            return $this;
        }
        $this->array[$key] = $value;
        return $this;
    }

    /**
     * Add one or more items to the collection.
     * You can add items in the following ways:
     * 1. As an associative array
     * 2. As an even number of arguments (alternating keys and values)
     * 3. As a single argument passed as a standalone value, which will be used as both the key and value
     * @param mixed ...$args
     * @return AssociativeCollection
     */
    public function add(...$args): static
    {
        // Case 1: First argument is an associative array
        if (is_array($args[0]) && array_keys($args[0]) !== range(0, count($args[0]) - 1)) {
            $this->array = array_merge($this->array, $args[0]);
        }
        // Case 2: Even number of arguments (alternating keys and values)
        elseif (count($args) % 2 === 0) {
            for ($i = 0; $i < count($args); $i += 2) {
                $key = $args[$i];
                $value = $args[$i + 1];
                $this->array[$key] = $value;
            }
        }
        // Case 3: Single argument passed as a standalone value
        elseif (count($args) === 1) {
            $arg = strval($args[0]);
            $this->array[$arg] = $arg;
        }
        // If none of these cases match, throw an exception or handle as needed
        else {
            throw new InvalidArgumentException("Invalid arguments provided to add method.");
        }
        return $this;
    }

    /**
     * Convert the collection to an instance of a class.
     *
     * Class properties will be set to the keys and values of the collection.
     *
     * Class must have the `#[\AllowDynamicProperties]` attribute.
     * @param string $klass The class to convert the collection to.
     * @throws ReflectionException
     */
    public function as(string $klass)
    {
        $reflection = new ReflectionClass($klass);
        $instance = $reflection->newInstance();
        foreach ($this->array as $key => $value) {
            $instance->$key = $value;
        }
        return $instance;
    }

    /**
     * Remove an item from the collection.
     * @param mixed $item
     * @return AssociativeCollection
     */
    public function remove(mixed $item = null): static
    {
        if ($item === null) {
            array_pop($this->array);
        } else {
            unset($this->array[$item]);
        }
        return $this;
    }

    protected function checkType(): string
    {
        return 'associative';
    }
}
