<?php

namespace Cant\Phase\Me\Presenters\Login;

use Rhubarb\Leaf\Presenters\Controls\Text\Password\Password;
use Rhubarb\Leaf\Presenters\Controls\Text\TextArea\TextArea;
use Rhubarb\Leaf\Presenters\Controls\Text\TextBox\TextBox;
use Rhubarb\Leaf\Views\WithJqueryViewBridgeTrait;

class IndexView extends \Cant\Phase\Me\Presenters\IndexView
{
	use WithJqueryViewBridgeTrait;

	public function createPresenters()
	{
		parent::createPresenters();

		$this->addPresenters(
			new TextBox( "username" ),
			new Password( "password" ),
			new TextBox( "email" ),
			new TextArea( "info" )
		);
	}

	protected function configurePresenters()
	{
		parent::configurePresenters();

		$this->presenters[ "username" ]->setPlaceholderText( "Username" );
		$this->presenters[ "username" ]->addCssClassName( "input-center" );

		$this->presenters[ "password" ]->setPlaceholderText( "Password" );
		$this->presenters[ "password" ]->addCssClassName( "input-center" );

		$this->presenters[ "email" ]->setPlaceholderText( "Email" );
		$this->presenters[ "email" ]->addCssClassName( "input-center" );

		$this->presenters[ "info" ]->setPlaceholderText( "A little info about yourself" );
		$this->presenters[ "info" ]->addCssClassName( "input-center" );
	}

	public function printOverlay()
	{
		?>
			<?= $this->presenters[ "username" ] ?><br>
			<?= $this->presenters[ "password" ] ?><br>
			<?= $this->presenters[ "email" ] ?><br>
			<?= $this->presenters[ "info" ] ?><br>
			<a href="#" class="submit-button">submit</a>
		<?php
	}

	public function getDeploymentPackageDirectory()
	{
		return __DIR__;
	}
}