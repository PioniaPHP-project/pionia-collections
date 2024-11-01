<?php

namespace Pionia\Collections\Variants;

use InvalidArgumentException;
use Pionia\Collections\Contracts\CollectionContract;
use ReflectionException;

/**
 * A collection that holds a matrix of associative arrays.
 * @example
 * ``` $collection = Collection::make([
 *     ['name' => 'John', 'age' => 30, 'city' => 'New York'],
 *    ['name' => 'Jane', 'age' => 25, 'city' => 'Los Angeles'],
 *   ['name' => 'Doe', 'age' => 35, 'city' => 'Chicago'],
 * ]);```
 * Class MatrixAssociativeCollection
 * @package Pionia\Collections\Variants
 */
class MatrixAssociativeCollection extends BaseCollection
{
    /**
     * @method pluck($column)
     * @method pluck($column, $index_column)
     * @return AssociativeCollection
     */
    public function pluck(): AssociativeCollection
    {
        $args = func_get_args();
        if (count($args) < 1) {
            throw new InvalidArgumentException('The pluck method requires at least one argument.');
        }
        $column = $args[0];
        $indexColumn = $args[1] ?? null;
        $this->array = array_column($this->array, $column, $indexColumn);
        return AssociativeCollection::make($this->array);
    }

    /**
     * Get the first item from the collection.
     * @return mixed
     * @throws ReflectionException
     */
    public function as($klass): array
    {
        return array_map(fn($item) => AssociativeCollection::make($item)->as($klass), $this->array);
    }


    /**
     * Get the first item from the collection.
     */
    public function first(): AssociativeCollection
    {
        $first = reset($this->array);
        return AssociativeCollection::make($first);
    }

    /**
     * Get the last item from the collection.
     * @return mixed
     */
    public function last(): AssociativeCollection
    {
        $last = end($this->array);
        return AssociativeCollection::make($last);
    }

    /**
     * Get the item  by index or key.
     */
    public function get(mixed $indexOrKey): AssociativeCollection | static
    {
        if (is_int($indexOrKey)) {
            return AssociativeCollection::make($this->array[$indexOrKey]);
        }
        return $this->pluck($indexOrKey);
    }

    /**
     * Add an item to the collection.
     * @param array $arrayToMerge
     * @param int|null $index
     * @return MatrixAssociativeCollection
     */
    public function add(array $arrayToMerge, ?int $index = null): MatrixAssociativeCollection
    {
        if ($index !== null) {
            $before = array_slice($this->array, 0, $index);
            $after = array_slice($this->array, $index);
            $this->array = array_merge($before, [$arrayToMerge], $after);
            return $this;
        }
        $this->array[] = $arrayToMerge;
        return $this;
    }

    /**
     * Remove an item from the collection.
     * @param int|string|null $index
     * @return MatrixAssociativeCollection
     */
    public function remove(int|null|string $index): MatrixAssociativeCollection
    {
        if(is_int($index)) {
            unset($this->array[$index]);
            return $this;
        } elseif (is_string($index)) {
            return $this->removeColumn($index);
        }
        array_pop($this->array);
        return $this;
    }

    /**
     * Delete an entire row from the collection by its key.
     * @param string $columnKeys
     * @return MatrixAssociativeCollection
     */
    public function removeColumn(string $columnKeys): MatrixAssociativeCollection
    {
        foreach ($this->array as &$item) {
            if (is_array($item) && array_key_exists($columnKeys, $item)) {
                unset($item[$columnKeys]);
            }
        }
        return $this;
    }

    /**
     * Delete multiple columns from the collection by their keys.
     * @return MatrixAssociativeCollection
     */
    public function removeColumns(): MatrixAssociativeCollection
    {
        $columns = func_get_args();
        if (count($columns) < 1) {
            throw new InvalidArgumentException('The removeColumns method requires at least one argument.');
        }
        foreach ($columns as $key) {
            $this->removeColumn($key);
        }
        return $this;
    }

    /**
     * This checks the type of the data in the collection
     * @return string
     */
    protected function checkType(): string
    {
        return 'matrix_associative';
    }
}
