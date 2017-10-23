<?php

namespace Sirius\Builder\Grid\Displayers;

use Sirius\Support\Contracts\Arrayable;

class Badge extends AbstractDisplayer
{
    public function display($style = 'red')
    {
        if ($this->value instanceof Arrayable) {
            $this->value = $this->value->toArray();
        }

        return collect((array) $this->value)->map(function ($name) use ($style) {
            return "<span class='badge bg-{$style}'>$name</span>";
        })->implode('&nbsp;');
    }
}
