<?php

namespace Sirius\Builder\Grid\Displayers;

use function Sirius\Support\collect;

class Button extends AbstractDisplayer
{
    public function display($style)
    {
        $style = collect((array) $style)->map(function ($style) {
            return 'btn-'.$style;
        })->implode(' ');

        return "<span class='btn $style'>{$this->value}</span>";
    }
}
