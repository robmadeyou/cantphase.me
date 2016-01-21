<?php

namespace Cant\Phase\Me\Presenters\Admin\Item;

use Cant\Phase\Me\Layouts\AdminLayout;
use Rhubarb\Crown\Layout\LayoutModule;
use Rhubarb\Patterns\Mvp\Crud\ModelForm\ModelFormPresenter;

class ItemEditPresenter extends ModelFormPresenter
{
	protected function createView()
	{
		LayoutModule::setLayoutClassName( AdminLayout::class );
		return new ItemEditView();
	}
}