<?php

namespace Cant\Phase\Me\Presenters\Login\Signup;


class IndexPresenter extends \Cant\Phase\Me\Presenters\Login\IndexPresenter
{
	protected function createView()
	{
		return new IndexView();
	}

	protected function configureView()
	{
		parent::configureView();

		$this->view->hasOverlay = true;
		$this->canRegister = true;
	}
}