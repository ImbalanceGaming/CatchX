<?php
/**
 * Created by PhpStorm.
 * User: Christopher
 * Date: 27/06/2015
 * Time: 18:24
 */

namespace Gas;

abstract class ExtendedGasORM extends ORM{

    public function _after_save() {

        $this->id = $this::last_created()->id;
        return $this;

    }

}