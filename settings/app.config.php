<?php
namespace Cant\Phase\Me;

use Cant\Phase\Me\Layouts\PhasedLayoutProvider;
use Cant\Phase\Me\Models\PhasedSolutionSchema;
use Cant\Phase\Me\Presenters\Admin\AdminIndexPresenter;
use Rhubarb\Crown\Encryption\HashProvider;
use Rhubarb\Crown\Layout\LayoutModule;
use Rhubarb\Crown\Module;
use Rhubarb\Crown\UrlHandlers\ClassMappedUrlHandler;
use Rhubarb\Leaf\LayoutProviders\LayoutProvider;
use Rhubarb\Patterns\Mvp\Crud\CrudUrlHandler;
use Rhubarb\Stem\Repositories\MySql\MySql;
use Rhubarb\Stem\Repositories\Repository;
use Rhubarb\Stem\Schema\SolutionSchema;

class CantPhaseMeModule extends Module
{
	protected function initialise()
	{
		parent::initialise();

		Repository::SetDefaultRepositoryClassName( MySql::class );

		include_once( "settings/site.config.php" );

		SolutionSchema::RegisterSchema( "home", PhasedSolutionSchema::class );
		LayoutProvider::setDefaultLayoutProviderClassName( PhasedLayoutProvider::class );
	}
	protected function registerUrlHandlers()
	{
		parent::registerUrlHandlers();

		$this->addUrlHandlers(
			[
				"/" => new ClassMappedUrlHandler( 'Cant\Phase\Me\Presenters\IndexPresenter', [
					'admin' => new ClassMappedUrlHandler( AdminIndexPresenter::class, [
						'/item/' => new CrudUrlHandler( 'Item', 'Cant\Phase\Me\Presenters\Admin\Item' )
					] )
				] ),
			]
		);
	}
	protected function registerDependantModules()
	{
		HashProvider::setHashProviderClassName( 'Rhubarb\Crown\Encryption\Sha512HashProvider' );
		Module::registerModule( new LayoutModule( 'Cant\Phase\Me\Layouts\DefaultLayout' ) );
	}
}
Module::registerModule(new CantPhaseMeModule());