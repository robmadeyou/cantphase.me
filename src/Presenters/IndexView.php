<?php

namespace Cant\Phase\Me\Presenters;

use Rhubarb\Leaf\Views\HtmlView;

class IndexView extends HtmlView
{
    protected function PrintViewContent()
    {
		print "Hello!";
    }
}