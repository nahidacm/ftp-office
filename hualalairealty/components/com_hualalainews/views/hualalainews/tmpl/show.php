<?php 
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.database.database');
jimport( 'joomla.database.table' );
?>
<div class="banner">
    <div class="banner_image">
        <div class="banner_image_in">
            <div class="bannergroup">
                <div class="banneritem">
                    <img alt="Banner" src="<?php echo JURI::base();?>/components/com_hualalainews/images/news_banner.jpg">
                    <div class="clr"></div>
                </div>
            </div>                   
        </div>
    </div>                           
</div>
<br />

<div style="width: 958px; float:left; padding: 0 0 0 0; margin:0px; border: 0;">
<?php
$counts = count($this->allData);
$rows = $counts/5;

if ($rows == 1){
	$numRows = (count($this->allData)%5)+1;
}else{
	$numRows = (count($this->allData)/5);
}
$j = 0;
?>
<table cellspacing="0" cellpadding="0" border="0" width="958" style="margin: auto;">
<tbody>
<tr>

<td colspan="9">
<div>
	<h1 id="article_title">Hualalai in the Press</h1>
	<p>Click on icons to view full article.</p>
</div>
<br />
</td>
</tr>
<?php for ($i=0; $i<$numRows; $i++){?>

<tr align="left" valign="top">    
    
    <td width="140">
    <?php if ($this->allData[$j]->article_image){?>
    <a href="index.php?option=com_hualalainews&task=edit&cid[]=<?php echo $this->allData[$j]->id?>"><img border="0" width="140" alt="Cover" src="<?php echo JURI::base();?>/administrator/components/com_hualalainews/hualalainews_image/<?php echo $this->allData[$j]->article_image;?>"></a><br /><img height="8" width="140" alt="" src="<?php echo $this->baseurl ?>/components/com_hualalainews/images/bg_press_shadow.jpg">
    <?php }?> 
    </td>
    
    <td width="65"><img height="10" border="0" width="65" alt="" src="<?php echo JURI::base();?>/components/com_hualalainews/images/blank.gif"></td>

    <td width="140">
    <?php if ($this->allData[$j+1]->article_image){?>
    <a href="index.php?option=com_hualalainews&task=edit&cid[]=<?php echo $this->allData[$j+1]->id?>"><img border="0" width="140" alt="Cover" src="<?php echo JURI::base();?>/administrator/components/com_hualalainews/hualalainews_image/<?php echo $this->allData[$j+1]->article_image;?>"></a><br /><img height="8" width="140" alt="" src="<?php echo $this->baseurl ?>/components/com_hualalainews/images/bg_press_shadow.jpg">
    <?php }?>
    <?php if ($this->allData[$j+1]->title){?>
    <?php }?>
    </td>    
    
    <td width="65"><img height="10" border="0" width="65" alt="" src="<?php echo JURI::base();?>/components/com_hualalainews/images/blank.gif"></td>

    <td width="140">
    <?php if ($this->allData[$j+2]->article_image){?>
    <a href="index.php?option=com_hualalainews&task=edit&cid[]=<?php echo $this->allData[$j+2]->id?>"><img border="0" width="140" alt="Cover" src="<?php echo JURI::base();?>/administrator/components/com_hualalainews/hualalainews_image/<?php echo $this->allData[$j+2]->article_image;?>"></a><br /><img height="8" width="140" alt="" src="<?php echo $this->baseurl ?>/components/com_hualalainews/images/bg_press_shadow.jpg">
    <?php }?>   
    <?php if ($this->allData[$j+2]->title){?> 
    <?php }?>
    </td>   
    
    <td width="65"><img height="10" border="0" width="65" alt="" src="<?php echo JURI::base();?>/components/com_hualalainews/images/blank.gif"></td>

    <td width="140">
    <?php if ($this->allData[$j+3]->article_image){?>
    <a href="index.php?option=com_hualalainews&task=edit&cid[]=<?php echo $this->allData[$j+3]->id?>"><img border="0" width="140" alt="Cover" src="<?php echo JURI::base();?>/administrator/components/com_hualalainews/hualalainews_image/<?php echo $this->allData[$j+3]->article_image;?>"></a><br /><img height="8" width="140" alt="" src="<?php echo $this->baseurl ?>/components/com_hualalainews/images/bg_press_shadow.jpg">
    <?php }?>
    <?php if ($this->allData[$j+3]->title){?> 
    <?php }?>
    </td>
    
    <td width="65"><img height="10" border="0" width="65" alt="" src="<?php echo JURI::base();?>/components/com_hualalainews/images/blank.gif"></td>

    <td width="140">
    <?php if ($this->allData[$j+4]->article_image){?>
    <a href="index.php?option=com_hualalainews&task=edit&cid[]=<?php echo $this->allData[$j+4]->id?>"><img border="0" width="140" alt="Cover" src="<?php echo JURI::base();?>/administrator/components/com_hualalainews/hualalainews_image/<?php echo $this->allData[$j+4]->article_image;?>"></a><br /><img height="8" width="140" alt="" src="<?php echo $this->baseurl ?>/components/com_hualalainews/images/bg_press_shadow.jpg">
    <?php }?>
    <?php if ($this->allData[$j+4]->title){?> 
    <?php }?>
    </td>    
</tr>

<tr><td colspan="7">&nbsp;<br>&nbsp;</td></tr>
<?php $j = $j + 5;}?>
</tbody></table>
    <?php
    if($this->pagination->limitstart > 0){
        $prev_page_limitstart = $this->pagination->limitstart - $this->pagination->limit;
        $prev_page_link = '<a style="float: left;" href="http://www.hualalairealty.com/component/hualalainews/hualalainews/show/48/?limitstart='.$prev_page_limitstart.'">Previous Page</a>';
    }else{
        $prev_page_limitstart = FALSE;
        $prev_page_link = '';
    }
    if( $this->pagination->total > ($this->pagination->limitstart + $this->pagination->limit)){
        $next_page_limitstart = $this->pagination->limitstart + $this->pagination->limit;
        $next_page_link = '<a style="float: right;" href="http://www.hualalairealty.com/component/hualalainews/hualalainews/show/48/?limitstart='.$next_page_limitstart.'">Next Page</a>';
    }else{
        $next_page_limitstart = FALSE;
        $next_page_link = '';
    }
    
    echo $prev_page_link.$next_page_link;
    ?>
    
</div>