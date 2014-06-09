<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'jobDialog',
                'options'=>array(
                    'title'=>Yii::t('proveedor','Cargar nuevo Proveedor'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'500',
                    'height'=>'400',
                ),
                ));
echo $this->renderPartial('_formDialog', array('model'=>$model)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>