<?php
namespace Cant\Phase\Me\Presenters\Spider;

use Rhubarb\Leaf\Presenters\Forms\Form;

class BigSpiderPresenter extends Form
{
	protected function createView()
	{
		return new BigSpiderView();
	}

}