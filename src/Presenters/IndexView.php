<?php

namespace Cant\Phase\Me\Presenters;

use Rhubarb\Leaf\Views\HtmlView;
use Rhubarb\Leaf\Views\WithJqueryViewBridgeTrait;

class IndexView extends HtmlView
{
	use WithJqueryViewBridgeTrait;
	public $hasOverlay = false;

	protected function PrintViewContent()
	{
		if( $this->hasOverlay )
		{
			?>
			<div class="overlay">
				<?= $this->printOverlay() ?>
			</div>
		<?php
		}
		?>
			<div style="text-align: center;">
				<img src="/static/image/title-2.jpg">
				<div class="underlay">
					<a href="/music/">
						<div class="content-box content-box-1x1">
							Music!
						</div>
						<div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div><div class="content-box content-box-1x1">
							Music!
						</div>
					</a>
				</div>
			</div>
		<?php

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