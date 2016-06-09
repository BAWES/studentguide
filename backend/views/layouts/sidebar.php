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
				$Controller 	=	get_class($this->context);
				$action 		=	$this->context->action->id;
				$menu 			=	explode('\\',$Controller);
				$menu_act 		=	$menu[2];
			?>
			<p class="menu-title"><span class="pull-right"><a href="javascript:;"></a></span></p> 
			<ul>
				<li class="<?php if ($menu_act == 'SiteController' && $action != "send_notification") {echo "active"; } else  {echo "noactive";}?>">
					<a class="link-title" href="<?= Url::to(['/site/index']) ?>">
						<i class="icon-custom-home"></i>
						<span class="title">Dashboard</span>
					</a>
				</li>
				<li class="<?php if ($menu_act == 'SettingController') {echo "active"; } else  {echo "noactive";}?>">
					<a class="link-title" href="<?= Url::to(['/setting/index']) ?>">
						<i class="fa fa-gear"></i>
						<span class="title">Setting</span>
					</a>
				</li>
				<li class="<?php if ($menu_act == 'AreaController') {echo "active"; } else  {echo "noactive";}?>">
					<a class="link-title" href="<?= Url::to(['/area/index']) ?>">
						<i class="fa fa-map-marker"></i>
						<span class="title">Area</span>
					</a>
				</li>
				<li class="<?php if ($menu_act == 'CategoryController') {echo "active"; } else  {echo "noactive";}?>">
					<a class="link-title" href="<?= Url::to(['/category/index']) ?>">
						<i class="fa fa-bars"></i>
						<span class="title">Category</span>
					</a>
				</li>
				<li class="<?php if ($menu_act == 'VendorController') {echo "active"; } else  {echo "noactive";}?>">
					<a class="link-title" href="<?= Url::to(['/vendor/index']) ?>">
						<i class="fa fa-users"></i>
						<span class="title">Vendor</span>
					</a>
				</li>
				<li class="<?php if ($menu_act == 'EnquiryController') {echo "active"; } else  {echo "noactive";}?>">
					<a class="link-title" href="<?= Url::to(['/enquiry/index']) ?>">
						<i class="fa fa-book"></i>
						<span class="title">Contact Enquiries</span>
					</a>
				</li>
				<li class="<?php if ($menu_act == 'SiteController' && $action == "send_notification") {echo "active"; } else  {echo "noactive";}?>">
					<a class="link-title" href="<?= Url::to(['/site/send_notification']) ?>">
						<i class="fa fa-paper-plane"></i>
						<span class="title">Push Notification</span>
					</a>
				</li>
				<li class="<?php if ($menu_act == 'PushnotificationhistoryController') {echo "active"; } else  {echo "noactive";}?>">
					<a class="link-title" href="<?= Url::to(['/pushnotificationhistory/index']) ?>">
						<i class="fa fa-paper-plane"></i>
						<span class="title">Push Notification History</span>
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
