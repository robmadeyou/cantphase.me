<?php

namespace Cant\Phase\Me\Presenters\Admin;

use Cant\Phase\Me\Layouts\AdminLayout;
use Rhubarb\Crown\Html\ResourceLoader;
use Rhubarb\Crown\Layout\LayoutModule;
use Rhubarb\Patterns\Mvp\Crud\ModelForm\ModelFormPresenter;

class AdminIndexPresenter extends ModelFormPresenter
{
    protected function createView()
    {
        LayoutModule::setLayoutClassName( AdminLayout::class );
        return new AdminIndexView();
    }
}