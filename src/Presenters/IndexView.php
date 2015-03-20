<?php

namespace Cant\Phase\Me\Presenters;

use Rhubarb\Leaf\Views\HtmlView;
use Rhubarb\Leaf\Views\WithViewBridgeTrait;

class IndexView extends HtmlView
{
	use WithViewBridgeTrait;

    protected function PrintViewContent()
    {
	    ?>
			<div class="main">

				<div class="overlay">

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