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
			} )
		);
	}

	protected function printViewContent()
	{
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
		if( sizeof( $behind ) || sizeof( $ahead ) )
		{
			print $this->presenters[ 'GitStatus' ];
		}
	}
}