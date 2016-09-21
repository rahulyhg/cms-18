<h3 class="title-2">My Account</h3>
<ul class="nav-list">
	<?php $currentUrl = $this->getCurrentUrlWithoutParam();?>
	<li <?php if (strpos($currentUrl, 'update-profile')):?>class="active"<?php endif;?>><a href="<?php echo Yii::app()->createAbsoluteUrl("member/update-profile");?>">My Account</a></li>
	<li <?php if (strpos($currentUrl, 'changepassword')):?>class="active"<?php endif;?>><a href="<?php echo Yii::app()->createAbsoluteUrl("member/site/ChangePassword");?>">Change Password</a></li>
	<li <?php if (strpos($currentUrl, 'documents')):?>class="active"<?php endif;?>><a href="<?php echo Yii::app()->createAbsoluteUrl("member/site/documents");?>">Generate Documents</a></li>
    <li <?php if (strpos($currentUrl, 'privatedocuments')):?>class="active"<?php endif;?>><a href="<?php echo Yii::app()->createAbsoluteUrl("member/site/privatedocuments");?>">Private Documents</a></li>
	<li <?php if (strpos($currentUrl, 'logout')):?>class="active"<?php endif;?>><a href="<?php echo Yii::app()->createAbsoluteUrl("site/logout");?>">Logout</a></li>
</ul>