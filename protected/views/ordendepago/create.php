<?php
/* @var $this OrdendepagoController */
/* @var $model ordendepago */
?>

<?php
$this->breadcrumbs=array(
	'Orden de pago'=>array('index'),
	'Create',
);

/*$this->menu=array(
	array(
		'label'=>'Nueva Ordendepago', 
		'url'=>array('create'),
		'active' => true,
	
	),
);*/

?>
<?php 
if(isset($_GET['idctacte'])){
	$idctacte=$_GET['idctacte'];
	$nombre=$_GET['nombre'];
	
	} else{
	$idctacte=null;
	$nombre=null;
	
	}?>
	
<h5 class="well well-small">ORDEN DE PAGO: <?php echo $nombre;?></h5>
<br>	

<?php $this->renderPartial('_form', array('model'=>$model,'member'=>$member,'validatedMembers'=>$validatedMembers,'idctacte'=>$idctacte,'nombre'=>$nombre,'modelchequecargado'=>$modelchequecargado)); ?>

