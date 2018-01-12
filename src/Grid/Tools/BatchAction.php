<?php

namespace Sirius\Builder\Grid\Tools;

use function token;

abstract class BatchAction
{
    protected $id;

    protected $resource;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    public function getToken()
    {
        return token();
    }

    protected function getElementClass()
    {
        return '.grid-batch-'.$this->id;
    }

    public function script()
    {
        return '';
    }
}
