<?php
/*
Plugin Name: jQuery Wysiwyg Editor
Plugin URI: http://amfearliath.tk/osclass-jquery-wysiwyg-editor
Description: Add a Wysiwyg Editor to the ad create/edit pages
Version: 1.0.1
Author: Liath
Author URI: http://amfearliath.tk
Short Name: jquery_wysiwyg_editor
Plugin update URI: jquery-wysiwyg-editor


DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
Version 2, December 2004

Copyright (C) 2004 Sam Hocevar
14 rue de Plaisance, 75014 Paris, France
Everyone is permitted to copy and distribute verbatim or modified
copies of this license document, and changing it is allowed as long
as the name is changed.

DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION

0. You just DO WHAT THE FUCK YOU WANT TO.
*/

if (!defined('OC_ADMIN') || OC_ADMIN!==true) exit('Access is not allowed.');

if (Params::getParam('plugin_action') == 'done') {
    $pref = jQWE::jQWE_sect();        
    $opts = array(
        'jQWE_placeholder'      => array(Params::getParam('jQWE_placeholder'), $pref, 'STRING'),
        'jQWE_placeholderURL'   => array(Params::getParam('jQWE_placeholderURL'), $pref, 'STRING'),
        'jQWE_allowHTML'        => array(Params::getParam('jQWE_allowHTML'), $pref, 'BOOLEAN'),
        'jQWE_fonts'            => array(Params::getParam('jQWE_fonts'), $pref, 'BOOLEAN'),
        'jQWE_fontsize'         => array(Params::getParam('jQWE_fontsize'), $pref, 'BOOLEAN'),
        'jQWE_header'           => array(Params::getParam('jQWE_header'), $pref, 'BOOLEAN'),
        'jQWE_bold'             => array(Params::getParam('jQWE_bold'), $pref, 'BOOLEAN'),
        'jQWE_italic'           => array(Params::getParam('jQWE_italic'), $pref, 'BOOLEAN'),
        'jQWE_underline'        => array(Params::getParam('jQWE_underline'), $pref, 'BOOLEAN'),
        'jQWE_strikethrough'    => array(Params::getParam('jQWE_strikethrough'), $pref, 'BOOLEAN'),
        'jQWE_link'             => array(Params::getParam('jQWE_link'), $pref, 'BOOLEAN'),
        'jQWE_textcolor'        => array(Params::getParam('jQWE_textcolor'), $pref, 'BOOLEAN'),
        'jQWE_bgcolor'          => array(Params::getParam('jQWE_bgcolor'), $pref, 'BOOLEAN'),
        'jQWE_alignleft'        => array(Params::getParam('jQWE_alignleft'), $pref, 'BOOLEAN'),
        'jQWE_alignright'       => array(Params::getParam('jQWE_alignright'), $pref, 'BOOLEAN'),
        'jQWE_aligncenter'      => array(Params::getParam('jQWE_aligncenter'), $pref, 'BOOLEAN'),
        'jQWE_alignjustified'   => array(Params::getParam('jQWE_alignjustified'), $pref, 'BOOLEAN'),
        'jQWE_subscript'        => array(Params::getParam('jQWE_subscript'), $pref, 'BOOLEAN'),
        'jQWE_superscript'      => array(Params::getParam('jQWE_superscript'), $pref, 'BOOLEAN'),
        'jQWE_indent'           => array(Params::getParam('jQWE_indent'), $pref, 'BOOLEAN'),
        'jQWE_outdent'          => array(Params::getParam('jQWE_outdent'), $pref, 'BOOLEAN'),
        'jQWE_ordered'          => array(Params::getParam('jQWE_ordered'), $pref, 'BOOLEAN'),
        'jQWE_unordered'        => array(Params::getParam('jQWE_unordered'), $pref, 'BOOLEAN'),
        'jQWE_clear'            => array(Params::getParam('jQWE_clear'), $pref, 'BOOLEAN'),
    );
    
    if (jQWE::jQWE_install($opts)) {        
        if(osc_version() < 300) {            
            echo '<div style="text-align:center; font-size:20px; background-color:#B0EFC0;"><p>'._e('<strong>All Settings saved.</strong> Your plugin ist now configured', 'jquery_wysiwyg_editor').'.</p></div>' ;
            osc_reset_preferences();            
        } else {            
            ob_get_clean();
            osc_add_flash_ok_message(__('<strong>All Settings saved.</strong> Your plugin ist now configured', 'jquery_wysiwyg_editor'), 'admin');
            osc_admin_render_plugin( osc_plugin_folder(__FILE__) . 'config.php');            
        }        
    } else {        
        if(osc_version() < 300) {            
            echo '<div style="text-align:center; font-size:20px; background-color:#EFB0B0;"><p>'._e('<strong>Error.</strong> Your settings can not be saved, please try again', 'jquery_wysiwyg_editor').'.</p></div>' ;
            osc_reset_preferences();            
        } else {            
            ob_get_clean();
            osc_add_flash_error_message(__('<strong>Error.</strong> Your settings can not be saved, please try again', 'jquery_wysiwyg_editor'), 'admin');
            osc_admin_render_plugin( osc_plugin_folder(__FILE__) . 'config.php');            
        }        
    }
} 
?>
<div class="jQWE_help">

    <div class="jQWE_header">
        <h1><?php _e('jQuery WYSIWYG Editor', 'jquery_wysiwyg_editor'); ?></h1>
                
        <br /><br />
        
        <form action="<?php echo osc_admin_base_url(true); ?>" method="POST">
            <input type="hidden" name="page" value="plugins" />
            <input type="hidden" name="action" value="renderplugin" />
            <input type="hidden" name="file" value="<?php echo osc_plugin_folder(__FILE__); ?>config.php" />
            <input type="hidden" name="plugin_action" value="done" />
            
            <h2 class="jQWE_title"><?php _e('Placeholder', 'jquery_wysiwyg_editor'); ?></h2>
            <p><?php _e('Here you can define, which placeholder should appear in the editor and the URL-Popup.', 'jquery_wysiwyg_editor'); ?></p>                    
            <br />
            <div class="jQWE_options">            
                <div class="form-group">
                    <label for="jQWE_placeholder"><?php _e('<strong>Editor</strong> Which placeholder should be appear in the editor window', 'jquery_wysiwyg_editor'); ?></label>
                    <br />
                    <input type="text" name="jQWE_placeholder" id="jQWE_placeholder" value="<?php echo jQWE::jQWE_get('jQWE_placeholder'); ?>" />
                </div>
                <br />            
                <div class="form-group">
                    <label for="jQWE_placeholderURL"><?php _e('<strong>URL-Popup</strong> Which placeholder should be appear in the URL-Popup', 'jquery_wysiwyg_editor'); ?></label>
                    <br />
                    <input type="text" name="jQWE_placeholderURL" id="jQWE_placeholderURL" value="<?php echo jQWE::jQWE_get('jQWE_placeholderURL'); ?>" />
                </div>
            </div>
                
            <h2 class="jQWE_title"><?php _e('Allow HTML', 'jquery_wysiwyg_editor'); ?></h2>
            <p><?php _e('Here you can define, whether the user is allowed to use HTML in the editor.', 'jquery_wysiwyg_editor'); ?></p>                    
            <br />            
            <div class="jQWE_options">            
                <div class="form-group">
                    <input type="checkbox" name="jQWE_allowHTML" id="jQWE_allowHTML" value="1" <?php if(jQWE::jQWE_get('jQWE_allowHTML')) echo 'checked="checked"';?> />
                    <label for="jQWE_allowHTML"><?php _e('<strong>Allow HTML</strong> Note that this malicious code can be inserted', 'jquery_wysiwyg_editor'); ?></label>
                </div>
            </div>
                
            <h2 class="jQWE_title"><?php _e('Options', 'jquery_wysiwyg_editor'); ?></h2>
            <p><?php _e('Here you can define, which buttons should appear in the editor toolbar.', 'jquery_wysiwyg_editor'); ?></p>                    
            <br />            
            <div class="jQWE_options">            
                <div class="form-group">
                    <input type="checkbox" name="jQWE_fonts" id="jQWE_fonts" value="1" <?php if(jQWE::jQWE_get('jQWE_fonts')) echo 'checked="checked"';?> />
                    <label for="jQWE_fonts"><?php _e('<strong>Google Fonts</strong> ', 'jquery_wysiwyg_editor'); ?></label>
                </div>            
                <div class="form-group">
                    <input type="checkbox" name="jQWE_fontsize" id="jQWE_fontsize" value="1" <?php if(jQWE::jQWE_get('jQWE_fontsize')) echo 'checked="checked"';?> />
                    <label for="jQWE_fontsize"><?php _e('<strong>Fontsize</strong> Enable the user, to select the fontsize', 'jquery_wysiwyg_editor'); ?></label>
                </div>            
                <div class="form-group">
                    <input type="checkbox" name="jQWE_header" id="jQWE_header" value="1" <?php if(jQWE::jQWE_get('jQWE_header')) echo 'checked="checked"';?> />
                    <label for="jQWE_header"><?php _e('<strong>Header</strong> Enable the user, to select the headertype', 'jquery_wysiwyg_editor'); ?></label>
                </div>            
                <div class="form-group">
                    <input type="checkbox" name="jQWE_bold" id="jQWE_bold" value="1" <?php if(jQWE::jQWE_get('jQWE_bold')) echo 'checked="checked"';?> />
                    <label for="jQWE_bold"><?php _e('<strong>Bold</strong> Enable the user, to mark text as bold', 'jquery_wysiwyg_editor'); ?></label>
                </div>            
                <div class="form-group">
                    <input type="checkbox" name="jQWE_italic" id="jQWE_italic" value="1" <?php if(jQWE::jQWE_get('jQWE_italic')) echo 'checked="checked"';?> />
                    <label for="jQWE_italic"><?php _e('<strong>Italic</strong> Enable the user, to mark text as italic', 'jquery_wysiwyg_editor'); ?></label>
                </div>            
                <div class="form-group">
                    <input type="checkbox" name="jQWE_underline" id="jQWE_underline" value="1" <?php if(jQWE::jQWE_get('jQWE_underline')) echo 'checked="checked"';?> />
                    <label for="jQWE_underline"><?php _e('<strong>Underlined</strong> Enable the user, to mark text as underlined', 'jquery_wysiwyg_editor'); ?></label>
                </div>            
                <div class="form-group">
                    <input type="checkbox" name="jQWE_strikethrough" id="jQWE_strikethrough" value="1" <?php if(jQWE::jQWE_get('jQWE_strikethrough')) echo 'checked="checked"';?> />
                    <label for="jQWE_strikethrough"><?php _e('<strong>Strikethrough</strong> Enable the user, to mark text as strikethrough', 'jquery_wysiwyg_editor'); ?></label>
                </div>            
                <div class="form-group">
                    <input type="checkbox" name="jQWE_link" id="jQWE_link" value="1" <?php if(jQWE::jQWE_get('jQWE_link')) echo 'checked="checked"';?> />
                    <label for="jQWE_link"><?php _e('<strong>Add URL</strong> Enable the user, to add an URL', 'jquery_wysiwyg_editor'); ?></label>
                </div>            
                <div class="form-group">
                    <input type="checkbox" name="jQWE_textcolor" id="jQWE_textcolor" value="1" <?php if(jQWE::jQWE_get('jQWE_textcolor')) echo 'checked="checked"';?> />
                    <label for="jQWE_textcolor"><?php _e('<strong>Text Color</strong> Enable the user, to change the text color', 'jquery_wysiwyg_editor'); ?></label>
                </div>            
                <div class="form-group">
                    <input type="checkbox" name="jQWE_bgcolor" id="jQWE_bgcolor" value="1" <?php if(jQWE::jQWE_get('jQWE_bgcolor')) echo 'checked="checked"';?> />
                    <label for="jQWE_bgcolor"><?php _e('<strong>Background Color</strong> Enable the user, to change the background color', 'jquery_wysiwyg_editor'); ?></label>
                </div>            
                <div class="form-group">
                    <input type="checkbox" name="jQWE_alignleft" id="jQWE_alignleft" value="1" <?php if(jQWE::jQWE_get('jQWE_alignleft')) echo 'checked="checked"';?> />
                    <label for="jQWE_alignleft"><?php _e('<strong>Align left</strong> Enable the user, to align text to the left side', 'jquery_wysiwyg_editor'); ?></label>
                </div>            
                <div class="form-group">
                    <input type="checkbox" name="jQWE_alignright" id="jQWE_alignright" value="1" <?php if(jQWE::jQWE_get('jQWE_alignright')) echo 'checked="checked"';?> />
                    <label for="jQWE_alignright"><?php _e('<strong>Align right</strong> Enable the user, to align text to the right side', 'jquery_wysiwyg_editor'); ?></label>
                </div>            
                <div class="form-group">
                    <input type="checkbox" name="jQWE_aligncenter" id="jQWE_aligncenter" value="1" <?php if(jQWE::jQWE_get('jQWE_aligncenter')) echo 'checked="checked"';?> />
                    <label for="jQWE_aligncenter"><?php _e('<strong>Align center</strong> Enable the user, to center text', 'jquery_wysiwyg_editor'); ?></label>
                </div>            
                <div class="form-group">
                    <input type="checkbox" name="jQWE_alignjustified" id="jQWE_alignjustified" value="1" <?php if(jQWE::jQWE_get('jQWE_alignjustified')) echo 'checked="checked"';?> />
                    <label for="jQWE_alignjustified"><?php _e('<strong>Align justified</strong> Enable the user, to justify text', 'jquery_wysiwyg_editor'); ?></label>
                </div>            
                <div class="form-group">
                    <input type="checkbox" name="jQWE_subscript" id="jQWE_subscript" value="1" <?php if(jQWE::jQWE_get('jQWE_subscript')) echo 'checked="checked"';?> />
                    <label for="jQWE_subscript"><?php _e('<strong>Subscript</strong> Enable the user, to show text subscript', 'jquery_wysiwyg_editor'); ?></label>
                </div>            
                <div class="form-group">
                    <input type="checkbox" name="jQWE_superscript" id="jQWE_superscript" value="1" <?php if(jQWE::jQWE_get('jQWE_superscript')) echo 'checked="checked"';?> />
                    <label for="jQWE_superscript"><?php _e('<strong>Superscript</strong> Enable the user, to show text superscript', 'jquery_wysiwyg_editor'); ?></label>
                </div>            
                <div class="form-group">
                    <input type="checkbox" name="jQWE_indent" id="jQWE_indent" value="1" <?php if(jQWE::jQWE_get('jQWE_indent')) echo 'checked="checked"';?> />
                    <label for="jQWE_indent"><?php _e('<strong>Indent</strong> Enable the user, to indent text', 'jquery_wysiwyg_editor'); ?></label>
                </div>            
                <div class="form-group">
                    <input type="checkbox" name="jQWE_outdent" id="jQWE_outdent" value="1" <?php if(jQWE::jQWE_get('jQWE_outdent')) echo 'checked="checked"';?> />
                    <label for="jQWE_outdent"><?php _e('<strong>Outdent</strong> Enable the user, to outdent text', 'jquery_wysiwyg_editor'); ?></label>
                </div>            
                <div class="form-group">
                    <input type="checkbox" name="jQWE_ordered" id="jQWE_ordered" value="1" <?php if(jQWE::jQWE_get('jQWE_ordered')) echo 'checked="checked"';?> />
                    <label for="jQWE_ordered"><?php _e('<strong>ordered List</strong> Enable the user, to make an ordered list', 'jquery_wysiwyg_editor'); ?></label>
                </div>            
                <div class="form-group">
                    <input type="checkbox" name="jQWE_unordered" id="jQWE_unordered" value="1" <?php if(jQWE::jQWE_get('jQWE_unordered')) echo 'checked="checked"';?> />
                    <label for="jQWE_unordered"><?php _e('<strong>unordered List</strong> Enable the user, to make an unordered list', 'jquery_wysiwyg_editor'); ?></label>
                </div>            
                <div class="form-group">
                    <input type="checkbox" name="jQWE_clear" id="jQWE_clear" value="1" <?php if(jQWE::jQWE_get('jQWE_clear')) echo 'checked="checked"';?> />
                    <label for="jQWE_clear"><?php _e('<strong>clear Format</strong> Enable the user, to clear the formation from text', 'jquery_wysiwyg_editor'); ?></label>
                </div>            
                <div class="form-group" style="margin-top: 15px; text-align: right;">
                    <button class="btn btn-submit" type="submit"><?php _e('Save', 'jquery_wysiwyg_editor'); ?></button>
                </div>                
            </div>            
        </form>        
    </div>
</div>