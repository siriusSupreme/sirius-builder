<?php

namespace Sirius\Builder\Tree;

use Sirius\Builder\Tree;
use Sirius\Support\Contracts\Htmlable;
use Sirius\Support\Contracts\Renderable;
use Sirius\Support\Collection;

class Tools implements Renderable
{
    /**
     * Parent tree.
     *
     * @var Tree
     */
    protected $tree;

    /**
     * Collection of tools.
     *
     * @var Collection
     */
    protected $tools;

    /**
     * Create a new Tools instance.
     *
     * @param Tree $builder
     */
    public function __construct(Tree $tree)
    {
        $this->tree = $tree;
        $this->tools = new Collection();
    }

    /**
     * Prepend a tool.
     *
     * @param string $tool
     *
     * @return $this
     */
    public function add($tool)
    {
        $this->tools->push($tool);

        return $this;
    }

    /**
     * Render header tools bar.
     *
     * @return string
     */
    public function render()
    {
        return $this->tools->map(function ($tool) {
            if ($tool instanceof Renderable) {
                return $tool->render();
            }

            if ($tool instanceof Htmlable) {
                return $tool->toHtml();
            }

            return (string) $tool;
        })->implode(' ');
    }
}
