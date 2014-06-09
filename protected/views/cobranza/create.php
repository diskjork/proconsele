<?php
/* @var $this CobranzaController */
/* @var $model Cobranza */
?>

<?php
$this->breadcrumbs=array(
	'Cobranzas'=>array('index'),
	'Create',
);

/*$this->menu=array(
	array(
		'label'=>'Nueva Cobranza', 
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
	
<h5 class="well well-small">COBRANZA: <?php echo $nombre;?></h5>
<br>	

<?php $this->renderPartial('_form', array('model'=>$model,'member'=>$member,'validatedMembers'=>$validatedMembers,'idctacte'=>$idctacte,'nombre'=>$nombre)); ?>

