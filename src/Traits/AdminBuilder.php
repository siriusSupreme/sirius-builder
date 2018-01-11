<?php

namespace Sirius\Builder\Traits;

use Sirius\Builder\Form;
use Sirius\Builder\Table;
use Sirius\Builder\Tree;

trait AdminBuilder
{
    /**
     * @param \Closure $callback
     *
     * @return Table
     */
    public static function grid(\Closure $callback)
    {
        return new Table(new static(), $callback);
    }

    /**
     * @param \Closure $callback
     *
     * @return Form
     */
    public static function form(\Closure $callback)
    {
        Form::registerBuiltinFields();

        return new Form(new static(), $callback);
    }

    /**
     * @param \Closure $callback
     *
     * @return Tree
     */
    public static function tree(\Closure $callback = null)
    {
        return new Tree(new static(), $callback);
    }
}
