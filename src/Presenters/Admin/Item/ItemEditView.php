<?php

namespace Cant\Phase\Me\Presenters\Admin\Item;

use Rhubarb\Leaf\Presenters\Controls\Text\TextBox\TextBox;
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

	protected function configurePresenters()
	{
		parent::configurePresenters();

		foreach( $this->presenters as $presenter )
		{
			if( $presenter instanceof TextBox )
			{
				$presenter->addCssClassName( 'form-control' );
			}
		}
	}

	protected function printViewContent()
	{
		?>

		<div class="top-inputs">
			<?php
				$this->printFieldset( "Editing Items",
					[
						"Name",
						"Examine",
						"Price",
						"LowAlch",
						"HighAlch",
			] );
			?>
		</div>
		<div class="item-bonuses">
			<div class="col-md-6">
				<?php
					$this->printFieldset( '',
					[
						"Attack Stab"    => "AStab",
						"Attack Slash"   => "ASlash",
						"Attack Crush"   => "ACrush",
						"Attack Magic"   => "AMagic",
						"Attack Range"   => "ARange",
						"Strength bonus" => "OStrength",
						"Prayer bonus"   => "OPrayer",
					])
				?>
			</div>
			<div class="col-md-6">
				<?php
					$this->printFieldset( '',
					[
						"Defence Stab"   => "DStab",
						"Defence Slash"  => "DSlash",
						"Defence Crush"  => "DCrush",
						"Defence Magic"  => "DMagic",
						"Defence Range"  => "DRange",
					] )
				?>
			</div>
		</div>
		<?php
		print $this->presenters[ "Save" ].$this->presenters[ "Cancel" ];
	}
}