<?php 
	use yii\helpers\Html; 
	use yii\helpers\Url;
?>
<!-- BEGIN SIDEBAR -->
	<!-- BEGIN MENU -->
	<div class="page-sidebar" id="main-menu"> 
		<div class="page-sidebar-wrapper scrollbar-dynamic" id="main-menu-wrapper">
			<!-- BEGIN MINI-PROFILE -->
			<div class="user-info-wrapper">	
				<?php /*<div class="profile-wrapper">
					<img src="<?php echo Yii::getAlias('@web/uploads/app_img').'/avatar.jpg';?>" alt="" data-src="<?php echo Yii::getAlias('@web/uploads/app_img').'/avatar.jpg';?>" data-src-retina="<?php echo Yii::getAlias('@web/uploads/app_img').'/avatar.jpg';?>" width="69" height="69" />
					</div> */	
				?>
				<div class="user-info">
					<div class="greeting">Welcome <?php echo Yii::$app->user->identity->username; ?> </div>
					<div class="username"> <span class="semi-bold"> <?php //echo Yii::$app->user->identity->admin_name; ?> </span></div>
					<?php /* <div class="status">Status<a href="#"><div class="status-icon green"></div>Online</a></div> */ ?>
				</div>
			</div>
			<!-- END MINI-PROFILE -->
			<!-- BEGIN SIDEBAR MENU -->
			<?php 
				$Controller = get_class($this->context);
				$action 	= $this->context->action->id;
				$menu 		= explode('\\',$Controller);
				$menu_act 	= $menu[2];
			?>
			<p class="menu-title"><span class="pull-right"><a href="javascript:;"></a></span></p> 
			<ul>
				<li class="<?php if ($menu_act == 'DefaultController') {echo "active"; } else  {echo "noactive";}?>">
					<a class="link-title" href="<?= Url::to(['/site/index']) ?>">
						<i class="icon-custom-home"></i>
						<span class="title">Dashboard</span>
					</a>
				</li>
			</ul>
			<!-- END SIDEBAR MENU -->

			<div class="clearfix"></div>
			<!-- END SIDEBAR WIDGETS --> 
		</div>
	</div>
	<!-- BEGIN SCROLL UP HOVER -->
	<a href="#" class="scrollup">Scroll</a> 
	<!-- END SCROLL UP HOVER -->
	<!-- END MENU -->

<!-- END SIDEBAR --> 
<?php $this->registerJs('$(document).ready(function () {
$(".nav li").removeClass("active");
$(".open").addClass("active");
});'); ?>
