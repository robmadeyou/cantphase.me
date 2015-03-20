<?php

namespace Cant\Phase\Me\Presenters\Login;

class IndexPresenter extends \Cant\Phase\Me\Presenters\IndexPresenter
{
    protected function CreateView()
    {
	    return new IndexView();
    }
}