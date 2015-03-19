<?php
namespace Cant\Phase\Me;

use Rhubarb\Crown\Layout\LayoutModule;
use Rhubarb\Crown\Module;
use Rhubarb\Crown\UrlHandlers\ClassMappedUrlHandler;
use Rhubarb\Stem\Repositories\Repository;
use Rhubarb\Stem\Schema\SolutionSchema;

class CantPhaseMeModule extends Module
{
	protected function initialise()
	{
		parent::initialise();

		Repository::SetDefaultRepositoryClassName( 'Rhubarb\Stem\Repositories\MySql\MySql' );
		include_once( "settings/site.config.php" );

		SolutionSchema::RegisterSchema( "home", 'Cant\Phase\Me\Model\CantPhaseMeSolutionSchema' );
	}
	protected function registerUrlHandlers()
	{
		parent::registerUrlHandlers();

		$this->addUrlHandlers(
			[
				"/" => new ClassMappedUrlHandler( 'Cant\Phase\Me\Presenters\IndexPresenter' )
			]
		);
	}
	protected function registerDependantModules()
	{
		Module::registerModule( new LayoutModule( 'Cant\Phase\Me\Layouts\DefaultLayout' ) );
	}
}
Module::registerModule(new CantPhaseMeModule());