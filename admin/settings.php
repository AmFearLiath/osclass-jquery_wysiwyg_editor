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
$jqwe = new jQWE;                                                                    
?>
<div class="jQWE_help">

    <div class="jQWE_header">
        
        <form action="<?php echo osc_admin_base_url(true); ?>" method="POST">
            <input type="hidden" name="page" value="plugins" />
            <input type="hidden" name="action" value="renderplugin" />
            <input type="hidden" name="file" value="<?php echo osc_plugin_folder(__FILE__); ?>config.php" />
            <input type="hidden" name="plugin_action" value="done" />             
            
            <ul class="subtabs jqwe_tabs">
                <li class="subtab-link current" data-tab="jqwesub_appearance"><a><?php _e('Appearance', 'jquery_wysiwyg_editor'); ?></a></li>
                <li class="subtab-link" data-tab="jqwesub_settings"><a><?php _e('Settings', 'jquery_wysiwyg_editor'); ?></a></li>
                <li class="subtab-link" data-tab="jqwesub_buttons"><a><?php _e('Buttons', 'jquery_wysiwyg_editor'); ?></a></li>
                <li class="subtab-link"><button type="submit" class="btn btn-info"><?php _e('Save', 'jquery_wysiwyg_editor'); ?></button></li>
            </ul>
            
            <div class="jqwe_options">
                <div id="jqwesub_appearance" class="subtab-content current">    
                    <h2 class="jQWE_title">
                    <!--i class="fa fa-info tipso_style tooltip" data-tipso-title="Set editor height" data-tipso="Here you can define the visible height of the editor window."></i-->
                    <?php _e('Set Editor height', 'jquery_wysiwyg_editor'); ?>
                    </h2>
                    <p><?php _e('Here you can select the appearance of the Editor. Should the Editor have a fixed height or a dynamic sliding effect on focus.', 'jquery_wysiwyg_editor'); ?></p>
                                                    
                    <div class="jQWE_options">
                        <div class="formGroup">
                            <div class="checkSlide">
                                <input type="checkbox" name="jQWE_toggleHeight" id="jQWE_toggleHeight" value="1" <?php if(jQWE::newInstance()->jQWE_get('jQWE_toggleHeight')) echo 'checked="checked"';?> />
                                <label for="jQWE_toggleHeight"></label>
                            </div>
                            <div id="height_deactivated"<?php if (jQWE::newInstance()->jQWE_get('jQWE_toggleHeight')) echo ' style="display: none;"';?>><?php _e('<strong>Fixed height.</strong> No sliding effect activated', 'jquery_wysiwyg_editor'); ?></div>
                            <div id="height_activated"<?php if (!jQWE::newInstance()->jQWE_get('jQWE_toggleHeight')) echo ' style="display: none;"';?>><?php _e('<strong>Dynamic height.</strong> Sliding effect is activated', 'jquery_wysiwyg_editor'); ?></div>
                        </div>
                    </div>
                    <br />                                
                    <div class="jQWE_options" id="jQWE_heightNormal"<?php if (jQWE::newInstance()->jQWE_get('jQWE_toggleHeight')) echo ' style="display: none;"';?>>            
                        <div class="form-group">
                            <label class="left" for="jQWE_height"><strong><?php _e('Height', 'jquery_wysiwyg_editor'); ?></strong></label>
                            <input type="number" name="jQWE_height" id="jQWE_height" value="<?php echo jQWE::newInstance()->jQWE_get('jQWE_height');?>" />
                        </div>
                    </div>                                
                    <div class="jQWE_options" id="jQWE_heightSlide"<?php if (!jQWE::newInstance()->jQWE_get('jQWE_toggleHeight')) echo ' style="display: none;"';?>>            
                        <div class="form-group">
                            <label class="left" for="jQWE_minheight"><strong><?php _e('Min-Height', 'jquery_wysiwyg_editor'); ?></strong></label>
                            <input type="number" name="jQWE_minheight" id="jQWE_minheight" value="<?php echo jQWE::newInstance()->jQWE_get('jQWE_minheight');?>" />
                        </div>
                        <br />
                        <div class="form-group">
                            <label class="left" for="jQWE_maxheight"><strong><?php _e('Max-Height', 'jquery_wysiwyg_editor'); ?></strong></label>
                            <input type="number" name="jQWE_maxheight" id="jQWE_maxheight" value="<?php echo jQWE::newInstance()->jQWE_get('jQWE_maxheight');?>" />
                        </div>
                    </div>
                </div>
                
                <div id="jqwesub_settings" class="subtab-content">    
                    <h2 class="jQWE_title">
                        <?php _e('Allow using of HTML', 'jquery_wysiwyg_editor'); ?>
                    </h2>                                
                    <p><?php _e('Here you can define, whether the user is allowed to use HTML in the editor. BE CAREFUL. Malicious code could be inserted through this.', 'jquery_wysiwyg_editor'); ?></p>                                
                    <p><?php _e('If this is deactiated, some HTML Elements will be replaced to entities before saving them to the database (<, >, ", &)', 'jquery_wysiwyg_editor'); ?></p>                                
                    <div class="jQWE_options">
                        <div class="formGroup">
                            <div class="checkSlide">
                                <input type="checkbox" name="jQWE_allowHTML" id="jQWE_allowHTML" value="1" <?php if (jQWE::newInstance()->jQWE_get('jQWE_allowHTML')) echo 'checked="checked"';?> />
                                <label for="jQWE_allowHTML"></label>
                            </div>
                            <div id="html_allowed"<?php if (jQWE::newInstance()->jQWE_get('jQWE_allowHTML')) echo ' style="display: none;"';?>><?php _e('<strong>HTML is allowed.</strong> No code replacing activated', 'jquery_wysiwyg_editor'); ?></div>
                            <div id="html_not_allowed"<?php if (!jQWE::newInstance()->jQWE_get('jQWE_allowHTML')) echo ' style="display: none;"';?>><?php _e('<strong>HTML is forbidden.</strong> Some code elements will be replaced in database', 'jquery_wysiwyg_editor'); ?></div>
                        </div>
                    </div>
                    <br /><hr /><br />
                    <h2 class="jQWE_title">
                        <?php _e('Placeholder', 'jquery_wysiwyg_editor'); ?>
                    </h2>                                
                    <p><?php _e('Here you can define, which placeholder should appear in the editor and the URL-Popup.', 'jquery_wysiwyg_editor'); ?></p>
                    <div class="jQWE_options">            
                        <div class="form-group">
                            <label class="left" for="jQWE_placeholder"><strong><?php _e('Editor', 'jquery_wysiwyg_editor'); ?></strong></label>
                            <input type="text" name="jQWE_placeholder" id="jQWE_placeholder" placeholder="Enter your description here" value="<?php echo jQWE::newInstance()->jQWE_get('jQWE_placeholder'); ?>" />
                        </div>
                        <br />            
                        <div class="form-group">
                            <label class="left" for="jQWE_placeholderURL"><strong><?php _e('URL-Popup', 'jquery_wysiwyg_editor'); ?></strong></label>
                            <input type="text" name="jQWE_placeholderURL" id="jQWE_placeholderURL" placeholder="<?php echo WEB_PATH; ?>" value="<?php echo jQWE::newInstance()->jQWE_get('jQWE_placeholderURL'); ?>" />
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                
                <div id="jqwesub_buttons" class="subtab-content">                    
                    <h2 class="jQWE_title"><?php _e('Options', 'jquery_wysiwyg_editor'); ?></h2>
                    <p><?php _e('Here you can define, which buttons should appear in the editor toolbar.', 'jquery_wysiwyg_editor'); ?></p>                    
                    <br />            
                    <div class="jQWE_options">                     
                        
                        <!-- Google Fonts-->
                        <div class="formGroup">
                            <div class="checkSlide">
                                <input type="checkbox" name="jQWE_fonts" id="jQWE_fonts" value="1" <?php if (jQWE::newInstance()->jQWE_get('jQWE_fonts')) echo 'checked="checked"';?> />
                                <label for="jQWE_fonts"></label>
                            </div>
                            <div><?php _e('<strong>Google Fonts</strong>', 'jquery_wysiwyg_editor'); ?></div>
                        </div>
                        
                        <!-- Fontsize -->
                        <div class="formGroup">
                            <div class="checkSlide">
                                <input type="checkbox" name="jQWE_fontsize" id="jQWE_fontsize" value="1" <?php if (jQWE::newInstance()->jQWE_get('jQWE_fontsize')) echo 'checked="checked"';?> />
                                <label for="jQWE_fontsize"></label>
                            </div>
                            <div><?php _e('<strong>Fontsize</strong> Enable the user, to select the fontsize', 'jquery_wysiwyg_editor'); ?></div>
                        </div>
                        
                        <!-- Header -->
                        <div class="formGroup">
                            <div class="checkSlide">
                                <input type="checkbox" name="jQWE_header" id="jQWE_header" value="1" <?php if (jQWE::newInstance()->jQWE_get('jQWE_header')) echo 'checked="checked"';?> />
                                <label for="jQWE_header"></label>
                            </div>
                            <div><?php _e('<strong>Header</strong> Enable the user, to select the headertype', 'jquery_wysiwyg_editor'); ?></div>
                        </div>
                        
                        <!-- Bold -->
                        <div class="formGroup">
                            <div class="checkSlide">
                                <input type="checkbox" name="jQWE_bold" id="jQWE_bold" value="1" <?php if (jQWE::newInstance()->jQWE_get('jQWE_bold')) echo 'checked="checked"';?> />
                                <label for="jQWE_header"></label>
                            </div>
                            <div><?php _e('<strong>Bold</strong> Enable the user, to mark text as bold', 'jquery_wysiwyg_editor'); ?></div>
                        </div>
                        
                        <!-- Italic -->
                        <div class="formGroup">
                            <div class="checkSlide">
                                <input type="checkbox" name="jQWE_italic" id="jQWE_italic" value="1" <?php if (jQWE::newInstance()->jQWE_get('jQWE_italic')) echo 'checked="checked"';?> />
                                <label for="jQWE_italic"></label>
                            </div>
                            <div><?php _e('<strong>Italic</strong> Enable the user, to mark text as italic', 'jquery_wysiwyg_editor'); ?></div>
                        </div>
                        
                        <!-- Underlined -->
                        <div class="formGroup">
                            <div class="checkSlide">
                                <input type="checkbox" name="jQWE_underline" id="jQWE_underline" value="1" <?php if (jQWE::newInstance()->jQWE_get('jQWE_underline')) echo 'checked="checked"';?> />
                                <label for="jQWE_underline"></label>
                            </div>
                            <div><?php _e('<strong>Underlined</strong> Enable the user, to mark text as underlined', 'jquery_wysiwyg_editor'); ?></div>
                        </div>
                        
                        <!-- Strikethrough -->
                        <div class="formGroup">
                            <div class="checkSlide">
                                <input type="checkbox" name="jQWE_strikethrough" id="jQWE_strikethrough" value="1" <?php if (jQWE::newInstance()->jQWE_get('jQWE_strikethrough')) echo 'checked="checked"';?> />
                                <label for="jQWE_strikethrough"></label>
                            </div>
                            <div><?php _e('<strong>Strikethrough</strong> Enable the user, to mark text as strikethrough', 'jquery_wysiwyg_editor'); ?></div>
                        </div>
                        
                        <!-- Links -->
                        <div class="formGroup">
                            <div class="checkSlide">
                                <input type="checkbox" name="jQWE_link" id="jQWE_link" value="1" <?php if (jQWE::newInstance()->jQWE_get('jQWE_link')) echo 'checked="checked"';?> />
                                <label for="jQWE_link"></label>
                            </div>
                            <div><?php _e('<strong>Links</strong> Enable the user, to link text', 'jquery_wysiwyg_editor'); ?></div>
                        </div>
                        
                        <!-- Text color -->
                        <div class="formGroup">
                            <div class="checkSlide">
                                <input type="checkbox" name="jQWE_textcolor" id="jQWE_textcolor" value="1" <?php if (jQWE::newInstance()->jQWE_get('jQWE_textcolor')) echo 'checked="checked"';?> />
                                <label for="jQWE_textcolor"></label>
                            </div>
                            <div><?php _e('<strong>Text Color</strong> Enable the user, to change the text color', 'jquery_wysiwyg_editor'); ?></div>
                        </div>
                        
                        <!-- Background Color -->
                        <div class="formGroup">
                            <div class="checkSlide">
                                <input type="checkbox" name="jQWE_bgcolor" id="jQWE_bgcolor" value="1" <?php if (jQWE::newInstance()->jQWE_get('jQWE_bgcolor')) echo 'checked="checked"';?> />
                                <label for="jQWE_bgcolor"></label>
                            </div>
                            <div><?php _e('<strong>Background Color</strong> Enable the user, to change the background color', 'jquery_wysiwyg_editor'); ?></div>
                        </div>
                        
                        <!-- Align left -->
                        <div class="formGroup">
                            <div class="checkSlide">
                                <input type="checkbox" name="jQWE_alignleft" id="jQWE_alignleft" value="1" <?php if (jQWE::newInstance()->jQWE_get('jQWE_alignleft')) echo 'checked="checked"';?> />
                                <label for="jQWE_alignleft"></label>
                            </div>
                            <div><?php _e('<strong>Align left</strong> Enable the user, to align text to the left side', 'jquery_wysiwyg_editor'); ?></div>
                        </div>
                        
                        <!-- Align right -->
                        <div class="formGroup">
                            <div class="checkSlide">
                                <input type="checkbox" name="jQWE_alignright" id="jQWE_alignright" value="1" <?php if (jQWE::newInstance()->jQWE_get('jQWE_alignright')) echo 'checked="checked"';?> />
                                <label for="jQWE_alignright"></label>
                            </div>
                            <div><?php _e('<strong>Align right</strong> Enable the user, to align text to the right side', 'jquery_wysiwyg_editor'); ?></div>
                        </div>
                        
                        <!-- Align center -->
                        <div class="formGroup">
                            <div class="checkSlide">
                                <input type="checkbox" name="jQWE_aligncenter" id="jQWE_aligncenter" value="1" <?php if (jQWE::newInstance()->jQWE_get('jQWE_aligncenter')) echo 'checked="checked"';?> />
                                <label for="jQWE_aligncenter"></label>
                            </div>
                            <div><?php _e('<strong>Align center</strong> Enable the user, to align text to center text', 'jquery_wysiwyg_editor'); ?></div>
                        </div>
                        
                        <!-- Align justified -->
                        <div class="formGroup">
                            <div class="checkSlide">
                                <input type="checkbox" name="jQWE_alignjustified" id="jQWE_alignjustified" value="1" <?php if (jQWE::newInstance()->jQWE_get('jQWE_alignjustified')) echo 'checked="checked"';?> />
                                <label for="jQWE_alignjustified"></label>
                            </div>
                            <div><?php _e('<strong>Align justified</strong> Enable the user, to justify text', 'jquery_wysiwyg_editor'); ?></div>
                        </div>
                        
                        <!-- Subscript -->
                        <div class="formGroup">
                            <div class="checkSlide">
                                <input type="checkbox" name="jQWE_subscript" id="jQWE_subscript" value="1" <?php if (jQWE::newInstance()->jQWE_get('jQWE_subscript')) echo 'checked="checked"';?> />
                                <label for="jQWE_subscript"></label>
                            </div>
                            <div><?php _e('<strong>Subscript</strong> Enable the user, to show text subscript', 'jquery_wysiwyg_editor'); ?></div>
                        </div>
                        
                        <!-- Superscript -->
                        <div class="formGroup">
                            <div class="checkSlide">
                                <input type="checkbox" name="jQWE_superscript" id="jQWE_superscript" value="1" <?php if (jQWE::newInstance()->jQWE_get('jQWE_superscript')) echo 'checked="checked"';?> />
                                <label for="jQWE_superscript"></label>
                            </div>
                            <div><?php _e('<strong>Superscript</strong> Enable the user, to show text superscript', 'jquery_wysiwyg_editor'); ?></div>
                        </div>
                        
                        <!-- Indent -->
                        <div class="formGroup">
                            <div class="checkSlide">
                                <input type="checkbox" name="jQWE_indent" id="jQWE_indent" value="1" <?php if (jQWE::newInstance()->jQWE_get('jQWE_indent')) echo 'checked="checked"';?> />
                                <label for="jQWE_indent"></label>
                            </div>
                            <div><?php _e('<strong>Indent</strong> Enable the user, to indent text', 'jquery_wysiwyg_editor'); ?></div>
                        </div>
                        
                        <!-- Outdent -->
                        <div class="formGroup">
                            <div class="checkSlide">
                                <input type="checkbox" name="jQWE_outdent" id="jQWE_outdent" value="1" <?php if (jQWE::newInstance()->jQWE_get('jQWE_outdent')) echo 'checked="checked"';?> />
                                <label for="jQWE_outdent"></label>
                            </div>
                            <div><?php _e('<strong>Indent</strong> Enable the user, to outdent text', 'jquery_wysiwyg_editor'); ?></div>
                        </div>
                        
                        <!-- ordered List -->
                        <div class="formGroup">
                            <div class="checkSlide">
                                <input type="checkbox" name="jQWE_ordered" id="jQWE_ordered" value="1" <?php if (jQWE::newInstance()->jQWE_get('jQWE_ordered')) echo 'checked="checked"';?> />
                                <label for="jQWE_ordered"></label>
                            </div>
                            <div><?php _e('<strong>ordered List</strong> Enable the user, to make an ordered list', 'jquery_wysiwyg_editor'); ?></div>
                        </div>
                        
                        <!-- unordered List -->
                        <div class="formGroup">
                            <div class="checkSlide">
                                <input type="checkbox" name="jQWE_unordered" id="jQWE_unordered" value="1" <?php if (jQWE::newInstance()->jQWE_get('jQWE_unordered')) echo 'checked="checked"';?> />
                                <label for="jQWE_unordered"></label>
                            </div>
                            <div><?php _e('<strong>unordered List</strong> Enable the user, to make an unordered list', 'jquery_wysiwyg_editor'); ?></div>
                        </div>
                        
                        <!-- unordered List -->
                        <div class="formGroup">
                            <div class="checkSlide">
                                <input type="checkbox" name="jQWE_clear" id="jQWE_clear" value="1" <?php if (jQWE::newInstance()->jQWE_get('jQWE_clear')) echo 'checked="checked"';?> />
                                <label for="jQWE_clear"></label>
                            </div>
                            <div><?php _e('<strong>clear Format</strong> Enable the user, to clear the formation from text', 'jquery_wysiwyg_editor'); ?></div>
                        </div>                
                    </div>            
                </div>
                <div class="clear"></div>            
            </div>            
        </form>        
    </div>
</div>