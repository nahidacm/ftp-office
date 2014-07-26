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
$rows = (count($this->allData)%4);

if ($rows == 1){
	$numRows = (count($this->allData)%4)+1;
}else{
	$numRows = (count($this->allData)/4);
}

$j = 0;
?>
<table cellspacing="0" cellpadding="0" border="0" width="958" style="margin: auto;">
<tbody>
<tr>

<td colspan="9">
<div>
	<h1 id="article_title">Hualalai in the Press</h1>
	<p>Below are stories and articles about Hualalai Resort.</p>
</div>
<br />
</td>
</tr>
<?php for ($i=0; $i<$numRows; $i++){?>

<tr align="left" valign="top">
    <td width="40"><img height="10" border="0" width="40" alt="" src="<?php echo JURI::base();?>/components/com_hualalainews/images/blank.gif"></td>    
    
    
    <td width="90">
    <?php if ($this->allData[$j]->article_image){?>
    	<img border="0" width="140" alt="Cover" src="<?php echo JURI::base();?>/administrator/components/com_hualalainews/hualalainews_image/<?php echo $this->allData[$j]->article_image;?>">
     
    <div class="newsPan">
    	<span style="width: 95px; float: left;">
        	<a href="index.php?option=com_hualalainews&task=edit&cid[]=<?php echo $this->allData[$j]->id?>">	
            	Plain Text
            </a>
        </span>
        <span style="width: 35px; float: right; text-align: right;">
        	<a href="<?php echo JURI::base();?>administrator/components/com_hualalainews/hualalainews_image/<?php echo $this->allData[$j]->article_attachment;?>" target="_blank">
			<?php if ($this->allData[$j]->article_attachment) { echo "PDF"; }?> 
        </a>
        </span>
    </div>
    <?php }?> 
    </td>
    
    <td width="50"><img height="10" border="0" width="50" alt="" src="<?php echo JURI::base();?>/components/com_hualalainews/images/blank.gif"></td>

    <td width="90">
    <?php if ($this->allData[$j+1]->article_image){?>
    	<img border="0" width="140" alt="Cover" src="<?php echo JURI::base();?>/administrator/components/com_hualalainews/hualalainews_image/<?php echo $this->allData[$j+1]->article_image;?>">
    <?php }?>
    <?php if ($this->allData[$j+1]->title){?>
    	<div class="newsPan">
            <span style="width: 95px; float: left;">
                <a href="index.php?option=com_hualalainews&task=edit&cid[]=<?php echo $this->allData[$j+1]->id?>">
                    Plain Text
                </a>
            </span>
            <span style="width: 35px; float: right; text-align: right;">
                <a href="<?php echo JURI::base();?>administrator/components/com_hualalainews/hualalainews_image/<?php echo $this->allData[$j+1]->article_attachment;?>" target="_blank">
                <?php if ($this->allData[$j+1]->article_attachment) { echo "PDF"; }?> 
            </a>
            </span>
        </div>
        <?php }?>
    </td>    
    
    <td width="50"><img height="10" border="0" width="50" alt="" src="<?php echo JURI::base();?>/components/com_hualalainews/images/blank.gif"></td>

    <td width="90">
    <?php if ($this->allData[$j+2]->article_image){?>
    	<img border="0" width="140" alt="Cover" src="<?php echo JURI::base();?>/administrator/components/com_hualalainews/hualalainews_image/<?php echo $this->allData[$j+2]->article_image;?>">
    <?php }?>   
    <?php if ($this->allData[$j+2]->title){?>
    <div class="newsPan">
        <span style="width: 95px; float: left;">
            <a href="index.php?option=com_hualalainews&task=edit&cid[]=<?php echo $this->allData[$j+2]->id?>">	
            	Plain Text
            </a>
        </span>
        <span style="width: 35px; float: right; text-align: right;">
            <a href="<?php echo JURI::base();?>administrator/components/com_hualalainews/hualalainews_image/<?php echo $this->allData[$j+2]->article_attachment;?>" target="_blank">
            <?php if ($this->allData[$j+2]->article_attachment) { echo "PDF"; }?> 
        </a>
        </span>
    </div> 
    <?php }?>
    </td>   
    
    <td width="50"><img height="10" border="0" width="50" alt="" src="<?php echo JURI::base();?>/components/com_hualalainews/images/blank.gif"></td>

    <td width="90">
    <?php if ($this->allData[$j+3]->article_image){?>
    	<img border="0" width="140" alt="Cover" src="<?php echo JURI::base();?>/administrator/components/com_hualalainews/hualalainews_image/<?php echo $this->allData[$j+3]->article_image;?>">
    <?php }?>
    <?php if ($this->allData[$j+3]->title){?>   
    <div class="newsPan">
        <span style="width: 95px; float: left;">
       		<a href="index.php?option=com_hualalainews&task=edit&cid[]=<?php echo $this->allData[$j+3]->id?>">	
            	Plain Text
            </a>
        </span>
        <span style="width: 35px; float: right; text-align: right;">
        	<a href="<?php echo JURI::base();?>administrator/components/com_hualalainews/hualalainews_image/<?php echo $this->allData[$j+3]->article_attachment;?>" target="_blank">
        	<?php if ($this->allData[$j+3]->article_attachment) { echo "PDF"; }?> 
        	</a>
        </span>
    </div> 
    <?php }?>
    </td>    
    <td width="40"><img height="10" border="0" width="40" alt="" src="<?php echo JURI::base();?>/components/com_hualalainews/images/blank.gif"></td>
</tr>

<tr><td colspan="7">&nbsp;<br>&nbsp;</td></tr>
<?php $j = $j + 4;}?>
</tbody></table>

</div>