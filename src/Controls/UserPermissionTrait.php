<?php

namespace Cant\Phase\Me\Controls;

use Rhubarb\Crown\Exceptions\ForceResponseException;
use Rhubarb\Crown\Response\RedirectResponse;
use Rhubarb\Scaffolds\Authentication\LoginProvider;

trait UserPermissionTrait
{
	function __construct()
	{
		parent::__construct();

		if( (new LoginProvider())->getLoggedInUser()->Authority < $this->GetMinimumPermissionLevel() )
		{
			throw new ForceResponseException( new RedirectResponse( '/' ) );
		}
	}

	/**
	 * Permission levels, the higher the bigger the permission the user has. Admin should
	 * always be at the max
	 * @return int
	 */
	public function GetMinimumPermissionLevel()
	{
		return 1000;
	}

	public function GetErrorMessage()
	{

	}
}