<?php  
/*------------------------------------------------------------------------
# author    tantrinh
# copyright Copyright © 2011 example.com. All rights reserved.
# @license  http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website   http://www.example.com
# Mail 	    thanhtan.hello@gmail.com 
-------------------------------------------------------------------------*/

defined( '_JEXEC' ) or die; 
// build the full path to the template files
$templatePath = $this->baseurl.'/templates/'.$this->template; // template path

// get the site name
$config =& JFactory::getConfig();
$siteName = $config->getValue('config.sitename');

// determine which positions we want to show
$showLeftPosition  = $this->countModules('left');
$showRightPosition  = $this->countModules('right');
$showTopPosition    = $this->countModules('top');

$showUser1User2User3User4Positions = $this->countModules('user1 or user2 or user3 or user4');
$showUser1Position  = $this->countModules('user1');
$showUser2Position  = $this->countModules('user2');


$showUser3User4Positions = $this->countModules('user3 or user4');
$showUser3Position  = $this->countModules('user3');
$showUser4Position  = $this->countModules('user4');

$showUser5User6User7User8Positions = $this->countModules('user5 or user6 or user7 or user8');
$showUser5Position  = $this->countModules('user5');
$showUser6Position  = $this->countModules('user6');
$showUser7Position  = $this->countModules('user7');
$showUser8Position  = $this->countModules('user8');

$showBannerTopPosition  = $this->countModules('banner-top');
$showMenuTopPosition  = $this->countModules('menu-top');

$showAds01Position  = $this->countModules('ads-01');
$showAds02Position  = $this->countModules('ads-02');
$showAds03Position  = $this->countModules('ads-03');

$showFooter01Footer02Position = $this->countModules('footer01 and footer02');
$showFooter01Position  = $this->countModules('footer-01');
$showFooter02Position  = $this->countModules('footer-02');


$showDebug=$this->countModules('debug');
// parameters (template)
$modernizr = $this->params->get('modernizr');
$bootstrap = $this->params->get('bootstrap');
$pie = $this->params->get('pie');
$componentWidth=$this->params->get('componentWidth');
$rightPositionWidth=$this->params->get('rightPositionWidth');
$leftPositionWidth=$this->params->get('leftPositionWidth');

// variables
$app = JFactory::getApplication();
$doc = JFactory::getDocument(); 
$params = $app->getParams();
$pageclass = $params->get('pageclass_sfx'); // parameter (menu entry)
$tpath = $this->baseurl.'/templates/'.$this->template;
$menu = $app->getMenu();
$lang = JFactory::getLanguage();
$this->setGenerator(null);
JHTML::_('behavior.modal');
// load sheets and scripts
$doc->addStyleSheet($tpath.'/css/template.css.php?b='.$bootstrap.'&v=1'); 
if ($modernizr==1) $doc->addScript($tpath.'/js/modernizr-2.6.2.js'); // <- this script must be in the head

// unset scripts, put them into /js/template.js.php to minify http requests
unset($doc->_scripts[$this->baseurl.'/media/system/js/mootools-core.js']);
unset($doc->_scripts[$this->baseurl.'/media/system/js/core.js']);
unset($doc->_scripts[$this->baseurl.'/media/system/js/caption.js']);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!--[if IEMobile]><html class="iemobile" lang="<?php echo $this->language; ?>"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="<?php echo $this->language; ?>"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="<?php echo $this->language; ?>"> <![endif]-->
<!--[if gt IE 8]><!-->  <html class="no-js" lang="<?php echo $this->language; ?>"> <!--<![endif]-->

<head>
	<meta http-equiv="Content-Type" content="text/html;<?php echo _ISO; ?>" />	
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" /> <!-- mobile viewport -->
  	
	<script type="text/javascript" src="<?php echo $tpath.'/js/template.js.php?b='.$bootstrap.'&v=1'; ?>"></script> 
    
    <link type="text/css" href="<?php echo $tpath.'/css/template_css.css' ?>" rel="stylesheet">
    <link type="text/css" href="<?php echo $tpath.'/css/add_css.css' ?>" rel="stylesheet">
    <link type="text/css" href="<?php echo $tpath.'/css/tools.css' ?>" rel="stylesheet">
    <jdoc:include type="head" />
    
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon-precomposed" href="<?php echo $tpath; ?>/apple-touch-icon-57x57.png"> <!-- iphone, ipod, android -->
  	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $tpath; ?>/apple-touch-icon-72x72.png"> <!-- ipad -->
  	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $tpath; ?>/apple-touch-icon-114x114.png"> <!-- iphone retina -->
	  <?php if ($pie==1) : ?>
        <!--[if lte IE 8]>
          <style> 
            .pagination ul li,#menu-main,.box-user1234,.box,div.mod-languages li,div.mod-languages li.lang-active,p.readmore,p.readmore:hover{behavior:url(<?php echo $tpath; ?>/js/PIE.htc);}            
          </style>
        <![endif]-->
      <?php endif; ?>  
    
</head>	
<body class="<?php //echo $pageclass; ?> fix-body">
    <div class="container_12">
		<?php if($showBannerTopPosition): ?>
        <div class="grid_12 header fix_header">
        	<jdoc:include type="modules" name="topbar" style="none" /> 
            <jdoc:include type="modules" name="banner-top" style="none" />            
        </div>        
        <div class="clr"></div>
        <?php endif; ?>        
        <?php if($showMenuTopPosition): ?>
        <div class="grid_12 navi">
            <jdoc:include type="modules" name="menu-top" style="none" />  
            <div id="intro-bar" class="fl intro-bar">
        	<div class="fl left15 intro-bar-left"><span><?php echo JText::_('Welcome_Company')?></span></div>
            <?php $date=getdate();?>
            <div class="fr right15 intro-bar-right"><em><span>
            <?php 
			$lang =& JFactory::getLanguage();
			$langCode=(string)$lang->getTag();			
			?>
            <?php if($langCode=='vi-VN'):?> 
            Tp.HCM <?php echo JText::_('NGAY');?> 
			<?php echo $date['mday']?> <?php echo JText::_('THANG');?> 
			<?php echo $date['mon'];?> <?php echo JText::_('NAM');?> 
			<?php echo $date['year']?>            
			<?php else:?>
            HCM <?php echo $date['weekday']?>, <?php echo $date['month']?>, <?php echo $date['mday']?>,<?php echo $date['year']?>
			<?php endif;?>

            </span></em></div>
        </div>          
        </div>        
        <div class="clr"></div>
        <?php endif; ?> 
               
        <?php if($showTopPosition): ?>
        <div class="grid_12">
            <jdoc:include type="modules" name="top" style="none" />
        </div>        
        <div class="clr"></div>
        <?php endif; ?> 
               
                         <?php if ($showUser2Position) : ?>
                         <div class="grid_12 home-about">
            <jdoc:include type="modules" name="user2" style="module" />
            </div>
            <?php else : ?>
            &nbsp;
            <?php endif; ?>	   
               
       
        <?php if ($showUser1User2User3User4Positions) : ?>         
        

                  
			<?php if ($showUser3Position) : ?>
            <jdoc:include type="modules" name="user3" style="module" />
            <?php else : ?>
            &nbsp;
            <?php endif; ?>
            
            <?php if ($showUser4Position) : ?>
            <jdoc:include type="modules" name="user4" style="module" />
            <?php else : ?>
            &nbsp;
            <?php endif; ?>
            
            <?php if ($showUser5Position) : ?>
            <jdoc:include type="modules" name="user5" style="module" />
            <?php else : ?>
            &nbsp;
            <?php endif; ?>       
        <?php endif;?>

         
		<?php if ($showUser6Position) : ?>
        <div class="grid_12">
        <jdoc:include type="modules" name="user6" style="module" />
        </div>
        <?php else : ?>
        &nbsp;
        <?php endif; ?>
        
        <?php if ($showUser7Position) : ?>
        <jdoc:include type="modules" name="user7" style="module" />
        <?php else : ?>
        &nbsp;
        <?php endif; ?>
       
		<div class="grid_12 fix-content">       
        <?php if($showLeftPosition):?>
        <div class="grid_<?php echo $leftPositionWidth; ?>">        	
            <jdoc:include type="modules" name="left" style="module" />          
        </div>
        <?php endif;?>  
         
        <?php if ($this->countModules('breadcrumb')) : ?>
        <div class="grid_9 fix_breadcrumb">
        	<jdoc:include type="modules" name="breadcrumb" style="module" />
        </div>
		<?php else : ?>
        &nbsp;
        <?php endif; ?>
       
        <div class="grid_<?php echo $componentWidth; ?> fix-right-content">  
        	<?php if ($showUser1Position) : ?>
            <jdoc:include type="modules" name="user1" style="module" />
            <?php else : ?>
            &nbsp;
            <?php endif; ?> 
            <?php if ($menu->getActive() != $menu->getDefault( $lang->getTag() )) : ?>   
        	<div class=" bgw">     	
            	<jdoc:include type="message" />            
            	<jdoc:include type="component" />            
            </div>
            <?php endif; ?>  
        </div>
           
        <?php if ($showRightPosition) : ?>
        <div class="grid_<?php echo $rightPositionWidth; ?> fix-right">
        	<div class="box-right"> 
            	<jdoc:include type="modules" name="right" style="module" />
            </div>
        </div>
        <?php endif; ?>
        </div>
        <div class="clr"></div>
        <?php if($showAds01Position): ?>
        <div class="grid_12 box-ads01">
        <jdoc:include type="modules" name="ads-01" style="module" />            
        </div>
        <div class="clr"></div>  
        <?php endif; ?> 
        <?php if($showAds03Position): ?>
        <div class="footer2">
            <jdoc:include type="modules" name="ads-03" style="none" />
        </div>        
        <div class="clr"></div>            
        <?php endif; ?> 
	</div>          
    
	<?php if($showFooter01Position): ?> 
    <footer>
    <div id="footer">
            <div class="container_12"> 
                <div class="fix_footer">       	
                    <?php if($showAds02Position): ?>
                    <div class="grid_12 box-ads">
                        <jdoc:include type="modules" name="ads-02" style="none" />
                    </div>
                    <div class="clr"></div>
                    <?php endif; ?>
                    
                    <jdoc:include type="modules" name="footer-01" style="none" />  
                    <div class="clr"></div> 
                </div>
            </div>
    </div>
    </footer>
    
    <?php endif; ?>    

    
    <?php if ($this->params->get('hideInformation')=="false") : ?>
    <div class="container_12" id="information">
        <div class="grid_12 header">
            <h1>
                Information
            </h1>
		</div>
        <div class="clr"></div>
        <div class="grid_5">
            <div class="box">
                <h2>
                    What's it for
                </h2>
                <p>
                    The 960 Grid System is a CSS framework that allows designers to quickly produce complex layouts.
                    This template is for Joomla! 1.5, it includes the 960 Grid System and the basics of a normal Joomla! template. You can use this template to create your own Joomla! templates using the 960 Grid System.
                </p>
            </div>
        </div>
        <div class="grid_7">
            <div class="box">
                <h2>
                    How it works
                </h2>
                <p>
                    The 960 Grid System uses containers consisting of either 12 or 16 columns. In the 12 column containers, columns are a total of 80 pixels wide, this consists of 60px of content area and 10 pixels either side of margin area. The 16 column containers, columns are 60 pixels wide, this consists of 40 pixels of content area and 10 pixels either side of margin. Within the containers we can define <div> elements that span one or more columns. For example, this content exists inside a 12 column container and spans a total of 7 columns.
                </p>
            </div>
        </div>
        <div class="clr"></div>
        <div class="grid_3" style="margin-bottom: 1em;">
            <a href="http://960.gs/" target="_blank">
                <img src="<?php echo $templatePath; ?>/images/960gs.jpg" 
                     style="border: 0;"
                     title="960.gs"
                     alt="960.gs"/>
            </a>
        </div>
        <div class="grid_3">
            <a href="http://net.tutsplus.com/tutorials/html-css-techniques/prototyping-with-the-grid-960-css-framework" target="_blank">
                <img src="<?php echo $templatePath; ?>/images/nettuts.jpg" 
                     style="border: 0;"
                     title="Prototyping With The Grid 960 CSS Framework"
                     alt="Prototyping With The Grid 960 CSS Framework"/>
            </a>
        </div>
        <div class="grid_3">
            <a href="http://www.woothemes.com/2008/12/why-we-love-960gs/" target="_blank">
                <img src="<?php echo $templatePath; ?>/images/woothemes.jpg" 
                     style="border: 0;"
                     title="Why we love 960.gs"
                     alt="Why we love 960.gs"/>
            </a>
        </div>
        <div class="grid_3">
            <a href="http://net.tutsplus.com/videos/screencasts/a-detailed-look-at-the-960-css-framework/" target="_blank">
                <img src="<?php echo $templatePath; ?>/images/nettuts-video.jpg" 
                     style="border: 0;"
                     title="A Detailed Look at the 960 CSS Framework"
                     alt="A Detailed Look at the 960 CSS Framework"/>
            </a>
        </div>
        <div class="clr"></div>
        <div class="grid_9">
            <div class="box">
                <h2>
                    Joomla! Template Positions
                </h2>
                <p>
                    Positions are used in Joomla! to allow us to place content in different positions on the page. Positions are defined on a per template basis. The positions used by this template are shown in the image to the right. Note that user positions 2 and 3 will automatically align to the left should there be no content in user positions 1 and 2 respectively.
                </p>
            </div>
        </div>
        <div class="grid_3">
            <div class="box" style="text-align: center;">
                <img src="<?php echo $templatePath; ?>/images/layout.png"/>
            </div>
        </div>
        <div class="clr"></div>
        <div class="grid_4">
            <div class="box">
                <h2>
                    Licenses
                </h2>
                <p>
                    <strong>960 Grid System</strong> <a href="http://www.opensource.org/licenses/gpl-2.0.php" target="_blank">GNU GPL</a> and <a href="http://www.opensource.org/licenses/mit-license.php" target="_blank" >MIT</a><br/>
                    <strong>PHP</strong> <a href="http://www.opensource.org/licenses/gpl-2.0.php" target="_blank">GNU GPL</a><br/>
                    <strong>Addtional CSS</strong> <a href="http://www.opensource.org/licenses/gpl-2.0.php" target="_blank">GNU GPL</a><br/>
                    <strong>Header Image</strong> <a href="http://www.sxc.hu/help/7_2" target="_blank">Royalty Free</a>
                </p>
            </div>
		</div>
        <div class="grid_8">
            <div class="box">
                <h2>
                    License Notes
                </h2>
                <p>
                    The 960 Grid System is covered by two licenses, for more information refer to the official <a href="http://960.gs/" target="_blank">website</a>.
                    All of the PHP code is derived from existing <a href="http://www.opensource.org/licenses/gpl-2.0.php" target="_blank">GNU GPL</a> templates and is therefore also covered by the <a href="http://www.opensource.org/licenses/gpl-2.0.php" target="_blank">GNU GPL</a> license.
                    All additional CSS is new (i.e. is not derived from existing code) and is released uncder the <a href="http://www.opensource.org/licenses/gpl-2.0.php" target="_blank">GNU GPL</a> license.
                    The header image is a royalty free stock image available from <a href="http://www.sxc.hu/photo/1212919" target="_blank">stock.xchang</a>, please be aware that some <a href="http://www.sxc.hu/help/7_2" target="_blank">restrictions</a> apply to the usage of this iamge.
                </p>
            </div>
        </div>
        <div class="clr"></div>
    </div>
    <div class="container_12 example_grid" id="example_grid_12">
        <div class="grid_12 header">
            <h1>
                12 Column Grid
            </h1>
		</div>
        <div class="clr"></div>
        <div class="grid_12">
            <p>
                940px
            </p>
        </div>
        <!-- end .grid_12 -->
        <div class="clr"></div>
        <div class="grid_1">
            <p>
                60px
            </p>
        </div>
        <!-- end .grid_1 -->
        <div class="grid_11">
            <p>
                860px
            </p>
        </div>
        <!-- end .grid_11 -->
        <div class="clr"></div>
        <div class="grid_2">
            <p>
                140px
            </p>
        </div>
        <!-- end .grid_2 -->
        <div class="grid_10">
            <p>
                780px
            </p>
        </div>
        <!-- end .grid_10 -->
        <div class="clr"></div>
        <div class="grid_3">
            <p>
                220px
            </p>
        </div>
        <!-- end .grid_3 -->
        <div class="grid_9">
            <p>
                700px
            </p>
        </div>        
        <!-- end .grid_9 -->
        <div class="clr"></div>
        <div class="grid_4">
            <p>
                300px
            </p>
        </div>
        <!-- end .grid_4 -->
        <div class="grid_8">
            <p>
                620px
            </p>
        </div>
        <!-- end .grid_8 -->
        <div class="clr"></div>
        <div class="grid_5">
            <p>
                380px
            </p>
        </div>
        <!-- end .grid_5 -->
        <div class="grid_7">
            <p>
                540px
            </p>
        </div>
        <!-- end .grid_7 -->
        <div class="clr"></div>
        <div class="grid_6">
            <p>
                460px
            </p>
        </div>
        <!-- end .grid_6 -->
        <div class="grid_6">
            <p>
                460px
            </p>
        </div>
        <!-- end .grid_6 -->
        <div class="clr"></div>
        <div class="grid_1 suffix_11">
            <p>
                60px
            </p>
        </div>
        <!-- end .grid_1.suffix_11 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_1 suffix_10">
            <p>
                60px
            </p>
        </div>
        <!-- end .grid_1.prefix_1.suffix_10 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_2 suffix_9">
            <p>
                60px
            </p>
        </div>
        <!-- end .grid_1.prefix_2.suffix_9 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_3 suffix_8">
            <p>
                60px
            </p>
        </div>
        <!-- end .grid_1.prefix_3.suffix_8 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_4 suffix_7">
            <p>
                60px
            </p>
        </div>
        <!-- end .grid_1.prefix_4.suffix_7 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_5 suffix_6">
            <p>
                60px
            </p>
        </div>
        <!-- end .grid_1.prefix_5.suffix_6 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_6 suffix_5">
            <p>
                60px
            </p>
        </div>
        <!-- end .grid_1.prefix_6.suffix_5 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_7 suffix_4">
            <p>
                60px
            </p>
        </div>
        <!-- end .grid_1.prefix_7.suffix_4 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_8 suffix_3">
            <p>
                60px
            </p>
        </div>
        <!-- end .grid_1.prefix_8.suffix_3 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_9 suffix_2">
            <p>
                60px
            </p>
        </div>
        <!-- end .grid_1.prefix_9.suffix_2 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_10 suffix_1">
            <p>
                60px
            </p>
        </div>
        <!-- end .grid_1.prefix_10.suffix_1 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_11">
            <p>
                60px
            </p>
        </div>
        <!-- end .grid_1.prefix_11 -->
        <div class="clr"></div>
        <div class="grid_6 push_6">
            <div class="grid_1 alpha">
                <p>
                    60px
                </p>
            </div>
            <!-- end .grid_1.alpha -->
            <div class="grid_5 omega">
                <p>
                    380px
                </p>
            </div>
            <!-- end .grid_5.omega -->
            <div class="clr"></div>
            <div class="grid_3 alpha">
                <p>
                    220px
                </p>
            </div>
            <!-- end .grid_3.alpha -->
            <div class="grid_3 omega">
                <p>
                    220px
                </p>
            </div>
            <!-- end .grid_3.omega -->
            <div class="clr"></div>
        </div>
        <!-- end .grid_6.push_6 -->
        <div class="grid_6 pull_6">
            <div class="grid_3 alpha">
                <p>
                    220px
                </p>
            </div>
            <!-- end .grid_3.alpha -->
            <div class="grid_3 omega">
                <p>
                    220px
                </p>
            </div>
            <!-- end .grid_3.omega -->
            <div class="clr"></div>
            <div class="grid_1 alpha">
                <p>
                    60px
                </p>
            </div>
            <!-- end .grid_1.alpha -->
            <div class="grid_5 omega">
                <p>
                    380px
                </p>
            </div>
            <!-- end .grid_5.omega -->
            <div class="clr"></div>
        </div>
        <!-- end .grid_6.pull_6 -->
        <div class="clr"></div>
    </div>
    <div class="container_16 example_grid" id="example_grid_16">
        <div class="grid_16 header">
            <h1>
                16 Column Grid
            </h1>
		</div>
        <div class="grid_16">
            <p>
                940px
            </p>
        </div>
        <!-- end .grid_16 -->
        <div class="clr"></div>
        <div class="grid_1">
            <p>
                40px
            </p>
        </div>
        <!-- end .grid_1 -->
        <div class="grid_15">
            <p>
                880px
            </p>
        </div>
        <!-- end .grid_15 -->
        <div class="clr"></div>
        <div class="grid_2">
            <p>
                100px
            </p>
        </div>
        <!-- end .grid_2 -->
        <div class="grid_14">
            <p>
                820px
            </p>
        </div>
        <!-- end .grid_14 -->
        <div class="clr"></div>
        <div class="grid_3">
            <p>
                160px
            </p>
        </div>
        <!-- end .grid_3 -->
        <div class="grid_13">
            <p>
                760px
            </p>
        </div>
        <!-- end .grid_13 -->
        <div class="clr"></div>
        <div class="grid_4">
            <p>
                220px
            </p>
        </div>
        <!-- end .grid_4 -->
        <div class="grid_12">
            <p>
                700px
            </p>
        </div>
        <!-- end .grid_12 -->
        <div class="clr"></div>
        <div class="grid_5">
            <p>
                280px
            </p>
        </div>
        <!-- end .grid_5 -->
        <div class="grid_11">
            <p>
                640px
            </p>
        </div>
        <!-- end .grid_11 -->        
        <div class="clr"></div>
        <div class="grid_6">
            <p>
                340px
            </p>
        </div>
        <!-- end .grid_6 -->
        <div class="grid_10">
            <p>
                580px
            </p>
        </div>
        <!-- end .grid_10 -->
        <div class="clr"></div>
        <div class="grid_7">
            <p>
                400px
            </p>
        </div>
        <!-- end .grid_7 -->
        <div class="grid_9">
            <p>
                520px
            </p>
        </div>
        <!-- end .grid_9 -->
        <div class="clr"></div>
        <div class="grid_8">
            <p>
                460px
            </p>
        </div>
        <!-- end .grid_8 -->
        <div class="grid_8">
            <p>
                460px
            </p>
        </div>
        <!-- end .grid_8 -->
        <div class="clr"></div>
        <div class="grid_1 suffix_15">
            <p>
                40px
            </p>
        </div>
        <!-- end .grid_1.suffix_15 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_1 suffix_14">
            <p>
                40px
            </p>
        </div>
        <!-- end .grid_1.prefix_1.suffix_14 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_2 suffix_13">
            <p>
                40px
            </p>
        </div>
        <!-- end .grid_1.prefix_2.suffix_13 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_3 suffix_12">
            <p>
                40px
            </p>
        </div>
        <!-- end .grid_1.prefix_3.suffix_12 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_4 suffix_11">
            <p>
                40px
            </p>
        </div>
        <!-- end .grid_1.prefix_4.suffix_11 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_5 suffix_10">
            <p>
                40px
            </p>
        </div>
        <!-- end .grid_1.prefix_5.suffix_10 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_6 suffix_9">
            <p>
                40px
            </p>
        </div>
        <!-- end .grid_1.prefix_6.suffix_9 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_7 suffix_8">
            <p>
                40px
            </p>
        </div>
        <!-- end .grid_1.prefix_7.suffix_8 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_8 suffix_7">
            <p>
                40px
            </p>
        </div>
        <!-- end .grid_1.prefix_8.suffix_7 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_9 suffix_6">
            <p>
                40px
            </p>
        </div>
        <!-- end .grid_1.prefix_9.suffix_6 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_10 suffix_5">
            <p>
                40px
            </p>
        </div>
        <!-- end .grid_1.prefix_10.suffix_5 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_11 suffix_4">
            <p>
                40px
            </p>
        </div>
        <!-- end .grid_1.prefix_11.suffix_4 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_12 suffix_3">
            <p>
                40px
            </p>
        </div>
        <!-- end .grid_1.prefix_12.suffix_3 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_13 suffix_2">
            <p>
                40px
            </p>
        </div>
        <!-- end .grid_1.prefix_13.suffix_2 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_14 suffix_1">
            <p>
                40px
            </p>
        </div>
        <!-- end .grid_1.prefix_14.suffix_1 -->
        <div class="clr"></div>
        <div class="grid_1 prefix_15">
            <p>
                40px
            </p>
        </div>
        <!-- end .grid_1.prefix_15 -->
        <div class="clr"></div>
        <div class="grid_8 push_8">
            <div class="grid_1 alpha">
                <p>
                    40px
                </p>
            </div>
            <!-- end .grid_1.alpha -->
            <div class="grid_7 omega">
                <p>
                    400px
                </p>
            </div>
            <!-- end .grid_7.omega -->
            <div class="clr"></div>
            <div class="grid_4 alpha">
                <p>
                    220px
                </p>
            </div>
            <!-- end .grid_4.alpha -->
            <div class="grid_4 omega">
                <p>
                    220px
                </p>
            </div>
            <!-- end .grid_4.omega -->
            <div class="clr"></div>
        </div>
        <!-- end .grid_8.push_8 -->
        <div class="grid_8 pull_8">
            <div class="grid_4 alpha">
                <p>
                    220px
                </p>
            </div>
            <!-- end .grid_4.alpha -->
            <div class="grid_4 omega">
                <p>
                    220px
                </p>
            </div>
            <!-- end .grid_4.omega -->
            <div class="clr"></div>
            <div class="grid_1 alpha">
                <p>
                    40px
                </p>
            </div>
            <!-- end .grid_1.alpha -->
            <div class="grid_7 omega">
                <p>
                    400px
                </p>
            </div>
            <!-- end .grid_7.omega -->
            <div class="clr"></div>
        </div>
        <!-- end .grid_8.pull_8 -->
        <div class="clr"></div>
    </div>
    <?php endif; ?> 
    	
  <?php if($showDebug): ?>
  <code><jdoc:include type="modules" name="debug" /></code>
  <?php endif;?>
<div class="clr"></div>
</body>
</html>

