<?php

namespace Cant\Phase\Me\Layouts;

use Rhubarb\Crown\Html\ResourceLoader;
use Rhubarb\Patterns\Layouts\BaseLayout;

class PhasedBaseLayout extends BaseLayout
{
	function __construct()
	{
		ResourceLoader::loadResource( '/static/css/base.css' );
		ResourceLoader::loadResource( '/static/css/general.css' );
		ResourceLoader::loadResource( "/static/css/bootstrap.min.css" );
	}

}