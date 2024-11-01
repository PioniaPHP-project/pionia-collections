<?php

namespace Pionia\Collections\Variants;


use Pionia\Collections\Contracts\CollectionContract;
use Pionia\Collections\Contracts\CommonsTrait;
use Pionia\Collections\Contracts\ModifierTrait;

abstract class BaseCollection implements CollectionContract
{
    use ModifierTrait, CommonsTrait;
    protected array $array = [];

    public function from(int $from): static
    {
        $size = $this->size();
        if ($from < 0) {
            $from = $size + $from;
        } elseif ($from > $size) {
            $from = $size;
        }
        $this->from = $from;
        return $this;
    }

    public function to(int $to): static
    {
        $size = $this->size();
        if ($to < 0) {
            $to = $size + $to;
        } elseif ($to > $size) {
            $to = $size;
        }
        $this->to = $to;
        return $this;
    }

}
