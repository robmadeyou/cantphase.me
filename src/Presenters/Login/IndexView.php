<?php

namespace Cant\Phase\Me\Presenters\Login;

use Cant\Phase\Me\Various\Greet;
use Rhubarb\Crown\Context;
use Rhubarb\Leaf\Presenters\Controls\Text\Password\Password;
use Rhubarb\Leaf\Presenters\Controls\Text\TextBox\TextBox;
use Rhubarb\Leaf\Views\HtmlView;
use Rhubarb\Leaf\Views\WithJqueryViewBridgeTrait;

class IndexView extends HtmlView
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

	protected function printViewContent()
	{
		?>
		<div class="welcome-text">
			<h1><?= Greet::GetMessage() ?></h1>
			<h3>You're on <?= (new Context())->SiteName?>.</h3>
			<div class="login-section">

			</div>
		</div>
		<?php
	}

	public function getDeploymentPackageDirectory()
	{
		return __DIR__;
	}
}