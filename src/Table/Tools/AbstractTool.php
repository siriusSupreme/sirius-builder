<?php

namespace Sirius\Builder\Table\Tools;

use Sirius\Builder\Table;
use Sirius\Support\Contracts\Renderable;

abstract class AbstractTool implements Renderable
{
    /**
     * @var Table
     */
    protected $grid;

    /**
     * Set parent grid.
     *
     * @param Table $grid
     *
     * @return $this
     */
    public function setGrid(Table $grid)
    {
        $this->grid = $grid;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function render();

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
