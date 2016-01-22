<?php

namespace Cant\Phase\Me\Layouts;


use Rhubarb\Leaf\LayoutProviders\FieldSetWithLabelsLayoutProvider;
use Rhubarb\Leaf\Presenters\Controls\ControlPresenter;
use Rhubarb\Leaf\Presenters\Controls\Text\TextBox\TextBox;
use Rhubarb\Leaf\Presenters\Presenter;

class PhasedLayoutProvider extends FieldSetWithLabelsLayoutProvider
{
    public function printValueWithLabel( $value, $label )
    {
        $controlName = (is_object($value) && ($value instanceof Presenter)) ? $value->getDisplayIdentifier() : "";
        ?>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="<?= $controlName; ?>"><?php $this->printLabel($label); ?></label>

            <div class="col-sm-10 control-value">
                <?php $this->printValue($value); ?>
            </div>
        </div>
        <?php
    }

    public function printValue( $value )
    {
        print $value;

        if ($value instanceof Presenter) {
            print $this->generatePlaceholder($value->getName());
        }
    }
}