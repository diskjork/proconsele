<?php /* @var $this Controller */ ?>
<?php  Yii::app()->bootstrap->register();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/indexPrincipal.css" />
	
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	
	<link href='<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.png' rel='shortcut icon' type='image/png' />
</head>

<body>

<div class="container" id="page">
	 
	<!-- <div id="header">
		<div id="logo"><img src="/images/yvn.jpg" alt="logo"/></div>
	</div><!-- header -->
	
	<?php

		$this->widget('bootstrap.widgets.TbNavbar', array(
			'brandLabel'=>"<img src=".Yii::app()->request->baseUrl."/images/logoyvn.jpg alt='logo' width='200' height='180'/>", //echo CHtml::encode(Yii::app()->name); 
			//'brandUrl'=>Yii::app()->request->baseUrl,
			'collapse'=>true, // requires bootstrap-responsive.css
			//'color' => TbHtml::NAVBAR_COLOR_INVERSE,
			'display'=>null,
			'items'=>array(
				array(
					'class'=>'bootstrap.widgets.TbNav',
					'items'=>array(
						array('label'=>'DASHBOARD','icon'=>'icon-th-large','url'=>Yii::app()->request->baseUrl.'/index.php'),
						array('label'=>'REPORTES','icon'=>'icon-signal','url'=>Yii::app()->request->baseUrl.'/index.php/reporte/index'),
						array('label'=>'CUENTAS','icon'=>'icon-signal','url'=>'#',
							'items'=>array(
									array('label'=>'CUENTAS','url'=>Yii::app()->request->baseUrl.'/index.php/cuenta/admin'),
									array('label'=>'ASIENTO','url'=>Yii::app()->request->baseUrl.'/index.php/asiento/admin'),
							)
						),
						array('label'=>'CONFIGURACION','icon'=>'icon-wrench','url'=>'#',
								'items'=>array(
									array('label'=>'Usuarios', 'url'=>Yii::app()->request->baseUrl.'/index.php/user/admin'),
									array('label'=>'Contraseña', 'url'=>Yii::app()->request->baseUrl.'/index.php/user/updateClave'),
								)),	
						
					array('label'=>'Acceder', 'icon'=>'icon-check','url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
					array('label'=>'Salir ('.Yii::app()->user->name.')', 'icon'=>'icon-lock','url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
	
					),
				),
				),
				
			));
			?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by J&P.<br/>
		Todos los derechos reservados.<br/>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
