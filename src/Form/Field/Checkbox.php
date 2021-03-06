<?php

namespace Sirius\Builder\Form\Field;

use Sirius\Support\Contracts\Arrayable;

class Checkbox extends MultipleSelect
{
    protected $inline = true;

    protected static $css = [
        '/vendor/laravel-admin/AdminLTE/plugins/iCheck/all.css',
    ];

    protected static $js = [
        '/vendor/laravel-admin/AdminLTE/plugins/iCheck/icheck.min.js',
    ];

    /**
     * Set options.
     *
     * @param array|callable|string $options
     *
     * @return $this|mixed
     */
    public function options($options = [])
    {
        if ($options instanceof Arrayable) {
            $options = $options->toArray();
        }

        $this->options = (array) $options;

        return $this;
    }

    /**
     * Draw inline checkboxes.
     */
    public function inline()
    {
        $this->inline = true;
    }

    /**
     * Draw stacked checkboxes.
     */
    public function stacked()
    {
        $this->inline = false;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $this->script = "$('{$this->getElementClassSelector()}').iCheck({checkboxClass:'icheckbox_minimal-blue'});";

        return parent::render()->with('inline', $this->inline);
    }
}
