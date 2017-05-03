<?php 
require_once(ABS_PATH.'/oc-load.php');
require_once(osc_plugin_path('jquery_wysiwyg_editor/classes/class.jqwe.php'));

$jqwe = new jQWE;
$settings = true; $help = false;

if (Params::getParam('tab') == 'settings') {
    $settings = true;    
}
if (Params::getParam('plugin_action') == 'done') {
    $params = Params::getParamsAsArray('', false);
    if ($jqwe->jQWE_set($params)) {
        ob_get_clean();
        osc_add_flash_ok_message(__('<strong>All Settings saved.</strong> Your plugin ist now configured', 'jquery_wysiwyg_editor'), 'admin');
        osc_admin_render_plugin( osc_plugin_folder(__FILE__) . 'config.php&tab=settings');    
    } else {
        ob_get_clean();
        osc_add_flash_error_message(__('<strong>Error.</strong> Your settings can not be saved, please try again', 'jquery_wysiwyg_editor'), 'admin');
        osc_admin_render_plugin( osc_plugin_folder(__FILE__) . 'config.php&tab=settings');    
    }
    
    $settings = true;      
}
    
?>
<div id="jqwe">
    <div class="container">
        <ul class="tabs">
            <li class="tab-link<?php if ($settings) { echo ' current'; } ?>" data-tab="jqwe_settings"><a><?php _e('Settings', 'jquery_wysiwyg_editor'); ?></a></li>
            <li class="tab-link<?php if (!$settings) { echo ' current'; } ?>" data-tab="jqwe_help"><a><?php _e('Info', 'jquery_wysiwyg_editor'); ?></a></li>
        </ul>

        <div id="jqwe_settings" class="tab-content<?php if ($settings) { echo ' current'; } ?>">
            <?php include_once(osc_plugin_path('jquery_wysiwyg_editor/admin/settings.php')); ?>    
        </div>

        <div id="jqwe_help" class="tab-content<?php if (!$settings) { echo ' current'; } ?>">
            <?php include_once(osc_plugin_path('jquery_wysiwyg_editor/admin/help.php')); ?>
        </div>        
    </div>   
</div>