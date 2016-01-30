<?php

namespace Cant\Phase\Me\Presenters\Admin\Npc;

use Rhubarb\Patterns\Mvp\Crud\ModelForm\ModelFormPresenter;

class NpcEditPresenter extends ModelFormPresenter
{
    protected function createView()
    {
        return new NpcEditView();
    }
}