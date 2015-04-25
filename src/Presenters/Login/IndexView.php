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
		$this->presenters[ "username" ]->setPlaceholderText( "username" );
		$this->presenters[ "password" ]->addCssClassName( "input-center login-input login-password" );
		$this->presenters[ "password" ]->setPlaceholderText( "password" );
	}

	protected function printViewContent()
	{
		?>
		<div class="login">
			<div class="welcome-text">
				<h1 class="greet"><?= Greet::GetMessage() ?></h1>
				<h3>You're on <?= (new Context())->SiteName?>.</h3>
				<?php
					if( !isset( $this->hasOverlay ) )
					{
						echo '<div><span class="login-click">Login</span><span> / </span><span><a href="signup">Signup</a></span></div>';
					}
				?>
				<div class="login-base <?= isset( $this->hasOverlay ) ? 'clear-hidden' : ''?>">
					<?= $this->printInputs() ?>
				</div>
			</div>
		</div>
		<?php
	}

	public function printInputs()
	{
		echo $this->presenters[ 'username' ] . '<br><br>';
		echo $this->presenters[ 'password' ];
	}

	public function getDeploymentPackageDirectory()
	{
		return __DIR__;
	}
}