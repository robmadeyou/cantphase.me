<?php
namespace Cant\Phase\Me\Presenters\Spider;

use Rhubarb\Leaf\Presenters\Controls\Buttons\Button;
use Rhubarb\Leaf\Views\View;

class BigSpiderView extends View
{
	public function createPresenters()
	{
		$this->addPresenters(
			$gitStatus = new Button( 'GitStatus', 'Update Repository', function()
			{
				$status = [];
				exec( 'git pull', $status );
			}, true )
		);
	}

	protected function printViewContent()
	{
	}
}