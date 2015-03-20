<?php

namespace Cant\Phase\Me\Presenters\Login;

class IndexView extends \Cant\Phase\Me\Presenters\IndexView
{
    protected function PrintViewContent()
    {
	    parent::PrintViewContent();
		print "Howdy";
    }
}