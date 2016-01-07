<?php

namespace Cant\Phase\Me\Presenters\Admin;

use Rhubarb\Leaf\Presenters\Application\Search\SearchPanel;
use Rhubarb\Leaf\Presenters\Controls\Text\TextBox\TextBox;
use Rhubarb\Stem\Filters\Contains;
use Rhubarb\Stem\Filters\Equals;
use Rhubarb\Stem\Filters\Group;
use Rhubarb\Stem\Filters\OneOf;

class AdminItemSearchPanel extends SearchPanel
{
	protected function createSearchControls()
	{
		$this->AutoSubmit = true;
		$controls = [
			new TextBox( 'Name', 30 ),
			new TextBox( 'ItemID', 10 )
		];

		return $controls;
	}

	public function populateFilterGroup( Group $filterGroup )
	{
		parent::populateFilterGroup( $filterGroup );

		if( $this->Name )
		{
			$filterGroup->addFilters( new Contains( 'Name', $this->Name ) );
		}

		if( $this->ItemID )
		{
			$filterGroup->addFilters( new OneOf( 'ItemID', explode( ',', $this->ItemID ) ) );
		}
	}

}