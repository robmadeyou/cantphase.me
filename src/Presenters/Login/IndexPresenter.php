<?php

namespace Cant\Phase\Me\Presenters\Login;

use Cant\Phase\Me\Model\PhasedUser\PhasedUser;
use Rhubarb\Crown\Exceptions\ForceResponseException;
use Rhubarb\Crown\LoginProviders\Exceptions\LoginDisabledException;
use Rhubarb\Crown\LoginProviders\Exceptions\LoginFailedException;
use Rhubarb\Crown\Response\RedirectResponse;
use Rhubarb\Scaffolds\Authentication\LoginProvider;
use Rhubarb\Stem\Exceptions\RecordNotFoundException;
use Rhubarb\Stem\Filters\Equals;

class IndexPresenter extends \Cant\Phase\Me\Presenters\IndexPresenter
{
    protected function CreateView()
    {
	    return new IndexView();
    }

	protected function configureView()
	{
		parent::configureView();

		$this->view->hasOverlay = true;

		$this->view->attachEventHandler( 'login', function( $user, $pass )
		{
			$providerName = LoginProvider::getDefaultLoginProviderClassName();
			$login = new $providerName( "PhasedUser", "Username", "Password", "Enabled" );
			try
			{
				PhasedUser::findFirst( new Equals( "Username", $user ) );
				try
				{
					if ( $login->login( $user, $pass ) )
					{
						return 1;
					}
				} catch ( LoginDisabledException $er )
				{
					$this->Disabled = true;
					$this->Failed = true;

					return 3;
				} catch ( LoginFailedException $er )
				{
					$this->Failed = true;

					return 4;
				}
			} catch ( RecordNotFoundException $ex )
			{
				$u = new PhasedUser();
				$u->Username = $user;
				$u->setNewPassword( $pass );
				$u->Forename = $user;
				$u->save();

				$login->login( $user, $pass );

				return 2;
			}
			return 0;
		});
	}
}