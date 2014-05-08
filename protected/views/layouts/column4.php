<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="span-5 last-1">
	<div id="sidebar">
	<?php
	$this->menu=array(
		array(
			'label'=>'Usuarios', 
			'url'=>Yii::app()->request->baseUrl.'/index.php/user/admin',
		),
		array(
			'label'=>'Permisos', 
			'url'=>Yii::app()->request->baseUrl.'/index.php/auth/assignment',
		),
	);
	?>
	
	<?php
	array_unshift($this->menu, array('label' => 'Operaciones'));
	?>
	<div class="well" style="max-width: 240px; padding: 8px 0;">
    <?php echo TbHtml::navList(
	       $this->menu
    ); ?>
	</div>	
	
	</div><!-- sidebar -->
</div>
<div class="span-19">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>

<?php $this->endContent(); ?>