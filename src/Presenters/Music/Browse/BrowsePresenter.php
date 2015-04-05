<?php

namespace Cant\Phase\Me\Presenters\Music\Browse;

use Rhubarb\Leaf\Presenters\Forms\Form;

class BrowsePresenter extends Form
{
	protected function createView()
	{
		return new BrowseView();
	}

}