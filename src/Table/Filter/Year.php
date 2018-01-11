<?php

namespace Sirius\Builder\Table\Filter;

class Year extends Date
{
    /**
     * {@inheritdoc}
     */
    protected $query = 'whereYear';

    /**
     * @var string
     */
    protected $fieldName = 'year';
}
