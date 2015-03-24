<?php

namespace Cant\Phase\Me\Presenters\Music;

use Rhubarb\Leaf\Presenters\Forms\Form;

class MusicCollectionPresenter extends Form
{
	protected function createView()
	{
		return new MusicCollectionView();
	}

}