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
			new Password( "password" )
		);
	}

	protected function configurePresenters()
	{
		parent::configurePresenters();

		$this->presenters[ "username" ]->addCssClassName( "input-center login-input login-username" );

		$this->presenters[ "password" ]->addCssClassName( "input-center login-input login-password" );
	}

	public function printOverlay()
	{
		?>
			<div id="login">
				<hr>
				<div  id="login-base">
					<h1 id="login-button">Login</h1>
				</div>
				<div id="actual-login" style="">
					<h1>Username</h1>
					<?= $this->presenters[ "username" ] ?><br>
					<h1>Password</h1>
					<?= $this->presenters[ "password" ] ?><br>
					<p>Haven't registered yet?</p>
					<a href="/login/signup">Sign up</a>
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