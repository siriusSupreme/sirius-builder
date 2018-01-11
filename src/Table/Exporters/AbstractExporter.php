<?php

namespace Sirius\Builder\Table\Exporters;

use Sirius\Builder\Table;

abstract class AbstractExporter implements ExporterInterface
{
    /**
     * @var \Sirius\Builder\Table
     */
    protected $grid;

    /**
     * Create a new exporter instance.
     *
     * @param $grid
     */
    public function __construct(Table $grid = null)
    {
        if ($grid) {
            $this->setGrid($grid);
        }
    }

    /**
     * Set grid for exporter.
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
     * Get table of grid.
     *
     * @return string
     */
    public function getTable()
    {
        return $this->grid->model()->eloquent()->getTable();
    }

    /**
     * Get data with export query.
     *
     * @return array
     */
    public function getData()
    {
        return $this->grid->getFilter()->execute();
    }

    /**
     * @param callable $callback
     * @param int      $count
     *
     * @return bool
     */
    public function chunk(callable $callback, $count = 100)
    {
        return $this->grid->getFilter()->chunk($callback, $count);
    }

    /**
     * Export data with scope.
     *
     * @param string $scope
     *
     * @return $this
     */
    public function withScope($scope)
    {
        if ( $scope == Table\Exporter::SCOPE_ALL) {
            return $this;
        }

        list($scope, $args) = explode(':', $scope);

        if ( $scope == Table\Exporter::SCOPE_CURRENT_PAGE) {
            $this->grid->model()->usePaginate(true);
        }

        if ( $scope == Table\Exporter::SCOPE_SELECTED_ROWS) {
            $selected = explode(',', $args);
            $this->grid->model()->whereIn($this->grid->getKeyName(), $selected);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function export();
}
