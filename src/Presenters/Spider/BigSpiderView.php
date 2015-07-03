<?php
namespace Cant\Phase\Me\Presenters\Spider;

use Rhubarb\Leaf\Presenters\Controls\Buttons\Button;
use Rhubarb\Leaf\Views\HtmlView;
use Rhubarb\Leaf\Views\View;
use Rhubarb\Leaf\Views\WithJqueryViewBridgeTrait;

class BigSpiderView extends HtmlView
{
	use WithJqueryViewBridgeTrait;

	public function createPresenters()
	{
		$this->addPresenters(
			$gitStatus = new Button( 'GitStatus', 'Update Repository', function()
			{
				$status = [];
				print exec( 'git pull', $status );
				var_dump( $status );
			}, true )
		);
	}

	protected function printViewContent()
	{
		exec( 'git fetch' );
		$behind = [];
		$ahead = [];
		exec( 'git rev-list HEAD..origin', $behind );
		exec( 'git rev-list origin..HEAD', $ahead );
		if( !sizeof( $behind ) && !sizeof( $ahead ) )
		{
			echo 'Server is not ahead, or behind';
		}
		else if( sizeof( $behind ) && !sizeof( $ahead ) )
		{
			echo 'Server is ' . sizeof( $behind ) . ' commits behind MASTER';
		}
		else if( !sizeof( $behind ) && sizeof( $ahead ) )
		{
			echo 'Server is ' . sizeof( $ahead ) . ' commits ahead of MASTER... Contact Rob';
		}
		else if( sizeof( $behind ) && sizeof( $ahead ) )
		{
			echo 'Server is ' . sizeof( $behind ) . ' commits behind and ' . sizeof( $ahead ) . ' commits ahead of MASTER ';
		}
		//if( sizeof( $behind ) || sizeof( $ahead ) )
		//{
			print $this->presenters[ 'GitStatus' ];
		//}
	}

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