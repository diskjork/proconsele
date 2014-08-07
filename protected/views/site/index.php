<?php
/* @var $this SiteController */

?>
<style type="text/css">
.table-bordered th, .table-bordered td
{font-size:10px;}
</style>
<?php
$this->pageTitle=Yii::app()->name;
?>
<h3>Dashboard</h3>
<div id="bloqueMain">
	<div id="bloqueUpRight">
	<div id="tituloDashboard">Compras por mes</div>
	<br>
	<?php
		$compras = new Compras;
		$dataProviderCompras = $compras->reporteCompras(date('Y'));
		$dataCompras=$dataProviderCompras->getData();
		//foreach ($dataCompras as $data){}

		$gridColumnsCompras= array(
			//'idmateriaprima',
			
            array(
				'value'=>'number_format($data->ene,2,".",",")',
				'header'=>'ENE',
				 
				),

			array(
				'header'=>'FEB',
				'value'=>'number_format($data->feb,2,".",",")',
				 
				),
			array(
				'header'=>'MAR',
				'value'=>'number_format($data->mar,2,".",",")',
				 
				),
			array(
				'header'=>'ABR',
				'value'=>'number_format($data->abr,2,".",",")',
				 
			),
			array(
				'header'=>'MAY',
				'value'=>'number_format($data->may,2,".",",")',
				 
				),
			array(
				'header'=>'JUN',
				'value'=>'number_format($data->jun,2,".",",")',
				 
				),
			array(
				'header'=>'JUL',
				'value'=>'number_format($data->jul,2,".",",")',
				 
				),
			array(
				'header'=>'AGO',
				'value'=>'number_format($data->ago,2,".",",")',
				 
				),
			array(
				'header'=>'SEP',
				'value'=>'number_format($data->sep,2,".",",")',
				 
				),
			array(
				'header'=>'OCT',
				'value'=>'number_format($data->oct,2,".",",")',
				 
				),
			array(
				'header'=>'NOV',
				'value'=>'number_format($data->nov,2,".",",")',
				 
				),
			array(
				'header'=>'DIC',
				'value'=>'number_format($data->dic,2,".",",")',
				 
				),
 		);
	?>
	<br>
	<?php 
		$this->widget('yiiwheels.widgets.grid.WhGridView', array(
	    //'filter'=>$model,
	    //'fixedHeader' => true,
	    //'headerOffset' => 0, // 40px is the height of the main navigation at bootstrap
	    'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED),
		//'rowCssClassExpression'=>'$data->color', //Se debe modificar linea 32 y 38 de profile.css
	    'dataProvider' => $dataProviderCompras,
	    'columns' => $gridColumnsCompras,
		'summaryText'=>'',
		'template'=>'{items}',
		//'pagerCssClass'=>'pagination pagination-small pagination-centered',
	    ));
	?>		
	
	
	</div>
	
	<div id="bloqueUpLeft">
	<div id="tituloDashboard">Facturación por mes</div>
	<br>
	<?php
		$factura = new Factura;
		$dataProviderfactura = $factura->reportefactura(date('Y'));
		$datafactura=$dataProviderfactura->getData();
		//foreach ($datafactura as $data){}

		$gridColumnsfactura= array(
			//'idmateriaprima',
			
            array(
				'value'=>'number_format($data->ene,2,".",",")',
				'header'=>'ENE',
				 
				),

			array(
				'header'=>'FEB',
				'value'=>'number_format($data->feb,2,".",",")',
				 
				),
			array(
				'header'=>'MAR',
				'value'=>'number_format($data->mar,2,".",",")',
				 
				),
			array(
				'header'=>'ABR',
				'value'=>'number_format($data->abr,2,".",",")',
				 
			),
			array(
				'header'=>'MAY',
				'value'=>'number_format($data->may,2,".",",")',
				 
				),
			array(
				'header'=>'JUN',
				'value'=>'number_format($data->jun,2,".",",")',
				 
				),
			array(
				'header'=>'JUL',
				'value'=>'number_format($data->jul,2,".",",")',
				 
				),
			array(
				'header'=>'AGO',
				'value'=>'number_format($data->ago,2,".",",")',
				 
				),
			array(
				'header'=>'SEP',
				'value'=>'number_format($data->sep,2,".",",")',
				 
				),
			array(
				'header'=>'OCT',
				'value'=>'number_format($data->oct,2,".",",")',
				 
				),
			array(
				'header'=>'NOV',
				'value'=>'number_format($data->nov,2,".",",")',
				 
				),
			array(
				'header'=>'DIC',
				'value'=>'number_format($data->dic,2,".",",")',
				 
				),
 		);
	?>
	<br>
	<?php 
		$this->widget('yiiwheels.widgets.grid.WhGridView', array(
	    //'filter'=>$model,
	    //'fixedHeader' => true,
	    //'headerOffset' => 0, // 40px is the height of the main navigation at bootstrap
	    'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED),
		//'rowCssClassExpression'=>'$data->color', //Se debe modificar linea 32 y 38 de profile.css
	    'dataProvider' => $dataProviderfactura,
	    'columns' => $gridColumnsfactura,
		'summaryText'=>'',
		'template'=>'{items}',
		//'pagerCssClass'=>'pagination pagination-small pagination-centered',
	    ));
	?>	
	
	</div>
	<div id="bloqueDownRight">
		<div id="tituloDashboard">Total de IVA COMPRAS por mes</div>
		<br>	
	<?php
		$compras = new Compras;
		$dataProviderCompras = $compras->reporteComprasIVA(date('Y'));
		$dataCompras=$dataProviderCompras->getData();
		//foreach ($dataCompras as $data){}

		$gridColumnsCompras= array(
			//'idmateriaprima',
			
            array(
				'value'=>'number_format($data->ene,2,".",",")',
				'header'=>'ENE',
				 
				),

			array(
				'header'=>'FEB',
				'value'=>'number_format($data->feb,2,".",",")',
				 
				),
			array(
				'header'=>'MAR',
				'value'=>'number_format($data->mar,2,".",",")',
				 
				),
			array(
				'header'=>'ABR',
				'value'=>'number_format($data->abr,2,".",",")',
				 
			),
			array(
				'header'=>'MAY',
				'value'=>'number_format($data->may,2,".",",")',
				 
				),
			array(
				'header'=>'JUN',
				'value'=>'number_format($data->jun,2,".",",")',
				 
				),
			array(
				'header'=>'JUL',
				'value'=>'number_format($data->jul,2,".",",")',
				 
				),
			array(
				'header'=>'AGO',
				'value'=>'number_format($data->ago,2,".",",")',
				 
				),
			array(
				'header'=>'SEP',
				'value'=>'number_format($data->sep,2,".",",")',
				 
				),
			array(
				'header'=>'OCT',
				'value'=>'number_format($data->oct,2,".",",")',
				 
				),
			array(
				'header'=>'NOV',
				'value'=>'number_format($data->nov,2,".",",")',
				 
				),
			array(
				'header'=>'DIC',
				'value'=>'number_format($data->dic,2,".",",")',
				 
				),
 		);
	?>
	<br>
	<?php 
		$this->widget('yiiwheels.widgets.grid.WhGridView', array(
	    //'filter'=>$model,
	    //'fixedHeader' => true,
	    //'headerOffset' => 0, // 40px is the height of the main navigation at bootstrap
	    'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED),
		//'rowCssClassExpression'=>'$data->color', //Se debe modificar linea 32 y 38 de profile.css
	    'dataProvider' => $dataProviderCompras,
	    'columns' => $gridColumnsCompras,
		'summaryText'=>'',
		'template'=>'{items}',
		//'pagerCssClass'=>'pagination pagination-small pagination-centered',
	    ));
	?>		
		
		</div>
	<div id="bloqueDownLeft">
		<div id="tituloDashboard">Total de IVA VENTAS por mes</div>
	<br>	
	<?php
		$factura = new Factura;
		$dataProviderfactura = $factura->reportefacturaIVA(date('Y'));
		$datafactura=$dataProviderfactura->getData();
		foreach ($datafactura as $data){}

		$gridColumnsfactura= array(
			//'idmateriaprima',
			
            array(
				'value'=>'number_format($data->ene,2,".",",")',
				'header'=>'ENE',
				 
				),

			array(
				'header'=>'FEB',
				'value'=>'number_format($data->feb,2,".",",")',
				 
				),
			array(
				'header'=>'MAR',
				'value'=>'number_format($data->mar,2,".",",")',
				 
				),
			array(
				'header'=>'ABR',
				'value'=>'number_format($data->abr,2,".",",")',
				 
			),
			array(
				'header'=>'MAY',
				'value'=>'number_format($data->may,2,".",",")',
				 
				),
			array(
				'header'=>'JUN',
				'value'=>'number_format($data->jun,2,".",",")',
				 
				),
			array(
				'header'=>'JUL',
				'value'=>'number_format($data->jul,2,".",",")',
				 
				),
			array(
				'header'=>'AGO',
				'value'=>'number_format($data->ago,2,".",",")',
				 
				),
			array(
				'header'=>'SEP',
				'value'=>'number_format($data->sep,2,".",",")',
				 
				),
			array(
				'header'=>'OCT',
				'value'=>'number_format($data->oct,2,".",",")',
				 
				),
			array(
				'header'=>'NOV',
				'value'=>'number_format($data->nov,2,".",",")',
				 
				),
			array(
				'header'=>'DIC',
				'value'=>'number_format($data->dic,2,".",",")',
				 
				),
 		);
	?>
	<br>
	<?php 
		$this->widget('yiiwheels.widgets.grid.WhGridView', array(
	    //'filter'=>$model,
	    //'fixedHeader' => true,
	    //'headerOffset' => 0, // 40px is the height of the main navigation at bootstrap
	    'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED),
		//'rowCssClassExpression'=>'$data->color', //Se debe modificar linea 32 y 38 de profile.css
	    'dataProvider' => $dataProviderfactura,
	    'columns' => $gridColumnsfactura,
		'summaryText'=>'',
		'template'=>'{items}',
		//'pagerCssClass'=>'pagination pagination-small pagination-centered',
	    ));
	?>	
	
		</div>
</div>