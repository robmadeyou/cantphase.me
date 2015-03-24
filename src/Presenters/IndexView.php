<?php

namespace Cant\Phase\Me\Presenters;

use Cant\Phase\Me\Model\PhasedUser\PhasedUser;
use Rhubarb\Crown\LoginProviders\Exceptions\NotLoggedInException;
use Rhubarb\Crown\LoginProviders\LoginProvider;
use Rhubarb\Leaf\Views\HtmlView;
use Rhubarb\Leaf\Views\WithJqueryViewBridgeTrait;

class IndexView extends HtmlView
{
	use WithJqueryViewBridgeTrait;
	public $hasOverlay = false;

	protected function PrintViewContent()
	{
		?>
			<div style="text-align: center;">
				<?php
					try
					{
						$user = PhasedUser::getLoggedInUser();
						print "Hello $user->Username!";
					}
					catch( NotLoggedInException $ex )
					{
						print "Main body is hidden... right?";
					}
				?>
			</div>
		<?php
			if( $this->hasOverlay )
			{
			?>
				<div class="overlay">
					<?= $this->printOverlay() ?>
				</div>
			<?php
			}
	}

	/**
	 * Override this method with the Login model to add the overlay effect.
	 */
	public function printOverlay()
	{}

	/**
	 * Implement this and return __DIR__ when your ViewBridge.js is in the same folder as your class
	 *
	 * @returns string Path to your ViewBridge.js file
	 */
	public function getDeploymentPackageDirectory()
	{
		return __DIR__;
	}
}