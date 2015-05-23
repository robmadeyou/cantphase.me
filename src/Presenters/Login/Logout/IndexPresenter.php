<?php

namespace Cant\Phase\Me\Presenters\Login\Logout;

use Rhubarb\Crown\Exceptions\ForceResponseException;
use Rhubarb\Crown\Response\RedirectResponse;
use Rhubarb\Leaf\Presenters\Forms\Form;
use Rhubarb\Scaffolds\Authentication\LoginProvider;

class IndexPresenter extends Form
{
	protected function createView()
	{
		$providerName = LoginProvider::getDefaultLoginProviderClassName();
		$login = new $providerName( "PhasedUser", "Username", "Password", "Enabled" );
		$login->logout();

		throw new ForceResponseException( new RedirectResponse( '/' ) );
	}
}