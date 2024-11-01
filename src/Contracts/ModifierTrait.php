<?php

namespace Pionia\Collections\Contracts;

trait ModifierTrait
{
    protected ?int $on = null;
    protected null|int $from = null;
    protected null|int $to = null;
    protected string $type;

    /**
     * This checks the type of the data in the collection
     * @return string
     */
    abstract protected function checkType(): string;

    /**
     * Get all items from the collection.
     * @return bool|string
     */
    public function json(): bool|string
    {
        return json_encode($this->array);
    }

    /**
     * Populate the collection from a json string.
     * @return mixed
     */
    public function fromJson($json): static
    {
        $this->array = json_decode($json);
        return $this;
    }

    /**
     * Get the type of the current collection.
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }

//    /**
//     * convert the collection to an associative array.
//     */
//    public function assoc(): static
//    {
//        $this->array = array_combine($this->array, $this->array);
//        $this->type = $this->arrayType();
//        return $this;
//    }
}
