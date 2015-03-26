<?php
namespace Cant\Phase\Me;

use Rhubarb\Crown\Encryption\HashProvider;
use Rhubarb\Crown\Layout\LayoutModule;
use Rhubarb\Crown\Module;
use Rhubarb\Crown\UrlHandlers\ClassMappedUrlHandler;
use Rhubarb\Scaffolds\AuthenticationWithRoles\AuthenticationWithRolesModule;
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

		$login =  new ClassMappedUrlHandler( 'Cant\Phase\Me\Presenters\Login\IndexPresenter', [
			"signup" => new ClassMappedUrlHandler( 'Cant\Phase\Me\Presenters\Login\Signup\IndexPresenter')
		] );
		$login->setPriority( 11 );

		$this->addUrlHandlers(
			[
				"/" => new ClassMappedUrlHandler( 'Cant\Phase\Me\Presenters\IndexPresenter',
					[
						'music/' => new ClassMappedUrlHandler( 'Cant\Phase\Me\Presenters\Music\MusicCollectionPresenter' )
					]),
				"/login/" => $login
			]
		);
	}
	protected function registerDependantModules()
	{
		HashProvider::setHashProviderClassName( 'Rhubarb\Crown\Encryption\Sha512HashProvider' );
		Module::registerModule( new LayoutModule( 'Cant\Phase\Me\Layouts\DefaultLayout' ) );
		Module::registerModule( new AuthenticationWithRolesModule( 'Rhubarb\Scaffolds\Authentication\LoginProvider') );
	}
}
Module::registerModule(new CantPhaseMeModule());