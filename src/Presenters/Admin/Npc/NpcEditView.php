<?php

namespace Cant\Phase\Me\Presenters\Admin\Npc;

use Cant\Phase\Me\Models\Npc;
use Rhubarb\Leaf\Presenters\Application\Table\Table;
use Rhubarb\Leaf\Views\WithJqueryViewBridgeTrait;
use Rhubarb\Patterns\Mvp\Crud\CrudView;

class NpcEditView extends CrudView
{
    use WithJqueryViewBridgeTrait;

    public function createPresenters()
    {
        parent::createPresenters();

        $this->addPresenters(
            "NpcID",
            "NpcName",
            "Combat",
            "Health",
            "SpawnX",
            "SpawnY",
            "Height",
            "Walk",
            "MaxHit",
            "Attack",
            "Defence",
            "Description"
        );
    }

    protected function printViewContent()
    {
        $this->printFieldset( "", [
            "NpcID",
            "NpcName",
            "Combat",
            "Health",
            "SpawnX",
            "SpawnY",
            "Height",
            "Walk",
            "MaxHit",
            "Attack",
            "Defence",
            "Description"
        ] );
    }

    public function getDeploymentPackageDirectory()
    {
        return __DIR__;
    }
}