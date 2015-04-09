<?php
/**
 * How is it going yo
 */

namespace Cant\Phase\Me\Presenters\Music\Browse;


use Rhubarb\Leaf\Presenters\Application\Search\SearchPanel;
use Rhubarb\Leaf\Presenters\Controls\Text\TextBox\TextBox;
use Rhubarb\Stem\Filters\Contains;
use Rhubarb\Stem\Filters\Group;
use Rhubarb\Stem\Filters\Not;

class BrowseSearch extends SearchPanel
{

	protected function createSearchControls()
	{
		$controls = [
			"Search" => new TextBox( "TextFilter" )
		];


		$namedControls = [];
		foreach( $controls as $control )
		{
			$namedControls[ $control->GetName() ] = $control;
		}
		return $namedControls;
	}

	protected function createView()
	{
		return new BrowseSearchView();
	}

	public function populateFilterGroup( Group $filterGroup )
	{
		parent::populateFilterGroup( $filterGroup );
		if( $this->TextFilter )
		{
			echo "hi";
			$title = "";
			$noGenres = [];
			$genres = [];
			$uploader = "";
			preg_match_all( '/@(\w)+/', $this->TextFilter, $title );
			try
			{
				$title = $title[0][0];
			}
			catch( \Exception $ex )
			{
				$title = "";
			}
			preg_match_all( '/\+(\w)+/', $this->TextFilter, $genres );
			$genres = $genres[0];
			preg_match_all( '/-(\w)+/', $this->TextFilter, $noGenres );
			$noGenres = $noGenres[0];
			preg_match_all( '/#(\w)+/', $this->TextFilter, $uploader );
			try
			{
				$uploader = $uploader[0][0];
			}
			catch( \Exception $ex )
			{
				$uploader = "";
			}

			if( $title )
			{
				$filterGroup->addFilters( new Contains( 'Name', str_replace( "@", "", $title ) ) );
			}

			if( $noGenres )
			{
				foreach( $noGenres as $noGenre )
				{
					$filterGroup->addFilters( new Not( new Contains( "Genre", str_replace( "-", "", $noGenre ) ) ) );
				}
			}

			if( $genres )
			{
				foreach( $genres as $genre )
				{
					$filterGroup->addFilters( new Contains( "Genre", str_replace( "+", "", $genre ) ) );
				}
			}

			if( $uploader )
			{
				$filterGroup->addFilters( new Contains( "Uploader", str_replace( "#", "", $uploader ) ) );
			}
		}
	}
}