<?php

namespace Cant\Phase\Me\Presenters\Admin\Item;

use Rhubarb\Patterns\Mvp\Crud\CrudView;

class ItemEditView extends CrudView
{
	public function createPresenters()
	{
		parent::createPresenters();

		$this->addPresenters(
			"Name",
			"Examine",
			"Price",
			"LowAlch",
			"HighAlch",
			"AStab",
			"ASlash",
			"ACrush",
			"AMagic",
			"ARange",
			"DStab",
			"DSlash",
			"DCrush",
			"DMagic",
			"DRange",
			"OStrength",
			"OPrayer"
		);
	}

	protected function printViewContent()
	{
		$this->printFieldset( "Editing Items", [
			"Name",
			"Examine",
			"Price",
			"LowAlch",
			"HighAlch",
			"Attack Stab"    => "AStab",
			"Attack Slash"   => "ASlash",
			"Attack Crush"   => "ACrush",
			"Attack Magic"   => "AMagic",
			"Attack Range"   => "ARange",
			"Defence Stab"   => "DStab",
			"Defence Slash"  => "DSlash",
			"Defence Crush"  => "DCrush",
			"Defence Magic"  => "DMagic",
			"Defence Range"  => "DRange",
			"Strength bonus" => "OStrength",
			"Prayer bonus"   => "OPrayer",
			$this->presenters[ "Save" ].$this->presenters[ "Cancel" ]
		] );
	}
}