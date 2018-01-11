<?php

namespace Sirius\Builder\Table\Filter;

class Date extends AbstractFilter
{
    /**
     * {@inheritdoc}
     */
    protected $query = 'whereDate';

    /**
     * @var string
     */
    protected $fieldName = 'date';

    /**
     * {@inheritdoc}
     */
    public function __construct($column, $label = '')
    {
        parent::__construct($column, $label);

        $this->{$this->fieldName}();
    }
}
