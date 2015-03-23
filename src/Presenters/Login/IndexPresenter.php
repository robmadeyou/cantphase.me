<?php

namespace Cant\Phase\Me\Presenters\Login;

use Cant\Phase\Me\Model\PhasedUser\PhasedUser;
use Cant\Phase\Me\Various\PhasedLoginProvider;
use Rhubarb\Crown\LoginProviders\Exceptions\LoginDisabledException;
use Rhubarb\Crown\LoginProviders\Exceptions\LoginFailedException;
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

		$this->view->attachEventHandler( 'login', function( $user, $pass, $email, $info )
		{
			try
			{
				$login = new PhasedLoginProvider( "PhasedUser", "Username", "Password", "Enabled" );
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

						return 3;
					}
				} catch ( RecordNotFoundException $ex )
				{
					$user = new PhasedUser();
					$user->Username = $user;
					$user->setNewPassword( $pass );
					$user->Forename = $user;
					$user->Email = $email;
					$user->Info = $info;
					$user->save();

					$login->login( $user, $pass );

					return 2;
				}
			}
			catch( \Exception $ex )
			{
				return $ex;
			}
			return 0;
		});
	}
}