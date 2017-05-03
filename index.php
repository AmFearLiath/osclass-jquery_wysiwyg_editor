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
require_once('classes/class.jqwe.php');

function jqwe_admin_page_header($message = false) {   
    echo '<h1>'.($message ? $message : __('jQuery WYSIWYG Editor', 'spam_protection')).'</h1>';    
}

function jQWE_install() {
    jQWE::newInstance()->jQWE_install();
}

function jQWE_uninstall() {
    jQWE::newInstance()->jQWE_uninstall();
}

function jQWE_style() {
    $params = Params::getParamsAsArray();    
    if (isset($params['file'])) {
        $plugin = explode("/", $params['file']);
        if ($plugin[0] == 'jquery_wysiwyg_editor') {
            
            osc_enqueue_style('jQWE-admin-style', osc_plugin_url('jquery_wysiwyg_editor/assets/css/admin.css').'admin.css');
            osc_enqueue_style('jQWE-admin-style-tipso', osc_plugin_url('jquery_wysiwyg_editor/assets/css/tipso.min.css').'tipso.min.css');
            
            osc_register_script('jQWE-admin-script', osc_plugin_url('jquery_wysiwyg_editor/assets/js/admin.js') . 'admin.js', array('jquery'));
            osc_enqueue_script('jQWE-admin-script');
            osc_register_script('jQWE-admin-tipso', osc_plugin_url('jquery_wysiwyg_editor/assets/js/tipso.min.js') . 'tipso.min.js', array('jquery'));
            osc_enqueue_script('jQWE-admin-tipso');
            
            osc_add_hook('admin_page_header','jqwe_admin_page_header');
            osc_remove_hook('admin_page_header', 'customPageHeader');    
        }    
    }
    osc_enqueue_style('jQWE-styles', osc_plugin_url('jquery_wysiwyg_editor/assets/css/jQWE.css').'jQWE.css');
    osc_enqueue_style('jQWE-fonts', osc_plugin_url('jquery_wysiwyg_editor/assets/css/fonts.css').'fonts.css');
    osc_enqueue_style('jQWE-style-font_awesome', osc_plugin_url('jquery_wysiwyg_editor/assets/css/font-awesome.min.css').'font-awesome.min.css');
}

function jQWE_configuration() {
    osc_admin_render_plugin(osc_plugin_path(dirname(__FILE__)) . '/admin/config.php');
}

function jQWE_load_js() {
    echo jQWE::newInstance()->jQWE_script(osc_version());
}

function jQWE_init() {
    
    $location   = Rewrite::newInstance()->get_location();
    $section    = Rewrite::newInstance()->get_section();

    if(isset($location)){
        $location = Params::getParam('page', false, false) ;
        $section  = Params::getParam('action', false, false) ;
    }

    if(($location=='item' && ($section=='item_add' || $section=='item_edit')) || ($location=='items' && ($section=='post' || $section=='item_edit'))) {                
        
        if (osc_version() < 311) {
            osc_add_hook('header',       'jQWE_load_js', 10);
            osc_add_hook('admin_header', 'jQWE_load_js', 10);
        } else {                
            osc_register_script('wysiwyg-main', osc_plugin_url('jquery_wysiwyg_editor/assets/js/wysiwyg.min.js') . 'wysiwyg.min.js', array('jquery'));
            osc_register_script('wysiwyg-editor', osc_plugin_url('jquery_wysiwyg_editor/assets/js/wysiwyg-editor.min.js') . 'wysiwyg-editor.min.js', array('jquery'));
            osc_register_script('wysiwyg-script', osc_plugin_url('jquery_wysiwyg_editor/assets/js/jQWE.js') . 'jQWE.js', array('jquery'));
            
            osc_enqueue_script('wysiwyg-main');
            osc_enqueue_script('wysiwyg-editor');
            osc_enqueue_script('wysiwyg-script');

            osc_add_hook('header',       'jQWE_load_js', 0);
            osc_add_hook('admin_header', 'jQWE_load_js', 0);
        }
    }
}

if(!function_exists('do_not_clean_items')) {    
    function do_not_clean_items($item) {
        $mItems = Item::newInstance();
        $catID  = $item['fk_i_category_id'];
        $itemID = $item['pk_i_id'];

        $title       = Params::getParam('title', false, false) ;
        $description = Params::getParam('description', false, false) ;
        
        $from = array('&', '"', '<', '>');
        $to = array('&amp;', '&quot;', '&lt;', '&gt;');

        foreach(osc_get_locales() as $v) {
            if (jQWE::newInstance()->jQWE_get('jQWE_allowHTML') != '1') {
                $title[$v['pk_c_code']] = str_replace($from, $to, $title[$v['pk_c_code']]);
                $description[$v['pk_c_code']] = str_replace($from, $to, $description[$v['pk_c_code']]);
            }
                
            $mItems->updateLocaleForce($itemID, $v['pk_c_code'], $title[$v['pk_c_code']], $description[$v['pk_c_code']]);    
        } 
    }
}
    
osc_register_plugin(osc_plugin_path(__FILE__), 'jQWE_install') ;
osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'jQWE_uninstall') ;

osc_add_hook('header', 'jQWE_style');
osc_add_hook('admin_header', 'jQWE_style');
osc_add_hook('admin_header', 'jQWE_style_admin');
osc_add_hook(osc_plugin_path(__FILE__) . '_configure', 'jQWE_configuration');

if(osc_version() >= 300) {
    osc_add_hook('admin_menu_init', 'jQWE_admin_menu_init');
} else {
    osc_add_hook('admin_menu', 'jQWE_admin_menu');
}
    
osc_add_hook('init', 'jQWE_init');
osc_add_hook('posted_item', 'do_not_clean_items');
osc_add_hook('edited_item', 'do_not_clean_items');

function jQWE_admin_menu_init() {
    osc_add_admin_menu_page( __('jQWE Plugin', 'jquery_wysiwyg_editor'), osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'admin/config.php'), 'jQWE_admin', 'administrator' );
    osc_add_admin_submenu_page('jQWE_admin', __('Settings', 'jquery_wysiwyg_editor'), osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'admin/config.php'), 'jQWE_admin_settings', 'administrator');
    osc_add_admin_submenu_page('jQWE_admin', __('Help', 'jquery_wysiwyg_editor'), osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'admin/help.php'), 'jQWE_admin_help', 'administrator');
}

function jQWE_admin_menu() {
    echo '<h3><a href="#">' . __('jQWE Plugin', 'jquery_wysiwyg_editor') . '</a></h3>
    <ul>
        <li><a href="' . osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'admin/config.php') . '">&raquo; ' . __('Settings', 'jquery_wysiwyg_editor') . '</a></li>
        <li><a href="' . osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'admin/help.php') . '">&raquo; ' . __('Help', 'jquery_wysiwyg_editor') . '</a></li>
    </ul>';
}                       
?>