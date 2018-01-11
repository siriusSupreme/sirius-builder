<?php

namespace Sirius\Builder\Table\Displayers;

use Sirius\Builder\Table;
use Sirius\Builder\Table\Column;

abstract class AbstractDisplayer
{
    /**
     * @var Table
     */
    protected $grid;

    /**
     * @var Column
     */
    protected $column;

    /**
     * @var \stdClass
     */
    public $row;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * Create a new displayer instance.
     *
     * @param mixed     $value
     * @param Table      $grid
     * @param Column    $column
     * @param \stdClass $row
     */
    public function __construct($value, Table $grid, Column $column, $row)
    {
        $this->value = $value;
        $this->grid = $grid;
        $this->column = $column;
        $this->row = $row;
    }

    /**
     * Get key of current row.
     *
     * @return mixed
     */
    public function getKey()
    {
        return $this->row->{$this->grid->getKeyName()};
    }

    /**
     * Get url path of current resource.
     *
     * @return string
     */
    public function getResource()
    {
        return $this->grid->resource();
    }

    /**
     * Get translation.
     *
     * @param string $text
     *
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    protected function trans($text)
    {
        return trans("admin.$text");
    }

    /**
     * Display method.
     *
     * @return mixed
     */
    abstract public function display();
}
