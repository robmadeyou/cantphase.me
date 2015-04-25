<?php

namespace Cant\Phase\Me\Presenters\Login\Signup;


use Rhubarb\Leaf\Presenters\Controls\Text\TextArea\TextArea;
use Rhubarb\Leaf\Presenters\Controls\Text\TextBox\TextBox;
use Rhubarb\Leaf\Views\WithJqueryViewBridgeTrait;

class IndexView extends \Cant\Phase\Me\Presenters\Login\IndexView
{
	use WithJqueryViewBridgeTrait;

	public function createPresenters()
	{
		parent::createPresenters();

		$this->addPresenters(
			new TextArea( "info" ),
			new TextBox( "email" )
		);
	}

	protected function configurePresenters()
	{
		parent::configurePresenters();

		$this->presenters[ "info" ]->addCssClassName( "input-center login-input" );
		$this->presenters[ 'email' ]->setPlaceholderText( 'email' );
		$this->presenters[ "email" ]->addCssClassName( "input-center login-input" );
		$this->presenters[ "info" ]->setPlaceholderText( 'info' );

	}

	public function printInputs()
	{
		parent::printInputs();

		echo '<br><br>' . $this->presenters[ 'email' ];
		echo '<br><br>' . $this->presenters[ 'info' ];
	}


	public function getDeploymentPackageDirectory()
	{
		return __DIR__;
	}
}