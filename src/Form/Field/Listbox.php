<?php

namespace Sirius\Builder\Form\Field;

/**
 * Class ListBox.
 *
 * @see https://github.com/istvan-ujjmeszaros/bootstrap-duallistbox
 */
class Listbox extends MultipleSelect
{
    protected $settings = [];

    protected static $css = [
        '/vendor/laravel-admin/bootstrap-duallistbox/dist/bootstrap-duallistbox.min.css',
    ];

    protected static $js = [
        '/vendor/laravel-admin/bootstrap-duallistbox/dist/jquery.bootstrap-duallistbox.min.js',
    ];

    public function settings(array $settings)
    {
        $this->settings = $settings;

        return $this;
    }

    public function render()
    {
        $settings = array_merge($this->settings, [
            'infoText'          => lang('admin.listbox.text_total'),
            'infoTextEmpty'     => lang('admin.listbox.text_empty'),
            'infoTextFiltered'  => lang('admin.listbox.filtered'),
            'filterTextClear'   => lang('admin.listbox.filter_clear'),
            'filterPlaceHolder' => lang('admin.listbox.filter_placeholder'),
        ]);

        $settings = json_encode($settings);

        $this->script = <<<SCRIPT

$("{$this->getElementClassSelector()}").bootstrapDualListbox($settings);

SCRIPT;

        return parent::render();
    }
}
