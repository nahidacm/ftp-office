<?php
if (!defined('_VALID_MOS') && !defined('_JEXEC'))
    die('Direct Access to ' . basename(__FILE__) . ' is not allowed.');

/**
 *
 * @package  RealEstateManager
 * @copyright 2009 Andrey Kvasnevskiy-OrdaSoft(akbet@mail.ru); Rob de Cleen(rob@decleen.com); 
 * Homepage: http://www.ordasoft.com
 * @version: 1.0 Basic $
 *  @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * */
require_once ($mosConfig_absolute_path . "/libraries/joomla/factory.php");
require_once ( JPATH_BASE . DS . 'includes' . DS . 'defines.php' );
require_once ( JPATH_BASE . DS . 'includes' . DS . 'framework.php' );
?>

<?php
// ensure this file is being included by a parent file



$bid = mosGetParam($_POST, 'bid', array(0));


require_once ($mosConfig_absolute_path . "/administrator/components/com_realestatemanager/admin.realestatemanager.class.others.php");

function catOrderDownIcon($i, $n, $index, $task = 'orderdown', $alt = 'Move Down') {
    if ($i < $n - 1) {
        return '<a href="#reorder" onclick="return listItemTask(\'cb' . $index . '\',\'' . $task . '\')" title="' . $alt . '">
			<img src="images/downarrow.png" width="12" height="12" border="0" alt="' . $alt . '" />
		</a>';
    } else {
        return '&nbsp;';
    }
}

function catOrderUpIcon($i, $index, $task = 'orderup', $alt = 'Move Up') {
    if ($i > 0) {
        return '<a href="#reorder" onclick="return listItemTask(\'cb' . $index . '\',\'' . $task . '\')" title="' . $alt . '">
			<img src="images/uparrow.png" width="12" height="12" border="0" alt="' . $alt . '" />
		</a>';
    } else {
        return '&nbsp;';
    }
}

class HTML_Categories {

    function show(&$rows, $myid, &$pageNav, &$lists, $type) {
        global $my, $mainframe, $mosConfig_live_site;

        $section = "com_realestatemanager";
        $section_name = "RealEstateManager";
        $mainframe->addCustomHeadTag('<link rel="stylesheet" href="' . $mosConfig_live_site . '/administrator/components/com_realestatemanager/includes/realestatemanager.css" type="text/css" />');
        ?>
        <form action="index2.php" method="post" name="adminForm">

                        <!--<table cellpadding="4" cellspacing="0" border="0" width="100%">
                        <tr>
              <td width="30%">
                      <img src="./components/com_realestatemanager/images/building_icon.jpg" align="right" alt="Config" />
              </td>
              <td width="70%" class="house_manager_caption" valign='bottom' >
        <?php echo _REALESTATE_MANAGER_CATEGORIES_MANAGER; ?>
                                </td>
                        </tr>
                        </table> -->

            <table class="adminlist">
                <tr>
                    <th width="20" align="center">
                        #
                    </th>
                    <th width="20">
                        <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
                    </th>
                    <th align = "center" class="title">
        <?php echo _HEADER_CATEGORY; ?>
                    </th>
                    <th align = "center" width="5%">
        <?php echo _HEADER_NUMBER; ?>
                    </th>

                    <th align = "center" width="10%">
        <?php echo _HEADER_PUBLISHED; ?>
                    </th>
                        <?php
                        if ($section <> 'content') {
                            ?>
                        <th align = "center" colspan="2">
            <?php echo _HEADER_REORDER; ?>
                        </th>
                            <?php
                        }
                        ?>
                    <th align = "center" width="10%">
                    <?php echo _HEADER_ACCESS; ?>
                    </th>
                        <?php
                        if ($section == 'content') {
                            ?>
                        <th width="12%" align="left">
                            Section
                        </th>
                        <?php
                    }
                    ?>
                    <th align = "center" width="12%">
                        ID
                    </th>
                    <th align = "center" width="12%">
                    <?php echo _HEADER_CHECKED_OUT; ?>
                    </th>
                </tr>
                    <?php
                    $k = 0;
                    $i = 0;
                    $n = count($rows);
                    foreach ($rows as $row) {
                        $img = $row->published ? 'tick.png' : 'publish_x.png';
                        $task = $row->published ? 'unpublish' : 'publish';
                        $alt = $row->published ? 'Published' : 'Unpublished';
                        if (!$row->access) {
                            $color_access = 'style="color: green;"';
                            $task_access = 'accessregistered';
                        } else if ($row->access == 1) {
                            $color_access = 'style="color: red;"';
                            $task_access = 'accessspecial';
                        } else {
                            $color_access = 'style="color: black;"';
                            $task_access = 'accesspublic';
                        }
                        ?>
                    <tr class="<?php echo "row$k"; ?>">
                        <td width="20" align="center">
                    <?php echo $pageNav->rowNumber($i); ?>
                        </td>
                        <td width="20">
                    <?php echo mosHTML::idBox($i, $row->id, ($row->checked_out_contact_category && $row->checked_out_contact_category != $my->id), 'bid'); ?>
                        </td>
                        <td width="35%">
                    <?php
                    if ($row->checked_out_contact_category && ($row->checked_out_contact_category != $my->id)) {
                        ?>
                        <?php echo $row->treename . ' ( ' . $row->title . ' )'; ?>
                                &nbsp;[ <i>Checked Out</i> ]
                <?php
            } else {
                ?>
                                <a href="#edit" onClick="return listItemTask('cb<?php echo $i; ?>', 'edit')">
                                <?php echo $row->treename . ' ( ' . $row->title . ' )'; ?>
                                </a>
                <?php
            }
            ?>
                        </td>
                        <td align="center">
                            <?php echo $row->nhouse; ?>
                        </td>

                        <td align="center">
                            <a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i; ?>', '<?php echo $task; ?>')">
                                <img src="images/<?php echo $img; ?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
                            </a>
                        </td>

                        <!-- old td  >
                            <?php echo $i . $pageNav->orderUpIcon($i); ?>
                        </td>
                        <td>
                            <?php echo $i . "::" . $n . $pageNav->orderDownIcon($i, $n); ?>
                        </td-->
                        <td>
                            <?php echo catOrderUpIcon($row->ordering - 1, $i); ?>
                        </td>
                        <td>
            <?php echo catOrderDownIcon($row->ordering - 1, $row->all_fields_in_list, $i); ?>
                        </td>

                        <td align="center">
                            <a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i; ?>', '<?php echo $task_access; ?>')" <?php echo $color_access; ?>>
            <?php echo $row->groupname; ?>
                            </a>
                        </td>
                        <td align="center">
                        <?php echo $row->id; ?>
                        </td>
                        <td align="center">
                            <?php echo $row->checked_out_contact_category ? $row->editor : ""; ?>				
                        </td>
            <?php
            $k = 1 - $k;
            ?>
                    </tr>
            <?php
            $k = 1 - $k;
            $i++;
        }
        ?>
                <tr><td colspan = "11"><?php echo $pageNav->getListFooter(); ?></td></tr>
            </table>


            <input type="hidden" name="option" value="com_realestatemanager" />
            <input type="hidden" name="section" value="categories" />
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="chosen" value="" />
            <input type="hidden" name="act" value="" />
            <input type="hidden" name="boxchecked" value="0" />
            <input type="hidden" name="type" value="<?php echo $type; ?>" />
        </form>
                <?php
            }

            /**
             * Writes the edit form for new and existing categories
             * 
             * @param mosCategory $ The category object
             * @param string $ 
             * @param array $ 
             */
            function edit(&$row, $section, &$lists, $redirect) {
                global $my, $mosConfig_live_site, $mainframe;

                $mainframe->addCustomHeadTag('<script type = "text/JavaScript" src ="' . $mosConfig_live_site . '/administrator/components/com_realestatemanager/includes/functions.js"></script>');

                $mainframe->addCustomHeadTag('<link rel="stylesheet" href="' . $mosConfig_live_site . '/administrator/components/com_realestatemanager/includes/realestatemanager.css" type="text/css" />');
                global $mosConfig_live_site, $option;
                if ($row->image == "") {
                    $row->image = 'blank.png';
                }
                mosMakeHtmlSafe($row, ENT_QUOTES, 'description');
                ?>
        <script language="javascript" type="text/javascript">
                            function submitbutton(pressbutton, section) {
                                var form = document.adminForm;
                                if (pressbutton == 'cancel') {
                                    submitform(pressbutton);
                                    return;
                                }

                                if (form.name.value == "") {
                                    alert('<?php echo _DML_CAT_MUST_SELECT_NAME; ?>');
                                } else {
        <?php getEditorContents('editor1', 'description'); ?>
                                    submitform(pressbutton);
                                }
                            }
        </script>

        <form action="index2.php" method="post" name="adminForm">
            <table >
                <tr>
                    <th  class="house_manager_caption" align="left">
        <?php echo $row->id ? _HEADER_EDIT : _HEADER_ADD; ?> <?php echo _CATEGORY; ?> <?php echo $row->name; ?>
                    </th>
                </tr>
            </table>

            <table width="100%">
                <tr>
                    <td valign="top">


                        <table class="adminform">
                            <tr>
                                <th colspan="3">
        <?php echo _CATEGORIES__DETAILS; ?>
                                </th>
                            </tr>
                            <tr>
                                <td>
        <?php echo _CATEGORIES_HEADER_TITLE; ?>:
                                </td>
                                <td colspan="2">
                                    <input class="text_area" type="text" name="title" value="<?php echo $row->title; ?>" size="50" maxlength="250" title="A short name to appear in menus" />
                                </td>
                            </tr>
                            <tr>
                                <td>
        <?php echo _CATEGORIES_HEADER_NAME; ?>:
                                </td>
                                <td colspan="2">
                                    <input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255" title="A short name to appear in menus" />
                                </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    <?php echo _CATEGORIES__PARENTITEM; ?>:</td>
                                <td>
        <?php echo $lists['parent']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
        <?php echo _CATEGORIES_HEADER_IMAGE; ?>:
                                </td>
                                <td>
        <?php echo $lists['image']; ?>
                                </td>
                                <td rowspan="4" width="50%">
                                    <script language="javascript" type="text/javascript">
                                        if (document.forms[0].image.options.value != '') {
                                            jsimg = '../images/stories/' + getSelectedValue('adminForm', 'image');
                                        }
                                        else
                                        {
                                            jsimg = '../images/M_images/blank.png';
                                        }
                                        document.write('<img src=' + jsimg + ' name="imagelib" width="80" height="80" border="2" alt="<?php echo _CATEGORIES__IMAGEPREVIEW; ?>" />');
                                    </script>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo _CATEGORIES_HEADER_IMAGEPOS; ?>:
                                </td>
                                <td>
                                    <?php echo $lists['image_position']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
        <?php echo _CATEGORIES_HEADER_ORDER; ?>:
                                </td>
                                <td>
        <?php echo $lists['ordering']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td align = "center">
        <?php echo _HEADER_ACCESS; ?>:
                                </td>
                                <td>
        <?php echo $lists['access']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo _HEADER_PUBLISHED; ?>:
                                </td>
                                <td>
        <?php echo $lists['published']; ?>
                                </td>
                            </tr>                
                            <tr>
                                <td valign="top">
                                    <?php echo _CATEGORIES__DETAILS; ?>:
                                </td>
                                <td colspan="2">
        <?php
        // parameters : areaname, content, hidden field, width, height, rows, cols
        editorArea('editor1', $row->description, 'description', '500', '200', '50', '5');
        ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <input type="hidden" name="option" value="com_realestatemanager" />
            <input type="hidden" name="section" value="categories" />
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="oldtitle" value="<?php echo $row->title; ?>" />
            <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
            <input type="hidden" name="sectionid" value="com_realestatemanager" />
            <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
        </form>
        <?php
    }

}

/**
 * realestatemanager Import Export Class
 * Handles the import and export of data from the realestatemanager.
 */
class HTML_realestatemanager {

    function edit_review($option, $house_id, &$review) {

        global $my, $mosConfig_live_site, $mainframe;
        $mainframe->addCustomHeadTag('<script type = "text/JavaScript" src ="' . $mosConfig_live_site . '/administrator/components/com_realestatemanager/includes/functions.js"></script>');
        ?>
        <form action="index2.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">

            <table cellpadding="4" cellspacing="5" border="0" width="100%" class="adminform">
                <tr>
                    <td colspan="2">
        <?php echo _REALESTATE_MANAGER_LABEL_REVIEW_TITLE; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input class="inputbox" type="text" name="title" size="80" 
                               value="<?php echo $review[0]->title ?>" />
                    </td>
                </tr>
                <tr>
                    <td>
        <?php echo _REALESTATE_MANAGER_LABEL_REVIEW_COMMENT; ?>
                    </td>
                    <td align="left" >
        <?php echo _REALESTATE_MANAGER_LABEL_REVIEW_RATING; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                     <!--<textarea align="top" name="comment" id="comment" cols="60" rows="10" style="width:400;height:100;"/></textarea>-->
        <?php
        editorArea('editor1', $review[0]->comment, 'comment', '410', '200', '60', '10');
        ?>
                    </td>
                    <td width="102" align='left'>
                        <?php
                        $k = 0;
                        while ($k < 11) {
                            ?>
                            <input type="radio" name="rating" value="<?php echo $k; ?>" 
            <?php if ($k == $review[0]->rating) echo 'checked="checked"'; ?> alt="Rating" />

                            <img src="../components/com_realestatemanager/images/rating-<?php echo $k; ?>.gif" 
                                 alt="<?php echo ($k) / 2; ?>" border="0" /><br />
            <?php
            $k++;
        }
        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;

                    </td>
                </tr>

            </table>

            <input type="hidden" name="option" value="<?php echo $option; ?>" />
            <input type="hidden" name="task" value="update_review" />
            <input type="hidden" name="house_id" value="<?php echo $house_id; ?>" />
            <input type="hidden" name="review_id" value="<?php echo $review[0]->id; ?>" />
        </form>
                        <?php
                    }

//*************   begin for manage reviews   ********************
                    function edit_manage_review($option, & $review) {
                        global $my, $mosConfig_live_site, $mainframe;
                        $mainframe->addCustomHeadTag('<script type = "text/JavaScript" src ="' . $mosConfig_live_site . '/administrator/components/com_realestatemanager/includes/functions.js"></script>');
                        ?>
        <form action="index2.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
            <table cellpadding="4" cellspacing="5" border="0" width="100%" class="adminform">
                <tr>
                    <td colspan="2">
        <?php echo _REALESTATE_MANAGER_LABEL_REVIEW_TITLE; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input class="inputbox" type="text" name="title" size="80" 
                               value="<?php echo $review[0]->title ?>" />
                    </td>
                </tr>
                <tr>
                    <td>
        <?php echo _REALESTATE_MANAGER_LABEL_REVIEW_COMMENT; ?>
                    </td>
                    <td align="left" >
        <?php echo _REALESTATE_MANAGER_LABEL_REVIEW_RATING; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                     <!--<textarea align= "top" name="comment" id="comment" cols="60" rows="10" style="width:400;height:100;"/></textarea>-->

        <?php
        editorArea('editor1', $review[0]->comment, 'comment', '410', '200', '60', '10');
        ?>
                    </td>
                    <td width="102" align='left'>
        <?php
        $k = 0;
        while ($k < 11) {
            ?>
                            <input type="radio" name="rating" value="<?php echo $k; ?>" 
            <?php if ($k == $review[0]->rating) echo 'checked="checked"'; ?> alt="Rating" />
                            <img src="../components/com_realestatemanager/images/rating-<?php echo $k; ?>.gif" 
                                 alt="<?php echo ($k) / 2; ?>" border="0" /><br />
            <?php
            $k++;
        }
        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;

                    </td>
                </tr>

            </table>

            <input type="hidden" name="option" value="<?php echo $option; ?>" />
            <input type="hidden" name="task" value="update_edit_manage_review" />
            <input type="hidden" name="review_id" value="<?php echo $review[0]->id; ?>" />
        </form>
                        <?php
                    }

//***************   end for manage reviews   ********************

                    function showRequestRentHouses($option, & $rent_requests, & $pageNav) {
                        global $my, $mosConfig_live_site, $mainframe;
                        $mainframe->addCustomHeadTag('<script type = "text/JavaScript" src ="' . $mosConfig_live_site . '/administrator/components/com_realestatemanager/includes/functions.js"></script>');

                        $mainframe->addCustomHeadTag('<link rel="stylesheet" href="' . $mosConfig_live_site . '/administrator/components/com_realestatemanager/includes/realestatemanager.css" type="text/css" />');
                        ?>
        <form action="index2.php" method="post" name="adminForm">

                        <!--<table cellpadding="4" cellspacing="0" border="0" width="100%">
                        <tr>
              <td width="30%">
                 <img src="./components/com_realestatemanager/images/building_icon.jpg" align="right" alt="Config" />
              </td>
              <td width="70%" class="house_manager_caption" valign='bottom' >
        <?php echo _REALESTATE_MANAGER_ADMIN_REQUEST_RENT; ?>
                                </td>
                        </tr>
                        </table> -->

            <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
                <tr>
                    <th align = "center" width="20">
                        <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rent_requests); ?>);" />
                    </th>
                    <th align = "center" width="30">#</th>
                    <th align = "center" class="title" width="10%" nowrap="nowrap">
        <?php echo _REALESTATE_MANAGER_LABEL_RENT_FROM; ?></th>
                    <th align = "center" class="title" width="10%" nowrap="nowrap">
        <?php echo _REALESTATE_MANAGER_LABEL_RENT_UNTIL; ?></th>
                    <th align = "center" class="title" width="5%" nowrap="nowrap">
        <?php echo _REALESTATE_MANAGER_LABEL_HOUSEID; ?></th>
                    <th align = "center" class="title" width="15%" nowrap="nowrap">
        <?php echo _REALESTATE_MANAGER_LABEL_ADDRESS; ?></th>
                    <th align = "center" class="title" width="15%" nowrap="nowrap">
        <?php echo _REALESTATE_MANAGER_LABEL_RENT_USER; ?></th>
                    <th align = "center" class="title" width="15%" nowrap="nowrap">
        <?php echo _REALESTATE_MANAGER_LABEL_RENT_EMAIL; ?></th>
                    <th align = "center" class="title" width="20%" nowrap="nowrap">    
        <?php echo _REALESTATE_MANAGER_LABEL_REQ_PROPERTY; ?></th>
                    <th align = "center" class="title" width="15%" nowrap="nowrap">
        <?php echo _REALESTATE_MANAGER_LABEL_REQ_MAINTANCE; ?></th>
                    <th align = "center" class="title" width="15%" nowrap="nowrap">
        <?php echo _REALESTATE_MANAGER_LABEL_REQ_COMPARABLE; ?></th>          
                    <th align = "center" class="title" width="20%" nowrap="nowrap">
            <?php echo _REALESTATE_MANAGER_LABEL_RENT_ADRES; ?></th>
                </tr>
        <?php
        for ($i = 0, $n = count($rent_requests); $i < $n; $i++) {
            $row = & $rent_requests[$i];
            ?>

                    <tr class="row<?php echo $i % 2; ?>">
                        <td width="20" align="center">

            <?php if ($row->fk_rentid != 0) { ?>
                                &nbsp;
                                <?php
                            } else {
                                echo mosHTML::idBox($i, $row->id, ($row->fk_rentid != 0), 'bid');
                            }
                            ?>
                        </td>
                        <td align = "center"><?php echo $row->id; ?></td>
                        <td align = "center">
                            <?php echo $row->rent_from; ?>
                        </td>
                        <td align = "center">
                            <?php echo $row->rent_until; ?>
                        </td>
                        <td align = "center"><?php echo $row->fk_houseid; ?></td>

                        <!--
                                                        <td align = "center">
                            <?php echo $row->mls; ?>
                                                        </td>
                        -->

                        <td align = "center">
                    <?php echo $row->htitle; ?>
                        </td>
                        <td align = "center">					
                    <?php echo $row->user_name; ?>
                        </td>
                        <td align = "center">
                            <a href=mailto:"<?php echo $row->user_email; ?>">
                            <?php echo $row->user_email; ?>
                            </a>
                        </td>
                        <td align = "center">
                            <?php if ($row->chkProperty) {
                                echo "Yes";
                            } ?>
                        </td>
                        <td align = "center">
            <?php if ($row->chkMaintence) {
                echo "Yes";
            } ?>
                        </td>
                        <td align = "center">
                            <?php if ($row->chkComparable) {
                                echo "Yes";
                            } ?>
                        </td>
                        <td align = "center">
                        <?php echo $row->user_mailing; ?>
                        </td>
                    </tr>
            <?php
        }
        ?>
                <tr><td colspan = "14"><?php echo $pageNav->getListFooter(); ?></td></tr>
            </table>
            <input type="hidden" name="option" value="<?php echo $option; ?>" />
            <input type="hidden" name="task" value="rent_requests" />
            <input type="hidden" name="boxchecked" value="0" />
        </form>

                            <?php
                        }

                        function showRequestBuyingHouses($option, $rent_requests, $pageNav) {
                            global $my, $mosConfig_live_site, $mainframe;
                            $mainframe->addCustomHeadTag('<script type = "text/JavaScript" src ="' . $mosConfig_live_site . '/administrator/components/com_realestatemanager/includes/functions.js"></script>');

                            $mainframe->addCustomHeadTag('<link rel="stylesheet" href="' . $mosConfig_live_site . '/administrator/components/com_realestatemanager/includes/realestatemanager.css" type="text/css" />');
                            ?>
        <form action="index2.php" method="post" name="adminForm">
        <!--<table cellpadding="4" cellspacing="0" border="0" width="100%">
                <tr>
                      <td width="30%">
                                <img src="./components/com_realestatemanager/images/building_icon.jpg" align="right" alt="Config" />
                        </td>
                        <td width="70%" class="house_manager_caption" valign='bottom' >
                <?php echo _REALESTATE_MANAGER_ADMIN_SALE_MANAGER; ?>
                        </td>
                </tr>
        </table> -->

            <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">

                <tr>

                    <th align = "center" width="20">

                        <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rent_requests); ?>);" />

                    </th>

                    <th align = "center" width="30">#</th>

                    <th align = "center" class="title" width="5%" nowrap="nowrap"><?php echo _REALESTATE_MANAGER_LABEL_HOUSEID; ?></th>

                    <!--
                    
                                                    <th align = "center" class="title" width="10%" nowrap="nowrap"><?php echo _REALESTATE_MANAGER_LABEL_MLS; ?></th>
                    -->


                    <th align = "center" class="title" width="15%" nowrap="nowrap"><?php echo _REALESTATE_MANAGER_LABEL_ADDRESS; ?></th>

                    <th align = "center" class="title" width="15%" nowrap="nowrap"><?php echo _REALESTATE_MANAGER_LABEL_RENT_USER; ?></th>

                    <th align = "center" class="title" width="15%" nowrap="nowrap"><?php echo _REALESTATE_MANAGER_LABEL_RENT_EMAIL; ?></th>

                    <th align = "center" class="title" width="20%" nowrap="nowrap"><?php echo _REALESTATE_MANAGER_LABEL_BUYING_ADRES; ?></th>
                </tr>
        <?php
        for ($i = 0, $n = count($rent_requests); $i < $n; $i++) {
            $row = & $rent_requests[$i];
            ?>

                    <tr class="row<?php echo $i % 2; ?>">

                        <td width="20">

            <?php if ($row->fk_rentid != 0) { ?>
                                &nbsp;
                <?php
            } else {
                ?>
                                <div align = "center">
                <?php
                echo mosHTML::idBox($i, $row->id, ($row->fk_rentid != 0), 'bid');
                ?>
                                </div>
                <?php
            }
            ?>
                        </td>

                        <td align = "center"><?php echo $row->id; ?></td>
                        <td align = "center"><?php echo $row->fk_houseid; ?></td>


                        <!--
                                                        <td align = "center"><?php echo $row->mls; ?></td>
                        -->


                        <td align = "center"><?php echo $row->hlocation; ?></td>

                        <td align = "center"><?php echo $row->customer_name; ?></td>

                        <td align = "center">
                            <a href=mailto:"<?php echo $row->customer_email; ?>">
                            <?php echo $row->customer_email; ?>
                            </a>
                        </td>

                        <td align = "center"><?php echo $row->customer_phone; ?></td>
                    </tr>
                            <?php } ?>
            </table>

            <input type="hidden" name="option" value="<?php echo $option; ?>" />

            <input type="hidden" name="task" value="rent_requests" />

            <input type="hidden" name="boxchecked" value="0" />
        </form>
        <?php
    }

    function showHouses($option, & $rows_house, & $clist, & $rentlist, & $publist, & $search, & $pageNav) {
        global $my, $mosConfig_live_site, $mainframe, $session;
        $mainframe->addCustomHeadTag('<script type = "text/JavaScript" src ="' . $mosConfig_live_site . '/administrator/components/com_realestatemanager/includes/functions.js"></script>');

        $mainframe->addCustomHeadTag('<link rel="stylesheet" href="' . $mosConfig_live_site . '/administrator/components/com_realestatemanager/includes/realestatemanager.css" type="text/css" />');
        ?>
        <form action="index2.php" method="post" name="adminForm">

                        <!--<table cellpadding="4" cellspacing="0" border="0" width="100%">
                                        <tr>
                                        <td width="30%">
                                           <img src="./components/com_realestatemanager/images/building_icon.jpg" align="right" alt="Config" />
                                        </td>

                                        <td width="68%" class="house_manager_caption" valign='bottom' >
        <?php echo _REALESTATE_MANAGER_SHOW; ?>
                                        </td>
                                        </tr>
                                </table> -->

            <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
                <tr>
                    <td>
        <?php echo _REALESTATE_MANAGER_SHOW_SEARCH; ?>
                    </td>
                    <td>

                        <input type="text" name="search" value="<?php echo $search; ?>" class="inputbox" onChange="document.adminForm.submit();" />
                    </td>
                    <td>
        <?php echo $publist; ?>
                    </td>
                    <td>
        <?php echo $rentlist; ?>
                    </td>

                    <td >
        <?php echo $clist; ?>
                    </td>
                </tr>
            </table>

            <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
                <tr>
                    <th width="20">
                        <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows_house); ?>);" />
                    </th>
                    <th width="30">#</th>
                    <th align = "center" class="title" width="5%" nowrap="nowrap"><?php echo _REALESTATE_MANAGER_LABEL_HOUSEID; ?></th>
                  <!--  <th align = "center"  class="title" width="12%" nowrap="nowrap"><?php echo _REALESTATE_MANAGER_LABEL_MLS; ?></th> -->
                    <th align = "center" class="title" width="27%" nowrap="nowrap"><?php echo _REALESTATE_MANAGER_LABEL_ADDRESS; ?></th>
                    <th align = "center" class="title" width="27%" nowrap="nowrap"><?php echo _REALESTATE_MANAGER_LABEL_TITLE; ?></th>
                    <th align = "center" class="title" width="5%" nowrap="nowrap" colspan="2"><?php echo _REALESTATE_MANAGER_LABEL_LINE; ?></th>
                    <th align = "center" class="title" width="16%" nowrap="nowrap"><?php echo _REALESTATE_MANAGER_LABEL_CATEGORY; ?></th>
                  <!--  <th align = "center" class="title" width="10%" nowrap="nowrap"><?php //echo _REALESTATE_MANAGER_LABEL_RENT; ?></th> -->
                    <th align = "center" class="title" width="5%" nowrap="nowrap"><?php echo _REALESTATE_MANAGER_LABEL_HITS; ?></th>		
                    <th align = "center"  class="title" width="5%" nowrap="nowrap"><?php echo _REALESTATE_MANAGER_LABEL_PUBLIC; ?></th>
                    <th align = "center" class="title" width="5%" nowrap="nowrap"><?php echo _REALESTATE_MANAGER_LABEL_CONTROL; ?></th>
                </tr>
        <?php
        for ($i = 0, $n = count($rows_house); $i < $n; $i++) {
            $row = & $rows_house[$i];
            ?>
                    <tr class="row<?php echo $i % 2; ?>">

                        <td width="20" align="left">
            <?php //if ($row->checked_out && $row->checked_out != $my->id) {  ?>
                            &nbsp;
                            <?php
                            //} else {
                            echo mosHTML::idBox($i, $row->id, false, 'bid');
                            //}
                            ?>
                        </td>
                        <td align = "center" ><?php echo $row->id; ?></td>
                        <td align = "center"><?php echo $row->houseid; ?></td>

            <!--                                <td align="center">
                    <a href="#edit" onClick="return listItemTask('cb<?php //echo $i; ?>','edit')">
            <?php //echo $row->mls;  ?>
                    </a>
            </td>  
                        -->

                        <td align="left">
                            <a href="#edit" onClick="return listItemTask('cb<?php echo $i; ?>', 'edit')">
            <?php echo $row->hlocation; ?>
                            </a>
                        </td>
                        <td align="left">
                            <a href="#edit" onClick="return listItemTask('cb<?php echo $i; ?>', 'edit')">
                    <?php echo $row->htitle; ?>
                            </a>
                        </td>
                        <td>
                    <?php echo $pageNav->orderUpIcon($i, ($row->catid == @$rows_house[$i - 1]->catid), "houseorderup"); ?>
                        </td>
                        <td>
            <?php echo $pageNav->orderDownIcon($i, $n, ($row->catid == @$rows_house[$i + 1]->catid), "houseorderdown"); ?>
                        </td>
                        <!--<td align="center">
                            <?php /* echo mosrealestatemanagerWS :: getWsNameById($row->link); */ ?>
                        </td>-->
                        <td align = "center"><?php echo $row->category; ?></td>
                        <!--<td align = "center">
                            <?php
                            /* if($row->listing_type == 'house for rent'||$row->listing_type == 'room for rent' || $row->listing_type == 'sublet'){
                              if ($row->rent_from == null) { */
                            ?>
                                <a href="javascript: void(0);" onClick="return listItemTask('cb<?php //echo $i; ?>','rent')">
                                <img src='./components/com_realestatemanager/images/lend_f2.png' align='middle' width='15' height='15' border='0' alt='Rent out' />
                                        <br />
                                </a>
                        <?php
                        /* } else { */
                        ?>

                        <img src='./components/com_realestatemanager/images/lend_return_f2.png' align='middle' width='15' height='15' border='0' alt='Return house' />
                        <br />
                        <a href="javascript: void(0);" onClick="return listItemTask('cb<?php //echo $i; ?>','rent_return')"> 
                                <?php //echo substr($row->rent_from, 0, 10); ?>
                        </a>
                
            <?php
            /* 	}} */
            ?>

                        </td> -->

                        <td align = "center"><?php echo $row->hits; ?></td>
            <?php
            $task = $row->published ? 'unpublish' : 'publish';
            $alt = $row->published ? 'Unpublish' : 'Publish';
            $img = $row->published ? 'tick.png' : 'publish_x.png';
            ?>
                        <td width="5%" align="center">
                            <a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i; ?>', '<?php echo $task; ?>')">
                                <img src="images/<?php echo $img; ?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
                            </a>
                        </td>
                        <?php
                        if ($row->checked_out) {
                            ?>
                            <td align="center"><?php echo $row->editor; ?></td>
            <?php } else { ?>
                            <td align="center">&nbsp;</td>
                        <?php } ?>
                    </tr>
                        <?php
                    }//end for
                    ?>
                <tr><td colspan = "13"><?php echo $pageNav->getListFooter(); ?></td>
                </tr>
            </table>
            <input type="hidden" name="option" value="<?php echo $option; ?>" />
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="boxchecked" value="0" />
        </form>

                    <?php
                }

                /**
                 * Writes the edit form for new and existing records
                 *
                 */
                function editHouse($option, & $row, & $catListValue, & $clist, & $rating, & $delete_edoc, & $reviews, & $test_list, & $listing_status_list, & $property_type_list, & $listing_type_list, & $provider_class_list, & $zoning_list, & $style_list, & $house_photos) {

                    global $realestatemanager_configuration;

                    global $my, $mosConfig_live_site, $mainframe;

                    $mainframe->addCustomHeadTag('<script type = "text/JavaScript" src ="' . $mosConfig_live_site . '/administrator/components/com_realestatemanager/includes/functions.js"></script>');
                    $mainframe->addCustomHeadTag('<link rel="stylesheet" type="text/css" media="all" href="' . $mosConfig_live_site . '/includes/js/calendar/calendar-mos.css" title="green" />');

                    $mainframe->addCustomHeadTag('<script type = "text/JavaScript" src ="' . $mosConfig_live_site . '/includes/js/calendar/calendar.js"></script>');

                    $mainframe->addCustomHeadTag('<script type = "text/JavaScript" src ="' . $mosConfig_live_site . '/includes/js/calendar/lang/calendar-en-GB.js"></script>');
                    ?>



        <script language="javascript" type="text/javascript">

                                        function trim(string) {
                                            return string.replace(/(^\s+)|(\s+$)/g, "");
                                        }
                                        function submitbutton(pressbutton) {

                                            var form = document.adminForm;


                                            if (pressbutton == 'save') {
                                                if (trim(form.houseid.value) == '') {
                                                    alert("<?php echo _REALESTATE_MANAGER_ADMIN_INFOTEXT_JS_EDIT_HOUSEID_CHECK; ?>");
                                                    return;
                                                } else if (form.catid.value == '0') {

                                                    alert("<?php echo _REALESTATE_MANAGER_ADMIN_INFOTEXT_JS_EDIT_CATEGORY; ?>");
                                                    return;
                                                } /*else if (form.listing_type.value == '') {
                                                 
                                                 alert( "<?php echo _REALESTATE_MANAGER_ADMIN_INFOTEXT_JS_EDIT_LISTING_TYPE; ?>");
                                                 return;
                                                 }*/ else if (form.hlocation.value == '') {

                                                    alert("<?php echo _REALESTATE_MANAGER_ADMIN_INFOTEXT_JS_EDIT_ADDRESS; ?>");
                                                    return;
                                                } else if (form.price.value == '') {

                                                    alert("<?php echo _REALESTATE_MANAGER_ADMIN_INFOTEXT_JS_EDIT_PRICE; ?>");
                                                    return;
                                                } else if (form.htitle.value == '') {

                                                    alert("<?php echo _REALESTATE_MANAGER_ADMIN_INFOTEXT_JS_EDIT_TITLE; ?>");
                                                    return;
                                                }/*else if (!form.bathrooms.value.test("^([0-9]*)$") ) {
                                                 
                                                 alert( "<?php echo _REALESTATE_MANAGER_INFOTEXT_JS_BATHROOMS; ?>");
                                                 return;
                                                 }else if (!form.bedrooms.value.test("^([0-9]*)$") ) {
                                                 
                                                 alert( "<?php echo _REALESTATE_MANAGER_INFOTEXT_JS_BEDROOMS; ?>");
                                                 return;
                                                 }*/ else if (!form.year.value.test("^([0-9]*)$")) {

                                                    alert("<?php echo _REALESTATE_MANAGER_INFOTEXT_JS_BUILD_YEAR; ?>");
                                                    return;
                                                }/*else if (!form.property_taxes.value < 0 || form.property_taxes.value > 1) {
                                                 
                                                 alert( "<?php echo _REALESTATE_MANAGER_ADMIN_INFOTEXT_JS_EDIT_PROPERTY_TAXES; ?>");
                                                 return;
                                                 }*/ else {

                                                    submitform(pressbutton);

                                                }
                                            } else {
                                                submitform(pressbutton);
                                            }

                                        }
                                        var photos = 0;
                                        function new_photos()
                                        {
                                            div = document.getElementById("items");
                                            button = document.getElementById("add");
                                            photos++;
                                            newitem = "<strong>" + "<?php echo _REALESTATE_MANAGER_ADMIN_NEW_PHOTO ?>" + photos + ": </strong>";
                                            newitem += "<input type=\"file\" name=\"new_photo_file[]";
                                            newitem += "\" value=\"\"size=\"45\">&nbsp;&nbsp; Title : <input type=\"text\" name=\"photo_title[]\" id=\"photo_title\" value=\"\"  size=\"50\" />&nbsp;&nbsp;<input  type=\"checkbox\" id=\"as_featured_image\" name=\"as_featured_image[]\" value=\"1\" />Featured?&nbsp;&nbsp;<input type=\"text\" name=\"need_login[]\" id=\"need_login\"  size=\"5\" value=\"\" />Need Login?  &nbsp; Ordering: <input type=\"text\" name=\"image_order[]\" id=\"image_order\"  size=\"5\" value=\"\" /><br>";

                                            newnode = document.createElement("span");
                                            newnode.innerHTML = newitem;
                                            div.insertBefore(newnode, button);
                                        }

        </script>

        <script language="javascript" type="text/javascript">

            function popitup(url) {
                newwindow = window.open(url, 'name', 'height=500,width=600,scrollbars=1');
                if (window.focus) {
                    newwindow.focus()
                }
                return false;
            }


        </script>

        <form action="index2.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
            <table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
                <tr>
                    <td width="15%" align="right">
                        <strong><?php echo _REALESTATE_MANAGER_LABEL_HOUSEID; ?>:</strong>				
                    </td>
                    <td width="85%" align="left">
                        <input class="inputbox" type="text" name="houseid" size="46" value="<?php echo $row->houseid; ?>" />
                    </td>
                </tr>
                <!--
                                <tr>
                                        <td width="20%" align="right">
                                                <strong><?php //echo _REALESTATE_MANAGER_LABEL_MLS; ?>:</strong>
                                        </td>
                                        <td align="left">
                                                <input class="inputbox" type="text" name="mls" size="20" maxlength="20" value="<?php //echo $row->mls; ?>" />				
                                        </td>
                                </tr>
                                <tr>
                                        <td width="20%" align="right">
                                                <strong><?php //echo _REALESTATE_MANAGER_LABEL_MLS_NAME; ?>:</strong>
                                        </td>
                                        <td align="left">
                                                <input class="inputbox" type="text" name="mls_name" size="20" maxlength="20" value="<?php //echo $row->mls_name; ?>" />				
                                        </td>
                                </tr>
                -->

                <tr>
                    <td valign="top" align="right">
                        <strong>ASSIGN USERS TO THIS PROPERTY:</strong>
                    </td>
                    <td align="left">
        <?php //echo $clist;  ?>


                        <a onclick="return popitup('http://www.hualalairealty.com/selectusers.php?id=<?php echo $row->id; ?>')" style="cursor:pointer;">Select Users</a>

                    </td>
                </tr>

                <tr>
                    <td valign="top" align="right">
                        <strong><?php echo _REALESTATE_MANAGER_LABEL_CATEGORY; ?>:</strong>
                    </td>
                    <td align="left">
        <?php //echo $clist;  ?>
                        <select id="catid" name="catid" class="inputbox" size="1">
                            <option value="0">Select Category</option>
        <?php for ($i = 0; $i < count($catListValue); $i++) { ?>
                                <option value="<?php echo $catListValue[$i]['value']; ?>" <?php if ($row->catid == $catListValue[$i]['value']) { ?> selected="selected"<?php } ?>><?php echo $catListValue[$i]['text']; ?></option>
        <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td valign="top" align="right">
                        <strong><?php echo _REALESTATE_MANAGER_LABEL_COMMENT; ?>:</strong>
                    </td>
                    <td align="left">
        <?php
        editorArea('editor1', $row->description, 'description', 500, 250, '70', '10');
        ?>
                            <!--<textarea name="comment" id="comment" cols="50" rows="25" style="width:800;height:200;"><?php /* echo $row->comment; */ ?></textarea>-->
                    </td>
                </tr>
        <?php if ($realestatemanager_configuration['edocs']['allow']) {
            ?>	
                    <tr>
                        <td valign="top" align="right">
                            <strong><?php echo _REALESTATE_MANAGER_LABEL_EDOCUMENT_UPLOAD; ?>:</strong>
                        </td>
                        <td align="left">
                            <input class="inputbox" type="file" name="edoc_file" value="" size="50" maxlength="250" onClick="document.adminForm.edok_link.value = '';"/>
                            <input class="inputbox" type="hidden" name="edok_link" value="<?php echo $row->edok_link; ?>" size="50" maxlength="250"/>
                        </td>
                    </tr>		
                    <!--<tr>
                            <td valign="top" align="right">
                                    <strong><?php //echo _REALESTATE_MANAGER_LABEL_EDOCUMENT_UPLOAD_URL; ?>:</strong>
                            </td>
                            <td align="left">
                                    <input class="inputbox" type="text" name="edok_link" value="<?php //echo $row->edok_link;  ?>" size="50" maxlength="250"/>
                            </td>
                    </tr>	 -->	
                                <?php
                            }
                            //var_dump($delete_edoc);
                            if (strlen($row->edok_link) > 0) {
                                ?>
                    <tr>
                        <td valign="top" align="right">
                            <strong><?php echo _REALESTATE_MANAGER_LABEL_EDOCUMENT_DELETE; ?>:</strong>
                        </td>
                        <td align="left">
                            <?php echo $delete_edoc; ?>
                            <a href="<?php echo $row->edok_link; ?>">View/Download File</a>
                        </td>
                    </tr>
            <?php
        }
        ?>	
                <tr>
                    <td valign="top" align="right">
                        <strong><?php echo _REALESTATE_MANAGER_LABEL_VIRTUAL_TOUR_URL; ?>:</strong>
                    </td>
                    <td align="left">
                        <input class="inputbox" type="text" name="virtual_link" value="<?php echo $row->virtual_link; ?>" size="50" maxlength="250"/>
                    </td>
                </tr>

                <tr>
                    <td valign="top" align="right">
                        <strong><?php echo _REALESTATE_MANAGER_LABEL_BROCHURE_URL; ?>:</strong>
                    </td>
                    <td align="left">
                        <input class="inputbox" type="text" name="brochure_link" value="<?php echo $row->brochure_link; ?>" size="50" maxlength="250"/>
                    </td>
                </tr>
                
                <tr>
                    <td valign="top" align="right">
                        <strong>Property video embed code:</strong>
                    </td>
                    <td align="left">
                        <textarea style="height: 200px; width: 262px;" name="property_video_embed_code"><?php echo stripcslashes($row->property_video_embed_code) ?></textarea>
                    </td>
                </tr>
                
                <tr>
                    <td valign="top" align="right">
                        <strong>Property video url:</strong>
                    </td>
                    <td align="left">
                        <input class="inputbox" type="text" name="property_video_url" value="<?php echo $row->property_video_url; ?>" size="50" maxlength="250"/>
                    </td>
                </tr>
                
                  <tr>
                    <td valign="top" align="right">
                        <strong>Property video image:</strong>
                    </td>
                    <td align="left">
                        <input class="inputbox" type="file" name="property_video_image_file" value="" size="50" maxlength="250" onClick="document.adminForm.property_video_image_file.value = '';"/>
                    </td>
                </tr>
                    <?php
                        if (strlen($row->property_video_image_link) > 0) {
                            ?>
                    <tr>
                        <td valign="top" align="right">

                        </td>
                        <td align="left">
                            <a class="view_doc" href="<?php echo $row->property_video_image_link; ?>">View/Download File</a><span id="property_video_image_link" class="delete_doc">Delete Doc</span>

                        </td>
                    </tr>
            <?php
        }
        ?>

                <tr>
                    <td valign="top" align="right">
                        <strong><?php echo _REALESTATE_MANAGER_LABEL_FLOOR_PLAN; ?>:</strong>
                    </td>
                    <td align="left">
                        <input class="inputbox" type="file" name="floor_file" value="" size="50" maxlength="250" onClick="document.adminForm.floor_file.value = '';"/>
                    </td>
                </tr>

                        <?php
                        if (strlen($row->floor_link) > 0) {
                            ?>
                    <tr>
                        <td valign="top" align="right">

                        </td>
                        <td align="left">
                            <a class="view_doc" href="<?php echo $row->floor_link; ?>">View/Download File</a><span id="floor_link" class="delete_doc">Delete Doc</span>

                        </td>
                    </tr>
            <?php
        }
        ?>
                    
                    
                    
                     <tr>
                    <td valign="top" align="right">
                        <strong>Features List:</strong>
                    </td>
                    <td align="left">
                        <input class="inputbox" type="file" name="features_list_file" value="" size="50" maxlength="250" onClick="document.adminForm.features_list_file.value = '';"/>
                    </td>
                </tr>
                    
                    <?php
                        if (strlen($row->features_list_link) > 0) {
                            ?>
                    <tr>
                        <td valign="top" align="right">

                        </td>
                        <td align="left">
                            <a class="view_doc" href="<?php echo $row->features_list_link; ?>">View/Download File</a><span id="features_list_link" class="delete_doc">Delete Doc</span>

                        </td>
                    </tr>
            <?php
        }
        ?>
                    <tr>
                    <td valign="top" align="right">
                        <strong>Plot Map:</strong>
                    </td>
                    <td align="left">
                        <input class="inputbox" type="file" name="plot_map_file" value="" size="50" maxlength="250" onClick="document.adminForm.plot_map_file.value = '';"/>
                    </td>
                </tr>
                    <?php
                        if (strlen($row->plot_map_link) > 0) {
                            ?>
                    <tr>
                        <td valign="top" align="right">

                        </td>
                        <td align="left">
                            <a class="view_doc" href="<?php echo $row->plot_map_link; ?>">View/Download File</a><span id="plot_map_link" class="delete_doc">Delete Doc</span>

                        </td>
                    </tr>
            <?php
        }
        ?>
          
                    
                  
                    
                    
                    

                <tr>
                    <td valign="top" align="right">
                        <strong><?php echo _REALESTATE_MANAGER_LABEL_LOT_PLAN; ?>:</strong>
                    </td>
                    <td align="left">
                        <input class="inputbox" type="file" name="lot_file" value="" size="50" maxlength="250" onClick="document.adminForm.lot_file.value = '';"/>
                    </td>
                </tr>
        <?php
        if (strlen($row->lot_link) > 0) {
            ?>
                    <tr>
                        <td valign="top" align="right">

                        </td>
                        <td align="left">
                            <a class="view_doc" href="<?php echo $row->lot_link; ?>">View/Download File</a><span id="lot_link" class="delete_doc">Delete Doc</span>

                        </td>
                    </tr>
                    <?php
                }
                ?>


                <tr>
                    <td valign="top" align="right">
                        <strong><?php echo _REALESTATE_MANAGER_LABEL_SITE_PLAN; ?>:</strong>
                    </td>
                    <td align="left">
                        <input class="inputbox" type="file" name="site_plan" value="" size="50" maxlength="250" onClick="document.adminForm.site_plan.value = '';"/>
                    </td>
                </tr>
                <?php
                if (strlen($row->site_plan) > 0) {
                    ?>
                    <tr>
                        <td valign="top" align="right">

                        </td>
                        <td align="left">
                            <a class="view_doc" href="<?php echo $row->site_plan; ?>">View/Download File</a><span id="site_plan" class="delete_doc">Delete Doc</span>

                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td valign="top" align="right">
                        <strong><?php echo _REALESTATE_MANAGER_LABEL_BLUEPRINTS; ?>:</strong>
                    </td>
                    <td align="left">
                        <input class="inputbox" type="file" name="blueprints" value="" size="50" maxlength="250" onClick="document.adminForm.blueprints.value = '';"/>
                    </td>
                </tr>
                <?php
                if (strlen($row->blueprints) > 0) {
                    ?>
                    <tr>
                        <td valign="top" align="right">

                        </td>
                        <td align="left">
                            <a class="view_doc" href="<?php echo $row->blueprints; ?>">View/Download File</a><span id="blueprints" class="delete_doc">Delete Doc</span>

                        </td>
                    </tr>
                    <?php
                }
                ?>

                <tr>
                    <td valign="top" align="right">
                        <strong><?php echo _REALESTATE_MANAGER_LABEL_SCHEMATICS; ?>:</strong>
                    </td>
                    <td align="left">
                        <input class="inputbox" type="file" name="schematics" value="" size="50" maxlength="250" onClick="document.adminForm.schematics.value = '';"/>
                    </td>

                <script type="text/javascript">
            jQuery(document).ready(function() {

                jQuery(".delete_doc").click(function() {
                    var answer = confirm("Delete Document?");
                    var element_id = this.id;
                    if (answer) {
                        jQuery.post("index.php?option=com_realestatemanager&remove_the_doc=something",
                                {id: "<?php echo $row->id; ?>", item: this.id},
                        function(data) {
                            //alert(data);
                            if (jQuery.trim(data) == "Successfully Deleted") {
                                jQuery("#" + element_id).closest("tr").hide();
                            }

                        });
                    }
                });

            });
                </script>
                <style type="text/css">

                </style>
                </tr>
                <?php
                if (strlen($row->schematics) > 0) {
                    ?>
                    <tr>
                        <td valign="top" align="right">

                        </td>
                        <td align="left">
                            <a class="view_doc" href="<?php echo $row->schematics; ?>">View/Download File</a><span id="schematics" class="delete_doc">Delete Doc</span> 
                        </td>
                    </tr>
            <?php
        }
        ?>


                <tr>
                    <td colspan="2">			  				
                        <hr size="2" width="100%" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h1><?php echo _REALESTATE_MANAGER_HEADER_REQUIREMENT_FIELDS; ?></h1>
                    </td>
                </tr>
                <tr>
                    <td valign="top" align="right">
                        <strong><?php echo _REALESTATE_MANAGER_LABEL_LISTING_TYPE; ?>:</strong>
                    </td>
                    <td align="left">
                        <select size="1" class="inputbox" id="listing_type" name="listing_type">
                            <option value="New Listing" <?php if ($row->listing_type == "New Listing") { ?> selected="selected"<?php } ?>>New Listing</option>
                            <option value="Active" selected="selected">Active</option>
                            <option value="In Escrow" <?php if ($row->listing_type == "In Escrow") { ?> selected="selected"<?php } ?>>In Escrow</option>                
                        </select><?php //echo $listing_type_list;?>
                    </td>
                </tr>
                <tr>
                    <td valign="top" align="right">
                        <strong><?php echo _REALESTATE_MANAGER_LABEL_FEATURE; ?>:</strong>
                    </td>
                    <td align="left">				
                        <select size="1" class="inputbox" id="feature" name="feature">
                            <option value="NO" <?php if ($row->feature == "NO") { ?> selected="selected"<?php } ?>>NO</option>
                            <option value="YES" <?php if ($row->feature == "YES") { ?> selected="selected"<?php } ?>>YES</option>                            
                        </select>		
                    </td>
                </tr>
                <tr>
                    <td valign="top" align="right">
                        <strong><?php echo _REALESTATE_MANAGER_LABEL_PRICE; ?>:</strong>
                    </td>
                    <td align="left">
                        <input class="inputbox" type="text" name="price" size="15" value="<?php echo $row->price; ?>" />
                    </td>
                </tr>
        <!--<tr>
                        <td valign="top" align="right">
                                <strong><?php //echo _REALESTATE_MANAGER_LABEL_PRICE_DESC; ?>:</strong>
                        </td>
                        <td align="left">
                                <input class="inputbox" type="text" name="price_text" size="80" value="<?php //echo $row->price_text; ?>" />               
                        </td>
                </tr> -->
                <tr>
                    <td valign="top" align="right">
                        <strong><?php echo _REALESTATE_MANAGER_LABEL_PRISE_TYPE; ?>:</strong>
                    </td>
                    <td align="left">
        <?php echo $test_list; ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top" align="right">
                        <strong><?php echo _REALESTATE_MANAGER_LABEL_TITLE; ?>:</strong>
                    </td>
                    <td align="left">
                        <input class="inputbox" type="text" name="htitle" size="80" value="<?php echo $row->htitle; ?>" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">	
                        <hr size="2" width="100%" />
                    </td>
                </tr>
                <!--Roman editions -->

                <tr>
                    <td colspan="2">
                        <h1><?php echo _REALESTATE_MANAGER_HEADER_ADDRESS_FIELDS; ?><h1>
                                </td>
                                </tr>
                                <tr>
                                    <td valign="top" align="right">
                                        <strong><?php echo _REALESTATE_MANAGER_LABEL_ADDRESS; ?>:</strong>
                                    </td>
                                    <td align="left">
                                        <input class="inputbox" type="text" name="hlocation" size="80" value="<?php echo $row->hlocation; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top" align="right">
                                        <strong><?php echo "Street Name"; ?>:</strong>
                                    </td>
                                    <td align="left">
                                        <input class="inputbox" type="text" name="streetName" size="80" value="<?php echo $row->streetName; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top" align="right">
                                        <strong><?php echo "Address Number"; ?>:</strong>
                                    </td>
                                    <td align="left">
                                        <input class="inputbox" type="text" name="addNumber" size="80" value="<?php echo $row->addNumber; ?>" />
                                    </td>
                                </tr>
                                <tr>

                                    <td valign="top" align="right">
                                        <strong><?php echo _REALESTATE_MANAGER_LABEL_LATITUDE; ?>:</strong>
                                    </td>
                                    <td align="left">
                                        <input class="inputbox" type="text" id="hlatitude" name="hlatitude" size="20" value="<?php echo $row->hlatitude; ?>" readonly/>
                                    </td>
                                </tr>
                                <tr>

                                    <td valign="top" align="right">
                                        <strong><?php echo _REALESTATE_MANAGER_LABEL_LONGITUDE; ?>:</strong>
                                    </td>
                                    <td align="left">
                                        <input class="inputbox" type="text" id="hlongitude" name="hlongitude" size="20" value="<?php echo $row->hlongitude; ?>" readonly/>
                                        <input type="hidden" name="map_zoom" value="<?php echo $row->map_zoom; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top" align="right">
                                        <strong>Click on the map to choose the house location:</strong>
                                    </td>				
                                    <td align="left">
                                        <div id="map_canvas" style="width:400px; height:300px; border: 1px solid black; float: rigth;"></div>	
                                        <!--Image google map-->	
                                        <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=<?php echo $realestatemanager_configuration['google_map']['key']; ?>"
                                                type="text/javascript">
                                        </script>

                                        <script type="text/javascript">
                                            var map;
                                            var lastmarker = null;

                                            if (GBrowserIsCompatible())
                                            {
                                                map = new GMap2(document.getElementById("map_canvas"));

                                                //Установка центра карты    			
                                                map.setCenter(new GLatLng(<?php if ($row->hlatitude) echo $row->hlatitude;
        else echo 0; ?>,
        <?php if ($row->hlongitude) echo $row->hlongitude;
        else echo 0; ?>),
        <?php if (($row->map_zoom) != 0) echo $row->map_zoom;
        else echo 1; ?>);


                                                /*set type map: G_HYBRID_MAP, G_NORMAL_MAP, G_SATELLITE_MAP*/
                                                map.setMapType(G_HYBRID_MAP);

                                                var mapTypeControl = new GMapTypeControl();
                                                /*задание координат где выводить кнопку с типами карт*/
                                                var topRight = new GControlPosition(G_ANCHOR_TOP_RIGHT, new GSize(5, 5));
                                                map.addControl(mapTypeControl, topRight); /* topRight вывод самих кнопок*/
                                                /*GSmallMapControl() -- Создает контроль с кнопками, +- право/лево в  угол*/
                                                var mapZoomControl = new GSmallMapControl();
                                                map.addControl(mapZoomControl);

                                                //Установка маркера с координатами дома	
        <?php if ($row->hlatitude && $row->hlongitude) {
            ?>
                                                    lastmarker = new GMarker(new GLatLng(<?php echo $row->hlatitude; ?>, <?php echo $row->hlongitude; ?>), false);
                                                    map.addOverlay(lastmarker);
        <?php } ?>

                                                //Если изменяем масшатаб, то сохраняем его в поле map_zoom	
                                                GEvent.addListener(map, "zoomend", function(oldLevel, newLevel)
                                                {
                                                    document.adminForm.map_zoom.value = newLevel;
                                                });

                                                GEvent.addListener(map, "click", function(overlay, latlng)
                                                {
                                                    //Initialize marker         
                                                    var marker = new GMarker(latlng, false);

                                                    //Delete marker
                                                    if (lastmarker)
                                                        map.removeOverlay(lastmarker);

                                                    //Add marker to the map
                                                    map.addOverlay(marker);
                                                    //Output marker information
                                                    document.adminForm.hlatitude.value = latlng.lat();
                                                    document.adminForm.hlongitude.value = latlng.lng();
                                                    //Memory marker to delete
                                                    lastmarker = marker;

                                                    //Text under marker
                                                    //var comments = "Latitude: " + latlng.lat() + "<br>Longitude: " + latlng.lng();	
                                                    //map.openInfoWindow(latlng, comments);
                                                }); //end function and GEvent.addListener */

                                            }  //end if (GBrowserIsCompatible)

                                        </script> 
                                        <!--End google map.Желательно выгружать google с памяти с помощью функции onunload="GUnload()"   -->
                                    </td>			
                                </tr>

                                <tr>
                                    <td colspan="2">			  				
                                        <hr size="2" width="100%" />
                                    </td>
                                </tr>

                                <!--end Roman editions -->		
                                <tr>
                                    <td colspan="2">
                                        <h1><?php echo _REALESTATE_MANAGER_HEADER_RECOMMENDED_FIELDS; ?><h1>
                                                </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" align="right">
                                                        <strong><?php echo _REALESTATE_MANAGER_LABEL_BATHROOMS; ?>:</strong>
                                                    </td>
                                                    <td align="left">
                                                        <input class="inputbox" type="text" name="bathrooms" size="10" value="<?php echo $row->bathrooms; ?>" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" align="right">
                                                        <strong><?php echo _REALESTATE_MANAGER_LABEL_BEDROOMS; ?>:</strong>
                                                    </td>
                                                    <td align="left">
                                                        <input class="inputbox" type="text" name="bedrooms" size="10" value="<?php echo $row->bedrooms; ?>" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" align="right">
                                                        <strong><?php echo _REALESTATE_MANAGER_LABEL_BEDROOMS_ADDITIONAL; ?>:</strong>
                                                    </td>
                                                    <td align="left">
                                                        <input class="inputbox" type="text" name="additional_room" size="40" value="<?php echo $row->additional_room; ?>" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" align="right">
                                                        <strong><?php echo _REALESTATE_MANAGER_LABEL_CARS; ?>:</strong>
                                                    </td>
                                                    <td align="left">
                                                        <input class="inputbox" type="text" name="car" size="10" value="<?php echo $row->car; ?>" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" align="right">
                                                        <strong><?php echo _REALESTATE_MANAGER_LABEL_BROKER; ?>:</strong>
                                                    </td>
                                                    <td align="left">
                                                        <input class="inputbox" type="text" name="broker" size="40" value="<?php echo $row->broker; ?>" />
                                                    </td>
                                                </tr>
                                                <!--<tr>
                                                        <td valign="top" align="right">
                                                                <strong><?php //echo _REALESTATE_MANAGER_LABEL_LISTING_STATUS; ?>:</strong>
                                                        </td>
                                                        <td align="left">
        <?php //echo $listing_status_list;  ?>
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <td valign="top" align="right">
                                                                <strong><?php //echo _REALESTATE_MANAGER_LABEL_EDITION; ?>:</strong>
                                                        </td>
                                                        <td align="left">
        <?php //echo $property_type_list;  ?>
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <td valign="top" align="right">
                                                                <strong><?php //echo _REALESTATE_MANAGER_LABEL_PROVIDER_CLASS; ?>:</strong>
                                                        </td>
                                                        <td align="left">
        <?php //echo $provider_class_list; ?>	
                                                        </td>
                                                </tr> -->
                                                <tr>
                                                    <td valign="top" align="right">
                                                        <strong><?php echo _REALESTATE_MANAGER_LABEL_BUILD_YEAR; ?>:</strong>
                                                    </td>
                                                    <td align="left">
                                                        <input class="inputbox" type="text" name="year" size="20" id="year" value="<?php echo $row->year; ?>" />

                                                        <input type="reset" class="button" value="..." onclick="calendar = null;
                                                return showCalendar('year', 'y');" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <hr size="2" width="100%" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <h1><?php echo _REALESTATE_MANAGER_HEADER_OPTIONAL_FIELDS ?></h1>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" align="right">
                                                        <strong><?php echo _REALESTATE_MANAGER_LABEL_AGENT; ?>:</strong>
                                                    </td>
                                                    <td align="left">
                                                        <input class="inputbox" type="text" name="agent" size="30" value="<?php echo $row->agent; ?>" />				
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" align="right">
                                                        <strong><?php echo _REALESTATE_MANAGER_LABEL_AREA; ?>:</strong>
                                                    </td>
                                                    <td align="left">
                                                        <input class="inputbox" type="text" name="area" size="30" value="<?php echo $row->area; ?>" />				
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" align="right">
                                                        <strong><?php echo _REALESTATE_MANAGER_LABEL_INTERIOR_AREA; ?>:</strong>
                                                    </td>
                                                    <td align="left">
                                                        <input class="inputbox" type="text" name="interior_area" size="30" value="<?php echo $row->interior_area; ?>" />				
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" align="right">
                                                        <strong><?php echo _REALESTATE_MANAGER_LABEL_LANAI; ?>:</strong>
                                                    </td>
                                                    <td align="left">
                                                        <input class="inputbox" type="text" name="lanai" size="30" value="<?php echo $row->lanai; ?>" />				
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" align="right">
                                                        <strong><?php echo _REALESTATE_MANAGER_LABEL_GARAGE; ?>:</strong>
                                                    </td>
                                                    <td align="left">
                                                        <input class="inputbox" type="text" name="garage" size="30" value="<?php echo $row->garage; ?>" />				
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" align="right">
                                                        <strong><?php echo _REALESTATE_MANAGER_LABEL_ROOF_AREA; ?>:</strong>
                                                    </td>
                                                    <td align="left">
                                                        <input class="inputbox" type="text" name="uroofarea" size="30" value="<?php echo $row->uroofarea; ?>" />				
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" align="right">
                                                        <strong><?php echo _REALESTATE_MANAGER_LABEL_ENVELOPE; ?>:</strong>
                                                    </td>
                                                    <td align="left">
                                                        <input class="inputbox" type="text" name="envelope" size="30" value="<?php echo $row->envelope; ?>" />				
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" align="right">
                                                        <strong><?php echo _REALESTATE_MANAGER_LABEL_SQUARE_FOOTAGE; ?>:</strong>
                                                    </td>
                                                    <td align="left">
                                                        <input class="inputbox" type="text" name="torsqfield" size="30" value="<?php echo $row->torsqfield; ?>" />				
                                                    </td>
                                                </tr>
                                                <!--<tr>
                                                        <td valign="top" align="right">
                                                                <strong><?php //echo _REALESTATE_MANAGER_LABEL_EXPIRATION_DATE; ?>:</strong>
                                                        </td>
                                                        <td align="left">
                                                                <input class="inputbox" type="text" name="expiration_date" id="expiration_date" size="30" value="<?php echo $row->expiration_date; ?>" />
                                
                                                                <input type="reset" class="button" value="..." onclick="calendar=null;return showCalendar('expiration_date', 'y-mm-dd');" />
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <td valign="top" align="right">
                                                                <strong><?php //echo _REALESTATE_MANAGER_LABEL_FEATURE; ?>:</strong>
                                                        </td>
                                                        <td align="left">
                                                                <input class="inputbox" type="text" name="feature" size="30" value="<?php echo $row->feature; ?>" />				
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <td valign="top" align="right">
                                                                <strong><?php //echo _REALESTATE_MANAGER_LABEL_HOA_DUES; ?>:</strong>
                                                        </td>
                                                        <td align="left">
                                                                <input class="inputbox" type="text" name="hoa_dues" size="30" value="<?php echo $row->hoa_dues; ?>" />				
                                                        </td>
                                                </tr> -->
                                                <tr>
                                                    <td valign="top" align="right">
                                                        <strong><?php echo _REALESTATE_MANAGER_LABEL_LOT_SIZE; ?>:</strong>
                                                    </td>
                                                    <td align="left">
                                                        <input class="inputbox" type="text" name="lot_size" size="30" value="<?php echo $row->lot_size; ?>" />				
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" align="right">
                                                        <strong><?php echo _REALESTATE_MANAGER_LABEL_METATAG; ?>:</strong>
                                                    </td>
                                                    <td align="left">
                                                        <textarea class="inputbox" name="metaTag" id="metaTag" rows="3" cols="60"><?php echo $row->metaTag; ?></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" align="right">
                                                        <strong><?php echo _REALESTATE_MANAGER_LABEL_METADESC; ?>:</strong>
                                                    </td>
                                                    <td align="left">
                                                        <textarea class="inputbox" name="metaDesc" id="metaDesc" rows="3" cols="60"><?php echo $row->metaDesc; ?></textarea>								
                                                    </td>
                                                </tr>
                                                <!--<tr>
                                                        <td valign="top" align="right">
                                                                <strong><?php //echo _REALESTATE_MANAGER_LABEL_SCHOOL; ?>:</strong>
                                                        </td>
                                                        <td align="left">
                                                                <input class="inputbox" type="text" name="school" size="30" value="<?php echo $row->school; ?>" />				
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <td valign="top" align="right">
                                                                <strong><?php //echo _REALESTATE_MANAGER_LABEL_SCHOOL_DISTRICT; ?>:</strong>
                                                        </td>
                                                        <td align="left">
                                                                <input class="inputbox" type="text" name="school_district" size="30" value="<?php echo $row->school_district; ?>" />				
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <td valign="top" align="right">
                                                                <strong><?php //echo _REALESTATE_MANAGER_LABEL_STYLE; ?>:</strong>
                                                        </td>
                                                        <td align="left">
        <?php //echo $style_list; ?>
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <td valign="top" align="right">
                                                                <strong><?php //echo _REALESTATE_MANAGER_LABEL_ZONING; ?>:</strong>
                                                        </td>
                                                        <td align="left">
        <?php //echo $zoning_list; ?>
                                                        </td>
                                                </tr>-->
                                                <tr>
                                                    <td colspan="2">
                                                        <hr size="2" width="100%" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <h1><?php echo _REALESTATE_MANAGER_HEADER_PHOTO_MANAGE; ?><h1>
                                                                </td>
                                                                </tr>
                                                                <!--<tr>
                                                                        <td valign="top" align="right">
                                                                                <strong><?php /* echo _REALESTATE_MANAGER_LABEL_RATING; */ ?>:</strong>
                                                                        </td>
                                                                        <td align="left">
        <?php /* echo $rating; */ ?>
                                                                        </td>	
                                                                </tr>-->
                                                                <tr>
                                                                    <td valign="top" align="right">
                                                                        <strong><?php echo _REALESTATE_MANAGER_LABEL_PICTURE_URL_UPLOAD; ?>:</strong>
                                                                    </td>
                                                                    <td align="left">
                                                                        <input class="inputbox" type="file" name="image_link" value="<?php echo $row->image_link; ?>" size="50" maxlength="250" />

                                                                        <br /><?php /* echo _REALESTATE_MANAGER_LABEL_PICTURE_URL_DESC; */ ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
        <?php
        if ($row->image_link != '')
            echo '<td valign="bottom" align="right">
				<strong>Select photo if it is necessary to remove:</strong>
			      </td>';
        else
            echo '<td>&nbsp</td>';
        ?>
                                                                    <!--
                                                                                            <td valign="top" align="right">
                                                                                                    <strong><?php echo _REALESTATE_MANAGER_ADMIN_REMOVE_MAIN_PHOTO; ?>:</strong>				
                                                                                            </td>
                                                                    -->

                                                                    <td align="left">
                                                                <?php
                                                                if ($row->image_link != '') {
                                                                    $main_photo_pth = pathinfo($row->image_link);
                                                                    $main_photo_type = '.' . $main_photo_pth['extension'];
                                                                    $main_photo_name = basename($row->image_link, $main_photo_type);
                                                                } else {
                                                                    echo 'The main photo is absent';
                                                                }
                                                                /* $main_photo_name=substr($row->image_link, 0, strlen($row->image_link)-4);
                                                                  $main_photo_type=substr($row->image_link, strlen($row->image_link)-4); */
                                                                if ($row->image_link != '')
                                                                    echo '<input type="checkbox" name="del_main_photo" value="<?php echo $row->image_link;?>" />';
                                                                ?>				
                                                                        <img src="<?php echo $mosConfig_live_site; ?>/components/com_realestatemanager/photos/<?php echo $main_photo_name . "_mini" . $main_photo_type; ?>"/>
                                                                        <!--  -->
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">&nbsp</td>
                                                                </tr>		

                                                                <tr>
                                                                    <td valign="top" align="right"> 
                                                                        <strong><?php echo _REALESTATE_MANAGER_LABEL_OTHER_PICTURES_URL_UPLOAD; ?>:</strong>
                                                                    </td>
                                                                    <td align="left">
                                                                        <div ID="items">
                                                                            <input class="inputbox" type="button" name="new_photo" 
                                                                                   value="<?php echo 'Add new photo'; ?>" onClick="new_photos()" ID="add"/>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                        <!--<tr>
                                <td valign="top" align="right">
                                        <strong><?php /* echo _REALESTATE_MANAGER_LABEL_URL; */ ?>:</strong>
                                </td>
                                <td align="left">
                                        <input class="inputbox" type="text" name="URL" size="80" value="<?php /* echo $row->link; */ ?>" />
                                </td>
                        </tr>-->
                                                                        <?php
                                                                        if (count($house_photos) != 0) {
                                                                            ?>
                                                                    <tr>
                                                                        <td valign="bottom" align="right">
                                                                            <strong><?php echo "Select photos which are necessary to remove" ?>:</strong>
                                                                        </td>

                                                                        <td valign="bottom" align="right">
            <?php
            for ($i = 0; $i < count($house_photos); $i++) {
                $photo_pth = pathinfo($house_photos[$i]->main_img);
                $photo_type = '.' . $photo_pth['extension'];
                $photo_name = basename($house_photos[$i]->main_img, $photo_type);

                /* $photo_name=substr($house_photos[$i]->main_img, 0, strlen($house_photos[$i]->main_img)-4);
                  $photo_type=substr($house_photos[$i]->main_img, strlen($house_photos[$i]->main_img)-4); */
                ?>
                                                                                <input type="checkbox" name="del_photos[]" value="<?php echo $house_photos[$i]->main_img; ?>" />

                                                                                <img src="<?php echo $mosConfig_live_site; ?>/components/com_realestatemanager/photos/<?php echo $photo_name . "_mini" . $photo_type; ?>" alt="no such file"/>&nbsp;&nbsp;Title: <input type="text" id="photo_title" name="photo_title[]" value="<?php echo $house_photos[$i]->photo_title; ?>" size="50" />&nbsp;&nbsp;<input type="checkbox" id="as_featured_image" name="as_featured_image[]" value="1" <?php if ($house_photos[$i]->as_featured_image == '1') { ?> checked="checked"<?php } ?> />Featured?&nbsp;&nbsp;<input type="checkbox" name="need_login[]" id="need_login" value="<?php echo $house_photos[$i]->id; ?>" <?php if ($house_photos[$i]->need_login == '1') { ?> checked="checked"<?php } ?> />Need Login? &nbsp; Ordering: <input type="text" size="5" name="image_order[]" id="image_order" value="<?php echo $house_photos[$i]->image_order; ?>" /><br/><br />
            <?php } ?>
                                                                        </td>
                                                                    </tr>
        <?php } ?>
                                                                <tr>
                                                                    <td colspan="2">&nbsp;	
                                                                    </td>
                                                                </tr>


                                                                <!--
                                                                //**********************************   begin change review   ***********************
                                                                -->
        <?php if ($reviews > false) /* show, if review exist */ {
            ?>
                                                                    <tr>
                                                                        <td colspan="7">
                                                                            <hr width="100%" size="2" align="left"> <h3><?php echo _REALESTATE_MANAGER_LABEL_REVIEWS; ?>:</h3> 
                                                                        </td>
                                                                    </tr>
                                                                    <table class="adminlist">
                                                                        <tr class="row0">
                                                                            <td width="3%" valign="top" align="center">
                                                                                <div>#</div>
                                                                            </td>
                                                                            <td width="2%" valign="top" align="center">
                                                                                <div></div>
                                                                            </td>
                                                                            <td width="10%" valign="top" align="center">
                                                                                <strong><?php echo _REALESTATE_MANAGER_LABEL_REVIEW_TITLE; ?>:</strong>
                                                                            </td>
                                                                            <td width="10%" valign="top" align="center">
                                                                                <strong><?php echo _REALESTATE_MANAGER_LABEL_RENT_USER; ?>:</strong>
                                                                            </td>
                                                                            <td width="65%" valign="top" align="center">
                                                                                <strong><?php echo _REALESTATE_MANAGER_LABEL_REVIEW_COMMENT; ?>:</strong>
                                                                            </td>
                                                                            <td width="5%" valign="top" align="center">
                                                                                <strong><?php echo _REALESTATE_MANAGER_LABEL_BUILD_YEAR; ?>:</strong>
                                                                            </td>
                                                                            <td width="5%" valign="top" align="center">
                                                                                <strong><?php echo _REALESTATE_MANAGER_LABEL_REVIEW_RATING; ?>:</strong>
                                                                            </td>
                                                                        </tr>
                                                                    <?php for ($i = 0, $nn = 1; $i < count($reviews); $i++, $nn++) /* if not one comment */ {
                                                                        ?>
                                                                            <tr class="row0">
                                                                                <td valign="top" align="center">
                                                                                    <div><?php echo $nn; ?></div>
                                                                                </td>
                                                                                <td valign="top" align="center">
                                                                                    <div>
                <?php echo "<input type='radio' id='cb" . $i . "' name='bid[]' value='" . $row->id . "," . $reviews[$i]->id . "' onclick='isChecked(this.checked);' />"; ?>
                                                                                    </div>
                                                                                </td>
                                                                                <td valign="top" align="center">
                                                                                    <div><?php print_r($reviews[$i]->title); ?></div>
                                                                                </td>
                                                                                <td valign="top" align="left">
                                                                                    <div><?php print_r($reviews[$i]->user_name); ?></div>
                                                                                </td>
                                                                                <td valign="top" align="left">
                                                                                    <div><?php print_r($reviews[$i]->comment); ?></div>
                                                                                </td>
                                                                                <td valign="top" align="left">
                                                                                    <div><?php print_r($reviews[$i]->date); ?></div>
                                                                                </td>
                                                                                <td valign="top" align="left">
                                                                                    <div><img src="../components/com_realestatemanager/images/rating-<?php echo $reviews[$i]->rating; ?>.gif" alt="<?php echo ($reviews->rating[$i]) / 2; ?>" border="0" align="right"/>&nbsp;</div>
                                                                                </td>
                                                                            </tr>
            <?php }/* end for(...) */ ?>

                                                                    </table>
                                                                    <?php }/* end if(...) */ ?>

                                                                </table>

                                                                <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
                                                                <input type="hidden" name="option" value="<?php echo $option; ?>" />
                                                                <input type="hidden" name="boxchecked" value="0" />
                                                                <input type="hidden" name="task" value="" />				
                                                                </form>
                                                                <!--************************   end change review ***********************-->

        <?php
    }

    function showImportExportHouses($params, $option) {

        global $my, $mosConfig_live_site, $mainframe;


        $mainframe->addCustomHeadTag('<script type = "text/JavaScript" src ="' . $mosConfig_live_site . '/administrator/components/com_realestatemanager/includes/functions.js"></script>');


        $mainframe->addCustomHeadTag('<link rel="stylesheet" href="' . $mosConfig_live_site . '/administrator/components/com_realestatemanager/includes/realestatemanager.css" type="text/css" />');
        ?>

                                                                <div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>

                                                                <script type="text/javascript" language="Javascript" src="<?php echo $mosConfig_live_site; ?>/includes/js/overlib_mini.js">
                                                                </script>

                                                                <script language="javascript" type="text/javascript">
                                                                    function impch()
                                                                    {
                                                                        var a = document.getElementById('import_type').value;
                                                                        if (a == 3)
                                                                            document.getElementById('import_catid').disabled = true;
                                                                        else
                                                                            document.getElementById('import_catid').disabled = false;
                                                                        //	alert(a);
                                                                    }
                                                                    function expch()
                                                                    {
                                                                        var a = document.getElementById('export_type').value;
                                                                        if (a == 3)
                                                                            document.getElementById('export_catid').disabled = true;
                                                                        else
                                                                            document.getElementById('export_catid').disabled = false;
                                                                        //	alert(a);
                                                                    }
                                                                    function submitbutton(pressbutton) {
                                                                        var form = document.adminForm;
                                                                        if (pressbutton == 'import') {
                                                                            if (form.import_type.value == '0') {
                                                                                alert("<?PHP echo _REALESTATE_MANAGER_SHOW_IMPEXP_ERR1; ?>");
                                                                                return;
                                                                            }
                                                                            if (form.import_file.value == '' && form.import_type.value == '3') {
                                                                                alert("<?PHP echo _REALESTATE_MANAGER_SHOW_IMPEXP_ERR3; ?>");
                                                                                return;
                                                                            }
                                                                            if (form.import_catid.value == '0' && form.import_type.value != '3' && form.import_type.value != '0') {
                                                                                alert("<?PHP echo _REALESTATE_MANAGER_SHOW_IMPEXP_ERR2; ?>");
                                                                                return;
                                                                            }
                                                                            if (form.import_catid.value != '0' && form.import_file.value == '') {
                                                                                alert("<?PHP echo _REALESTATE_MANAGER_SHOW_IMPEXP_ERR3; ?>");
                                                                                return;
                                                                            }
                                                                            if ((form.import_type.value == '2') && (form.import_catid.value != '0' && form.import_file.value != '')) {
                                                                                submitform(pressbutton);
                                                                            }
                                                                            if ((form.import_type.value == '1') && (form.import_catid.value != '0' && form.import_file.value != '')) {
                                                                                submitform(pressbutton);
                                                                            }
                                                                            if (form.import_file.value != '' && form.import_type.value == '3') {
                                                                                resultat_1 = confirm("<?php echo _REALESTATE_MANAGER_SHOW_IMPEXP_CONF; ?>");
                                                                                if (resultat_1)
                                                                                    submitform(pressbutton);
                                                                            }
                                                                        }
                                                                        if (pressbutton == 'export') {
                                                                            if (form.export_type.value == '0') {
                                                                                alert("<?PHP echo _REALESTATE_MANAGER_SHOW_IMPEXP_ERR4; ?>");
                                                                                return;
                                                                            }
                                                                            if (form.export_type.value == '3') {
                                                                                submitform(pressbutton);
                                                                            }
                                                                            if (form.export_type.value == '1') {
                                                                                submitform(pressbutton);
                                                                            }
                                                                            if (form.export_type.value == '2') {
                                                                                submitform(pressbutton);
                                                                            }
                                                                        }
                                                                    }//end function submitbutton(pressbutton)
                                                                </script>


                      <!-- <table cellpadding="4" cellspacing="0" border="0" width="100%">
                        <tr>
                                <td width="30%">
                                  <img src="./components/com_realestatemanager/images/building_icon.jpg" align="right" alt="Config" />
                                </td>
                                <td width="70%" class="house_manager_caption" valign='bottom' >
        <?php echo _REALESTATE_MANAGER_ADMIN_IMPEXP; ?>
                                </td>
                        </tr>
                        </table>
                                                                -->

                                                                <form action="index2.php" method="post" name="adminForm" enctype="multipart/form-data">

        <?php
        $tabs = new mosTabs(1);
        $tabs->startPane("impexPane");
        $tabs->startTab(_REALESTATE_MANAGER_ADMIN_IMP, "impexPane");
        ?>

                                                                    <table class="adminform">
                                                                        <!--*   begin add Warning in 'Import' for 'CSV', 'XML', 'MySQL tables import'  -->
                                                                        <tr>
                                                                            <td colspan="3">
        <?php echo _REALESTATE_MANAGER_SHOW_IMPORT_WARNING_MESSAG; ?>
                                                                                <hr />
                                                                            </td>		
                                                                        </tr>

                                                                        <!--*****   end add Warning in 'Import' for 'CSV', 'XML', 'MySQL tables import'   -->

                                                                        <tr>
                                                                            <td width="185"><?php echo _REALESTATE_MANAGER_SHOW_IMPEXP_LABEL_IMPORT_TYP; ?>:</td> <!-- Typ importu -->
                                                                            <td width="20"><?php echo mosToolTip(_REALESTATE_MANAGER_ADMIN_SHOW_IMPEXP_LABEL_IMPORT_TYP_TT_HEAD, _REALESTATE_MANAGER_ADMIN_SHOW_IMPEXP_LABEL_IMPORT_TYP); ?></td>
                                                                            <td><?php echo $params['import']['type']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="185"><?php echo _REALESTATE_MANAGER_SHOW_IMPEXP_LABEL_IMPORT_CATEGORY; ?>:</td> <!-- Kategoria -->
                                                                            <td width="20"><?php echo mosToolTip(_REALESTATE_MANAGER_ADMIN_SHOW_IMPEXP_LABEL_IMPORT_CAT_TT_HEAD, _REALESTATE_MANAGER_ADMIN_SHOW_IMPEXP_LABEL_IMPORT_CAT); ?></td>
                                                                            <td><?php echo $params['import']['category']; ?></td>         
                                                                        </tr>      
                                                                        <tr>
                                                                            <td width="185"><?php echo _REALESTATE_MANAGER_SHOW_IMPEXP_LABEL_IMPORT_FILE; ?>:</td>   <!-- Plik do importu -->      
                                                                            <td width="20"><?php echo mosToolTip(_REALESTATE_MANAGER_ADMIN_SHOW_IMPEXP_LABEL_IMPORT_FILE_TT_HEAD, _REALESTATE_MANAGER_ADMIN_SHOW_IMPEXP_LABEL_IMPORT_FILE); ?></td>
                                                                            <td><input class="inputbox" type="file" name="import_file" value="" size="50" maxlength="250" /></td>         
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="3">&nbsp;</td>
                                                                        </tr>
                                                                        <!-- begin old poka ostavim
                                                                              <tr>
                                                                                 <td width="185">&nbsp;</td>
                                                                                 <td width="20">&nbsp;</td>
                                                                                 <td>
        <?php //echo _REALESTATE_MANAGER_SHOW_IMPEXP_FORMAT;
        ?>
                                                                                 </td>
                                                                              </tr>
                                                                        end old poka ostavim -->
                                                                    </table>

        <?php
        $tabs->endTab();
        $tabs->startTab(_REALESTATE_MANAGER_ADMIN_EXP, "impexPane");
        ?>


                                                                    <table class="adminform">
                                                                        <!--*****************************************************************************************************************-->
                                                                        <!--********************   begin add Warning in 'Export' for 'CSV', 'XML', 'MySQL tables import'   ******************-->
                                                                        <!--*****************************************************************************************************************-->
                                                                        <tr>
                                                                            <td colspan="3">
        <?php echo _REALESTATE_MANAGER_SHOW_EXPORT_WARNING_MESSAG; ?>
                                                                                <hr />
                                                                            </td>		
                                                                        </tr>
                                                                        <!--*****************************************************************************************************************-->
                                                                        <!--********************   end add Warning in 'Export' for 'CSV', 'XML', 'MySQL tables import'   ********************-->
                                                                        <!--*****************************************************************************************************************-->
                                                                        <tr>
                                                                            <td width="185"><?php echo _REALESTATE_MANAGER_SHOW_IMPEXP_LABEL_EXPORT_TYP; ?>:</td>
                                                                            <td width="20"><?php echo mosToolTip(_REALESTATE_MANAGER_ADMIN_SHOW_IMPEXP_LABEL_EXPORT_TYP_TT_HEAD, _REALESTATE_MANAGER_ADMIN_SHOW_IMPEXP_LABEL_EXPORT_TYP); ?></td>
                                                                            <td><?php echo $params['export']['type']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="185"><?php echo _REALESTATE_MANAGER_SHOW_IMPEXP_LABEL_EXPORT_CATEGORY; ?>:</td>
                                                                            <td width="20"><?php echo mosToolTip(_REALESTATE_MANAGER_ADMIN_SHOW_IMPEXP_LABEL_EXPORT_CAT_TT_HEAD, _REALESTATE_MANAGER_ADMIN_SHOW_IMPEXP_LABEL_EXPORT_CAT); ?></td>
                                                                            <td><?php echo $params['export']['category']; ?></td>         
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="3">&nbsp;</td>
                                                                        </tr>
                                                                    </table>


                                                                    <?php
                                                                    $tabs->endTab();
                                                                    $tabs->endPane();
                                                                    ?>
                                                                    <input type="hidden" name="option" value="<?php echo $option; ?>" />
                                                                    <input type="hidden" name="task" value="" />
                                                                </form>
        <?php
    }

    function showRentHouses($option, & $rows, & $userlist, $type) {
        global $my, $mosConfig_live_site, $mainframe;

        $mainframe->addCustomHeadTag('<link rel="stylesheet" href="' . $mosConfig_live_site . '/administrator/components/com_realestatemanager/includes/realestatemanager.css" type="text/css" />');

        $mainframe->addCustomHeadTag('<script type = "text/JavaScript" src ="' . $mosConfig_live_site . '/administrator/components/com_realestatemanager/includes/functions.js"></script>');

        $mainframe->addCustomHeadTag('<script type = "text/JavaScript" src ="' . $mosConfig_live_site . '/includes/js/mambojavascript.js"></script>');


        $mainframe->addCustomHeadTag('<link rel="stylesheet" type="text/css" media="all" href="' . $mosConfig_live_site . '/includes/js/calendar/calendar-mos.css" title="green" />');

        $mainframe->addCustomHeadTag('<script type = "text/JavaScript" src ="' . $mosConfig_live_site . '/includes/js/calendar/calendar.js"></script>');

        $mainframe->addCustomHeadTag('<script type = "text/JavaScript" src ="' . $mosConfig_live_site . '/includes/js/calendar/lang/calendar-en-GB.js"></script>');

        $mainframe->addCustomHeadTag('<script type = "text/JavaScript" src ="' . $mosConfig_live_site . '/includes/js/overlib_mini.js"></script>');
        ?>


                                                                <div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>

                                                                <form action="index2.php" method="post" name="adminForm" id="adminForm">

                                                                    <table cellpadding="4" cellspacing="0" border="0" width="100%">

                                                                        <tr>
                                                                            <td width="100%" class="house_manager_caption"  >
        <?php
        if ($type == "rent") {
            echo _REALESTATE_MANAGER_SHOW_RENT_HOUSES;
        } else
        if ($type == "rent_return") {
            echo _REALESTATE_MANAGER_SHOW_RENT_RETURN;
        } else {

            echo "&nbsp;";
        }
        ?>
                                                                            </td>
                                                                        </tr>		
                                                                        <tr>
                                                                            <td align="left">&nbsp;

                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                <?php
                                                                if ($type == "rent") {
                                                                    ?>
                                                                        <table cellpadding="4" cellspacing="0" border="0" width="100%">
                                                                            <tr>
                                                                                <td align="center" nowrap="nowrap">
                                                                    <?php echo _REALESTATE_MANAGER_LABEL_RENT_TO . ':'; ?>
                                                                                </td>
                                                                                <td align="center" nowrap="nowrap">
            <?php echo $userlist; ?>
                                                                                </td>
                                                                                <td align="center" nowrap="nowrap">
            <?php echo _REALESTATE_MANAGER_LABEL_RENT_USER . ':'; ?>
                                                                                </td>
                                                                                <td>  
                                                                                    <input type="text" name="user_name" class="inputbox" />
                                                                                </td>

                                                                                <td width="1000%">
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td align="left">&nbsp;
                                                                                </td>

                                                                                <td align="left">&nbsp;
                                                                                </td>

                                                                                <td align="left" nowrap="nowrap">
            <?php echo _REALESTATE_MANAGER_LABEL_RENT_EMAIL . ':'; ?>
                                                                                </td>
                                                                                <td>    
                                                                                    <input type="text" name="user_email" class="inputbox" />
                                                                                </td>
                                                                                <td width="30%">&nbsp;
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td align="left" nowrap="nowrap">
                                                                        <?php echo _REALESTATE_MANAGER_LABEL_RENT_TIME . ':'; ?>
                                                                                </td>
                                                                                <td align="left" nowrap="nowrap">
                                                                                    <input class="inputbox" type="text" name="rent_until" id="rent_until" size="12" maxlength="10" value="<?php echo date("Y-m-d"); ?>" />
                                                                                    <input type="reset" class="button" value="..." onClick="return showCalendar('rent_until', 'y-mm-dd');" />
                                                                                </td>
                                                                                <td colspan="3">&nbsp;
                                                                                </td>		
                                                                            </tr>
                                                                            <tr>
                                                                                <td align="left">&nbsp;
                                                                                </td>
                                                                            </tr>
                                                                        </table>
            <?php
        } else {
            ?>
                                                                        &nbsp;
            <?php
        }
        ?>
                                                                    <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
                                                                        <tr>
                                                                            <th width="20" align="center">
                                                                                <input type="checkbox" checked="checked" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
                                                                            </th>
                                                                            <th align = "center" width="30">#</th>
                                                                            <th align = "center" class="title" width="5%" nowrap="nowrap"><?php echo _REALESTATE_MANAGER_LABEL_HOUSEID; ?></th>
                                                                            <th align = "center" class="title" width="25%" nowrap="nowrap"><?php echo _REALESTATE_MANAGER_LABEL_ADDRESS; ?></th>
                                                                            <th align = "center" class="title" width="15%" nowrap="nowrap"><?php echo _REALESTATE_MANAGER_LABEL_RENT_FROM; ?></th>
                                                                            <th align = "center" class="title" width="20%" nowrap="nowrap"><?php echo _REALESTATE_MANAGER_LABEL_RENT_UNTIL; ?></th>
                                                                            <th align = "center" class="title" width="15%" nowrap="nowrap"><?php echo _REALESTATE_MANAGER_LABEL_RENT_TO; ?></th>
                                                                        </tr>

        <?php
        for ($i = 0, $n = count($rows); $i < $n; $i++) {
            $row = & $rows[$i];
            ?>
                                                                            <tr class="row<?php echo $i % 2; ?>">
                                                                                <td width="20" align="center">
            <?php
            //error for this row rent was called even if the House is already lent out
            if ($row->rent_from != null && $type == "rent") {
                ?>
                                                                                        &nbsp;
                <?php
                //rent was called for a correct House
            } else if ($row->rent_from == null && $type == "rent") {
                ?>
                                                                                        <input type="checkbox" checked="checked" id="cb<?php echo $i; ?>" name="bid[]" value="<?php echo $row->id; ?>" onClick="isChecked(this.checked);" />
                                                                            <?php
                                                                            //rent return was called on a House which was not rent out
                                                                        } else if ($row->rent_from == null && $type == "rent_return") {
                                                                            ?>
                                                                                        &nbsp;
                                                                            <?php
                                                                            //rent return was called correctly
                                                                        } else if ($row->rent_from != null && $type == "rent_return") {
                                                                            ?>
                                                                                        <input type="checkbox" checked="checked" id="cb<?php echo $i; ?>" name="bid[]" value="<?php echo $row->rentid; ?>" onClick="isChecked(this.checked);" />
                <?php
            } else {
                ?>
                                                                                        &nbsp;
                <?php
            }
            ?>
                                                                                </td>
                                                                                <td align="center"><?php echo $row->id; ?></td>
                                                                                <td align="center"><?php echo $row->houseid; ?></td>
                                                                                <td align="center"><?php echo $row->hlocation; ?></td>
                                                                                <td align="center"><?php echo $row->rent_from; ?></td>
                                                                                <td align="center"><?php echo $row->rent_until ?></td>	
                                                                                <td align="center">			
                                                                            <?php
                                                                            echo $row->user_name;
                                                                            echo "&nbsp;";
                                                                            echo "<a href='mailto:" . $row->user_email . "'>";
                                                                            echo $row->user_email;
                                                                            echo "</a>";
                                                                            ?>
                                                                                </td>
                                                                            </tr>


                                                                                <?php } ?>

                                                                    </table>

                                                                    <input type="hidden" name="option" value="<?php echo $option; ?>" />
                                                                    <input type="hidden" name="task" value="" />
                                                                    <input type="hidden" name="boxchecked" value="1" />
                                                                    <input type="hidden" name="save" value="1" />
                                                                </form>

                                                                                <?php
                                                                            }

                                                                            function showConfiguration($lists, $option) {

                                                                                global $my, $mosConfig_live_site, $mainframe, $act, $task;

                                                                                $mainframe->addCustomHeadTag('<script type = "text/JavaScript" src ="' . $mosConfig_live_site . '/administrator/components/com_realestatemanager/includes/functions.js"></script>');


                                                                                $mainframe->addCustomHeadTag('<link rel="stylesheet" href="' . $mosConfig_live_site . '/administrator/components/com_realestatemanager/includes/realestatemanager.css" type="text/css" />');
                                                                                ?>

                                                                <div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>

                                                                <script type="text/javascript" language="Javascript" src="<?php echo $mosConfig_live_site; ?>/includes/js/overlib_mini.js"></script>

              <!--<table cellpadding="4" cellspacing="0" border="0" width="100%">
                <tr>
                  <td width="30%">
                     <img src="./components/com_realestatemanager/images/building_icon.jpg" align="right" alt ="Config" />
                  </td>
                  <td width="70%" class="house_manager_caption" valign='bottom' >
        <?php echo _REALESTATE_MANAGER_ADMIN_CONFIG ?>
                  </td>
              </tr>
              </table> -->

                                                                <form action="index2.php" method="post" name="adminForm" id="adminForm">

        <?php
        $tabs = new mosTabs(1);
        $tabs->startPane("impexPane");
        $tabs->startTab(_REALESTATE_MANAGER_ADMIN_CONFIG_FRONTEND, "impexPane");
        ?>
                                                                    <h1><?php echo _REALESTATE_MANAGER_ADMIN_CONFIG_FRONTEND; ?></h1>
                                                                    <table class="adminform">

                                                                        <tr>
                                                                            <td width="185"><?php echo _REALESTATE_MANAGER_ADMIN_CONFIG_REVIEWS_SHOW; ?>:</td>
                                                                            <td width="20"><?php echo mosToolTip(_REALESTATE_MANAGER_ADMIN_CONFIG_REVIEWS_SHOW_TT_BODY, _REALESTATE_MANAGER_ADMIN_CONFIG_REVIEWS_SHOW_TT_HEAD); ?></td>
                                                                            <td><?php echo $lists['reviews']['show']; ?></td>
                                                                            <td width="185"><?php echo _REALESTATE_MANAGER_ADMIN_CONFIG_REVIEWS_REGISTRATIONLEVEL; ?>:</td>         
                                                                            <td width="20"><?php echo mosToolTip(_REALESTATE_MANAGER_ADMIN_CONFIG_REVIEWS_REGISTRATIONLEVEL_TT_BODY, _REALESTATE_MANAGER_ADMIN_CONFIG_REVIEWS_REGISTRATIONLEVEL_TT_HEAD); ?></td>
                                                                            <td><?php echo $lists['reviews']['registrationlevel']; ?></td>         
                                                                        </tr>

                                                                        <tr>
                                                                            <td colspan="6">
                                                                                <hr />
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td width="185"><?php echo _REALESTATE_MANAGER_ADMIN_CONFIG_RENTSTATUS_SHOW; ?>:</td>

                                                                            <td width="20"><?php echo mosToolTip(_REALESTATE_MANAGER_ADMIN_CONFIG_RENTSTATUS_SHOW_TT_BODY, _REALESTATE_MANAGER_ADMIN_CONFIG_RENTSTATUS_SHOW_TT_HEAD); ?></td>
                                                                            <td><?php echo $lists['rentstatus']['show']; ?></td>
                                                                            <td width="185"><?php echo _REALESTATE_MANAGER_ADMIN_CONFIG_RENTREQUEST_REGISTRATIONLEVEL; ?>:</td>
                                                                            <td width="20"><?php echo mosToolTip(_REALESTATE_MANAGER_ADMIN_CONFIG_RENTREQUEST_REGISTRATIONLEVEL_TT_BODY, _REALESTATE_MANAGER_ADMIN_CONFIG_RENTREQUEST_REGISTRATIONLEVEL_TT_HEAD); ?></td>
                                                                            <td><?php echo $lists['rentrequest']['registrationlevel']; ?></td>         
                                                                        </tr>      
                                                                        <tr>
                                                                            <td colspan="6">
                                                                                <hr />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="185"><?php echo _REALESTATE_MANAGER_ADMIN_CONFIG_PRICE_SHOW; ?>:</td>
                                                                            <td width="20"><?php echo mosToolTip(_REALESTATE_MANAGER_ADMIN_CONFIG_PRICE_SHOW_TT_BODY, _REALESTATE_MANAGER_ADMIN_CONFIG_PRICE_SHOW_TT_HEAD); ?></td>
                                                                            <td><?php echo $lists['price']['show']; ?></td>
                                                                            <td width="185"></td>
                                                                            <td width="20"></td>
                                                                            <td></td> 
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="6">
                                                                                <hr />
                                                                            </td>
                                                                        </tr>

                                                                        <!--************   begin add button 'buy now'   ******************-->
                                                                        <!--tr>
                                                                           <td width="185"><?php echo _REALESTATE_MANAGER_ADMIN_CONFIG_BUYNOW_SHOW; ?>:</td>
                                                                           <td width="20"><?php echo mosToolTip(_REALESTATE_MANAGER_ADMIN_CONFIG_BUYNOW_SHOW_TT_BODY, _REALESTATE_MANAGER_ADMIN_CONFIG_BUYNOW_SHOW_TT_HEAD); ?></td>
                                                                           <td><?php echo $lists['buy_now']['show']; ?></td>
                                                                           <td width="185"><?php echo _REALESTATE_MANAGER_ADMIN_CONFIG_BUYNOW_REGISTRATIONLEVEL; ?></td>
                                                                           <td width="20"><?php echo mosToolTip(_REALESTATE_MANAGER_ADMIN_CONFIG_BUYNOW_REGISTRATIONLEVEL_TT_BODY, _REALESTATE_MANAGER_ADMIN_CONFIG_BUYNOW_REGISTRATIONLEVEL_TT_HEAD); ?></td>
                                                                           <td><?php echo $lists['buy_now']['allow']['categories']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td colspan="6">
                                                                            <hr />
                                                                          </td>
                                                                        </tr-->
                                                                        <!--************   end add button 'buy now'   *********************-->
                                                                        <tr>
                                                                            <td width="185"><?php echo _REALESTATE_MANAGER_ADMIN_CONFIG_EDOCUMENTS_SHOW; ?>:</td>
                                                                            <td width="20"><?php echo mosToolTip(_REALESTATE_MANAGER_ADMIN_CONFIG_EDOCUMENTS_SHOW_TT_BODY, _REALESTATE_MANAGER_ADMIN_CONFIG_EDOCUMENTS_SHOW_TT_HEAD); ?></td>
                                                                            <td><?php echo $lists['edocs']['show']; ?></td>
                                                                            <td width="185"><?php echo _REALESTATE_MANAGER_ADMIN_CONFIG_EDOCUMENTS_REGISTRATIONLEVEL; ?>:</td>
                                                                            <td width="20"><?php echo mosToolTip(_REALESTATE_MANAGER_ADMIN_CONFIG_EDOCUMENTS_REGISTRATIONLEVEL_TT_BODY, _REALESTATE_MANAGER_ADMIN_CONFIG_EDOCUMENTS_REGISTRATIONLEVEL_TT_HEAD); ?></td>
                                                                            <td><?php echo $lists['edocs']['registrationlevel']; ?></td>
                                                                        </tr>

                                                                        <!--
                                                                        //***********************************************************************************************
                                                                        //				begin add FotoSize
                                                                        //***********************************************************************************************
                                                                        -->
                                                                        <tr>
                                                                            <td colspan="6">
                                                                                <hr />
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td width="185"><?php echo _REALESTATE_MANAGER_ADMIN_CONFIG_FOTO_SIZE; ?>:</td>
                                                                            <td width="20"><?php echo mosToolTip(_REALESTATE_MANAGER_ADMIN_CONFIG_FOTO_SIZE_TT_BODY, _REALESTATE_MANAGER_ADMIN_CONFIG_FOTO_SIZE_TT_HEAD); ?></td>
                                                                            <td><?php echo ($lists['foto']['high']) . " / " . ($lists['foto']['width']); ?></td>
                                                                        </tr>

                                                                        <!--
                                                                        //***********************************************************************************************
                                                                        //				end add FotoSize
                                                                        //***********************************************************************************************
                                                                        -->

                                                                        <!--
                                                                        //***********************************************************************************************
                                                                        //				begin add PageItems
                                                                        //***********************************************************************************************
                                                                        -->
                                                                        <tr>
                                                                            <td colspan="6">
                                                                                <hr />
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td width="185"><?php echo _REALESTATE_MANAGER_ADMIN_CONFIG_PAGE_ITEMS; ?>:</td>
                                                                            <td width="20"><?php echo mosToolTip(_REALESTATE_MANAGER_ADMIN_CONFIG_PAGE_ITEMS_TT_BODY, _REALESTATE_MANAGER_ADMIN_CONFIG_PAGE_ITEMS_TT_HEAD); ?></td>
                                                                            <td><?php echo $lists['page']['items']; ?></td>
                                                                        </tr>
                                                                        <!--*******	end add PageItems ************ -->
                                                                        <!--********   begin add for show in category picture   **************-->
                                                                        <tr>
                                                                            <td colspan="6">
                                                                                <hr />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="185"><?php echo _REALESTATE_MANAGER_ADMIN_CONFIG_PICTURE_IN_CATEGORY; ?>:</td>
                                                                            <td width="20"><?php echo mosToolTip(_REALESTATE_MANAGER_ADMIN_CONFIG_PICTURE_IN_CATEGORY_TT_BODY, _REALESTATE_MANAGER_ADMIN_CONFIG_PICTURE_IN_CATEGORY_TT_HEAD); ?></td>
                                                                            <td><?php echo $lists['cat_pic']['show']; ?></td>
                                                                        </tr>
                                                                        <!--***************   end add for show in category picture  *************-->

                                                                        <!--********   begin add for show subcategory   **************-->
                                                                        <tr>
                                                                            <td colspan="6">
                                                                                <hr />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="185"><?php echo _REALESTATE_MANAGER_ADMIN_CONFIG_SUBCATEGORY_SHOW; ?>:</td>
                                                                            <td width="20"><?php echo mosToolTip(_REALESTATE_MANAGER_ADMIN_CONFIG_SUBCATEGORY_SHOW_TT_BODY, _REALESTATE_MANAGER_ADMIN_CONFIG_SUBCATEGORY_SHOW_TT_HEAD); ?></td>
                                                                            <td><?php echo $lists['subcategory']['show']; ?></td>
                                                                        </tr>
                                                                        <!--***************   end add for show subcategory *************-->

                                                                    </table>
                                                                   <!--input type="hidden" name="option" value="<?php echo $option; ?>" />
                                                                   <input type="hidden" name="task" value="config_save_frontend" /-->

        <?php
        $tabs->endTab();
        $tabs->startTab(_REALESTATE_MANAGER_ADMIN_CONFIG_BACKEND, "impexPane");
        ?>
                                                                    <h1><?php echo _REALESTATE_MANAGER_ADMIN_CONFIG_BACKEND; ?></h1>

                                                                    <table class="adminform">

                                                                        <tr>
                                                                            <td width="185"><?php echo _REALESTATE_MANAGER_ADMIN_CONFIG_EDOCUMENTS_DOWNLOAD; ?>:</td>
                                                                            <td width="20"><?php echo mosToolTip(_REALESTATE_MANAGER_ADMIN_CONFIG_EDOCUMENTS_DOWNLOAD_TT_BODY, _REALESTATE_MANAGER_ADMIN_CONFIG_EDOCUMENTS_DOWNLOAD_TT_HEAD); ?></td>
                                                                            <td><?php echo $lists['edocs']['allow']; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td width="185"><?php echo _REALESTATE_MANAGER_ADMIN_CONFIG_EDOCUMENTS_DOWNLOAD_LOCATION; ?>:</td>
                                                                            <td width="20"><?php echo mosToolTip(_REALESTATE_MANAGER_ADMIN_CONFIG_EDOCUMENTS_DOWNLOAD_LOCATION_TT_BODY, _REALESTATE_MANAGER_ADMIN_CONFIG_EDOCUMENTS_DOWNLOAD_LOCATION_TT_HEAD); ?></td>
                                                                            <td><?php echo $lists['edocs']['location']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="3">
                                                                                <hr />
                                                                            </td>
                                                                        </tr>
                                                                        <!--********   begin add for google map key  **************-->
                                                                        <tr>
                                                                            <td width="185"><?php echo _REALESTATE_MANAGER_ADMIN_CONFIG_GOOGLEMAP_KEY; ?>:</td>
                                                                            <td width="20"><?php echo mosToolTip(_REALESTATE_MANAGER_ADMIN_CONFIG_GOOGLEMAP_KEY_TT_BODY, _REALESTATE_MANAGER_ADMIN_CONFIG_GOOGLEMAP_KEY_TT_HEAD); ?></td>
                                                                            <td><?php echo $lists['google_map']['key']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="3">
                                                                                <hr />
                                                                            </td>
                                                                        </tr>
                                                                        <!--***************   end add for google map key *************-->

                                                                    </table>
                                                                    <?php
                                                                    $tabs->endTab();
                                                                    $tabs->endPane();
                                                                    ?>
                                                                    <input type="hidden" name="option" value="<?php echo $option; ?>" />
                                                                    <input type="hidden" name="task" value="config_save" />
                                                                </form>

        <?php
    }

//------------------------------------------------------------------
    function about() {

        global $mosConfig_live_site, $mainframe;
        $tabs = new mosTabs(0);

        $mainframe->addCustomHeadTag('<link rel="stylesheet" href="' . $mosConfig_live_site . '/administrator/components/com_realestatemanager/includes/realestatemanager.css" type="text/css" />');
        ?>
                                                                <div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
                                                                <script type="text/javascript" language="Javascript" src="<?php echo $mosConfig_live_site; ?>/includes/js/overlib_mini.js"></script>

           <!-- <table cellpadding="4" cellspacing="0" border="0" width="100%">
              <tr>
                <td width="30%">
                  <img src="./components/com_realestatemanager/images/building_icon.jpg" align="right" alt="Config" />
                </td>
                <td width="70%" class="house_manager_caption" valign='bottom' >
        <?php echo _REALESTATE_MANAGER_ADMIN_ABOUT ?>
                </td>
              </tr>
            </table> -->

                                                                <form action="index2.php" method="post" name="adminForm" id="adminForm">
        <?php
        $tabs->startPane("aboutPane");
        $tabs->startTab(_REALESTATE_MANAGER_ADMIN_ABOUT_ABOUT, "display-page");
        ?>
                                                                    <table class="adminform">
                                                                        <tr>
                                                                            <td width="80%">
                                                                                <h3><?PHP echo _REALESTATE_MANAGER__HTML_ABOUT; ?></h3>
                                                                    <?PHP echo _REALESTATE_MANAGER__HTML_ABOUT_INTRO; ?>
                                                                            </td>
                                                                            <td width="20%">
                                                                                <img src="../components/com_realestatemanager/images/rem_logo.png" align="right" alt="Real Estate Manager logo" />
                                                                            </td>	         
                                                                        </tr>

                                                                    </table>

                                                                <?php
                                                                $tabs->endTab();
//******************************   tab--2 about   **************************************
                                                                $tabs->startTab(_REALESTATE_MANAGER_ADMIN_ABOUT_RELEASENOTE, "display-page");
                                                                include_once("./components/com_realestatemanager/doc/releasenote.php");
                                                                $tabs->endTab();
//******************************   tab--3 about--changelog.txt   ***********************
                                                                $tabs->startTab(_REALESTATE_MANAGER_ADMIN_ABOUT_CHANGELOG, "display-page");
                                                                include_once("./components/com_realestatemanager/doc/changelog.html");
                                                                $tabs->endTab();

                                                                $tabs->endPane();
                                                                ?>
                <!--        <input type="hidden" name="option" value="<?php /* echo $option; */ ?>">  -->
                                                                </form>
                                                                <?php
                                                            }

                                                            function showImportResult($table, $option) {
                                                                global $my, $mosConfig_live_site, $mainframe;
                                                                $mainframe->addCustomHeadTag('<script type = "text/JavaScript" src ="' . $mosConfig_live_site . '/administrator/components/com_realestatemanager/includes/functions.js"></script>');
                                                                ?>
                                                                <form action="index2.php" method="post" name="adminForm" id="adminForm">
                                                                    <table cellpadding='4' cellspacing='0' border='1' width='100%'>
                                                                        <tr>
                                                                            <td>#</td>
                                                                            <td><?php echo _REALESTATE_MANAGER_LABEL_HOUSEID; ?></td>
                                            <!--	    			<td><?php echo _REALESTATE_MANAGER_LABEL_MLS; ?></td>
                                                                            -->
                                                                            <td><?php echo _REALESTATE_MANAGER_LABEL_ADDRESS; ?></td>
                                                                            <td><?php echo _REALESTATE_MANAGER_LABEL_TITLE; ?></td>
                                                                            <td><?php echo _REALESTATE_MANAGER_LABEL_BROKER; ?></td>
                                                                            <td><?php echo _REALESTATE_MANAGER_LABEL_STATUS; ?></td>
                                                                        </tr>

        <?php foreach ($table as $entry) {
            ?>
                                                                            <tr>
                                                                                <td><?php echo $entry[0] + 1; ?></td>
                                                                                <td><?php echo $entry[1]; ?></td>
                                                                                <td><?php echo $entry[2]; ?></td>
                                                                                <td><?php echo $entry[3]; ?></td>
                                                                                <td><?php echo $entry[4]; ?></td>
                                                                                <td><?php echo $entry[5]; ?></td>
                                                                                <!--
                                                                                                                <td><?php echo $entry[6]; ?></td>
                                                                                -->
                                                                            </tr>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    </table>
                                                                    <input type="hidden" name="option" value="<?php echo $option; ?>" />
                                                                    <input type="hidden" name="task" value="cancel" />
                                                                </form>	

                                                                <?php
                                                            }

                                                            function showExportResult($InformationArray, $option) {
                                                                ?>
                                                                <form action="index2.php" method="post" name="adminForm" id="adminForm">

                                                                    <div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
                                                                    <script type="text/javascript" language="Javascript" src="<?php echo $mosConfig_live_site; ?>/includes/js/overlib_mini.js"></script>

                                                                    <table border="0" class="adminheading" cellpadding="0" cellspacing="0" width="100%">
                                                                        <tr valign="middle">
                                                                            <th class="config"><?php echo _REALESTATE_MANAGER_SHOW_IMPEXP_RESULT; ?></th>
                                                                            <td align="right"></td>
                                                                        </tr>
                                                                    </table>

                                                                        <?php echo _REALESTATE_MANAGER_SHOW_IMPEXP_RESULT_DOWNLOAD; ?>  <br />
                                                                    <a href="<?php echo $InformationArray['urlBase'] . $InformationArray['out_file']; ?>" target="blank"><?php echo $InformationArray['urlBase'] . $InformationArray['out_file']; ?></a>
                                                                    <br />
        <?php echo _REALESTATE_MANAGER_SHOW_IMPEXP_RESULT_REMEMBER; ?>  <br />  
                                                                    <input type="hidden" name="option" value="<?php echo $option; ?>" />
                                                                    <input type="hidden" name="task" value="cancel" />
                                                                </form>	

        <?php
    }

}
?>