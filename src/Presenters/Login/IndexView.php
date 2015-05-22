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
				<h1 class="greet">The Flow</h1>
				<img src="/static/image/waveyLines.png">
				<?php
					if( !isset( $this->hasOverlay ) )
					{
						?>
						<h3 class="login-click">~ Join us ~</h3>
						<div class="login-base">
							<?= $this->printInputs() ?><br>
							<span class="login-functions"><a href="/login/signup">Register</a> | <span title="I forgot my password"><a href="/login/forgot/">I am silly</a></span></span>
						</div>
						<?php
					}
					else
					{
						print $this->printInputs();
					}
				?>
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
