<?php

namespace Cant\Phase\Me\Presenters\Admin;

use Cant\Phase\Me\Handler\Server;
use Cant\Phase\Me\Layouts\AdminLayout;
use Rhubarb\Crown\Layout\LayoutModule;
use Rhubarb\Patterns\Mvp\Crud\ModelForm\ModelFormPresenter;

class AdminIndexPresenter extends ModelFormPresenter
{
    protected function createView()
    {
        LayoutModule::setLayoutClassName( AdminLayout::class );
        return new AdminIndexView();
    }

    protected function configureView()
    {
        $this->view->attachEventHandler( 'LoadItemsIntoSLQ', function()
        {
            $a = Server::LoadCFG( 'item.cfg' );
            //print $a;
            return $a;
        });
        return parent::configureView();
    }
}