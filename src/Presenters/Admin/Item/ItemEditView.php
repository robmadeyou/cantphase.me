<?php

namespace Cant\Phase\Me\Presenters\Admin\Item;

use Rhubarb\Crown\Settings\HtmlPageSettings;
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
		$html = new HtmlPageSettings();
		$html->PageTitle = "Editing " . str_replace( '_', ' ', $this->getData( 'Name' ) );
		?>

		<div class="top-inputs">
			<div class="col-md-4">
				<img src="<?= $this->getData( 'ImagePath' ) ?>">
			</div>
			<div class="col-md-4">
				<?php
				$this->printFieldset( '',
					[
						"Attack Stab"    => "AStab",
						"Attack Slash"   => "ASlash",
						"Attack Crush"   => "ACrush",
						"Attack Magic"   => "AMagic",
						"Attack Range"   => "ARange",
					])
				?>
			</div>
			<div class="col-md-4">
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
		<div class="item-bonuses">
			<div class="col-md-3">
			</div>
			<div class="col-md-8" style="padding-left: 69px">
				<?php
				$this->printFieldset( "",
					[
						"Name",
						"Examine",
						"Price",
						"LowAlch",
						"HighAlch",
						"Strength bonus" => "OStrength",
						"Prayer bonus"   => "OPrayer",
					] );
				?>

			</div>

		</div>
		<div class="clearfix"></div>
		<?php
		print $this->presenters[ "Save" ].$this->presenters[ "Cancel" ];
	}
}