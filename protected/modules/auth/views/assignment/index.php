<?php
/* @var $this AssignmentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    Yii::t('AuthModule.main', 'Assignments'),
);
?>

<h5 class="well well-small">ASIGNACION DE PERMISOS</h5>

<?php //$this->widget('bootstrap.widgets.TbGridView',
    $this->widget('yiiwheels.widgets.grid.WhGridView',
	array(
        'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED,TbHtml::GRID_TYPE_HOVER),
        'dataProvider' => $dataProvider,
        'emptyText' => Yii::t('AuthModule.main', 'No assignments found.'),
        //'template' => "{items}\n{pager}",
        'columns' => array(
    		array(
		    	'value'=>'$this->grid->dataProvider->pagination->currentPage*
		        $this->grid->dataProvider->pagination->pageSize + $row+1',
		        'htmlOptions'=>array('style'=>'text-align:center;width:30px;'),
        	),
            array(
                'header' => 'USUARIO',
                'class' => 'AuthAssignmentNameColumn',
            ),
            array(
                'header' => 'PERMISOS ASIGNADOS',
                'class' => 'AuthAssignmentItemsColumn',
            ),
            /*array(
                'class' => 'AuthAssignmentViewColumn',
            ),*/
        ),
    )
); ?>
