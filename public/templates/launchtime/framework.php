<?php 
// No direct access.
defined('_JEXEC') or die;

// get params
$bgimage 		= $this->params->get('backgroundimage', 'templates/launchtime/images/bg.png');
$bgcolor		= $this->params->get('backgroundcolor', '000000');
$enablelogo		= $this->params->get('enablelogo', '');
$logo			= $this->params->get('logoimg', '');

$boxalign		= $this->params->get('boxalign', '');
$boxposition	= $this->params->get('boxposition', '');
$enablemodule 	= $this->params->get('enablemodule', '0');
$moduleposition = $this->params->get('position', '');
$theme			= $this->params->get('theme', '');

$heading		= $this->params->get('heading', '');
$subheading		= $this->params->get('subheading', '');



$supersize_enable = true;
$video_embed = false;
$description_content = $this->params->get('desc_content', '');

$showmailchimp		= $this->params->get('showmailchimp', 0);
$formurl            = $this->params->get('formurl', '');
$signuppretext 		= $this->params->get('signuppretext', 0);

$showsocialicons	= $this->params->get('showsocialicons', 0);
$disablefb			= $this->params->get('disablefb', 0);
$facebookURL		= $this->params->get('fburl', 'http://facebook.com/your-facebook-page.html');
$disabletwtr		= $this->params->get('disabletwtr', 0);
$twitterURL			= $this->params->get('twtrurl', 'http:/facebook.com/your-twitter-page.html');
$disablegplus		= $this->params->get('disablegplus', 0);
$googleplusURL		= $this->params->get('gplusurl', 'http:/facebook.com/your-google-profile-page.html');

$showcounter	= $this->params->get('showcounter', 0);
$launchtime     = $this->params->get('launchtime', '');
$year = date( "Y", strtotime($launchtime));
$month = date( "n", strtotime($launchtime));
$day = date( "j", strtotime($launchtime));


/* Don't remove the credits below. Doing it is illegal. */
//$warningerrorx = '<a href="http://www.templateplazza.com/">TemplatePlazza</a>.';

$config = array(
	'targetDate' => array(	// Target countdown date
		'day'				=> $day,
		'month'				=> $month,
		'year'				=> $year,
		'hour'				=> 22,
		'minute'			=> 0,
		'second'			=> 0
	)
);

	$now = time();
	$target = mktime(
		$config['targetDate']['hour'], 
		$config['targetDate']['minute'], 
		$config['targetDate']['second'], 
		$config['targetDate']['month'], 
		$config['targetDate']['day'], 
		$config['targetDate']['year']
	);

	$diffSecs = $target - $now;
	
	$date = array();
	$date['secs'] = $diffSecs % 60;
	$date['mins'] = floor($diffSecs/60)%60;
	$date['hours'] = floor($diffSecs/60/60)%24;
	$date['days'] = floor($diffSecs/60/60/24)%7;
	//$date['days'] = floor($diffSecs/60/60/24);
	$date['weeks']	= floor($diffSecs/60/60/24/7);
	
	foreach ($date as $i => $d) {
		$d1 = $d%10;
		$d2 = ($d-$d1) / 10;
		$date[$i] = array(
			(int)$d2,
			(int)$d1,
			(int)$d
		);
	}
	


	
?>