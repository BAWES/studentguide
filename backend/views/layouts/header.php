<?php 
	use yii\helpers\Url;
?>
<!-- BEGIN HEADER -->

<div class="header navbar navbar-inverse"> 
	<!-- BEGIN TOP NAVIGATION BAR -->
	<div class="navbar-inner">
		<!-- BEGIN NAVIGATION HEADER -->
		
		<div class="header-seperation"> 
			<!-- BEGIN MOBILE HEADER -->
			<ul class="nav pull-left notifcation-center" id="main-menu-toggle-wrapper" style="display:none">	
				<li class="dropdown">
					<a id="main-menu-toggle" href="#main-menu" class="">
						<div class="iconset top-menu-toggle-white"></div>
					</a>
				</li>		 
			</ul>
			<!-- END MOBILE HEADER -->
			<!-- BEGIN LOGO -->	
			<a href="<?php //echo Yii::$app->urlManagerBackEnd->createAbsoluteUrl('/admin/site/index'); ?>">
				<img src="<?= $this->theme->getUrl('img/logo.png') ?>" class="logo" alt="" data-src="<?php //echo Siteinfo::logoUrl();?>" data-src-retina="<?php //echo Siteinfo::logoUrl();?>" width="175" height="55"/>
			</a>
			<?php //echo Yii::getAlias('@logo_url').'/logo.png';
			?>
			<!-- END LOGO -->
			<ul class="nav pull-right notifcation-center">	
			<li class="dropdown" id="header_task_bar"> <a href="<?php //echo Yii::$app->urlManagerBackEnd->createAbsoluteUrl('/admin/site/index'); ?>" class="dropdown-toggle active" data-toggle=""> <div class="iconset top-home"></div> </a> </li>
			<!--<li class="dropdown" id="header_inbox_bar" > <a href="email.html" class="dropdown-toggle" > <div class="iconset top-messages"></div>  <span class="badge" id="msgs-badge">2</span> </a></li>
			<li class="dropdown" id="portrait-chat-toggler" style="display:none"> <a href="#sidr" class="chat-menu-toggle"> <div class="iconset top-chat-white "></div> </a> </li> -->       
		  </ul>
			<!-- END LOGO NAV BUTTONS -->
		</div>
		<!-- END NAVIGATION HEADER -->
		<!-- BEGIN CONTENT HEADER -->
		<div class="header-quick-nav"> 
			<!-- BEGIN HEADER LEFT SIDE SECTION -->
			<div class="pull-left"> 
				<!-- BEGIN SLIM NAVIGATION TOGGLE -->
				<ul class="nav quick-section">
					<li class="quicklinks">
						<a href="#" class="" id="layout-condensed-toggle">
							<div class="iconset top-menu-toggle-dark"></div>
						</a>
					</li>
				</ul>
				<!-- END SLIM NAVIGATION TOGGLE -->				
				<!-- BEGIN HEADER QUICK LINKS -->
				<!--<ul class="nav quick-section">
					<li class="quicklinks"><a href="#" class=""><div class="iconset top-reload"></div></a></li>
					<li class="quicklinks"><span class="h-seperate"></span></li>
					<li class="quicklinks"><a href="#" class=""><div class="iconset top-tiles"></div></a></li>
					<!-- BEGIN SEARCH BOX -->
					<!--<li class="m-r-10 input-prepend inside search-form no-boarder">
						<span class="add-on"><span class="iconset top-search"></span></span>
						<input name="" type="text" class="no-boarder" placeholder="Search Dashboard" style="width:250px;">
					</li>
					<!-- END SEARCH BOX 
				</ul>-->
				<!-- BEGIN HEADER QUICK LINKS -->				
			</div>
			<!-- END HEADER LEFT SIDE SECTION -->
			<!-- BEGIN HEADER RIGHT SIDE SECTION -->
			<div class="pull-right"> 
				<div class="chat-toggler">	
					<!-- BEGIN NOTIFICATION CENTER -->
					<a href="#" <?php /* class="dropdown-toggle" id="my-task-list" */ ?> data-placement="bottom" data-content="" data-toggle="dropdown" data-original-title="Notifications">
						<div class="user-details"> 
							<div class="username">
								<!--<span class="badge badge-important">3</span>-->&nbsp;<span class="bold">&nbsp; <?php // echo ucfirst(Yii::$app->user->identity->admin_name); ?></span>									
							</div>						
						</div>
						&nbsp;&nbsp;&nbsp;
						<!--<div class="iconset top-down-arrow"></div>-->
					</a>	
					<div id="notification-list" style="display:none">
						<div style="width:300px">
						<!-- BEGIN NOTIFICATION MESSAGE 
							<div class="notification-messages info">
								<div class="user-profile">
									<img src="assets/img/profiles/d.jpg" alt="" data-src="assets/img/profiles/d.jpg" data-src-retina="assets/img/profiles/d2x.jpg" width="35" height="35">
								</div>
								<div class="message-wrapper">
									<div class="heading">Title of Notification</div>
									<div class="description">Description...</div>
									<div class="date pull-left">A min ago</div>										
								</div>
								<div class="clearfix"></div>									
							</div>
							<!-- END NOTIFICATION MESSAGE -->	
						</div>				
					</div>
					<!-- END NOTIFICATION CENTER -->
					<?php /*<!-- BEGIN PROFILE PICTURE -->
					<div class="profile-pic"> 
						<img src="<?php echo Yii::getAlias('@web/uploads/app_img').'/avatar.jpg';?>" alt="" data-src="<?php echo Yii::getAlias('@web/uploads/app_img').'/avatar.jpg';?>" data-src-retina="<?php echo Yii::getAlias('@web/uploads/app_img').'/avatar.jpg';?>" width="35" height="35" /> 
					</div>  
					<!-- END PROFILE PICTURE -->
					*/ ?>
				</div>
				<!-- BEGIN HEADER NAV BUTTONS -->
				<ul class="nav quick-section">
					<!-- BEGIN SETTINGS -->
					<li class="quicklinks"> 
						<a data-toggle="dropdown" class="dropdown-toggle pull-right" href="#" id="user-options">						
							<div class="iconset top-settings-dark"></div> 	
						</a>
						<ul class="dropdown-menu  pull-right" role="menu" aria-labelledby="user-options">
						  <li><a href="<?= Url::to(['/site/change_password'])?>">Change password</a>
						  </li>
						  <li class="divider"></li>                
						  <li><a href='<?= Url::to(['/site/logout']) ?>'><i class="fa fa-power-off fa-fw"></i>Log Out</a></li>
					   </ul>
					</li>
					<!-- END SETTINGS 
					<li class="quicklinks"><span class="h-seperate"></span></li> 
					<!-- BEGIN CHAT SIDEBAR TOGGLE 
					<li class="quicklinks"> 	
						<a id="chat-menu-toggle" href="#sidr" class="chat-menu-toggle">
							<div class="iconset top-chat-dark"><span class="badge badge-important hide" id="chat-message-count">1</span></div>
						</a> 
						<!-- BEGIN OPTIONAL RECENT CHAT POP UP NOTIFICATION 
						<div class="simple-chat-popup chat-menu-toggle hide">
							<div class="simple-chat-popup-arrow"></div>
							<div class="simple-chat-popup-inner">
								<div style="width:100px">
									<div class="semi-bold">Name</div>
									<div class="message">Message...</div>
								</div>
							</div>
						</div>
						<!-- END OPTIONAL RECENT CHAT POP UP NOTIFICATION 
					</li>-->
					<!-- END CHAT SIDEBAR TOGGLE --> 
				</ul>
				<!-- END HEADER NAV BUTTONS -->
			</div>
			<!-- END HEADER RIGHT SIDE SECTION -->
		</div> 
		<!-- END CONTENT HEADER --> 
	</div>
	<!-- END TOP NAVIGATION BAR --> 
</div>
<!-- END HEADER -->

<div class="processing_image" style="display: none;">
<img src="<?= $this->theme->getUrl('img/loader.gif') ?>" alt="loading.gif" style="padding-top:0px;">
</div>
