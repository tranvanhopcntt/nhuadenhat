<?php 
// 2Cols theme for LaunchTime
// No direct access.
defined('_JEXEC') or die;
?>

<div id="box-<?php echo $boxalign; ?>">

	<!-- COL1 START -->
	<div id="col1">
		<!-- LOGO -->
		<?php if ($enablelogo) { ?>
		<div class="logo">
			<img src="<?php echo $this->baseurl; ?>/<?php echo htmlspecialchars($logo); ?>" alt="<?php /*echo htmlspecialchars($templateparams->get('sitetitle'));*/ ?>" />
		</div>		
		<?php } ?>
		<!-- H1 TITLE -->
		<?php if ($heading) { ?>
			<h1><a href="<?php JURI::base(); ?>"><?php echo htmlspecialchars($heading);?></a></h1>
		<?php }  ?>
		<?php if($showcounter) { ?>
		<!-- Countdown Timer -->
		<div class="countdown_title">Time left to Launch</div>
			<div id="countdown_dashboard">
				<div class="dash weeks_dash">
					<span class="dash_title">wks</span>
					<div class="digit"><?=$date['weeks'][0]?></div>
					<div class="digit"><?=$date['weeks'][1]?></div>
				</div>
				<div class="dash days_dash">
					<span class="dash_title">days</span>
					<div class="digit"><?=$date['days'][0]?></div>
					<div class="digit"><?=$date['days'][1]?></div>
				</div>
				<div class="dash hours_dash">
					<span class="dash_title">hrs</span>
					<div class="digit"><?=$date['hours'][0]?></div>
					<div class="digit"><?=$date['hours'][1]?></div>
				</div>
				<div class="dash minutes_dash">
					<span class="dash_title">min</span>
					<div class="digit"><?=$date['mins'][0]?></div>
					<div class="digit"><?=$date['mins'][1]?></div>
				</div>
				<div class="dash seconds_dash">
					<span class="dash_title">sec</span>
					<div class="digit"><?=$date['secs'][0]?></div>
					<div class="digit"><?=$date['secs'][1]?></div>
				</div>
			</div>
		<?php } ?>
		</div>
	<!-- COL1 END COL 2 START-->
	<div id="col2">
		<!-- LOAD MODULE -->
		<?php if ($enablemodule) { ?>
			<jdoc:include type="modules" name="<?php echo $moduleposition; ?>" style="raw" />		
		<?php }  ?>
		<!-- H2 SUBHEADING / P DESCRIPTION (PRESIGNUP) -->
		<div id="content">
			<div id="presignup-content" class="content-block-left">
				<h2><?php echo $subheading; ?></h2>
				<p><?php echo $description_content; ?></p>
			</div>
			<?php if ($showmailchimp) { ?>
			<!-- MAILCHIMP -->
			<div id="mailchimp">
			<form action="<?php echo $formurl; ?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
				<label for="mce-EMAIL"><?php echo $signuppretext; ?></label>
				<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
				<input type="submit" value="Go" name="subscribe" id="mc-embedded-subscribe" class="button">
			</form>
			</div>
			<!--END MAILCHIMP -->
			<?php } ?>	
		</div>
		<!-- END #content -->
		<div class="clear"></div>
		<!-- SOCIALSHARE -->
		<?php if( $showsocialicons || $showcounter) { ?>
			<ul id="socialshare">
			<?php if( $showsocialicons && (!$disablefb) ) { ?>
				<li class="socialshare_icon facebook"><a href="<?php echo $facebookURL; ?>" target="_blank">Facebook Page</a></li>
			<?php } ?>
			<?php if( $showsocialicons && (!$disabletwtr) ) { ?>
				<li class="socialshare_icon twitter"><a href="<?php echo $twitterURL; ?>" target="_blank">Follow Me</a></li>
			<?php } ?>
			<?php if( $showsocialicons && (!$disablegplus) ) { ?>
				<li class="socialshare_icon googleplus"><a href="<?php echo $googleplusURL; ?>" target="_blank">Google+ Page</a></li>
			<?php } ?>
			</ul>
		<?php } ?>
		<div class="clear"></div>
	</div>
	<!-- COL2 END -->
<div class="clear"></div>
</div>
	
        