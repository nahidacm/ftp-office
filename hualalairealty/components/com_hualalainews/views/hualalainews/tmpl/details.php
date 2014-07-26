<?php 
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.database.database');
jimport( 'joomla.database.table' );
?>
<div class="content_divider"></div>
<div class="news_details">


<br />

<table width="960" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
<td width="270"><span class="news_title"><?php echo $this->detailData[0]->title;?></span>

<br /><br /><br />

<p><a href="http://www.hualalairealty.com/component/hualalainews/hualalainews/show/48"> &laquo; Return to News Articles</a></p>

</td>
<td width="40">&nbsp;</td>
<td width="470" class="news_content"><?php echo $this->detailData[0]->contenttext;?></td>
<td width="40">&nbsp;</td>
<td width="140" class="news_image">
    <img src="<?php echo JURI::base();?>/administrator/components/com_hualalainews/hualalainews_image/<?php echo $this->detailData[0]->article_image;?>" border="0" />
    <div style="padding-top:20px;">
    <a href="<?php echo $this->detailData[0]->link_url;?>" target="_blank">
        <img src="<?php echo JURI::base();?>/components/com_hualalainews/images/view-article-button.gif" border="0" height="47" width="140" />
    </a>
    </div>
</td>
</tr>
</table>
<br clear="all" />
</div>
<br />