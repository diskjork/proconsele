<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>
<?php //echo $code; ?>
<br>
<h4 class="well well-small error" align="center">
	<?php echo CHtml::encode($message); ?>
</h4>