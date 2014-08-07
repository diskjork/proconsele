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
						//array('label'=>'REPORTES','icon'=>'icon-signal','url'=>Yii::app()->request->baseUrl.'/index.php/reporte/index'),
						array('label'=>'CUENTAS','icon'=>' icon-align-justify','url'=>'#',
							'items'=>array(
									array('label'=>'PLAN DE CUENTAS','url'=>Yii::app()->request->baseUrl.'/index.php/cuenta/admin'),
									array('label'=>'ASIENTO','url'=>Yii::app()->request->baseUrl.'/index.php/asiento/admin'),
									array('label'=>'RESUMEN CUENTAS','url'=>Yii::app()->request->baseUrl.'/index.php/cuenta/seleccuenta'),
							)
						),
						array('label'=>'CLIENTES','icon'=>'icon-star','items'=>array(
							array('label'=>'Administrar','url'=>Yii::app()->request->baseUrl.'/index.php/cliente/admin'),
							array('label'=>'Cuentas Corrientes', 'url'=>Yii::app()->request->baseUrl.'/index.php/ctactecliente/admin'),
							array('label'=>'Notas de Crédito', 'url'=>Yii::app()->request->baseUrl.'/notacredito/admin'),
							array('label'=>'Notas de Débito', 'url'=>Yii::app()->request->baseUrl.'/notadebito/admin'),
						)),
						array('label'=>'PROVEEDORES','icon'=>'icon-star-empty','items'=>array(
							array('label'=>'Administrar','url'=>Yii::app()->request->baseUrl.'/index.php/proveedor/admin'),
							array('label'=>'Cuentas Corrientes', 'url'=>Yii::app()->request->baseUrl.'/index.php/ctacteprov/admin'),
							array('label'=>'Notas de Crédito', 'url'=>Yii::app()->request->baseUrl.'/notacreditoprov/admin'),
							array('label'=>'Notas de Débito', 'url'=>Yii::app()->request->baseUrl.'/notadebitoprov/admin'),
						)),
						array('label'=>'VALORES','icon'=>'icon-briefcase', 'url'=>'#',
								'items'=>array(
									array('label'=>'Caja', 'url'=>Yii::app()->request->baseUrl.'/index.php/movimientocaja/admin'),
									array('label'=>'Banco', 'url'=>Yii::app()->request->baseUrl.'/movimientobanco/admin'),
									array('label'=>'Cheques', 'url'=>'#',
										 'items'=>array(
												array('label'=>'Cheques emitidos', 'url'=>Yii::app()->request->baseUrl.'/cheque/emitido'),
												array('label'=>'Cheques recibidos', 'url'=>Yii::app()->request->baseUrl.'/cheque/recibido'),
									)),
								)),
						array('label'=>'FACTURACION','icon'=>'icon-file', 'url'=>'#',
								'items'=>array(
									array('label'=>'Administrar', 'url'=>Yii::app()->request->baseUrl.'/factura/admin'),
												
								)),
						array('label'=>'COMPRAS','icon'=>'icon-shopping-cart', 'url'=>'#',
								'items'=>array(
									array('label'=>'Administrar', 'url'=>Yii::app()->request->baseUrl.'/compras/admin'),
									
								)),
						array('label'=>'LIBROS IVA','icon'=>'icon-book', 'url'=>'#',
								'items'=>array(
									array('label'=>'LIBRO IVA COMPRAS', 'url'=>Yii::app()->request->baseUrl.'/ivamovimiento/tabscompras'),
									array('label'=>'LIBRO IVA VENTA', 'url'=>Yii::app()->request->baseUrl.'/ivamovimiento/tabsventas'),
								)),
						array('label'=>'PRODUCTOS','icon'=>'icon-inbox', 'url'=>'#',
								'items'=>array(
									array('label'=>'Administrar', 'url'=>Yii::app()->request->baseUrl.'/producto/admin'),
									
								)),
						array('label'=>'CONFIGURACION','icon'=>'icon-wrench','url'=>'#',
								'items'=>array(
									array('label'=>'Datos Empresa', 'url'=>Yii::app()->request->baseUrl.'/index.php/empresa/admin'),
									array('label'=>'Usuarios y Permisos', 'url'=>Yii::app()->request->baseUrl.'/index.php/user/admin'),
									array('label'=>'Contraseña', 'url'=>Yii::app()->request->baseUrl.'/index.php/user/updateClave'),
									array('label'=>'Cuentas bancarias', 'url'=>Yii::app()->request->baseUrl.'/index.php/ctabancaria/admin'),
									array('label'=>'Chequeras', 'url'=>Yii::app()->request->baseUrl.'/index.php/chequera/admin'),
									array('label'=>'Cajas', 'url'=>Yii::app()->request->baseUrl.'/index.php/caja/admin'),
									//array('label'=>'Contribuyente', 'url'=>Yii::app()->request->baseUrl.'/index.php/tipodecontribuyente/admin'),
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
