<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );

/**
*
* @package  RealEstateManager
* @copyright 2009 Andrey Kvasnevskiy-OrdaSoft(akbet@mail.ru); Rob de Cleen(rob@decleen.com); 
* Homepage: http://www.ordasoft.com
* @version: 1.0 Basic $
*  @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
/**
* This file provides compatibility for RealEstateManager on Joomla! 1.0.x and Joomla! 1.5
*
*/


/**
 * Legacy function, use <jdoc:include type="module" /> instead
 *
 * @deprecated		As of version 1.5
 */
if ( !function_exists('mosLoadModule')) {
  function mosLoadModule( $name, $style=-1 ) {
    ?><jdoc:include type="module" name="<?php echo $name ?>" style="<?php echo $style ?>" /><?php
  }
}

/**
 * Legacy function, using <jdoc:include type="modules" /> instead
 *
 * @deprecated  As of version 1.5
 */
if ( !function_exists('mosMail')) {
  function mosMail($from, $fromname, $recipient, $subject, $body, $mode=0, $cc=NULL, $bcc=NULL, $attachment=NULL, $replyto=NULL, $replytoname=NULL ) {
    return JUTility::sendMail($from, $fromname, $recipient, $subject, $body, $mode, $cc, $bcc, $attachment, $replyto, $replytoname );
  }
}

if ( !function_exists('mosLoadAdminModules')) {
  function mosLoadAdminModules( $position='left', $style=0 ) {

    // Select the module chrome function
    if (is_numeric($style))
    {
      switch ( $style )
      {
        case 2:
          $style = 'xhtml';
          break;
  
        case 0  :
        default :
          $style = 'raw';
          break;
      }
    }
    ?><jdoc:include type="modules" name="<?php echo $position ?>" style="<?php echo $style ?>" /><?php
  }
}

/**
 * Legacy function, using <jdoc:include type="module" /> instead
 *
 * @deprecated  As of version 1.5
 */
if ( !function_exists('mosLoadAdminModule')) {
  function mosLoadAdminModule( $name, $style=0 ) {
    ?><jdoc:include type="module" name="<?php echo $name ?>" style="<?php echo $style ?>" /><?php
  }
}

/**
 * Legacy function, always use {@link JRequest::getVar()} instead
 *
 * @deprecated  As of version 1.5
 */
if ( !function_exists('mosStripslashes')) {
  function mosStripslashes( &$value )
  {
    $ret = '';
    if (is_string( $value )) {
      $ret = stripslashes( $value );
    } else {
      if (is_array( $value )) {
        $ret = array();
        foreach ($value as $key => $val) {
          $ret[$key] = mosStripslashes( $val );
        }
      } else {
        $ret = $value;
      }
    }
    return $ret;
  }
}

/**
 * Legacy function, use {@link JFolder::files()} or {@link JFolder::folders()} instead
 *
 * @deprecated  As of version 1.5
 */
if ( !function_exists('mosReadDirectory')) {
  function mosReadDirectory( $path, $filter='.', $recurse=false, $fullpath=false  )
  {
    $arr = array(null);
  
    // Get the files and folders
    jimport('joomla.filesystem.folder');
    $files    = JFolder::files($path, $filter, $recurse, $fullpath);
    $folders  = JFolder::folders($path, $filter, $recurse, $fullpath);
    // Merge files and folders into one array
    $arr = array_merge($files, $folders);
    // Sort them all
    asort($arr);
    return $arr;
  }
}

/**
 * Legacy function, use {@link JApplication::redirect() JApplication->redirect()} instead
 *
 * @deprecated  As of version 1.5
 */
if ( !function_exists('mosRedirect')) {
  function mosRedirect( $url, $msg='' ) {
    global $mainframe;
    $mainframe->redirect( $url, $msg );
  }
}

/**
 * Legacy function, use {@link JArrayHelper::getValue()} instead
 *
 * @deprecated  As of version 1.5
 */
if ( !function_exists('mosGetParam')) {
  function mosGetParam( &$arr, $name, $def=null, $mask=0 )
  {
    // Static input filters for specific settings
    static $noHtmlFilter  = null;
    static $safeHtmlFilter  = null;
  
    $var = JArrayHelper::getValue( $arr, $name, $def, '' );
  
    // If the no trim flag is not set, trim the variable
    if (!($mask & 1) && is_string($var)) {
      $var = trim($var);
    }
  
    // Now we handle input filtering
    if ($mask & 2) {
      // If the allow html flag is set, apply a safe html filter to the variable
      if (is_null($safeHtmlFilter)) {
        $safeHtmlFilter = & JFilterInput::getInstance(null, null, 1, 1);
      }
      $var = $safeHtmlFilter->clean($var, 'none');
    } elseif ($mask & 4) {
      // If the allow raw flag is set, do not modify the variable
      $var = $var;
    } else {
      // Since no allow flags were set, we will apply the most strict filter to the variable
      if (is_null($noHtmlFilter)) {
        $noHtmlFilter = & JFilterInput::getInstance(/* $tags, $attr, $tag_method, $attr_method, $xss_auto */);
      }
      $var = $noHtmlFilter->clean($var, 'none');
    }
    return $var;
  }
}

/**
 * Legacy function, use {@link JEditor::save()} or {@link JEditor::getContent()} instead
 *
 * @deprecated  As of version 1.5
 */
if ( !function_exists('getEditorContents')) {
  function getEditorContents($editorArea, $hiddenField)
  {
    jimport( 'joomla.html.editor' );
    $editor =& JFactory::getEditor();
    echo $editor->save( $hiddenField );
  }
}

/**
 * Legacy function, use {@link JFilterOutput::objectHTMLSafe()} instead
 *
 * @deprecated  As of version 1.5
 */
if ( !function_exists('mosMakeHtmlSafe')) {
  function mosMakeHtmlSafe( &$mixed, $quote_style=ENT_QUOTES, $exclude_keys='' ) {
    JFilterOutput::objectHTMLSafe( $mixed, $quote_style, $exclude_keys );
  }
}

/**
* Legacy utility function to provide ToolTips
*
* @deprecated As of version 1.5
*/
if ( !function_exists('mosToolTip')) {
  function mosToolTip( $tooltip, $title='', $width='', $image='tooltip.png', $text='', $href='', $link=1 )
  {
    // Initialize the toolips if required
    static $init;
    if ( ! $init )
    {
      JHTML::_('behavior.tooltip');
      $init = true;
    }
  
    return JHTML::_('tooltip', $tooltip, $title, $image, $text, $href, $link);
  }
}

/**
 * Legacy function to replaces &amp; with & for xhtml compliance
 *
 * @deprecated  As of version 1.5
 */
if ( !function_exists('mosTreeRecurse')) {
  function mosTreeRecurse( $id, $indent, $list, &$children, $maxlevel=9999, $level=0, $type=1 )
  {
    jimport('joomla.html.html');
    return JHTML::_('menu.treerecurse', $id, $indent, $list, $children, $maxlevel, $level, $type);
  }
}

?>