<?php

namespace Cant\Phase\Me\Presenters\Admin\Npc;

use Cant\Phase\Me\Layouts\AdminLayout;
use Rhubarb\Crown\Layout\LayoutModule;
use Rhubarb\Patterns\Mvp\Crud\ModelForm\ModelFormPresenter;

class NpcEditPresenter extends ModelFormPresenter
{
    protected function createView()
    {
        LayoutModule::setLayoutClassName( AdminLayout::class );
        return new NpcEditView();
    }
}