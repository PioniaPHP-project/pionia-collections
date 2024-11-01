<?php

namespace Pionia\Collections\Contracts;

enum CollectionType
{
    case ASSOCIATIVE;
    case INDEXED;
    case MULTI_DIMENSIONAL;
    case MATRIX_INDEXED;
    case MATRIX_ASSOCIATIVE;
    case EMPTY;
}
