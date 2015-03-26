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
		$this->presenters[ "email" ]->addCssClassName( "input-center login-input" );

	}

	public function printOverlay()
	{
		?>
			<div id="login">
				<hr>
				<div id="actual-login" style="display:block">
					<h1>Username</h1>
					<?= $this->presenters[ "username" ] ?><br>
					<h1>Password</h1>
					<?= $this->presenters[ "password" ] ?><br>
					<h1>Email</h1>
					<?= $this->presenters[ "email" ] ?><br>
					<h1>Info</h1>
					<?= $this->presenters[ "info" ] ?>
				</div>
			</div>
			<hr>
		<?php
	}

	public function getDeploymentPackageDirectory()
	{
		return __DIR__;
	}
}