<?php

namespace Sirius\Builder\Table\Filter\Presenter;

use Sirius\Builder\Facades\Admin;

class Checkbox extends Radio
{
    protected function prepare()
    {
        $script = "$('.{$this->filter->getId()}').iCheck({checkboxClass:'icheckbox_minimal-blue'});";

        Admin::script($script);
    }
}
