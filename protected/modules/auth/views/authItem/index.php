<?php
/* @var $this OperationController|TaskController|RoleController */
/* @var $dataProvider AuthItemDataProvider */

$this->breadcrumbs = array(
    $this->capitalize($this->getTypeText(true)),
);
?>

<h5 class="well well-small"><?php echo strtoupper($this->capitalize($this->getTypeText(true))); ?></h5>
<br>
<?php echo TbHtml::linkButton(
    Yii::t('AuthModule.main', 'Add {type}', array('{type}' => $this->getTypeText())),
    array(
        'color' => TbHtml::BUTTON_COLOR_PRIMARY,
    	'size' => TbHtml::BUTTON_SIZE_SMALL,
        'url' => array('crear'),
    )
); ?>

<?php  $this->widget('yiiwheels.widgets.grid.WhGridView',
    array(
        'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED,TbHtml::GRID_TYPE_HOVER),
        'dataProvider' => $dataProvider,
        'emptyText' => Yii::t('AuthModule.main', 'No {type} found.', array('{type}' => $this->getTypeText(true))),
        //'template' => "{items}\n{pager}",
        'columns' => array(
    		array(
		    	'value'=>'$this->grid->dataProvider->pagination->currentPage*
		        $this->grid->dataProvider->pagination->pageSize + $row+1',
		        'htmlOptions'=>array('style'=>'text-align:center;width:30px;'),
        	),
            array(
                'name' => 'name',
                'type' => 'raw',
                'header' => Yii::t('AuthModule.main', 'System name'),
                'htmlOptions' => array('class' => 'item-name-column'),
                'value' => "CHtml::link(\$data->name, array('view', 'name'=>\$data->name))",
            ),
            array(
                'name' => 'description',
                'header' => Yii::t('AuthModule.main', 'Description'),
                'htmlOptions' => array('class' => 'item-description-column'),
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'viewButtonLabel' => Yii::t('AuthModule.main', 'View'),
                'viewButtonUrl' => "Yii::app()->controller->createUrl('view', array('name'=>\$data->name))",
                'updateButtonLabel' => Yii::t('AuthModule.main', 'Edit'),
                'updateButtonUrl' => "Yii::app()->controller->createUrl('update', array('name'=>\$data->name))",
                'deleteButtonLabel' => Yii::t('AuthModule.main', 'Delete'),
                'deleteButtonUrl' => "Yii::app()->controller->createUrl('delete', array('name'=>\$data->name))",
                'deleteConfirmation' => Yii::t('AuthModule.main', 'Are you sure you want to delete this item?'),
            ),
        ),
    )
); ?>
