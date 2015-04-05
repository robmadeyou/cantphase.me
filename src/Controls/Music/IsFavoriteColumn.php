<?php

namespace Cant\Phase\Me\Controls\Music;


use Cant\Phase\Me\Model\Music\Music;
use Rhubarb\Leaf\Presenters\Application\Table\Columns\TableColumn;
use Rhubarb\Scaffolds\Authentication\LoginProvider;
use Rhubarb\Stem\Models\Model;

class IsFavoriteColumn extends TableColumn
{

	/**
	 * Implement this to return the content for a cell.
	 *
	 * @param \Rhubarb\Stem\Models\Model             $row
	 * @param \Rhubarb\Stem\Decorators\DataDecorator $decorator
	 *
	 * @return mixed
	 */
	protected function getCellValue( Model $row, $decorator )
	{
		$music = new Music( $row->MusicID );
		if( $music->IsFavoriteSong( (new LoginProvider())->getLoggedInUser()->UserID ) )
		{
			return '<a href="#" style="width: 100%; height: 100%; text-align: center" ><img src="/static/image/songFavouriteSelect.png" style="width: 18px; height: 18px"/></a>';
		}
		else
		{
			return '<a href="#"><img src="/static/image/songFavouriteUnSelect.png" style="width: 18px; height: 18px"/></a>';
		}
	}
}