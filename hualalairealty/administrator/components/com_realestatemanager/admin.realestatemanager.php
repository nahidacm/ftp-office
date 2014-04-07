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
defined('_VM_IS_BACKEND') or define('_VM_IS_BACKEND', '1');


include_once( dirname(__FILE__) . '/compat.joomla1.5.php' );
$my = $GLOBALS['my'];

$css = $mosConfig_live_site . '/administrator/components/com_realestatemanager/includes/realestatemanager.css';

include_once ($mainframe->getPath('admin_html'));
include_once ($mainframe->getPath('class'));

require_once ($mosConfig_absolute_path . "/components/com_realestatemanager/realestatemanager.class.rent.php");
require_once ($mosConfig_absolute_path . "/components/com_realestatemanager/realestatemanager.class.rent_request.php");
require_once ($mosConfig_absolute_path . "/components/com_realestatemanager/realestatemanager.class.buying_request.php");
require_once ($mosConfig_absolute_path . "/administrator/components/com_realestatemanager/admin.realestatemanager.class.impexp.php");
require_once ($mosConfig_absolute_path . "/administrator/components/com_realestatemanager/admin.realestatemanager.class.conf.php");



$GLOBALS['realestatemanager_configuration'] = $realestatemanager_configuration;
$GLOBALS['database'] = $database;
$GLOBALS['my'] = $my;
$GLOBALS['mosConfig_absolute_path'] = $mosConfig_absolute_path;
require_once ($mosConfig_absolute_path . "/includes/domit/xml_domit_include.php");

// *** Get language files
if (file_exists($mosConfig_absolute_path . "/components/com_realestatemanager/language/{$mosConfig_lang}.php")) {

    include_once($mosConfig_absolute_path . "/components/com_realestatemanager/language/{$mosConfig_lang}.php" );
} else {
    include_once($mosConfig_absolute_path . "/components/com_realestatemanager/language/english.php" );
}



$bid = mosGetParam($_POST, 'bid', array(0));
$section = mosGetParam($_REQUEST, 'section', 'courses');

if ($realestatemanager_configuration['debug'] == '1') {

    echo "Task: " . $task . "<br />";

    print_r($_POST);

    echo "<hr /><br />";
}

/* Added by NHD */
if (isset($_GET['remove_the_doc'])) {
    //echo "Good!!!";
    $item_name = $_POST['item'];
    $item_id = $_POST['id'];
    global $database;
    $query = "UPDATE #__rem_houses SET $item_name = '' WHERE id=$item_id";
    $database->setQuery($query);
    if ($database->query()) {
        echo "Successfully Deleted";
    } else {
        echo "Failed";
    }
    die;
}
/* END of Added by NHD */



if (isset($section) && $section == 'categories') {
    switch ($task) {

        case "edit" :
            editCategory($option, $bid[0]);
            break;

        case "new":
            editCategory($option, 0);
            break;
        case "cancel":
            cancelCategory();
            break;
        case "save":
            saveCategory();
            break;
        case "remove":
            removeCategories($option, $bid);
            break;
        case "publish":
            publishCategories("com_realestatemanager", $id, $bid, 1);
            break;
        case "unpublish":
            publishCategories("com_realestatemanager", $id, $bid, 0);
            break;
        case "orderup":
            orderCategory($bid[0], -1);
            break;
        case "orderdown":
            orderCategory($bid[0], 1);
            break;
        case "accesspublic":
            accessCategory($bid[0], 0);
            break;
        case "accessregistered":
            accessCategory($bid[0], 1);
            break;
        case "accessspecial":
            accessCategory($bid[0], 2);
            break;
        case "show":
        default :
            showCategories();
    }
} else {



    switch ($task) {

        case "categories":
            echo "now work $section=='categories , this part not work";
            exit;
            mosRedirect("index2.php?option=categories&section=com_realestatemanager");
            break;

        case "new" :
            editHouse($option, 0);
            break;

        case "edit" :
            editHouse($option, array_pop($bid));
            break;

        case "save" :
            saveHouse($option);
            break;

        case "remove" :
            removeHouses($bid, $option);
            break;

        case "publish" :
            publishHouses($bid, 1, $option);
            break;

        case "unpublish" :
            publishHouses($bid, 0, $option);
            break;

        case "cancel" :
            cancelHouse($option);
            break;

        case "houseorderdown" :
            orderHouses($bid[0], 1, $option);
            break;

        case "houseorderup" :
            orderHouses($bid[0], -1, $option);
            break;


        case "show_import_export" :
            importExportHouses($option);
            break;

        case "import" :
            import($option);
            break;


        case "export" :
            export($option);
            break;


        case "config" :
            configure($option);
            break;

        case "config_save" :
            configure_save_frontend($option);
            configure_save_backend($option);
            configure($option);
            break;

        case "rent" :
            if (mosGetParam($_POST, 'save') == 1) {
                saveRent($option, $bid);
            } else {
                rent($option, $bid);
            }
            break;

        case "rent_requests" :
            rent_requests($option, $bid);
            break;

        case "buying_requests" :
            buying_requests($option);
            break;

        case "accept_rent_requests" :
            accept_rent_requests($option, $bid);
            break;

        case "decline_rent_requests" :
            decline_rent_requests($option, $bid);
            break;

        case "accept_buying_requests" :
            accept_buying_requests($option, $bid);
            break;

        case "decline_buying_requests" :
            decline_buying_requests($option, $bid);
            break;

        case "about" :
            HTML_realestatemanager :: about();
            break;

        case "show_info" :
            showInfo($option, $bid);
            break;

        case "rent_return" :
            if (mosGetParam($_POST, 'save') == 1) {
                saveRent_return($option, $bid);
            } else {
                rent_return($option, $bid);
            }
            break;

        case "delete_review" :
            $ids = explode(',', $bid[0]);
            delete_review($option, $ids[1]);
            editHouse($option, $ids[0]);
            break;

        case "edit_review" :
            $ids = explode(',', $bid[0]);
            edit_review($option, $ids[1], $ids[0]);
            break;

        case "update_review" :
            $title = mosGetParam($_POST, 'title');
            $comment = mosGetParam($_POST, 'comment');
            $rating = mosGetParam($_POST, 'rating');
            $house_id = mosGetParam($_POST, 'house_id');
            $review_id = mosGetParam($_POST, 'review_id');

            update_review($title, $comment, $rating, $review_id);
            editHouse($option, $house_id);
            break;

        case "cancel_review_edit" :
            $house_id = mosGetParam($_POST, 'house_id');
            editHouse($option, $house_id);
            break;

        default :
            showHouses($option);
            break;
    }
} //else

class CAT_Utils {

    function categoryArray() {
        global $database;
        // get a list of the menu items
        $query = "SELECT c.*, c.parent_id AS parent"
                . "\n FROM #__categories c"
                . "\n WHERE section='com_realestatemanager'"
                . "\n AND published <> -2"
                . "\n ORDER BY ordering";
        $database->setQuery($query);
        $items = $database->loadObjectList();
        // establish the hierarchy of the menu
        $children = array();
        // first pass - collect children
        foreach ($items as $v) {
            $pt = $v->parent;
            $list = @$children[$pt] ? $children[$pt] : array();
            array_push($list, $v);
            $children[$pt] = $list;
        }
        // second pass - get an indent list of the items
        $array = mosTreeRecurse(0, '', array(), $children);

        return $array;
    }

}

/**
 * HTML Class
 * Utility class for all HTML drawing classes
 * @desc class General HTML creation class. We use it for back/front ends.
 */
class HTML {

    // TODO :: merge categoryList and categoryParentList
    // add filter option ?
    function categoryList($id, $action, $options = array()) {
        $list = CAT_Utils::categoryArray();
        // assemble menu items to the array
        foreach ($list as $item) {
            $options[] = mosHTML::makeOption($item->id, $item->treename);
        }
        $parent = mosHTML::selectList($options, 'catid', 'id="catid" class="inputbox" size="1" onchange="' . $action . '"', 'value', 'text', $id);
        return $parent;
    }

    function categoryParentList($id, $action, $options = array()) {
        global $database;
        $list = CAT_Utils::categoryArray();
        $cat = new mosCategory($database);
        $cat->load($id);

        $this_treename = '';
        $childs_ids = Array();
        foreach ($list as $item) {
            if ($item->id == $cat->id || array_key_exists($item->parent_id, $childs_ids))
                $childs_ids[$item->id] = $item->id;
        }

        foreach ($list as $item) {
            if ($this_treename) {
                if ($item->id != $cat->id && strpos($item->treename, $this_treename) === false && array_key_exists($item->id, $childs_ids) === false) {
                    $options[] = mosHTML::makeOption($item->id, $item->treename);
                }
            } else {
                if ($item->id != $cat->id) {
                    $options[] = mosHTML::makeOption($item->id, $item->treename);
                } else {
                    $this_treename = "$item->treename/";
                }
            }
        }

        $parent = null;
        $parent = mosHTML::selectList($options, 'parent_id', 'class="inputbox" size="1"', 'value', 'text', $cat->parent_id);

        return $parent;
    }

    function imageList($name, &$active, $javascript = null, $directory = null) {

        global $mosConfig_absolute_path;
        if (!$javascript) {
            $javascript = "onchange=\"javascript:if (document.adminForm." . $name .
                    ".options[selectedIndex].value!='')    {document.imagelib.src='../images/stories/' + document.adminForm."
                    . $name . ".options[selectedIndex].value} else {document.imagelib.src='../images/blank.png'}\"";
        }
        if (!$directory) {
            $directory = '/images/stories';
        }

        $imageFiles = mosReadDirectory($mosConfig_absolute_path . $directory);
        $images = array(mosHTML::makeOption('', _A_SELECT_IMAGE));
        foreach ($imageFiles as $file) {
            if (preg_match("/bmp|gif|jpg|png/i", $file)) {
                $images[] = mosHTML::makeOption($file);
            }
        }

        $images = mosHTML::selectList($images, $name, 'id="' . $name . '" class="inputbox" size="1" '
                        . $javascript, 'value', 'text', $active);
        return $images;
    }

}

function houseLibraryTreeRecurse($id, $indent, $list, &$children, $maxlevel = 9999, $level = 0, $type = 1) {

    if (@$children[$id] && $level <= $maxlevel) {
        $parent_id = $id;
        foreach ($children[$id] as $v) {
            $id = $v->id;

            if ($type) {
                $pre = '<sup>L</sup>&nbsp;';
                $spacer = '.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            } else {
                $pre = '- ';
                $spacer = '&nbsp;&nbsp;';
            }

            if ($v->parent == 0) {
                $txt = $v->name;
            } else {
                $txt = $pre . $v->name;
            }
            $pt = $v->parent;
            $list[$id] = $v;
            $list[$id]->treename = "$indent$txt";
            $list[$id]->children = count(@$children[$id]);
            $list[$id]->all_fields_in_list = count(@$children[$parent_id]);

            $list = houseLibraryTreeRecurse($id, $indent . $spacer, $list, $children, $maxlevel, $level + 1, $type);
        }
    }
    return $list;
}

function showCategories() {

    global $database, $my, $option, $menutype, $mainframe, $mosConfig_list_limit;

    $section = "com_realestatemanager";

    $sectionid = $mainframe->getUserStateFromRequest("sectionid{$section}{$section}", 'sectionid', 0);
    $limit = $mainframe->getUserStateFromRequest("viewlistlimit", 'limit', $mosConfig_list_limit);
    $limitstart = $mainframe->getUserStateFromRequest("view{$section}limitstart", 'limitstart', 0);
    $levellimit = $mainframe->getUserStateFromRequest("view{$option}limit$menutype", 'levellimit', 10);

    $query = "SELECT  c.*, c.checked_out as checked_out_contact_category, c.parent_id as parent, g.name AS groupname, u.name AS editor"
            . "\n FROM #__categories AS c"
            . "\n LEFT JOIN #__users AS u ON u.id = c.checked_out"
            . "\n LEFT JOIN #__groups AS g ON g.id = c.access"
            . "\n WHERE c.section='$section'"
            . "\n AND c.published != -2"
            . "\n ORDER BY parent_id, ordering";

    $database->setQuery($query);

    $rows = $database->loadObjectList();

    foreach ($rows as $k => $v) {
        $rows[$k]->ncourses = 0;
        $sql = "SELECT COUNT(catid) AS cc FROM #__rem_houses WHERE catid=" . $v->id;
        $database->setQuery($sql);
        $aa = $database->loadObjectList();
        $rows[$k]->nhouse = ($aa[0]->cc == 0) ? "-" : "<a href=\"?option=com_realestatemanager&section=house&catid=" . $v->id . "\">" . ($aa[0]->cc) . "</a>";
    }


    if ($database->getErrorNum()) {
        echo $database->stderr();
        return false;
    }
    // establish the hierarchy of the categories
    $children = array();
    // first pass - collect children
    foreach ($rows as $v) {
        $pt = $v->parent;
        $list = @$children[$pt] ? $children[$pt] : array();
        array_push($list, $v);
        $children[$pt] = $list;
    }
    // second pass - get an indent list of the items
    $list = houseLibraryTreeRecurse(0, '', array(), $children, max(0, $levellimit - 1));
    $total = count($list);

    require_once($GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php');
    $pageNav = new mosPageNav($total, $limitstart, $limit);

    $levellist = mosHTML::integerSelectList(1, 20, 1, 'levellimit', 'size="1" onchange="document.adminForm.submit();"', $levellimit);
    // slice out elements based on limits
    $list = array_slice($list, $pageNav->limitstart, $pageNav->limit);

//echo "<pre>"; print_r($list); echo "</pre>";exit;

    $count = count($list);
    // number of Active Items
    /*  for ($i = 0; $i < $count; $i++) {
      $query = "SELECT COUNT( d.id )"
      . "\n FROM #__categories AS d"
      . "\n WHERE d.catid = " . $list[$i]->id;
      // . "\n AND d.state <> '-2'";
      $database->setQuery($query);
      $active = $database->loadResult();
      $list[$i]->documents = $active;
      } */
    // get list of sections for dropdown filter
    $javascript = 'onchange="document.adminForm.submit();"';
    $lists['sectionid'] = mosAdminMenus::SelectSection('sectionid', $sectionid, $javascript);

    HTML_Categories::show($list, $my->id, $pageNav, $lists, 'other');
}

function editCategory($section = '', $uid = 0) {

    global $database, $my;
    global $mosConfig_absolute_path, $mosConfig_live_site;


    $type = mosGetParam($_REQUEST, 'type', '');
    $redirect = mosGetParam($_POST, 'section', '');
    ;
    $row = new mosCategory($database);
    // load the row from the db table
    $row->load($uid);
    // fail if checked out not by 'me'
    if ($row->checked_out && $row->checked_out <> $my->id) {
        mosRedirect('index2.php?option=com_realestatemanager&task=categories', 'The category ' . $row->title . ' is currently being edited by another administrator');
    }

    if ($uid) {
        // existing record
        $row->checkout($my->id);
        // code for Link Menu
    } else {
        // new record
        $row->section = $section;
        $row->published = 1;
    }
    // make order list
    $order = array();

    $database->setQuery("SELECT COUNT(*) FROM #__categories WHERE section='$row->section'");
    $max = intval($database->loadResult()) + 1;

    for ($i = 1; $i < $max; $i++) {
        $order[] = mosHTML::makeOption($i);
    }
    // build the html select list for ordering
    $query = "SELECT ordering AS value, title AS text"
            . "\n FROM #__categories"
            . "\n WHERE section = '$row->section'"
            . "\n ORDER BY ordering";

    $lists['ordering'] = mosAdminMenus::SpecificOrdering($row, $uid, $query);
    // build the select list for the image positions
    $active = ($row->image_position ? $row->image_position : 'left');
    $lists['image_position'] = mosAdminMenus::Positions('image_position', $active, null, 0, 0);
    // Imagelist
    $lists['image'] = HTML::imageList('image', $row->image);
    // build the html select list for the group access
    $lists['access'] = mosAdminMenus::Access($row);
    // build the html radio buttons for published
    $lists['published'] = mosHTML::yesnoRadioList('published', 'class="inputbox"', $row->published);
    // build the html select list for paraent item
    $options = array();
    $options[] = mosHTML::makeOption('0', _A_SELECT_TOP);

    $lists['parent'] = HTML::categoryParentList($row->id, "", $options);

    HTML_Categories::edit($row, $section, $lists, $redirect);
}

function saveCategory() {
    global $database;

    $row = new mosCategory($database);
    if (!$row->bind($_POST)) {
        echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
        exit();
    }
    $row->section = 'com_realestatemanager';
    $row->parent_id = $_REQUEST['parent_id'];

    if (!$row->check()) {
        echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
        exit();
    }
    if (!$row->store()) {
        echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
        exit();
    }

    $row->checkin();
    $row->updateOrder("section='com_realestatemanager' AND parent_id='$row->parent_id'");

    if ($oldtitle = mosGetParam($_POST, 'oldtitle', null)) {
        if ($oldtitle != $row->title) {
            $database->setQuery("UPDATE #__categories " . "\n SET name='$row->title' " . "\n WHERE name='$oldtitle' " . "\n    AND section='com_realestatemanager'");

            $database->query();
        }
    }
    mosRedirect('index2.php?option=com_realestatemanager&section=categories');
}

//this function check - is exist houses in this folder and folders under this category 
function is_exist_curr_and_subcategory_houses($catid) {
    global $database, $my;

    $query = "SELECT *, COUNT(a.id) AS numlinks FROM #__categories AS cc"
            . "\n LEFT JOIN #__rem_houses AS a ON a.catid = cc.id"
            . "\n WHERE a.published='1' AND a.approved='1' AND section='com_realestatemanager' AND cc.id='$catid' AND cc.published='1' AND cc.access <= '$my->gid'"
            . "\n GROUP BY cc.id"
            . "\n ORDER BY cc.ordering";
    $database->setQuery($query);
    $categories = $database->loadObjectList();
    if (count($categories) != 0)
        return true;

    $query = "SELECT id "
            . "FROM #__categories AS cc "
            . " WHERE section='com_realestatemanager' AND parent_id='$catid' AND published='1' AND access<='$my->gid'";
    $database->setQuery($query);
    $categories = $database->loadObjectList();

    if (count($categories) == 0)
        return false;

    foreach ($categories as $k) {
        if (is_exist_curr_and_subcategory_houses($k->id))
            return true;
    }
    return false;
}

//end function

function removeCategoriesFromDB($cid) {
    global $database, $my;

    $query = "SELECT id,  "
            . "FROM #__categories AS cc "
            . " WHERE section='com_realestatemanager' AND parent_id='$cid' AND published='1' AND access<='$my->gid'";
    $database->setQuery($query);
    $categories = $database->loadObjectList();
    //    echo $database->getErrorMsg() ;

    if (count($categories) != 0) {
        //delete child
        foreach ($categories as $k) {
            removeCategoriesFromDB($k->id);
        }
    }

    $sql = "DELETE FROM #__categories WHERE id = $cid ";
    $database->setQuery($sql);
    $database->query();
}

/**
 * Deletes one or more categories from the categories table
 * 
 * @param string $ The name of the category section
 * @param array $ An array of unique category id numbers
 */
function removeCategories($section, $cid) {
    global $database;

    if (count($cid) < 1) {
        echo "<script> alert('Select a category to delete'); window.history.go(-1);</script>\n";
        exit;
    }

    foreach ($cid as $catid) {
        if (is_exist_curr_and_subcategory_houses($catid)) {
            echo "<script> alert('Some category or subcategory from yours select contain houses. \\n Please remove houses first!'); window.history.go(-1); </script>\n";
            exit;
        }
    }

    foreach ($cid as $catid) {
        removeCategoriesFromDB($catid);
    }

    /*    $cids = implode(',', $cid);

      $query = "SELECT c.id AS numcat, c.name, COUNT(s.catid ) AS numkids"
      . "\n FROM #__categories AS c"
      . "\n LEFT JOIN #__realestatemanager AS s ON s.catid=c.id"
      . "\n WHERE c.id IN ($cids)"
      . "\n GROUP BY c.id" ;

      // add set query
      $database->setQuery($query);
      if (!($rows = $database->loadObjectList())) {
      echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
      return ;
      }

      $err = array();
      $new_cid = array();

      foreach ($rows as $row) {

      if ($row->numkids == 0) {
      $new_cid[] = $row->numcat;
      } else {
      $err[] = $row->name;
      }
      }

      if (count($new_cid)) {
      $new_cids = implode(',', $new_cid);

      if (count($cid)) {
      $new_cids = implode(',', $cid);

      $sql="DELETE FROM #__categories WHERE id IN ($new_cids)";
      $database->setQuery($sql);

      if (!$database->query()) {
      echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
      return ;
      }
      }

      if (count($err)) {
      if (count($err) > 1) {
      $new_cids = implode(', ', $err);
      $msg = "Categories : $new_cids -";
      } else {
      $msg = "Category " . $err[0] ;
      }
      $msg .= ' cannot be removed. There are associated records and/or subcategories';
      mosRedirect('index2.php?option=com_realestatemanager&section=categories&mosmsg=' . $msg);
      }
     */
    $msg = (count($err) > 1 ? "Categories " : _CATEGORIES_NAME . " ") . _DELETED;
    mosRedirect('index2.php?option=com_realestatemanager&section=categories&mosmsg=' . $msg);
}

/**
 * Publishes or Unpublishes one or more categories
 * 
 * @param string $ The name of the category section
 * @param integer $ A unique category id (passed from an edit form)
 * @param array $ An array of unique category id numbers
 * @param integer $ 0 if unpublishing, 1 if publishing
 * @param string $ The name of the current user
 */
function publishCategories($section, $categoryid = null, $cid = null, $publish = 1) {
    global $database, $my;

    if (!is_array($cid)) {
        $cid = array();
    }
    if ($categoryid) {
        $cid[] = $categoryid;
    }

    if (count($cid) < 1) {
        $action = $publish ? _PUBLISH : _DML_UNPUBLISH;
        echo "<script> alert('" . _DML_SELECTCATTO . " $action'); window.history.go(-1);</script>\n";
        exit;
    }

    $cids = implode(',', $cid);

    $query = "UPDATE #__categories SET published='$publish'"
            . "\nWHERE id IN ($cids) AND (checked_out=0 OR (checked_out='$my->id'))";
    $database->setQuery($query);
    if (!$database->query()) {
        echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
        exit();
    }

    if (count($cid) == 1) {
        $row = new mosCategory($database);
        $row->checkin($cid[0]);
    }

    mosRedirect('index2.php?option=com_realestatemanager&section=categories');
}

/**
 * Cancels an edit operation
 * 
 * @param string $ The name of the category section
 * @param integer $ A unique category id
 */
function cancelCategory() {
    global $database;

    $row = new mosCategory($database);
    $row->bind($_POST);
    $row->checkin();
    mosRedirect('index2.php?option=com_realestatemanager&section=categories');
}

/**
 * Moves the order of a record
 * 
 * @param integer $ The increment to reorder by
 */
function orderCategory($uid, $inc) {
    global $database;
    $row = new mosCategory($database);
    $row->load($uid);
    if ($row->ordering == 1 && $inc == -1)
        mosRedirect('index2.php?option=com_realestatemanager&section=categories');

    $new_order = $row->ordering + $inc;

    //change ordering - for other element
    $query = "UPDATE #__categories SET ordering='" . ($row->ordering) . "'"
            . "\nWHERE parent_id = $row->parent_id and ordering=$new_order";
    $database->setQuery($query);
    $database->query();

    //change ordering - for this element
    $query = "UPDATE #__categories SET ordering='" . $new_order . "'"
            . "\nWHERE id = $uid";
    $database->setQuery($query);
    $database->query();

    mosRedirect('index2.php?option=com_realestatemanager&section=categories');

    /*    $row = new mosCategory($database);
      $row->load($uid);
      $row->move($inc, "section='$row->section'");
      mosRedirect('index2.php?option=com_realestatemanager&section=categories');
     */
}

/**
 * changes the access level of a record
 * 
 * @param integer $ The increment to reorder by
 */
function accessCategory($uid, $access) {
    global $database;

    $row = new mosCategory($database);
    $row->load($uid);
    $row->access = $access;

    if (!$row->check()) {
        return $row->getError();
    }
    if (!$row->store()) {
        return $row->getError();
    }

    mosRedirect('index2.php?option=com_realestatemanager&section=categories');
}

function update_review($title, $comment, $rating, $review_id) {
    global $database;

    //update review where id =.. ;
    $database->setQuery('update #__rem_review set rating=' . $rating .
            ', title="' . $title . '", comment="' . $comment . '" where id = ' . $review_id . ' ;');

    $database->query();
    echo $database->getErrorMsg();
}

function edit_review($option, $review_id, $house_id) {
    global $database;


    $database->setQuery("SELECT * FROM #__rem_review WHERE id=" . $review_id . " ");
    $review = $database->loadObjectList();
    echo $database->getErrorMsg();

    HTML_realestatemanager :: edit_review($option, $house_id, $review);
}

/*
 * Function for delete coment
 * (comment for every house) 
 * in database.
 */

function delete_review($option, $id) {
    global $database;

    //delete review where id =.. ;
    $database->setQuery("DELETE FROM #__rem_review WHERE #__rem_review.id=" . $id . ";");

    $database->query();
    echo $database->getErrorMsg();
}

function showInfo($option, $bid) {

    if (is_array($bid) && count($bid) > 0) {
        $bid = $bid[0];
    }

    echo "Test: " . $bid;
}

function decline_rent_requests($option, $bids) {

    global $database;

    foreach ($bids as $bid) {
        $rent_request = new mosRealEstateManager_rent_request($database);
        $rent_request->load($bid);
        $tmp = $rent_request->decline();

        if ($tmp != null) {
            echo "<script> alert('" . $tmp . "'); window.history.go(-1); </script>\n";
            exit();
        }
    }

    mosRedirect("index2.php?option=$option&task=rent_requests");
}

function accept_rent_requests($option, $bids) {

    global $database;

    foreach ($bids as $bid) {
        $rent_request = new mosRealEstateManager_rent_request($database);
        $rent_request->load($bid);
        $tmp = $rent_request->accept();
        if ($tmp != null) {
            echo "<script> alert('" . $tmp . "'); window.history.go(-1); </script>\n";
            exit();
        }
    }
    mosRedirect("index2.php?option=$option&task=rent_requests");
}

function accept_buying_requests($option, $bids) {
    global $database;
    foreach ($bids as $bid) {
        $buying_request = new mosRealEstateManager_buying_request($database);
        $buying_request->delete($bid);
    }
    mosRedirect("index2.php?option=$option&task=buying_requests");
}

function rent_requests($option, $bid) {

    global $database, $mainframe, $mosConfig_list_limit;

    $limit = $mainframe->getUserStateFromRequest("viewlistlimit", 'limit', $mosConfig_list_limit);
    $limitstart = $mainframe->getUserStateFromRequest("view{$option}limitstart", 'limitstart', 0);

    $database->setQuery("SELECT count(*) FROM #__rem_houses AS a" .
            "\nLEFT JOIN #__rem_rent_request AS l" .
            "\nON l.fk_houseid = a.id" .
            "\nWHERE l.status = 0");
    $total = $database->loadResult();
    echo $database->getErrorMsg();

    require_once ($GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php');
    $pageNav = new mosPageNav($total, $limitstart, $limit);

    $database->setQuery("SELECT * FROM #__rem_houses AS a" .
            "\nLEFT JOIN #__rem_rent_request AS l" .
            "\nON l.fk_houseid = a.id" .
            "\nWHERE l.status = 0" .
            "\nORDER BY l.rent_from, l.rent_until, l.user_name" .
            "\nLIMIT $pageNav->limitstart,$pageNav->limit;");
    $rent_requests = $database->loadObjectList();
    echo $database->getErrorMsg();

    //	print_r($total);	

    HTML_realestatemanager :: showRequestRentHouses($option, $rent_requests, $pageNav);
}

function buying_requests($option) {

    global $database, $mainframe, $mosConfig_list_limit;

    $limit = $mainframe->getUserStateFromRequest("viewlistlimit", 'limit', $mosConfig_list_limit);
    $limitstart = $mainframe->getUserStateFromRequest("view{$option}limitstart", 'limitstart', 0);

    $database->setQuery("SELECT count(*) FROM #__rem_houses AS a" .
            "\nLEFT JOIN #__rem_buying_request AS s" .
            "\nON s.fk_houseid = a.id" .
            "\nWHERE s.status = 0");
    $total = $database->loadResult();
    echo $database->getErrorMsg();

    require_once ($GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php');
    $pageNav = new mosPageNav($total, $limitstart, $limit);

    $database->setQuery("SELECT * FROM #__rem_houses AS a" .
            "\nLEFT JOIN #__rem_buying_request AS s" .
            "\nON s.fk_houseid = a.id" .
            "\nWHERE s.status = 0" .
            "\nORDER BY s.customer_name" .
            "\nLIMIT $pageNav->limitstart,$pageNav->limit;");
    $rent_requests = $database->loadObjectList();
    echo $database->getErrorMsg();
    HTML_realestatemanager ::showRequestBuyingHouses($option, $rent_requests, $pageNav);
}

/**
 * Compiles a list of records
 * @param database - A database connector object
 * select categories
 */
function showHouses($option) {
    global $database, $mainframe, $mosConfig_list_limit;

    $limit = $mainframe->getUserStateFromRequest("viewlistlimit", 'limit', $mosConfig_list_limit);
    $limitstart = $mainframe->getUserStateFromRequest("view{$option}limitstart", 'limitstart', 0);
    $catid = $mainframe->getUserStateFromRequest("catid{$option}", 'catid', '-1'); //old 0
    $rent = $mainframe->getUserStateFromRequest("rent{$option}", 'rent', '-1'); //add nik
    $pub = $mainframe->getUserStateFromRequest("pub{$option}", 'pub', '-1'); //add nik

    $search = $mainframe->getUserStateFromRequest("search{$option}", 'search', '');
    $search = $database->getEscaped(trim(strtolower($search)));

    $where = array();

    if ($rent == "rent") {
        array_push($where, "a.fk_rentid <> 0");
    } else if ($rent == "not_rent") {
        array_push($where, "a.fk_rentid = 0");
    }
    if ($pub == "pub") {
        array_push($where, "a.published = 1");
    } else if ($pub == "not_pub") {
        array_push($where, "a.published = 0");
    }
    if ($catid > 0) {
        array_push($where, "a.catid='$catid'");
    }


    if ($search) {
        array_push($where, "(LOWER(a.htitle) LIKE '%$search%' OR LOWER(a.hlocation) LIKE '%$search%' OR LOWER(a.houseid) LIKE '%$search%')");
    }


    $database->setQuery("SELECT count(*) FROM #__rem_houses AS a" .
            "\nLEFT JOIN #__rem_rent AS l" .
            "\nON a.fk_rentid = l.id" .
            (count($where) ? "\nWHERE " . implode(' AND ', $where) : ""));

    $total = $database->loadResult();
    echo $database->getErrorMsg();

    require_once ($GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php');
    $pageNav = new mosPageNav($total, $limitstart, $limit);

    $selectstring = "SELECT a.*, cc.title AS category, l.id as rentid, l.rent_from as rent_from, l.rent_return as rent_return, l.rent_until as rent_until, u.name AS editor" .
            "\nFROM #__rem_houses AS a" .
            "\nLEFT JOIN #__categories AS cc ON cc.id = a.catid" .
            "\nLEFT JOIN #__rem_rent AS l ON a.fk_rentid = l.id" .
            "\nLEFT JOIN #__users AS u ON u.id = a.checked_out" .
            (count($where) ? "\nWHERE " . implode(' AND ', $where) : "") .
            "\nORDER BY a.catid, a.ordering" .
            "\nLIMIT $pageNav->limitstart,$pageNav->limit;";
    $database->setQuery($selectstring);
    $rows = $database->loadObjectList();

    //echo $rows[0];exit;	

    if ($database->getErrorNum()) {
        echo $database->stderr();
        return false;
    }

    // get list of categories
    /*
     * select list treeSelectList
     */

    $categories[] = mosHTML :: makeOption('0', _REALESTATE_MANAGER_LABEL_SELECT_CATEGORIES);
    $categories[] = mosHTML :: makeOption('-1', _REALESTATE_MANAGER_LABEL_SELECT_ALL_CATEGORIES);
    //$database->setQuery("SELECT id AS value, title AS text FROM #__categories"."\nWHERE section='com_realestatemanager' ORDER BY ordering");
//	$categories = array_merge($categories, $database->loadObjectList());//old valid
//	$clist = mosHTML :: selectList($categories, 'catid', 'class="inputbox" size="1" onchange="document.adminForm.submit();"', 'value', 'text', $catid);//old valid
//*************   begin add for sub category in select in manager houses   *************
    $options = $categories;
    $id = 0; //$categories_array;
    $list = CAT_Utils::categoryArray();

    $cat = new mosCategory($database);
    $cat->load($id);

    $this_treename = '';
    foreach ($list as $item) {
        if ($this_treename) {
            if ($item->id != $cat->id && strpos($item->treename, $this_treename) === false) {
                $options[] = mosHTML::makeOption($item->id, $item->treename);
            }
        } else {
            if ($item->id != $cat->id) {
                $options[] = mosHTML::makeOption($item->id, $item->treename);
            } else {
                $this_treename = "$item->treename/";
            }
        }
    }

    $clist = mosHTML::selectList($options, 'catid', 'class="inputbox" size="1" onchange="document.adminForm.submit();"', 'value', 'text', $catid); //new nik edit
//	$clist = mosHTML :: selectList($categories, 'catid', 'class="inputbox" size="1" onchange="document.adminForm.submit();"', 'value', 'text', $catid);//old valid
//*****  end add for sub category in select in manager houses   **********

    $rentmenu[] = mosHTML :: makeOption('0', _REALESTATE_MANAGER_LABEL_SELECT_TO_RENT);
    $rentmenu[] = mosHTML :: makeOption('-1', _REALESTATE_MANAGER_LABEL_SELECT_ALL_RENT);
    $rentmenu[] = mosHTML :: makeOption('not_rent', _REALESTATE_MANAGER_LABEL_SELECT_NOT_RENT);
    $rentmenu[] = mosHTML :: makeOption('rent', _REALESTATE_MANAGER_LABEL_SELECT_RENT);

    $rentlist = mosHTML :: selectList($rentmenu, 'rent', 'class="inputbox" size="1" onchange="document.adminForm.submit();"', 'value', 'text', $rent);

    $pubmenu[] = mosHTML :: makeOption('0', _REALESTATE_MANAGER_LABEL_SELECT_TO_PUBLIC);
    $pubmenu[] = mosHTML :: makeOption('-1', _REALESTATE_MANAGER_LABEL_SELECT_ALL_PUBLIC);
    $pubmenu[] = mosHTML :: makeOption('not_pub', _REALESTATE_MANAGER_LABEL_SELECT_NOT_PUBLIC);
    $pubmenu[] = mosHTML :: makeOption('pub', _REALESTATE_MANAGER_LABEL_SELECT_PUBLIC);

    $publist = mosHTML :: selectList($pubmenu, 'pub', 'class="inputbox" size="1" onchange="document.adminForm.submit();"', 'value', 'text', $pub);


    HTML_realestatemanager :: showHouses($option, $rows, $clist, $rentlist, $publist, $search, $pageNav);
}

/**
 * Compiles information to add or edit houses
 * @param integer bid The unique id of the record to edit (0 if new)
 * @param array option the current options
 */
function editHouse($option, $bid) {
    global $database, $my, $mosConfig_live_site, $realestatemanager_configuration;

    $house = new mosRealEstateManager($database);

    // load the row from the db table
    $house->load(intval($bid));
//	echo $house->map_zoom;exit;
    //$house->year = "1900";
    //$house->expiration_date = "2027-12-31";
    // get list of categories
    $categories[] = mosHTML :: makeOption('0', _REALESTATE_MANAGER_LABEL_SELECT_CATEGORIES);

    $database->setQuery("SELECT id AS value, name AS text FROM #__categories" .
            " WHERE section='$option' ORDER BY ordering");
    $categories = array_merge($categories, $database->loadObjectList());

    if (count($categories) <= 1) {
        mosRedirect("index2.php?option=com_realestatemanager&section=categories", _REALESTATE_MANAGER_ADMIN_IMPEXP_ADD);
    }

    $clist = mosHTML :: selectList($categories, 'catid', 'class="inputbox" size="1"', 'value', 'text', intval($house->catid));

    $database->setQuery("SELECT id AS value, name AS text FROM #__categories" .
            " WHERE section='$option' AND parent_id = 0 AND published=1 ORDER BY title ASC");
    $listOrgCats = $database->loadObjectList();

    $k = 0;

    for ($i = 0; $i < count($listOrgCats); $i++) {

        $database->setQuery("SELECT id AS value, name AS text FROM #__categories" .
                " WHERE section='$option' AND parent_id = " . $listOrgCats[$i]->value . " AND published=1 ORDER BY ordering");
        $listCats = $database->loadObjectList();
        //echo "<br>".count($listCats)."<br>";
        if (count($listCats) > 0) {
            for ($j = 0; $j < count($listCats); $j++) {
                $catListValue[$k]["value"] = $listCats[$j]->value;
                $catListValue[$k]["text"] = $listOrgCats[$i]->text . " - " . $listCats[$j]->text;
                $k++;
            }
        } else {
            $catListValue[$k]["value"] = $listOrgCats[$i]->value;
            $catListValue[$k]["text"] = $listOrgCats[$i]->text;
            $k++;
        }
    }

    //get Rating
    $retVal2 = mosRealEstateManagerOthers :: getRatingArray();
    $rating = null;
    for ($i = 0, $n = count($retVal2); $i < $n; $i++) {
        $help = & $retVal2[$i];
        $rating[] = mosHTML :: makeOption($help[0], $help[1]);
    }

    /* $ratinglist = mosHTML :: selectList($rating, 'rating', 'class="inputbox" size="1"', 'value', 'text', $house->rating); */

    //delete ehouse?
    $help = str_replace($mosConfig_live_site, "", $house->edok_link);
    $delete_ehouse_yesno[] = mosHTML :: makeOption($help, _REALESTATE_MANAGER_YES);
    $delete_ehouse_yesno[] = mosHTML :: makeOption('0', _REALESTATE_MANAGER_NO);
    $delete_edoc = mosHTML :: RadioList($delete_ehouse_yesno, 'delete_edoc', 'class="inputbox"', '0', 'value', 'text');

    // fail if checked out not by 'me'
    if ($house->checked_out && $house->checked_out <> $my->id) {
        mosRedirect("index2.php?option=$option", _REALESTATE_MANAGER_IS_EDITED);
    }

    if ($bid) {
        $house->checkout($my->id);
    } else {
        // initialise new record
        $house->published = 0;
        $house->approved = 0;
    }

//print_r($house);exit;
//*****************************   begin for reviews **************************//
    $database->setQuery("select a.* from #__rem_review a " .
            " WHERE a.fk_houseid=" . $bid . " ORDER BY date ;");
    $reviews = $database->loadObjectList();
//echo "reviews::"; print_r($reviews);
//**********************   end for reviews   *****************************//
    //cоздание списка "тип сделки"
    $listing_type[] = mosHtml::makeOption('foreclosure', _REALESTATE_MANAGER_OPTION_FORECLOSURE);
    $listing_type[] = mosHtml::makeOption('house for rent', _REALESTATE_MANAGER_OPTION_HOUSE_FOR_RENT);
    $listing_type[] = mosHtml::makeOption('room for rent', _REALESTATE_MANAGER_OPTION_ROOM_FOR_RENT);
    $listing_type[] = mosHtml::makeOption('for sale', _REALESTATE_MANAGER_OPTION_FOR_SALE);
    $listing_type[] = mosHtml::makeOption('new home', _REALESTATE_MANAGER_OPTION_NEW_HOME);
    $listing_type[] = mosHtml::makeOption('sublet', _REALESTATE_MANAGER_OPTION_SUBLET);
    $listing_type_list = mosHTML :: selectList($listing_type, 'listing_type', 'class="inputbox" size="1"', 'value', 'text', $house->listing_type);

    //cоздание списка "тип цены"
    $test[] = mosHtml::makeOption('negotiable', _REALESTATE_MANAGER_OPTION_NEGOTIABLE);
    $test[] = mosHtml::makeOption('starting', _REALESTATE_MANAGER_OPTION_STARTING);
    $test_list = mosHTML :: selectList($test, 'price_type', 'class="inputbox" size="1"', 'value', 'text', $house->price_type);

    //cоздание списка "статус сделки"
    $listing_status_type[] = mosHtml::makeOption('active', _REALESTATE_MANAGER_OPTION_ACTIVE);
    $listing_status_type[] = mosHtml::makeOption('offer', _REALESTATE_MANAGER_OPTION_OFFER);
    $listing_status_type[] = mosHtml::makeOption('contract', _REALESTATE_MANAGER_OPTION_CONTRACT);
    $listing_status_type[] = mosHtml::makeOption('closed', _REALESTATE_MANAGER_OPTION_CLOSED);
    $listing_status_type[] = mosHtml::makeOption('withdrawn', _REALESTATE_MANAGER_OPTION_WITHDRAWN);
    $listing_status_list = mosHTML :: selectList($listing_status_type, 'listing_status', 'class="inputbox" size="1"', 'value', 'text', $house->listing_status);

    $property_type[] = mosHtml::makeOption('apartment', _REALESTATE_MANAGER_OPTION_APARTMENT);
    $property_type[] = mosHtml::makeOption('commercial', _REALESTATE_MANAGER_OPTION_COMMERCIAL);
    $property_type[] = mosHtml::makeOption('condo', _REALESTATE_MANAGER_OPTION_CONDO);
    $property_type[] = mosHtml::makeOption('coop', _REALESTATE_MANAGER_OPTION_COOP);
    $property_type[] = mosHtml::makeOption('farm', _REALESTATE_MANAGER_OPTION_FARM);
    $property_type[] = mosHtml::makeOption('land', _REALESTATE_MANAGER_OPTION_LAND);
    $property_type[] = mosHtml::makeOption('manufactured', _REALESTATE_MANAGER_OPTION_MANUFACTURED);
    $property_type[] = mosHtml::makeOption('multifamily', _REALESTATE_MANAGER_OPTION_MULTIFAMILY);
    $property_type[] = mosHtml::makeOption('ranch', _REALESTATE_MANAGER_OPTION_RANCH);
    $property_type[] = mosHtml::makeOption('single family', _REALESTATE_MANAGER_OPTION_SINGLE_FAMILY);
    $property_type[] = mosHtml::makeOption('tic', _REALESTATE_MANAGER_OPTION_TIC);
    $property_type[] = mosHtml::makeOption('townhouse', _REALESTATE_MANAGER_OPTION_TOWNHOUSE);
    $property_type_list = mosHTML :: selectList($property_type, 'property_type', 'class="inputbox" size="1"', 'value', 'text', $house->property_type);

    //cоздание списка "класс провайдера"
    $provider_class[] = mosHtml::makeOption('agent', _REALESTATE_MANAGER_OPTION_AGENT);
    $provider_class[] = mosHtml::makeOption('aggregator', _REALESTATE_MANAGER_OPTION_AGGREGATOR);
    $provider_class[] = mosHtml::makeOption('broker', _REALESTATE_MANAGER_OPTION_BROKER);
    $provider_class[] = mosHtml::makeOption('franchisor', _REALESTATE_MANAGER_OPTION_FRANCHISOR);
    $provider_class[] = mosHtml::makeOption('homebuilder', _REALESTATE_MANAGER_OPTION_HOMEBUILDER);
    $provider_class[] = mosHtml::makeOption('publisher', _REALESTATE_MANAGER_OPTION_PUBLISHER);
//	$provider_class[] = mosHtml::makeOption('mls',"mls");
    $provider_class_list = mosHTML :: selectList($provider_class, 'provider_class', 'class="inputbox" size="1"', 'value', 'text', $house->provider_class);

    //cоздание списка "районирование"
    $zoning[] = mosHtml::makeOption('agricultural', _REALESTATE_MANAGER_OPTION_AGRICULTURAL);
    $zoning[] = mosHtml::makeOption('commercial', _REALESTATE_MANAGER_OPTION_COMMERCIAL);
    $zoning[] = mosHtml::makeOption('industrial', _REALESTATE_MANAGER_OPTION_INDUSTRIAL);
    $zoning[] = mosHtml::makeOption('recreational', _REALESTATE_MANAGER_OPTION_RECREATIONAL);
    $zoning[] = mosHtml::makeOption('residential', _REALESTATE_MANAGER_OPTION_RESIDENTIAL);
    $zoning[] = mosHtml::makeOption('unincorporated', _REALESTATE_MANAGER_OPTION_UNINCORPORATED);
    $zoning_list = mosHTML :: selectList($zoning, 'zoning', 'class="inputbox" size="1"', 'value', 'text', $house->zoning);

    //cоздание списка "style"
    $style[] = mosHtml::makeOption('Cape Cod', _REALESTATE_MANAGER_OPTION_CAPE_COD);
    $style[] = mosHtml::makeOption('Colonial', _REALESTATE_MANAGER_OPTION_COLONIAL);
    $style[] = mosHtml::makeOption('Craftsman', _REALESTATE_MANAGER_OPTION_CRAFTSMAN);
    $style[] = mosHtml::makeOption('Gothic', _REALESTATE_MANAGER_OPTION_GOTHIC);
    $style[] = mosHtml::makeOption('Prairie', _REALESTATE_MANAGER_OPTION_PRAIRIE);
    $style[] = mosHtml::makeOption('Ranch', _REALESTATE_MANAGER_OPTION_RANCH2);
    $style[] = mosHtml::makeOption('Split Level', _REALESTATE_MANAGER_OPTION_SPLIT_LEVEL);
    $style[] = mosHtml::makeOption('Tudor', _REALESTATE_MANAGER_OPTION_TUDOR);
    $style[] = mosHtml::makeOption('Victorian Queen Anne', _REALESTATE_MANAGER_OPTION_VICTORIAN_QUEEN_ANNE);
    $style_list = mosHTML :: selectList($style, 'style', 'class="inputbox" size="1"', 'value', 'text', $house->style);

    $query = "select * from #__rem_photos WHERE fk_houseid=$house->id order by id";
    $database->setQuery($query);
    $house_photos = $database->loadObjectList();


    HTML_realestatemanager :: editHouse($option, $house, $catListValue, $clist, $ratinglist, $delete_edoc, $reviews, $test_list, $listing_status_list, $property_type_list, $listing_type_list, $provider_class_list, $zoning_list, $style_list, $house_photos);
}

/**
 * Saves the record on an edit form submit
 * @param database A database connector object
 */
function picture_thumbnail($file) {
    global $mosConfig_absolute_path;

    //разделение имени файла на имя и расширение
    $file_pth = pathinfo($file);
    $file_type = '.' . $file_pth['extension'];
    $file_name = basename($file, $file_type);

    /*  $file_name = substr($file, 0, strlen($file)-4);
      $file_type = substr($file, strlen($file)-4); */

    // Setting the resize parameters
    list($width, $height) = getimagesize($mosConfig_absolute_path . '/components/com_realestatemanager/photos/' . $file);
    // Creating the Canvas
    $tn = imagecreatetruecolor(258, 172);

    //проверка типа
    switch (strtolower($file_type)) {
        case '.png':
            echo 'type of your image is PNG';
            $source = imagecreatefrompng($mosConfig_absolute_path . '/components/com_realestatemanager/photos/' . $file);
            $file = imagecopyresized($tn, $source, 0, 0, 0, 0, 258, 172, $width, $height);
            imagepng($tn, $mosConfig_absolute_path . '/components/com_realestatemanager/photos/' . $file_name . "_mini" . $file_type);
            break;
        case '.jpg':
            echo 'type of your image is JPG';
            $source = imagecreatefromjpeg($mosConfig_absolute_path . '/components/com_realestatemanager/photos/' . $file);
            $file = imagecopyresized($tn, $source, 0, 0, 0, 0, 258, 172, $width, $height);
            imagejpeg($tn, $mosConfig_absolute_path . '/components/com_realestatemanager/photos/' . $file_name . "_mini" . $file_type);
            break;
        case '.jpeg':
            echo 'type of your image is JPEG';
            $source = imagecreatefromjpeg($mosConfig_absolute_path . '/components/com_realestatemanager/photos/' . $file);
            $file = imagecopyresized($tn, $source, 0, 0, 0, 0, 258, 172, $width, $height);
            imagejpeg($tn, $mosConfig_absolute_path . '/components/com_realestatemanager/photos/' . $file_name . "_mini" . $file_type);
            break;
        case '.gif':
            echo 'type of your image is GIF';
            $source = imagecreatefromgif($mosConfig_absolute_path . '/components/com_realestatemanager/photos/' . $file);
            $file = imagecopyresized($tn, $source, 0, 0, 0, 0, 258, 172, $width, $height);
            imagegif($tn, $mosConfig_absolute_path . '/components/com_realestatemanager/photos/' . $file_name . "_mini" . $file_type);
            break;
        default:
            echo 'not support';
            return;
    }

    return $file_name . "_mini" . $file_type;
}

function saveHouse($option) {
    global $database, $my, $mosConfig_absolute_path, $mosConfig_live_site, $realestatemanager_configuration;

    //check how the other info should be provided
    $house = new mosRealEstateManager($database);
    //$_POST['htitle'] = $_POST['houseid'];

    $idd = $_POST['id'];
    $queryPhoto = "SELECT id FROM #__rem_photos WHERE fk_houseid = $idd ORDER BY id ASC";
    $database->setQuery($queryPhoto);
    $rowPhoto = $database->loadResultArray();

    $savePhoto = count($_POST['photo_title']);

    $prevPhoto = count($rowPhoto);
    $addiPhoto = $savePhoto - $prevPhoto;

    for ($pInd = 0; $pInd < count($rowPhoto); $pInd++) {
        $database->setQuery("UPDATE #__rem_photos SET photo_title='" . $_POST['photo_title'][$pInd + $addiPhoto] . "', image_order='" . $_POST['image_order'][$pInd + $addiPhoto] . "', need_login='0' WHERE id=" . $rowPhoto[$pInd]);
        if (!$database->query()) {
            echo "<script> alert('" . $database->getErrorMsg() . "');</script>\n";
        }
    }

    $need_log = $_POST['need_login'];
    //var_dump($need_log);
    //die();
    if (count($need_log) > 0) {
        foreach ($need_log as $need_l) {
            $database->setQuery("UPDATE #__rem_photos SET need_login='1' WHERE id='$need_l'");
            if (!$database->query()) {
                echo "<script> alert('" . $database->getErrorMsg() . "');</script>\n";
            }
        }
    }

    if (!$house->bind($_POST)) {
        echo "<script> alert('" . $house->getError() . "'); window.history.go(-1); </script>\n";
        exit();
    }

    //сохранение основного изображения 
    $uploaddir = $mosConfig_absolute_path . '/components/com_realestatemanager/photos/';

    if ($_FILES['image_link']['name'] != '') {
        $code = guid();

        $file_name = $code . '_' . str_replace(" ", "_", $_FILES['image_link']['name']);
        //$file_name = $code.'_'.$_FILES['image_link']['name'];

        $uploadfile = $uploaddir . $file_name;

        if (copy($_FILES['image_link']['tmp_name'], $uploadfile)) {
            $mini_file_name = picture_thumbnail($file_name);

            $house->image_link = $file_name;

            $idd = $_POST['houseid'];
            $database->setQuery("UPDATE #__rem_houses SET image_link='$file_name' WHERE houseid=$idd");

            if (!$database->query()) {
                echo "<script> alert('" . $database->getErrorMsg() . "');</script>\n";
            }
        }
    } //end if


    if ($_POST['edok_link'] != '')
        $house->edok_link = $_POST['edok_link'];
    //delete ehouse file if neccesary
    $delete_edoc = mosGetParam($_POST, 'delete_edoc', 0);
    if ($delete_edoc != '0') {

        $retVal = @unlink($mosConfig_absolute_path . $delete_edoc);
        $house->edok_link = "";
    }


    //storing e-house
    $edfile = $_FILES['edoc_file'];
    //check if fileupload is correct
    if ($realestatemanager_configuration['edocs']['allow'] && intval($edfile['error']) > 0 && intval($edfile['error']) < 4) {

        echo "<script> alert('" . _REALESTATE_MANAGER_LABEL_EDOCUMENT_UPLOAD_ERROR .
        "'); window.history.go(-1); </script>\n";
        exit();
    } else if ($realestatemanager_configuration['edocs']['allow'] && intval($edfile['error']) != 4) {

        $uploaddir = $mosConfig_absolute_path .
                $realestatemanager_configuration['edocs']['location'];
        $file_new = $uploaddir . $_FILES['edoc_file']['name'];
        echo $file_new;
        if (!copy($edfile['tmp_name'], $file_new)) {
            echo "<script> alert('error: not copy'); window.history.go(-1); </script>\n";
            exit();
        } else {
            $house->edok_link = $mosConfig_live_site .
                    $realestatemanager_configuration['edocs']['location'] . $edfile['name'];
        }
    }

    //************************************************** START UPLOAD FLOOR FILE **************************************************

    if ($_POST['floor_link'] != '')
        $house->floor_link = $_POST['floor_link'];
    //delete ehouse file if neccesary
    $delete_floor = mosGetParam($_POST, 'delete_floor', 0);
    if ($delete_floor != '0' || $delete_floor != '') {

        $retVal = @unlink($mosConfig_absolute_path . $delete_floor);
        $house->floor_link = "";
    }


    //storing e-house
    $flfile = $_FILES['floor_file'];
    //check if fileupload is correct
    if ($realestatemanager_configuration['edocs']['allow'] && intval($flfile['error']) > 0 && intval($flfile['error']) < 4) {

        echo "<script> alert('" . _REALESTATE_MANAGER_LABEL_EDOCUMENT_UPLOAD_ERROR .
        "'); window.history.go(-1); </script>\n";
        exit();
    } else if ($realestatemanager_configuration['edocs']['allow'] && intval($flfile['error']) != 4) {

        $uploaddir = $mosConfig_absolute_path .
                $realestatemanager_configuration['edocs']['location'];
        $file_new = $uploaddir . $_FILES['floor_file']['name'];
        echo $file_new;
        if (!copy($flfile['tmp_name'], $file_new)) {
            echo "<script> alert('error: not copy'); window.history.go(-1); </script>\n";
            exit();
        } else {
            $house->floor_link = $mosConfig_live_site .
                    $realestatemanager_configuration['edocs']['location'] . $flfile['name'];
        }
    }

    //************************************************** END UPLOAD FLOOR FILE ****************************************************
    
    //************************************************** START UPLOAD PROPERTY VIDEO IMAGE FILE **************************************************

    if ($_POST['property_video_image_link'] != '')
        $house->property_video_image_link = $_POST['property_video_image_link'];
    //delete ehouse file if neccesary
//    $delete_floor = mosGetParam($_POST, 'delete_floor', 0);
//    if ($delete_floor != '0' || $delete_floor != '') {
//
//        $retVal = @unlink($mosConfig_absolute_path . $delete_floor);
//        $house->floor_link = "";
//    }


    //storing e-house
    $property_video_image_file = $_FILES['property_video_image_file'];
    //check if fileupload is correct
    if ($realestatemanager_configuration['edocs']['allow'] && intval($property_video_image_file['error']) > 0 && intval($property_video_image_file['error']) < 4) {

        echo "<script> alert('" . _REALESTATE_MANAGER_LABEL_EDOCUMENT_UPLOAD_ERROR .
        "'); window.history.go(-1); </script>\n";
        exit();
    } else if ($realestatemanager_configuration['edocs']['allow'] && intval($property_video_image_file['error']) != 4) {

        $uploaddir = $mosConfig_absolute_path .
                $realestatemanager_configuration['edocs']['location'];
        $file_new = $uploaddir . $_FILES['property_video_image_file']['name'];
        
        echo $file_new;
        if (!copy($property_video_image_file['tmp_name'], $file_new)) {
            echo "<script> alert('error: not copy'); window.history.go(-1); </script>\n";
            exit();
        } else {
            $house->property_video_image_link = $mosConfig_live_site .
                    $realestatemanager_configuration['edocs']['location'] . $property_video_image_file['name'];
        }
    }

    //************************************************** END UPLOAD Property Video Image FILE ****************************************************

    //************************************************** START UPLOAD FEATURES LIST FILE **************************************************
//    var_dump($_POST);
    if ($_POST['features_list_link'] != '')
        $house->features_list_link = $_POST['features_list_link'];
    //delete ehouse file if neccesary
//    $delete_floor = mosGetParam($_POST, 'delete_floor', 0);
//    if ($delete_floor != '0' || $delete_floor != '') {
//
//        $retVal = @unlink($mosConfig_absolute_path . $delete_floor);
//        $house->floor_link = "";
//    }


    //storing e-house
    $feature_list_file = $_FILES['features_list_file'];
    //check if fileupload is correct
    if ($realestatemanager_configuration['edocs']['allow'] && intval($feature_list_file['error']) > 0 && intval($feature_list_file['error']) < 4) {

        echo "<script> alert('" . _REALESTATE_MANAGER_LABEL_EDOCUMENT_UPLOAD_ERROR .
        "'); window.history.go(-1); </script>\n";
        exit();
    } else if ($realestatemanager_configuration['edocs']['allow'] && intval($feature_list_file['error']) != 4) {

        $uploaddir = $mosConfig_absolute_path .
                $realestatemanager_configuration['edocs']['location'];
        $file_new = $uploaddir . $_FILES['features_list_file']['name'];
        
        echo $file_new;
        if (!copy($feature_list_file['tmp_name'], $file_new)) {
            echo "<script> alert('error: not copy'); window.history.go(-1); </script>\n";
            exit();
        } else {
            $house->features_list_link = $mosConfig_live_site .
                    $realestatemanager_configuration['edocs']['location'] . $feature_list_file['name'];
        }
    }

    //************************************************** END UPLOAD Feature List FILE ****************************************************

    //************************************************** START UPLOAD PLOT MAP FILE **************************************************

    if ($_POST['plot_map_link'] != '')
        $house->plot_map_link = $_POST['plot_map_link'];
    //delete ehouse file if neccesary
//    $delete_floor = mosGetParam($_POST, 'delete_floor', 0);
//    if ($delete_floor != '0' || $delete_floor != '') {
//
//        $retVal = @unlink($mosConfig_absolute_path . $delete_floor);
//        $house->floor_link = "";
//    }


    //storing e-house
    $plot_map_file = $_FILES['plot_map_file'];
    //check if fileupload is correct
    if ($realestatemanager_configuration['edocs']['allow'] && intval($plot_map_file['error']) > 0 && intval($plot_map_file['error']) < 4) {

        echo "<script> alert('" . _REALESTATE_MANAGER_LABEL_EDOCUMENT_UPLOAD_ERROR .
        "'); window.history.go(-1); </script>\n";
        exit();
    } else if ($realestatemanager_configuration['edocs']['allow'] && intval($plot_map_file['error']) != 4) {

        $uploaddir = $mosConfig_absolute_path .
                $realestatemanager_configuration['edocs']['location'];
        $file_new = $uploaddir . $_FILES['plot_map_file']['name'];
        echo $file_new;
        if (!copy($plot_map_file['tmp_name'], $file_new)) {
            echo "<script> alert('error: not copy'); window.history.go(-1); </script>\n";
            exit();
        } else {
            $house->plot_map_link = $mosConfig_live_site .
                    $realestatemanager_configuration['edocs']['location'] . $plot_map_file['name'];
        }
    }

    //************************************************** END UPLOAD PLOT MAP FILE ****************************************************



//************************************************** START UPLOAD LOT FILE **************************************************

    if ($_POST['lot_link'] != '')
        $house->floor_link = $_POST['lot_link'];
    //delete ehouse file if neccesary
    $delete_lot = mosGetParam($_POST, 'delete_lot', 0);
    if ($delete_lot != '0' || $delete_lot != '') {

        $retVal = @unlink($mosConfig_absolute_path . $delete_lot);
        $house->lot_link = "";
    }


    //storing e-house
    $lotfile = $_FILES['lot_file'];
    //check if fileupload is correct
    if ($realestatemanager_configuration['edocs']['allow'] && intval($lotfile['error']) > 0 && intval($lotfile['error']) < 4) {

        echo "<script> alert('" . _REALESTATE_MANAGER_LABEL_EDOCUMENT_UPLOAD_ERROR .
        "'); window.history.go(-1); </script>\n";
        exit();
    } else if ($realestatemanager_configuration['edocs']['allow'] && intval($lotfile['error']) != 4) {

        $uploaddir = $mosConfig_absolute_path .
                $realestatemanager_configuration['edocs']['location'];
        $file_new = $uploaddir . $_FILES['lot_file']['name'];

        if (!copy($lotfile['tmp_name'], $file_new)) {
            echo "<script> alert('error: not copy'); window.history.go(-1); </script>\n";
            exit();
        } else {
            $house->lot_link = $mosConfig_live_site .
                    $realestatemanager_configuration['edocs']['location'] . $lotfile['name'];
        }
    }

    //************************************************** END UPLOAD LOT FILE ****************************************************
    //************************************************** START UPLOAD SITE PLANS FILE **************************************************
    $dt = date('Y-m-s') . "_" . time();

    if ($_POST['site_plan'] != '')
        $house->site_plan = $_POST['site_plan'];
    //delete ehouse file if neccesary
    $site_plan = mosGetParam($_POST, 'site_plan', 0);
    if ($site_plan != '0' || $site_plan != '') {

        $retVal = @unlink($mosConfig_absolute_path . $site_plan);
        $house->site_plan = "";
    }


    //storing e-house
    $siteplanfile = $_FILES['site_plan'];
    //check if fileupload is correct
    if ($realestatemanager_configuration['edocs']['allow'] && intval($siteplanfile['error']) > 0 && intval($siteplanfile['error']) < 4) {

        echo "<script> alert('" . _REALESTATE_MANAGER_LABEL_EDOCUMENT_UPLOAD_ERROR .
        "'); window.history.go(-1); </script>\n";
        exit();
    } else if ($realestatemanager_configuration['edocs']['allow'] && intval($siteplanfile['error']) != 4) {

        $uploaddir = $mosConfig_absolute_path .
                $realestatemanager_configuration['edocs']['location'];
        $file_new = $uploaddir . $dt . "_" . $_FILES['site_plan']['name'];

        if (!copy($siteplanfile['tmp_name'], $file_new)) {
            echo "<script> alert('error: not copy'); window.history.go(-1); </script>\n";
            exit();
        } else {
            $house->site_plan = $mosConfig_live_site .
                    $realestatemanager_configuration['edocs']['location'] . $dt . "_" . $siteplanfile['name'];
        }
    }

    //************************************************** END UPLOAD SITE PLANS FILE ****************************************************
    //************************************************** START UPLOAD BLUEPRINTS FILE **************************************************
    $dt = date('Y-m-s') . "_" . time();
    if ($_POST['blueprints'] != '')
        $house->site_plan = $_POST['blueprints'];
    //delete ehouse file if neccesary
    $blueprints = mosGetParam($_POST, 'blueprints', 0);
    if ($blueprints != '0' || $blueprints != '') {

        $retVal = @unlink($mosConfig_absolute_path . $blueprints);
        $house->blueprints = "";
    }
    //storing e-house
    $blueprintsfile = $_FILES['blueprints'];
    //check if fileupload is correct
    if ($realestatemanager_configuration['edocs']['allow'] && intval($blueprintsfile['error']) > 0 && intval($blueprintsfile['error']) < 4) {

        echo "<script> alert('" . _REALESTATE_MANAGER_LABEL_EDOCUMENT_UPLOAD_ERROR .
        "'); window.history.go(-1); </script>\n";
        exit();
    } else if ($realestatemanager_configuration['edocs']['allow'] && intval($blueprintsfile['error']) != 4) {

        $uploaddir = $mosConfig_absolute_path .
                $realestatemanager_configuration['edocs']['location'];
        $file_new = $uploaddir . $dt . "_" . $_FILES['blueprints']['name'];

        if (!copy($blueprintsfile['tmp_name'], $file_new)) {
            echo "<script> alert('error: not copy'); window.history.go(-1); </script>\n";
            exit();
        } else {
            $house->blueprints = $mosConfig_live_site .
                    $realestatemanager_configuration['edocs']['location'] . $dt . "_" . $blueprintsfile['name'];
        }
    }

    //************************************************** END UPLOAD BLUEPRINTS FILE ****************************************************
    //************************************************** START UPLOAD SCHEMATICS FILE **************************************************
    $dt = date('Y-m-s') . "_" . time();
    if ($_POST['schematics'] != '')
        $house->site_plan = $_POST['schematics'];
    //delete ehouse file if neccesary
    $schematics = mosGetParam($_POST, 'schematics', 0);
    if ($schematics != '0' || $schematics != '') {

        $retVal = @unlink($mosConfig_absolute_path . $schematics);
        $house->schematics = "";
    }


    //storing e-house
    $schematicsfile = $_FILES['schematics'];
    //check if fileupload is correct
    if ($realestatemanager_configuration['edocs']['allow'] && intval($schematicsfile['error']) > 0 && intval($schematicsfile['error']) < 4) {

        echo "<script> alert('" . _REALESTATE_MANAGER_LABEL_EDOCUMENT_UPLOAD_ERROR .
        "'); window.history.go(-1); </script>\n";
        exit();
    } else if ($realestatemanager_configuration['edocs']['allow'] && intval($schematicsfile['error']) != 4) {

        $uploaddir = $mosConfig_absolute_path .
                $realestatemanager_configuration['edocs']['location'];
        $file_new = $uploaddir . $dt . "_" . $_FILES['schematics']['name'];

        if (!copy($schematicsfile['tmp_name'], $file_new)) {
            echo "<script> alert('error: not copy'); window.history.go(-1); </script>\n";
            exit();
        } else {
            $house->schematics = $mosConfig_live_site .
                    $realestatemanager_configuration['edocs']['location'] . $dt . "_" . $schematicsfile['name'];
        }
    }

    //************************************************** END UPLOAD SCHEMATICS FILE ****************************************************


    /* $file = $_FILES['picture_file'];

      //check if fileupload is correct
      if($file['size'] != 0 && ( $file['error'] != 0
      || strpos($file['type'],'image') === false
      ||strpos($file['type'],'image')===""))
      {
      echo "<script> alert('" . _REALESTATE_MANAGER_LABEL_PICTURE_URL_UPLOAD_ERROR . "'); window.history.go(-1); </script>\n";
      exit ();

      } */


    if (is_string($house)) {
        echo "<script> alert('" . $house . "'); window.history.go(-1); </script>\n";
        exit();
    }

    $house->date = date("Y-m-d H:i:s");
    /* 	if (!$house->check()) {
      echo "<script> alert('".$house->getError()."'); window.history.go(-1); </script>\n";
      exit ();
      } */

    //remove escaped slashes
    if (get_magic_quotes_gpc()) {
        $house->description = stripslashes($house->description);
    }

    if (!$house->store()) {
        echo "<script> alert('" . $house->getError() . "'); window.history.go(-1); </script>\n";
        exit();
    }

    //$house->checkin();
    //$house->updateOrder( "catid='$house->catid'" );
    //$house->updateOrder("catid='$row->catid'");
    //$id = $row->id;
    $photo_title = $_POST['photo_title'];
    $image_order = $_POST['image_order'];
    $as_featured_image = $_POST['as_featured_image'];
    $need_login = $_POST['need_login'];

    //сохранение динамических файлов в папку photos
    $uploaddir = $mosConfig_absolute_path . '/components/com_realestatemanager/photos/';

    if (array_key_exists("new_photo_file", $_FILES)) {
        for ($i = 0; $i <= count($_FILES['new_photo_file']['name']); $i++) {
            $code = guid();
            //$file_name = $code.'_'.$_FILES['new_photo_file']['name'][$i];
            $file_name = $code . '_' . str_replace(" ", "_", $_FILES['new_photo_file']['name'][$i]);
            $uploadfile = $uploaddir . $file_name;
            if (copy($_FILES['new_photo_file']['tmp_name'][$i], $uploadfile)) {
                $mini_file_name = picture_thumbnail($file_name);
                $ptitle = $photo_title[$i];
                $imgorder = $image_order[$i];
                $as_featured = $as_featured_image[$i];
                $need_login2 = $need_login[$i];

                $database->setQuery("INSERT INTO #__rem_photos VALUES ( '','$house->id','$ptitle', '$mini_file_name','$file_name','$imgorder','$as_featured','0' )");
                if (!$database->query()) {
                    echo "<script> alert('" . $database->getErrorMsg() . "');</script>\n";
                    $mini_file_name = picture_thumbnail($file_name);
                }
            }
        }
    }  //end if
    //echo $ptitle = $photo_title[$i];print_r($photo_title);

    if (array_key_exists("del_main_photo", $_POST)) {
        $del_main_photo = $_POST['del_main_photo'];

        if ($del_main_photo != '') {
            $house->image_link = '';
            @unlink($mosConfig_absolute_path . '/components/com_realestatemanager/photos/' .
                            $del_main_photo);
            //разделение имени файла на имя и расширение

            $del_main_pth = pathinfo($del_main_photo);
            $del_main_photo_type = '.' . $del_main_pth['extension'];
            $del_main_photo_name = basename($del_main_photo, $del_main_photo_type);

            /* $del_main_photo_name = substr($del_main_photo, 0, strlen($del_main_photo)-4);
              $del_main_photo_type = substr($del_main_photo, strlen($del_main_photo)-4); */
            @unlink($mosConfig_absolute_path . '/components/com_realestatemanager/photos/' .
                            $del_main_photo_name . "_mini" . $del_main_photo_type);
        }
        @unlink($mosConfig_absolute_path . '/components/com_realestatemanager/photos/' .
                        $del_main_photo);
        //�?зменения в базе данных
        $idd = $_POST['houseid'];
        $database->setQuery("UPDATE #__rem_houses SET image_link='' WHERE houseid=$idd");
        if (!$database->query()) {
            echo "<script> alert('" . $database->getErrorMsg() . "');</script>\n";
        }
    } //end if	


    if (count($_POST['del_photos']) != 0) {
        for ($i = 0; $i < count($_POST['del_photos']); $i++) {
            //echo $_POST['del_photos'][$i];
            $del_photo = $_POST['del_photos'][$i];
            $database->setQuery("DELETE FROM #__rem_photos WHERE main_img='$del_photo'");
            if ($database->query()) {
                unlink($mosConfig_absolute_path . '/components/com_realestatemanager/photos/' .
                        $del_photo);
                //разделение имени файла на имя и расширение
                $del_pth = pathinfo($del_photo);
                $del_photo_type = '.' . $del_pth['extension'];
                $del_photo_name = basename($del_photo, $del_photo_type);

                /* $del_photo_name = substr($del_photo, 0, strlen($del_photo)-4);
                  $del_photo_type = substr($del_photo, strlen($del_photo)-4); */
                unlink($mosConfig_absolute_path . '/components/com_realestatemanager/photos/' .
                        $del_photo_name . "_mini" . $del_photo_type);
            }
        }
    }

    $house->checkin();
    $house->updateOrder("catid='$house->catid'");

    mosRedirect("index2.php?option=$option");
}

/**
 * Deletes one or more records
 * @param array - An array of unique category id numbers
 * @param string - The current author option
 */
////////////////////////////
function guid() {
    if (function_exists('com_create_guid')) {
        return com_create_guid();
    } else {
        mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45); // "-"
        $uuid = //chr(123)// "{"
                substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12);
        //.chr(125);// "}"
        return $uuid;
    }
}

////////////////////////////

function removeHouses($bid, $option) {

    global $database;

    if (!is_array($bid) || count($bid) < 1) {
        echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>\n";
        exit;
    }

    if (count($bid)) {
        $bids = implode(',', $bid);

        $database->setQuery("DELETE FROM #__rem_review WHERE fk_houseid IN ($bids)");
        if (!$database->query()) {
            echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
        }

        $database->setQuery("SELECT thumbnail_img, main_img FROM #__rem_photos WHERE fk_houseid IN ($bids)");
        $del_photos = $database->loadObjectList();

        @unlink($mosConfig_absolute_path . '/components/com_realestatemanager/photos/' . $del_photos[0]->location);

        $database->setQuery("DELETE FROM #__rem_photos WHERE fk_houseid IN ($bids)");
        if (!$database->query()) {
            echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
        }

        $database->setQuery("DELETE FROM #__rem_houses WHERE id IN ($bids)");
        if (!$database->query()) {
            echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
        }
    }

    mosRedirect("index2.php?option=$option");
}

/**
 * Publishes or Unpublishes one or more records
 * @param array - An array of unique category id numbers
 * @param integer - 0 if unpublishing, 1 if publishing
 * @param string - The current author option
 */
function publishHouses($bid, $publish, $option) {

    global $database, $my;

    $catid = mosGetParam($_POST, 'catid', array(0));

    if (!is_array($bid) || count($bid) < 1) {
        $action = $publish ? 'publish' : 'unpublish';
        echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
        exit;
    }

    $bids = implode(',', $bid);

    $database->setQuery("UPDATE #__rem_houses SET published='$publish'" .
            "\nWHERE id IN ($bids) AND (checked_out=0 OR (checked_out='$my->id'))");
    if (!$database->query()) {
        echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
        exit();
    }

    if (count($bid) == 1) {
        $row = new mosRealEstateManager($database);
        $row->checkin($bid[0]);
    }

    mosRedirect("index2.php?option=$option");
}

/**
 * Moves the order of a record
 * @param integer - The increment to reorder by
 */
function orderHouses($bid, $inc, $option) {

    global $database;

    $house = new mosRealEstateManager($database);
    $house->load($bid);
    $house->move($inc);
    mosRedirect("index2.php?option=$option");
}

/**
 * Cancels an edit operation
 * @param string - The current author option
 */
function cancelHouse($option) {

    global $database;
    $row = new mosRealEstateManager($database);
    $row->bind($_POST);
    $row->checkin();
    mosRedirect("index2.php?option=$option");
}

function configure_save_frontend($option) {
    global $my, $realestatemanager_configuration;

    $str = '';
    $supArr = array();
    $supArr = mosGetParam($_POST, 'edocs_registrationlevel', 0);
    for ($i = 0; $i < count($supArr); $i++)
        $str.=$supArr[$i] . ',';
    $str = substr($str, 0, -1);
    $realestatemanager_configuration['edocs']['registrationlevel'] = $str;

    $str = '';
    $supArr = mosGetParam($_POST, 'reviews_registrationlevel', 0);
    for ($i = 0; $i < count($supArr); $i++)
        $str.=$supArr[$i] . ',';
    $str = substr($str, 0, -1);
    $realestatemanager_configuration['reviews']['registrationlevel'] = $str;

    $str = '';
    $supArr = mosGetParam($_POST, 'rentrequest_registrationlevel', 0);
    for ($i = 0; $i < count($supArr); $i++)
        $str.=$supArr[$i] . ',';
    $str = substr($str, 0, -1);
    $realestatemanager_configuration['rentrequest']['registrationlevel'] = $str;



//**********   begin add button 'buy now'   *****************************
    $str = '';
    $supArr = mosGetParam($_POST, 'buy_now_allow_categories', 0);
    for ($i = 0; $i < count($supArr); $i++)
        $str.=$supArr[$i] . ',';
    $str = substr($str, 0, -1);
    $realestatemanager_configuration['buy_now']['allow']['categories'] = $str;

    $realestatemanager_configuration['buy_now']['show'] = mosGetParam($_POST, 'buy_now_show', 0);
//*************   end add button 'buy now'   ***********************


    $realestatemanager_configuration['reviews']['show'] = mosGetParam($_POST, 'reviews_show', 0);
    $realestatemanager_configuration['rentstatus']['show'] = mosGetParam($_POST, 'rentstatus_show', 0);
    $realestatemanager_configuration['edocs']['show'] = mosGetParam($_POST, 'edocs_show', 0);
    $realestatemanager_configuration['price']['show'] = mosGetParam($_POST, 'price_show', 0);
    $realestatemanager_configuration['foto']['high'] = mosGetParam($_POST, 'foto_high');
    $realestatemanager_configuration['foto']['width'] = mosGetParam($_POST, 'foto_width');
    $realestatemanager_configuration['page']['items'] = mosGetParam($_POST, 'page_items');
    //add for show in category picture
    $realestatemanager_configuration['cat_pic']['show'] = mosGetParam($_POST, 'cat_pic_show');

    //add for show subcategory 
    $realestatemanager_configuration['subcategory']['show'] = mosGetParam($_POST, 'subcategory_show');

    //google Map key
    $realestatemanager_configuration['google_map']['key'] = mosGetParam($_POST, 'google_map_key');

    mosRealEstateManagerOthers :: setParams();
}

function configure_save_backend($option) {

    global $my, $realestatemanager_configuration;

    $realestatemanager_configuration['edocs']['allow'] = mosGetParam($_POST, 'edocs_allow', 0);
    $realestatemanager_configuration['edocs']['location'] = mosGetParam($_POST, 'edocs_location', "/components/com_realestatemanager/edocs/");

    mosRealEstateManagerOthers :: setParams();
}

function configure($option) {

//configure_frontend
    global $my, $realestatemanager_configuration, $acl, $database;

    $yesno[] = mosHTML :: makeOption('1', _REALESTATE_MANAGER_YES);
    $yesno[] = mosHTML :: makeOption('0', _REALESTATE_MANAGER_NO);

    $gtree[] = mosHTML :: makeOption('-2', 'Everyone');
    $gtree = array_merge($gtree, $acl->get_group_children_tree(null, 'USERS', false));

    $lists = array();
    $f = "";
    $s = explode(',', $realestatemanager_configuration['reviews']['registrationlevel']);
    for ($i = 0; $i < count($s); $i++)
        $f[] = mosHTML::makeOption($s[$i]);

    $lists['reviews']['show'] = mosHTML :: RadioList($yesno, 'reviews_show', 'class="inputbox"', $realestatemanager_configuration['reviews']['show'], 'value', 'text');
    $lists['reviews']['registrationlevel'] = mosHTML::selectList($gtree, 'reviews_registrationlevel[]', 'size="4" multiple="multiple"', 'value', 'text', $f);

    $f = "";
    $s = explode(',', $realestatemanager_configuration['rentrequest']['registrationlevel']);
    for ($i = 0; $i < count($s); $i++)
        $f[] = mosHTML::makeOption($s[$i]);

    $lists['rentstatus']['show'] = mosHTML :: RadioList($yesno, 'rentstatus_show', 'class="inputbox"', $realestatemanager_configuration['rentstatus']['show'], 'value', 'text');

    $lists['rentrequest']['registrationlevel'] = mosHTML::selectList($gtree, 'rentrequest_registrationlevel[]', 'size="4" multiple="multiple"', 'value', 'text', $f);

    $f = "";
    $s = explode(',', $realestatemanager_configuration['edocs']['registrationlevel']);
    for ($i = 0; $i < count($s); $i++)
        $f[] = mosHTML::makeOption($s[$i]);

    $lists['edocs']['registrationlevel'] = mosHTML::selectList($gtree, 'edocs_registrationlevel[]', 'size="4" multiple="multiple"', 'value', 'text', $f);

    $lists['edocs']['show'] = mosHTML :: RadioList($yesno, 'edocs_show', 'class="inputbox"', $realestatemanager_configuration['edocs']['show'], 'value', 'text');

    $lists['price']['show'] = mosHTML :: RadioList($yesno, 'price_show', 'class="inputbox"', $realestatemanager_configuration['price']['show'], 'value', 'text');

//********   begin add button 'buy now'   ************************
    $ctree[] = mosHTML :: makeOption('-2', 'All Categories');

    $id = 0;
    $list = CAT_Utils::categoryArray();
    $cat = new mosCategory($database);
    $cat->load($id);

    $this_treename = '';
    foreach ($list as $item) {
        if ($this_treename) {
            if ($item->id != $cat->id && strpos($item->treename, $this_treename) === false) {
                $options[] = mosHTML::makeOption($item->id, $item->treename);
            }
        } else {
            if ($item->id != $cat->id) {
                $options[] = mosHTML::makeOption($item->id, $item->treename);
            } else {
                $this_treename = "$item->treename/";
            }
        }
    }

    if (count($list) > 0) {
        $ctree = array_merge($ctree, $options);
    }

    $f = "";
    $s = explode(',', $realestatemanager_configuration['buy_now']['allow']['categories']);
    for ($i = 0; $i < count($s); $i++)
        $f[] = mosHTML::makeOption($s[$i]);

    /*  $lists['buy_now']['show'] = mosHTML :: RadioList($yesno, 'buy_now_show', 'class="inputbox"',
      $realestatemanager_configuration['buy_now']['show'], 'value', 'text');

      $lists['buy_now']['allow']['categories'] = mosHTML::selectList( $ctree, 'buy_now_allow_categories[]', 'size="4"
      multiple="multiple"', 'value', 'text', $f); */
//*************   end add button 'buy now'   ************************


    $lists['foto']['high'] = '<input type="text" name="foto_high"
    value="' . $realestatemanager_configuration['foto']['high'] .
            '" class="inputbox" size="4" maxlength="4" title="" />';

    $lists['foto']['width'] = '<input type="text" name="foto_width"
    value="' . $realestatemanager_configuration['foto']['width'] .
            '" class="inputbox" size="4" maxlength="4" title="" />';

    $lists['page']['items'] = '<input type="text" name="page_items"
    value="' . $realestatemanager_configuration['page']['items'] .
            '" class="inputbox" size="2" maxlength="2" title="" />';

    //add for show in category picture
    $lists['cat_pic']['show'] = mosHTML :: RadioList($yesno, 'cat_pic_show', 'class="inputbox"', $realestatemanager_configuration['cat_pic']['show'], 'value', 'text');

    //add for show subcategory 
    $lists['subcategory']['show'] = mosHTML :: RadioList($yesno, 'subcategory_show', 'class="inputbox"', $realestatemanager_configuration['subcategory']['show'], 'value', 'text');

    //google Map key
    $lists['google_map']['key'] = '<input type="text" name="google_map_key" 
    value="' . $realestatemanager_configuration['google_map']['key'] .
            '" class="inputbox" size="80" maxlength="200" title="" />';


//configure_backend


    $lists['edocs']['allow'] = mosHTML :: RadioList($yesno, 'edocs_allow', 'class="inputbox"', $realestatemanager_configuration['edocs']['allow'], 'value', 'text');

    $lists['edocs']['location'] = '<input type="text" name="edocs_location" value="' . $realestatemanager_configuration['edocs']['location'] . '" class="inputbox" size="50" maxlength="50" title="" />';


    HTML_realestatemanager :: showConfiguration($lists, $option);
}

function rent($option, $bid) {

    global $database, $my;

    if (!is_array($bid) || count($bid) < 1) {
        echo "<script> alert('Select an item to rent'); window.history.go(-1);</script>\n";
        exit;
    }

    $bids = implode(',', $bid);

    $select = "SELECT a.*, cc.name AS category, l.id as rentid, l.rent_from as rent_from, " .
            "l.rent_return as rent_return, l.rent_until as rent_until, " .
            "l.user_name as user_name, l.user_email as user_email " .
            "\nFROM #__rem_houses AS a" .
            "\nLEFT JOIN #__categories AS cc ON cc.id = a.catid" .
            "\nLEFT JOIN #__rem_rent AS l ON l.id = a.fk_rentid" .
            "\nWHERE a.id in (" . $bids . ")";

    $database->setQuery($select);

    if (!$database->query()) {
        echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
        exit();
    }



    $houses = $database->loadObjectList();


    //for rent or not
    $count = count($houses);
    for ($i = 0; $i < $count; $i++) {
        if ($houses[$i]->rent_from != '' || $houses[$i]->rent_until != '') {
            ?>
            <script type = "text/JavaScript" language = "JavaScript">
                alert('This house is already rent');
                window.history.go(-1);
            </script>
            <?php

            exit;
        }
        if ($houses[$i]->listing_type != 'house for rent' && $houses[$i]->listing_type != 'room for rent' && $houses[$i]->listing_type != 'sublet') {
            ?>
            <script type = "text/JavaScript" language = "JavaScript">
                alert('This house is not for rent');
                window.history.go(-1);
            </script>
            <?php

            exit;
        }
    }
    // get list of categories

    $userlist[] = mosHTML :: makeOption('-1', '----------');
    $database->setQuery("SELECT id AS value, name AS text from #__users ORDER BY name");
    $userlist = array_merge($userlist, $database->loadObjectList());
    $usermenu = mosHTML :: selectList($userlist, 'userid', 'class="inputbox" size="1"', 'value', 'text', '-1');

    HTML_realestatemanager :: showRentHouses($option, $houses, $usermenu, "rent");
}

function rent_return($option, $bid) {

    global $database, $my;
    if (!is_array($bid) || count($bid) < 1) {
        echo "<script> alert('Select an item to rent'); window.history.go(-1);</script>\n";
        exit;
    }
    $bids = implode(',', $bid);


    //for databases without subselect
    $select = "SELECT a.*, cc.name AS category, l.id as rentid, l.rent_from as rent_from, " .
            "l.rent_return as rent_return, l.rent_until as rent_until, " .
            "l.user_name as user_name, l.user_email as user_email " .
            "\nFROM #__rem_houses AS a" .
            "\nLEFT JOIN #__categories AS cc ON cc.id = a.catid" .
            "\nLEFT  JOIN #__rem_rent AS l ON l.id = a.fk_rentid" .
            "\nWHERE a.id in (" . $bids . ")";

    $database->setQuery($select);

    if (!$database->query()) {
        echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
        exit();
    }

    $houses = $database->loadObjectList();

    $count = count($houses);
    for ($i = 0; $i < $count; $i++) {
        if ($houses[$i]->listing_type != 'house for rent' && $houses[$i]->listing_type != 'room for rent' && $houses[$i]->listing_type != 'sublet') {
            ?>
            <script type = "text/JavaScript" language = "JavaScript">
                alert('This house is not for rent');
                window.history.go(-1);
            </script>
            <?php

            exit;
        }
    }
    for ($i = 0; $i < 1; $i++) {
        if ((($houses[$i]->rent_from) == '') && (($houses[$i]->rent_return) == '')) {
            /*
              echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
              exit ();
             */
            ?>
            <script type = "text/JavaScript" language = "JavaScript">
                alert('You can not return houses that were not lent out');
                window.history.go(-1);
            </script>
            <?php

            exit;
        }
    }
    // get list of users
    $userlist[] = mosHTML :: makeOption('-1', '----------');
    $database->setQuery("SELECT id AS value, name AS text from #__users ORDER BY name");
    $userlist = array_merge($userlist, $database->loadObjectList());
    $usermenu = mosHTML :: selectList($userlist, 'userid', 'class="inputbox" size="1"', 'value', 'text', '-1');

    HTML_realestatemanager :: showRentHouses($option, $houses, $usermenu, "rent_return");
}

function saveRent($option, $bids) {

    global $database;

    if (!is_array($bids) || count($bids) < 1) {
        echo "<script> alert('Select an item to rent'); window.history.go(-1);</script>\n";
        exit;
    }

    for ($i = 0, $n = count($bids); $i < $n; $i++) {
        $id = $bids[$i];
        $rent = new mosRealEstateManager_rent($database);

        $rent->rent_from = date("Y-m-d H:i:s");
        if (mosGetParam($_POST, 'rent_until') != "") {
            $rent->rent_until = mosGetParam($_POST, 'rent_until');
        } else {
            $rent->rent_until = null;
        }

        $rent->fk_houseid = $id;

        $userid = mosGetParam($_POST, 'userid');

        if ($userid == "-1") {
            $rent->user_name = mosGetParam($_POST, 'user_name', '');
            $rent->user_email = mosGetParam($_POST, 'user_email', '');
        } else {
            $rent->getRentTo(intval($userid));
        }

        if (!$rent->check($rent)) {
            echo "<script> alert('" . $rent->getError() . "'); window.history.go(-1); </script>\n";
            exit();
        }

        if (!$rent->store()) {
            echo "<script> alert('" . $rent->getError() . "'); window.history.go(-1); </script>\n";
            exit();
        }
        $rent->checkin();
        $house = new mosRealEstateManager($database);
        $house->load($id);
        $house->fk_rentid = $rent->id;
        $house->store();
        $house->checkin();
    }
    mosRedirect("index2.php?option=$option");
}

function saveRent_return($option, $lids) {

    global $database, $my;

    if (!is_array($lids) || count($lids) < 1) {
        echo "<script> alert('Select an item to return'); window.history.go(-1);</script>\n";
        exit;
    }
    for ($i = 0, $n = count($lids); $i < $n; $i++) {
        $id = $lids[$i];
        $rent = new mosRealEstateManager_rent($database);
        $rent->load(intval($id));
        $rent->rent_return = date("Y-m-d H:i:s");
        if (!$rent->check($rent)) {
            echo "<script> alert('" . $rent->getError() . "'); window.history.go(-1); </script>\n";
            exit();
        }

        if (!$rent->store()) {
            echo "<script> alert('" . $rent->getError() . "'); window.history.go(-1); </script>\n";
            exit();
        }
        $rent->checkin();
        $house = new mosRealEstateManager($database);
        $house->load($rent->fk_houseid);
        $house->fk_rentid = 0;
        $house->store(true);
        $house->checkin(true);
    }
    mosRedirect("index2.php?option=$option");
}

function import($option) {

    global $database, $my;

    $file = file($_FILES['import_file']['tmp_name']);
    $catid = mosGetParam($_POST, 'import_catid');

//***********************   begin add for XML format   ***************************************
    $type = mosGetParam($_POST, 'import_type');
    switch ($type) {
        //CSV=='1' XML=='2'
        case '1':
            $retVal = mosRealEstateManagerImportExport :: importHousesCSV($file, $catid);
            HTML_realestatemanager:: showImportResult($retVal, $option);
            break;

        case '2':
            $retVal = mosRealEstateManagerImportExport :: importHousesXML($_FILES['import_file']['tmp_name'], $catid);
            HTML_realestatemanager:: showImportResult($retVal, $option);
            break;

        case '3':
            $ret = mosRealEstateManagerImportExport::remove_info();
            if ($ret != "")
                return;
            $retVal = mosRealEstateManagerImportExport :: importHousesXML($_FILES['import_file']['tmp_name'], null);
            HTML_realestatemanager:: showImportResult($retVal, $option);
            break;
//***********************   end add for XML format   *****************************************
//	$retVal = mosRealEstateManagerImportExport :: importHousesCSV($file, $catid);//old CSV
    }
}

function export($option) {
    global $database, $my, $mainframe;

    $catid = mosGetParam($_POST, 'export_catid', 0);
    $rent = mosGetParam($_POST, 'export_rent', null);
    $pub = mosGetParam($_POST, 'export_pub', null);
    $type = mosGetParam($_POST, 'export_type', 0);

    $search = $mainframe->getUserStateFromRequest("search{$option}", 'search', '');
    $search = $database->getEscaped(trim(strtolower($search)));

    $where = array();

    if ($rent == "rent") {
        array_push($where, "a.fk_rentid <> 0");
    } else if ($rent == "not_rent") {
        array_push($where, "a.fk_rentid = 0");
    }
    if ($pub == "pub") {
        array_push($where, "a.published = 1");
    } else if ($pub == "not_pub") {
        array_push($where, "a.published = 0");
    }
    if ($catid > 0) {
        array_push($where, "a.catid='$catid'");
    }

    /*
      if ($search) {
      array_push($where, "(LOWER(a.title) LIKE '%$search%' OR LOWER(a.authors) LIKE '%$search%' OR LOWER(a.mls) LIKE '%$search%' OR LOWER(a.comment) LIKE '%$search%')");
      }
     */

    $selectstring = "SELECT id FROM #__rem_houses AS a " .
            (count($where) ? " WHERE " . implode(' AND ', $where) : "") .
            " ORDER BY a.catid, a.ordering";
    $database->setQuery($selectstring);
    $bids = $database->loadObjectList();

    if ($database->getErrorNum()) {
        echo $database->stderr();
        return;
    }

    $houses = array();
    $count = 0;
    foreach ($bids as $bid) {
        $house = new mosRealEstateManager($database);
        // load the row from the db table
        $house->load(intval($bid->id));
        $houses[$count] = $house;
        $count++;
    }

    //parsing in title and commenr symbol '|'
    $order = array("\r\n", "\n", "\r");
    for ($i = 0; $i < count($houses); $i++) {
        $houses[$i]->htitle = str_replace('|', '-', $houses[$i]->htitle);
        $houses[$i]->htitle = str_replace($order, ' ', $houses[$i]->htitle);
        $houses[$i]->description = str_replace('|', '-', $houses[$i]->description);
        $houses[$i]->description = str_replace($order, ' ', $houses[$i]->description);
        $houses[$i]->hlocation = str_replace('|', '-', $houses[$i]->hlocation);
        $houses[$i]->hlocation = str_replace($order, ' ', $houses[$i]->hlocation);
        $houses[$i]->agent = str_replace('|', '-', $houses[$i]->agent);
        $houses[$i]->agent = str_replace($order, ' ', $houses[$i]->agent);
        $houses[$i]->area = str_replace('|', '-', $houses[$i]->area);
        $houses[$i]->area = str_replace($order, ' ', $houses[$i]->area);
        $houses[$i]->feature = str_replace('|', '-', $houses[$i]->feature);
        $houses[$i]->feature = str_replace($order, ' ', $houses[$i]->feature);
        $houses[$i]->hoa_dues = str_replace('|', '-', $houses[$i]->hoa_dues);
        $houses[$i]->hoa_dues = str_replace($order, ' ', $houses[$i]->hoa_dues);
        $houses[$i]->model = str_replace('|', '-', $houses[$i]->model);
        $houses[$i]->model = str_replace($order, ' ', $houses[$i]->model);
        $houses[$i]->school = str_replace('|', '-', $houses[$i]->school);
        $houses[$i]->school = str_replace($order, ' ', $houses[$i]->school);
        $houses[$i]->school_district = str_replace('|', '-', $houses[$i]->school_district);
        $houses[$i]->school_district = str_replace($order, ' ', $houses[$i]->school_district);
        $houses[$i]->style = str_replace('|', '-', $houses[$i]->style);
        $houses[$i]->style = str_replace($order, ' ', $houses[$i]->style);
        $houses[$i]->zoning = str_replace('|', '-', $houses[$i]->zoning);
        $houses[$i]->zoning = str_replace($order, ' ', $houses[$i]->zoning);
    }

    // begin add for Export XML all record
    $type2 = 'xml';
    switch ($type) {
        case '1':
            $type2 = 'csv';
            //move to xml - all data
            $retVal = mosRealEstateManagerImportExport :: exportHousesXML($houses, false);
            break;
        case '2':
            $type2 = 'xml';
            //move to xml - some category
            $retVal = mosRealEstateManagerImportExport :: exportHousesXML($houses, false);
            break;
        case '3':
            $type2 = 'xml';
            //move to xml - all data
            $retVal = mosRealEstateManagerImportExport :: exportHousesXML($houses, true);
            break;
    }

    $InformationArray = mosRealEstateManagerImportExport :: storeExportFile($retVal, $type2);
    HTML_realestatemanager :: showExportResult($InformationArray, $option);
}

function importExportHouses($option) {
    global $database;

    // get list of categories
    $categories[] = mosHTML :: makeOption('0', _REALESTATE_MANAGER_LABEL_SELECT_CATEGORIES);
    $database->setQuery("SELECT id AS value, name AS text FROM #__categories" . "\nWHERE section='$option' ORDER BY ordering");
    $categories = array_merge($categories, $database->loadObjectList());

    if (count($categories) < 1) {
        mosRedirect("index2.php?option=com_realestatemanager&section=categories", _REALESTATE_MANAGER_ADMIN_IMPEXP_ADD);
    }

    $impclist = mosHTML :: selectList($categories, 'import_catid', 'class="inputbox" size="1" id="import_catid"', 'value', 'text', 0);
    $expclist = mosHTML :: selectList($categories, 'export_catid', 'class="inputbox" size="1" id="export_catid"', 'value', 'text', 0);

    $params = array();
    $params['import']['category'] = $impclist;
    $params['export']['category'] = $expclist;

    $importtypes[0] = mosHTML :: makeOption('0', _REALESTATE_MANAGER_ADMIN_PLEASE_SEL);
    $importtypes[1] = mosHTML :: makeOption('1', _REALESTATE_MANAGER_ADMIN_FORMAT_CSV);
    $importtypes[2] = mosHTML :: makeOption('2', _REALESTATE_MANAGER_ADMIN_FORMAT_XML);
    $importtypes[3] = mosHTML :: makeOption('3', _REALESTATE_MANAGER_ADMIN_ENTIRE_RECOVER);

    $params['import']['type'] = mosHTML :: selectList($importtypes, 'import_type', 'id="import_type" class="inputbox" size="1" onchange = "impch();"', 'value', 'text', 0);

    $exporttypes[0] = mosHTML :: makeOption('0', _REALESTATE_MANAGER_ADMIN_PLEASE_SEL);
    $exporttypes[1] = mosHTML :: makeOption('1', _REALESTATE_MANAGER_ADMIN_FORMAT_CSV);
    $exporttypes[2] = mosHTML :: makeOption('2', _REALESTATE_MANAGER_ADMIN_FORMAT_XML);
    $exporttypes[3] = mosHTML :: makeOption('3', _REALESTATE_MANAGER_ADMIN_ENTIRE_BU);

    $params['export']['type'] = mosHTML :: selectList($exporttypes, 'export_type', 'id="export_type" class="inputbox" size="1" onchange="expch();"', 'value', 'text', 0);

    HTML_realestatemanager :: showImportExportHouses($params, $option);
}
?>