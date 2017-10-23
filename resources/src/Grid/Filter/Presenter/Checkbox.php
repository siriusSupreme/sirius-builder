<?php

namespace Sirius\Builder\Grid\Filter\Presenter;

use Sirius\Builder\Facades\Admin;

class Checkbox extends Radio
{
    protected function prepare() : void
    {
        $script = "$('.{$this->filter->getId()}').iCheck({checkboxClass:'icheckbox_minimal-blue'});";

        Admin::script($script);
    }
}
