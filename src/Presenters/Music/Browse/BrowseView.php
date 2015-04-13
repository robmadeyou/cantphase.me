<?php

namespace Cant\Phase\Me\Presenters\Music\Browse;


use Cant\Phase\Me\Controls\Music\IsFavoriteColumn;
use Cant\Phase\Me\Model\Music\Music;
use Rhubarb\Leaf\Presenters\Application\Table\Table;
use Rhubarb\Leaf\Views\HtmlView;
use Rhubarb\Leaf\Views\WithJqueryViewBridgeTrait;

class BrowseView extends HtmlView
{

	use WithJqueryViewBridgeTrait;

	public function createPresenters()
	{

		$this->addPresenters(
			new Table( Music::find(), 50, "MusicTable" ),
			new BrowseSearch( "SearchPanel" )
		);
	}

	protected function configurePresenters()
	{
		$this->presenters[ "MusicTable" ]->Columns = [
			"CustomName",
			"Uploader",
			"Genre",
			"Name" => '<a href="/music/{MusicID}/">{Name}</a>',
			"" => new IsFavoriteColumn(),
			" " => '<a href=""><img src="/static/image/songOptions.png" style="width: 18px; height: 18px"/></a>'
		];

		$this->presenters[ "MusicTable" ]->addTableCssClass( [ "table-full-width" ] );
		$this->presenters[ "MusicTable" ]->bindEventsWith( $this->presenters[ "SearchPanel" ] );
	}

	protected function printViewContent()
	{
		?>
		<div class="browse-content-overlap">
			<div class="music-list-logo">
				<img src="/static/image/logoMusic.png">
			</div>
			<div class="music-list-content">
				<div class="music-list-filter">
					<?= $this->presenters[ "SearchPanel" ] ?>
				</div>
				<div class="music-list-table">
					<?= $this->presenters[ "MusicTable" ] ?>
				</div>
			</div>
		</div>
		<?php
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