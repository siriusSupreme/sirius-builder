<?php

namespace Sirius\Builder\Grid\Filter;

use function Sirius\Support\array_get;

class NotEqual extends AbstractFilter
{
    /**
     * {@inheritdoc}
     */
    public function condition($inputs)
    {
        $value = array_get($inputs, $this->column);

        if (!isset($value)) {
            return;
        }

        $this->value = $value;

        return $this->buildCondition($this->column, '!=', $this->value);
    }
}
