<?php

namespace Cant\Phase\Me\Presenters;

use Rhubarb\Leaf\Presenters\Forms\Form;

class IndexPresenter extends Form
{
    protected function createView()
    {
        return new IndexView();
    }
}