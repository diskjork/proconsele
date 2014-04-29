<?php
abstract class XActiveRecord extends GxActiveRecord {
    protected function beforeValidate()
    {
            foreach($this->owner->getTableSchema()->columns as $name => $column)
            {
                if (preg_match('/^decimal\(\d+,(\d+)\)/',$column->dbType,$m) && ($value=$this->$name)!==null)
                    $this->$name=str_replace(',','.',$this->$name);
            }
        return parent::beforeValidate();
    }
}
?>