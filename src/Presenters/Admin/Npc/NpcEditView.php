<?php

namespace Cant\Phase\Me\Presenters\Admin\Npc;

use Cant\Phase\Me\Models\Npc;
use Rhubarb\Leaf\Presenters\Application\Table\Table;
use Rhubarb\Patterns\Mvp\Crud\CrudView;

class NpcEditView extends CrudView
{
    public function createPresenters()
    {
        parent::createPresenters();



        $this->addPresenters(
        );
    }

    protected function printViewContent()
    {
        print $this->presenters[ 'NpcTable' ];
    }
}