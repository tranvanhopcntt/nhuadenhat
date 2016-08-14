<div class="blog LatestAds">
  <div class="m-title">
    <?php
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();
jimport('joomla.html.pane');
$conf= $this->conf;
$document	= JFactory::getDocument();
if ($conf->metadata_mode != 'nometadata') {
	$document->setMetaData("description", $this->content->metadata_description);
	$document->setMetaData("keywords", $this->content->metadata_keywords);
}
?>
    <?php /*?><pre><?php //print_r($this->content);?></pre><?php */?>
    <?php echo $this->content->event->onContentBeforeDisplay; ?>
    <h3> <span class="ad_title ">
      <?php if ($conf->display_inner_pathway == 1) { ?>
      <?php 
	$pathway ="";
	$nb = count($this->pathlist);
	for ($i = $nb - 1 ; $i >0;$i--)
	{
		$pathway .= '<a href="'.$this->pathlist[$i]->link.'">'.$this->pathlist[$i]->text.'</a>';
		$pathway .= '<span class="arrow"> » </span>';
	}
	
	$pathway .= '<a href="'.$this->pathlist[0]->link.'">'.$this->pathlist[0]->text.'</a>';
	$pathway .= '<span class="arrow"> » </span>';
	echo $pathway;

	if (function_exists('getContentClass')) 
		$classcontent = getContentClass($this->content,"details");
	else
		$classcontent = "";
?>
      <?php } ?>
      <?php 
               if (isset($this->fDisplay[1])){
                    foreach($this->fDisplay[1] as $field){
                        $c = $this->field->showFieldValue($this->content,$field); 
                        if ($c != "") {
                            $title = $this->field->showFieldTitle(@$this->content->catid,$field);
                            if ($title != "")
                                echo htmlspecialchars($title).": ";
                            echo "$c ";
                        }
                    }
                } ?>
      </span> </h3>
    <div class="<?php echo $classcontent;?> item-page">
      <section class="addetails_header">
        <div class="addetails_left">
          <div class="adsmanager_ads_image">
            <?php
                        $this->loadScriptImage($this->conf->image_display);
                        if (count($this->content->images) == 0)
                            $image_found = 0;
                        else
                            $image_found = 1;
                        foreach($this->content->images as $img)
                        {
                            $thumbnail = JURI::base()."images/com_adsmanager/ads/".$img->thumbnail;
                            $image = JURI::base()."images/com_adsmanager/ads/".$img->image;
                            switch($this->conf->image_display)
                            {
                                case 'popup':
                                    echo "<a href=\"javascript:popup('$image');\">
										  <img src='".$thumbnail."' alt='".htmlspecialchars($this->content->ad_headline)."' />
										  </a>";
                                    break;
                                case 'lightbox':
                                case 'lytebox':
                                    echo "<a href='".$image."' rel='lytebox[roadtrip".$this->content->id."]'>
									<img src='".$thumbnail."' alt='".htmlspecialchars($this->content->ad_headline)."' />
									</a>"; 
                                    break;
                                case 'highslide':
                                    echo "<a id='thumb".$this->content->id."' class='highslide' onclick='return hs.expand (this)' href='".$image."'>
									<img src='".$thumbnail."' alt='".htmlspecialchars($this->content->ad_headline)."' />
									</a>";
                                    break;
                                case 'default':	
                                default:
                                    echo "<a href='".$image."' target='_blank'>
									<img src='".$thumbnail."' alt='".htmlspecialchars($this->content->ad_headline)."' />
									</a>";
                                    break;
                            }
                        }
                        if (($image_found == 0)&&($conf->nb_images >  0))
                        {
                            echo '<img align="center" src="'.ADSMANAGER_NOPIC_IMG.'" alt="nopic" />'; 
                        }
                        ?>
          </div>
        </div>
        <div class="addetails_right box">
          <section class="ads_info_short ">
            <?php $strtitle = "";if (@$this->positions[3]->title) {$strtitle = JText::_($this->positions[3]->title); } ?>
            <h3> <span class="fr right10">
              <?php 
					   echo JText::_('ADSMANAGER_NAME');
					   if (isset($this->fDisplay[1])){
							foreach($this->fDisplay[1] as $field){
								$c = $this->field->showFieldValue($this->content,$field); 
								if ($c != "") {
									$title = $this->field->showFieldTitle(@$this->content->catid,$field);
									if ($title != "")
										echo htmlspecialchars($title).": ";
									echo "$c ";
								}
							}
						} ?>
              </span>
              <?php if(!empty($this->content->ad_sku)):?>
              <span class="fl left10"> <?php echo JText::_('ADSMANAGER_SKU');?> <?php echo $this->content->ad_sku;?> </span>
              <?php endif;?>
            </h3>
            <div class="tb_size"> <?php echo $this->content->ad_size;?> </div>
            <div class="d-price">
              <?php if (@$strtitle != "") echo @$strtitle."&nbsp;";						
                        if (isset($this->fDisplay[4])){
                                foreach($this->fDisplay[4] as $field){
                                    $c = $this->field->showFieldValue($this->content,$field); 
                                    if ($c != "") {
                                        //$title = $this->field->showFieldTitle(@$this->content->catid,$field);
                                        if ($title != "")
                                            echo htmlspecialchars($title).":&nbsp;";
                                        echo "$c";
                                    }
                                } 
                            }
                        ?>
            </div>
          </section>
        </div>
      </section>
      <div class="clr"></div>
      <?php echo $this->content->event->onContentAfterTitle; ?> 
      <!---->
      <?php /*?> 
			<section class="ads_admin">
			<?php 
            if ($this->content->userid != 0)
            {
                echo JText::_('ADSMANAGER_SHOW_OTHERS'); 
                if ($conf->comprofiler == 3) {
                    $target = TRoute::_("index.php?option=com_community&view=profile&userid=".$this->content->userid);
                }
                else if (COMMUNITY_BUILDER_ADSTAB == 1){
                    $target = TRoute::_("index.php?option=com_comprofiler&task=userProfile&tab=AdsManagerTab&user=".$this->content->userid);
                }
                else{
                    $target = TRoute::_("index.php?option=com_adsmanager&view=list&user=".$this->content->userid);
                }		    
                if ($conf->display_fullname == 1){echo "<a href='$target'><b>".$this->content->fullname."</b></a>";}
                else{echo "<a href='$target'><b>".$this->content->user."</b></a>";}			
                if ($this->userid == $this->content->userid){
                ?>
                <div>
                <?php
                    $target = TRoute::_("index.php?option=com_adsmanager&task=write&catid=".$this->content->category."&id=".$this->content->id);
                    echo "<a href='".$target."'>".JText::_('ADSMANAGER_CONTENT_EDIT')."</a>";
                    echo "&nbsp;";
                    $target = TRoute::_("index.php?option=com_adsmanager&task=delete&catid=".$this->content->category."&id=".$this->content->id);
                    echo "<a href='".$target."'>".JText::_('ADSMANAGER_CONTENT_DELETE')."</a>";
                ?>
                </div>
                <?php
                }
            }
            ?>
            </section>
		<?php */?>
      <div class="addetailsmain ">
        <?php 
	$pane =& JPane::getInstance('tabs', array('startOffset'=>2, 'allowAllClose'=>true, 'opacityTransition'=>true, 'duration'=>600)); 
	echo $pane->startPane('pane');
	?>
        <?php echo $pane->startPanel( JText::_('THONG_TIN_THEM'), 'panel1' );?>
        <div class="adsmanager_ads_desc">
          <?php $strtitle = "";if (@$this->positions[2]->title) {$strtitle = JText::_($this->positions[2]->title);} ?>
          <?php 
			if (isset($this->fDisplay[3]))
			{	
				foreach($this->fDisplay[3] as $field)
				{
					$c = $this->field->showFieldValue($this->content,$field); 
					if ($c != "") {
						$title = $this->field->showFieldTitle(@$this->content->catid,$field);
						if ($title != "")
							echo htmlspecialchars($title).": ";
						echo "$c<br/>";
					}
				}
			} ?>
        </div>
        <?php echo $pane->endPanel();?> <?php echo $pane->startPanel( JText::_('CACH_SU_DUNG'), 'panel2' ); ?>
        <div class="adsmanager_ads_desc">
          <div class="body">
            <div class="block">
              <?php if(!empty($this->content->ad_using)):	?>
              <?php echo $this->content->ad_using;?>
              <?php endif;?>
            </div>
          </div>
        </div>
        <?php echo $pane->endPanel();?>  
		<?php echo $pane->startPanel( JText::_('KHAC'), 'panel4' ); ?>
        <div class="adsmanager_ads_desc">
          <div class="body">
            <div class="block">
              <?php if(!empty($this->content->ad_others)):	?>
              <?php echo $this->content->ad_others;?>
              <?php endif;?>
            </div>
          </div>
        </div>
        <?php echo $pane->endPanel();?>
        <?php /*?>
			<?php echo $pane->startPanel( 'Liên hệ', 'panel3' );?>
			<div class="adsmanager_ads_contact">
			<?php $strtitle = "";if (@$this->positions[4]->title) {$strtitle = JText::_($this->positions[4]->title);} ?>
			<?php echo "<h2>".@$strtitle."</h2>"; 
			if (($this->userid != 0)||($conf->show_contact == 0)) {		
				if (isset($this->fDisplay[5]))
				{		
					foreach($this->fDisplay[5] as $field)
					{	
						$c = $this->field->showFieldValue($this->content,$field); 
						if ($c != "") {
							$title = $this->field->showFieldTitle(@$this->content->catid,$field);
							if ($title != "")
								echo htmlspecialchars($title).": ";
							echo "$c<br/>";
						}
					} 
				}
				if (($this->content->userid != 0)&&($conf->allow_contact_by_pms == 1))
				{
					if ($conf->display_fullname == 1)
						$pmsText= sprintf(JText::_('ADSMANAGER_PMS_FORM'),$this->content->fullname);
					else
						$pmsText= sprintf(JText::_('ADSMANAGER_PMS_FORM'),$this->content->user);
					$pmsForm = TRoute::_("index.php?option=com_uddeim&task=new&recip=".$this->content->userid);
					echo '<a href="'.$pmsForm.'">'.$pmsText.'</a><br />';
				}
			}
			else
			{
				echo JText::_('ADSMANAGER_CONTACT_NOT_LOGGED');
			}
			?>
			</div>
			<?php echo $pane->endPanel();?><?php */
			?>
        <?php echo $pane->endPane();?> </div>
      <div class="adsmanager_spacer"></div>
    </div>
  </div>
</div>
<div class="ads_related contact">
<h2><?php echo JText::_('THIET_BI_KEM_THEO');?></h2>
<ul>	
  <?php foreach($this->content->event->onContentAfterDisplay[0] as $key=>$ads_related):?>
  <?php 
  	$ads_related_images=@json_decode($ads_related->images);
  if($key==0){
	  $addclass="first";
	}elseif($key==(count($this->content->event->onContentAfterDisplay[0])-1)){
		$addclass="last";
	}else{
		$addclass="item_ads_related";
		}	
  ?>
  <li class="<?php echo $addclass;?>"> 
  <?php $target = TRoute::_("index.php?option=&view=details&catid=".$this->content->category."&id=".$ads_related->id);  
  ?> 
  <div class=" center item-ads-latest fl">
   <a href="<?php echo $target;?>" class="ads-title"><?php echo $ads_related->ad_headline;?></a> 
  <a href="#" title="<?php echo $ads_related->ad_headline;?>"><img border="0" alt="<?php echo $ads_related->ad_headline;?>" src="images/com_adsmanager/ads/<?php echo $ads_related_images[0]->thumbnail;?>"></a>
    <div class="shortDescription">
      <?php echo $ads_related->ad_shortdescript;?>
    </div>
    <div class="price"><?php echo $ads_related->ad_price;?></div>
    <div class="readmore"><a href="<?php echo $target;?>"><?php echo JText::_( 'JDETAILS' );?> <span class="arrow">»</span></a></div>
    <?php /*?><hr class="border-bottom"><?php */?>
  </div>
  </li>
  <?php endforeach;?>
  </ul>
</div>
