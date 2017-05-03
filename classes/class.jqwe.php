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
class jQWE {
    
    private static $instance ;
    
    public static function newInstance() {
        if( !self::$instance instanceof self ) {
            self::$instance = new self ;
        }
        return self::$instance ;
    }
    
    function __construct() {
        $this->debug = new Debugger;
        $this->_sect = 'plugin_jquery_wysiwyg_editor';
    }

    function jQWE_install($opts = '') {        
        if ($opts == '') { $opts = $this->_opt; }        
        foreach ($opts AS $k => $v) {
            osc_set_preference($k, $v[0], $this->_sect, $v[1]);
        }
        return true;        
    }

    function jQWE_uninstall() {        
        Preference::newInstance()->delete(array("s_section" => $this->_sect));
    }
    
    function _opt($k = '') {        
        $opts = array(
            'jQWE_placeholder' => array(__('Enter your description here', 'jquery_wysiwyg_editor'), 'STRING'),
            'jQWE_placeholderURL' => array(osc_base_url(), 'STRING'),
            'jQWE_allowHTML' => array('1', 'BOOLEAN'),
            'jQWE_fonts' => array('1', 'BOOLEAN'),
            'jQWE_fontsize' => array('1', 'BOOLEAN'),
            'jQWE_header' => array('1', 'BOOLEAN'),
            'jQWE_bold' => array('1', 'BOOLEAN'),
            'jQWE_italic' => array('1', 'BOOLEAN'),
            'jQWE_underline' => array('1', 'BOOLEAN'),
            'jQWE_strikethrough' => array('0', 'BOOLEAN'),
            'jQWE_link' => array('1', 'BOOLEAN'),
            'jQWE_textcolor' => array('1', 'BOOLEAN'),
            'jQWE_bgcolor' => array('0', 'BOOLEAN'),
            'jQWE_alignleft' => array('1', 'BOOLEAN'),
            'jQWE_alignright' => array('1', 'BOOLEAN'),
            'jQWE_aligncenter' => array('1', 'BOOLEAN'),
            'jQWE_alignjustified' => array('0', 'BOOLEAN'),
            'jQWE_subscript' => array('0', 'BOOLEAN'),
            'jQWE_superscript' => array('0', 'BOOLEAN'),
            'jQWE_indent' => array('1', 'BOOLEAN'),
            'jQWE_outdent' => array('1', 'BOOLEAN'),
            'jQWE_ordered' => array('1', 'BOOLEAN'),
            'jQWE_unordered' => array('1', 'BOOLEAN'),
            'jQWE_clear' => array('1', 'BOOLEAN'),
            'jQWE_toggleHeight' => array('1', 'BOOLEAN'),
            'jQWE_height' => array('', 'STRING'),
            'jQWE_minheight' => array('', 'STRING'),
            'jQWE_maxheight' => array('', 'STRING'),
        );
        
        if ($k) { return $opts[$k]; }
        return $opts;
    }

    function jQWE_get($opt) {
        return osc_get_preference($opt, $this->_sect);
    }

    function jQWE_set($params) {
        
        $data = array();
        foreach ($this->_opt() as $ok => $ov) {
            $data[$ok] = (isset($params[$ok]) ? $params[$ok] : '');       
        }
        $forbidden = array('CSRFName', 'CSRFToken', 'page', 'file', 'action', 'plugin_action');
        
        foreach($data as $k => $v) {
            if (!in_array($k, $forbidden)) {
                $opt = $this->_opt($k);
                if (empty($v)) { 
                    osc_delete_preference($k, $this->_sect); 
                } else {
                    if (!osc_set_preference($k, $v, $this->_sect, $opt[1])) {
                        return false;
                    }   
                }
                
            }
        }
        return true;
        
        
        return osc_set_preference($opt, $value, $this->_sect, $type);
    }

    function jQWE_script($version) {
        
        $editor_toggle = jQWE::newInstance()->jQWE_get('jQWE_toggleHeight'); 
        $editor_height = jQWE::newInstance()->jQWE_get('jQWE_height');
        $editor_min = jQWE::newInstance()->jQWE_get('jQWE_minheight');
        $editor_max = jQWE::newInstance()->jQWE_get('jQWE_maxheight');
        
        if ($version > 310) {
            $script = "
            <script type=\"text/javascript\">
                var jQWE = new Array();
                    jQWE.placeholder            = '".jQWE::newInstance()->jQWE_get('jQWE_placeholder')."',
                    jQWE.placeholderURL         = '".jQWE::newInstance()->jQWE_get('jQWE_placeholderURL')."',
                    jQWE.fonts                  = '".jQWE::newInstance()->jQWE_get('jQWE_fonts')."',
                    jQWE.trans_fonts            = '".__('Fonts', 'jquery_wysiwyg_editor')."',
                    jQWE.fontsize               = '".jQWE::newInstance()->jQWE_get('jQWE_fontsize')."',
                    jQWE.trans_fontsize         = '".__('Fontsize', 'jquery_wysiwyg_editor')."',
                    jQWE.header                 = '".jQWE::newInstance()->jQWE_get('jQWE_header')."'
                    jQWE.trans_header           = '".__('Header', 'jquery_wysiwyg_editor')."',
                    jQWE.bold                   = '".jQWE::newInstance()->jQWE_get('jQWE_bold')."',
                    jQWE.trans_bold             = '".__('Bold (CTRL + B)', 'jquery_wysiwyg_editor')."',
                    jQWE.italic                 = '".jQWE::newInstance()->jQWE_get('jQWE_italic')."',
                    jQWE.trans_italic           = '".__('Italic (CTRL + I)', 'jquery_wysiwyg_editor')."',
                    jQWE.underline              = '".jQWE::newInstance()->jQWE_get('jQWE_underline')."',
                    jQWE.trans_underline        = '".__('Underline (CTRL + U)', 'jquery_wysiwyg_editor')."',
                    jQWE.strikethrough          = '".jQWE::newInstance()->jQWE_get('jQWE_strikethrough')."',
                    jQWE.trans_strikethrough    = '".__('Strikethrough (CTRL + S)', 'jquery_wysiwyg_editor')."',
                    jQWE.link                   = '".jQWE::newInstance()->jQWE_get('jQWE_link')."',
                    jQWE.trans_link             = '".__('Insert Link', 'jquery_wysiwyg_editor')."',
                    jQWE.textcolor              = '".jQWE::newInstance()->jQWE_get('jQWE_textcolor')."',
                    jQWE.trans_textcolor        = '".__('Textcolor', 'jquery_wysiwyg_editor')."',
                    jQWE.bgcolor                = '".jQWE::newInstance()->jQWE_get('jQWE_bgcolor')."',
                    jQWE.trans_bgcolor          = '".__('Backgroundcolor', 'jquery_wysiwyg_editor')."',
                    jQWE.alignleft              = '".jQWE::newInstance()->jQWE_get('jQWE_alignleft')."',
                    jQWE.trans_alignleft        = '".__('Align Left', 'jquery_wysiwyg_editor')."',
                    jQWE.alignright             = '".jQWE::newInstance()->jQWE_get('jQWE_alignright')."',
                    jQWE.trans_alignright       = '".__('Align Right', 'jquery_wysiwyg_editor')."',
                    jQWE.aligncenter            = '".jQWE::newInstance()->jQWE_get('jQWE_aligncenter')."',
                    jQWE.trans_aligncenter      = '".__('Align Center', 'jquery_wysiwyg_editor')."',
                    jQWE.alignjustified         = '".jQWE::newInstance()->jQWE_get('jQWE_alignjustified')."',
                    jQWE.trans_alignjustified   = '".__('Justify', 'jquery_wysiwyg_editor')."',
                    jQWE.subscript              = '".jQWE::newInstance()->jQWE_get('jQWE_subscript')."',
                    jQWE.trans_subscript        = '".__('Subscript', 'jquery_wysiwyg_editor')."',
                    jQWE.superscript            = '".jQWE::newInstance()->jQWE_get('jQWE_superscript')."',
                    jQWE.trans_superscript      = '".__('Superscript', 'jquery_wysiwyg_editor')."',
                    jQWE.indent                 = '".jQWE::newInstance()->jQWE_get('jQWE_indent')."',
                    jQWE.trans_indent           = '".__('Indent', 'jquery_wysiwyg_editor')."',
                    jQWE.outdent                = '".jQWE::newInstance()->jQWE_get('jQWE_outdent')."',
                    jQWE.trans_outdent          = '".__('Outdent', 'jquery_wysiwyg_editor')."',
                    jQWE.ordered                = '".jQWE::newInstance()->jQWE_get('jQWE_ordered')."'
                    jQWE.trans_ordered          = '".__('Ordered List', 'jquery_wysiwyg_editor')."',
                    jQWE.unordered              = '".jQWE::newInstance()->jQWE_get('jQWE_unordered')."',
                    jQWE.trans_unordered        = '".__('Unordered List', 'jquery_wysiwyg_editor')."',
                    jQWE.clear                  = '".jQWE::newInstance()->jQWE_get('jQWE_clear')."', 
                    jQWE.trans_clear            = '".__('Clear Format', 'jquery_wysiwyg_editor')."';
                    jQWE.height                 = '".jQWE::newInstance()->jQWE_get('jQWE_height')."', 
                    jQWE.trans_height           = '".__('Define height of editor window', 'jquery_wysiwyg_editor')."'; 
            </script>
            ";
            
            if (!$editor_toggle && $editor_height) {
                $script .= '
            <style>
            .wysiwyg-container {
                height: '.$editor_height.'px;
            }
            </style>
                ';
            } elseif ($editor_toggle && $editor_min && $editor_max) {
                $script .= '
            <style>
            .wysiwyg-container {
                height: '.$editor_min.'px !important;
                
            }
            .wysiwyg-container.wysiwyg-active {
                height: '.$editor_max.'px !important;
                
            }
            </style>
                ';    
            }
            return $script;
                
        } else {                        
            $script = "
            <script type=\"text/javascript\" src=\"".dirname(osc_plugin_url(__FILE__))."/assets/js/wysiwyg.min.js\"></script>
            <script type=\"text/javascript\" src=\"".dirname(osc_plugin_url(__FILE__))."/assets/js/wysiwyg-editor.min.js\"></script>
            <script type=\"text/javascript\">
                function htmleditor(container) {  
                    $(container).each( function(index, element) {
                        $(element).wysiwyg({
                            classes: 'content-editor',
                            toolbar: 'top',            
                            placeholder: '".jQWE::newInstance()->jQWE_get('jQWE_placeholder')."',                                            
                            placeholderUrl: '".jQWE::newInstance()->jQWE_get('jQWE_placeholderURL')."',
                            buttons: {
                                ".(jQWE::newInstance()->jQWE_get('jQWE_fonts') == "1" ? "
                                fontname: index == 1 ? false : {
                                title: '"._e('Fonts', 'jquery_wysiwyg_editor')."',
                                image: '\uf031',
                                popup: function( popups, button ) {
                                    var list_fontnames = {
                                            'Amatic SC'             : 'Amatic SC',
                                            'Architects Daughter'   : 'Architects Daughter',
                                            'Arial, Helvetica'      : 'Arial,Helvetica',
                                            'Audiowide'             : 'Audiowide',
                                            'Bad Script'            : 'Bad Script',
                                            'Black Ops One'         : 'Black Ops One',
                                            'Calligraffitti'        : 'Calligraffitti',
                                            'Cinzel'                : 'Cinzel',
                                            'Cinzel Decorative'     : 'Cinzel Decorative',
                                            'Codystar'              : 'Codeystar',
                                            'Cookie'                : 'Cookie',
                                            'Courier New'           : 'Courier New,Courier',
                                            'Dancing Script'        : 'Dancing Script',
                                            'Dosis'                 : 'Dosis',
                                            'Forum'                 : 'Forum',
                                            'Fredericka the Great'  : 'Fredericka the Great',
                                            'Georgia'               : 'Georgia',
                                            'Great Vibes'           : 'Great Vibes',
                                            'Handlee'               : 'Handlee',
                                            'Josefin Sans'          : 'Josefin Sans',
                                            'Josefin Slab'          : 'Josefin Slab',
                                            'Kaushan Script'        : 'Kaushan Script',
                                            'Lobster Two'           : 'Lobster Two',
                                            'Maven Pro'             : 'Maven Pro',
                                            'Orbitron'              : 'Orbitron',
                                            'Play'                  : 'Play',
                                            'Playball'              : 'Playball',
                                            'Petit Formal Script'   : 'Petit Formal Script',
                                            'Poiret One'            : 'Poiret One',
                                            'PT Serif'              : 'PT Serif',
                                            'Quicksand'             : 'Quicksand',
                                            'Raleway'               : 'Raleway',
                                            'Rock Salt'             : 'Rock Salt',
                                            'Shadows Into Light'    : 'Shadows Into Light',
                                            'Tangerine'             : 'Tangerine',
                                            'Times New Roman'       : 'Times New Roman,Times',
                                            'Verdana'               : 'Verdana,Geneva',
                                            'Vollkorn'              : 'Vollkorn'
                                        };
                                    var list = $('<div/>').addClass('wysiwyg-plugin-list')
                                                           .attr('unselectable','on');
                                    $.each( list_fontnames, function( name, font ) {
                                        var link = $('<a/>').attr('href','#')
                                                            .css( 'font-family', font )
                                                            .html( name )
                                                            .click(function(event) {
                                                                $(element).wysiwyg('shell').fontName(font).closePopup();
                                                                event.stopPropagation();
                                                                event.preventDefault();
                                                                return false;
                                                            });
                                        list.append( link );
                                    });
                                    popups.append( list );
                                   }    
                                },
                                " : "")."
                                ".(jQWE::newInstance()->jQWE_get('jQWE_fontsize') == "1" ? "
                                fontsize: index == 1 ? false : {
                                    title: '"._e('Fontsize', 'jquery_wysiwyg_editor')."',
                                    image: '\uf034',
                                    popup: function( popup, button ) {
                                    var list_fontsizes = [];
                                    for( var i=8; i <= 11; ++i )
                                        list_fontsizes.push(i+'px');
                                    for( var i=12; i <= 28; i+=2 )
                                        list_fontsizes.push(i+'px');
                                    list_fontsizes.push('36px');
                                    list_fontsizes.push('48px');
                                    list_fontsizes.push('72px');
                                    var list = $('<div/>').addClass('wysiwyg-plugin-list')
                                                           .attr('unselectable','on');
                                    $.each( list_fontsizes, function( index, size ) {
                                        var link = $('<a/>').attr('href','#')
                                                            .html( size )
                                                            .click(function(event) {
                                                                $(element).wysiwyg('shell').fontSize(7).closePopup();
                                                                $(element).wysiwyg('container')
                                                                        .find('font[size=7]')
                                                                        .removeAttr('size')
                                                                        .css('font-size', size);
                                                                // prevent link-href-#
                                                                event.stopPropagation();
                                                                event.preventDefault();
                                                                return false;
                                                            });
                                        list.append( link );
                                    });
                                    popup.append( list );
                                   }    
                                },
                                " : "")."
                                ".(jQWE::newInstance()->jQWE_get('jQWE_header') == "1" ? "
                                header: index == 1 ? false : {
                                    title: '"._e('Header', 'jquery_wysiwyg_editor')."',
                                    image: '\uf1dc',
                                    showstatic: true,    
                                    showselection: true,     
                                    popup: function( popup, button ) {
                                            var list_headers = {
                                                    'Header 1' : '<h1>',
                                                    'Header 2' : '<h2>',
                                                    'Header 3' : '<h3>',
                                                    'Header 4' : '<h4>',
                                                    'Header 5' : '<h5>',
                                                    'Header 6' : '<h6>'
                                                };
                                            var list = $('<div/>').addClass('wysiwyg-plugin-list')
                                                                   .attr('unselectable','on');
                                            $.each( list_headers, function( name, format ) {
                                                var link = $('<a/>').attr('href','#')
                                                                     .css( 'font-family', format )
                                                                     .html( name )
                                                                     .click(function(event) {
                                                                        $(element).wysiwyg('shell').format(format).closePopup();
                                                                        event.stopPropagation();
                                                                        event.preventDefault();
                                                                        return false;
                                                                    });
                                                list.append( link );
                                            });
                                            popup.append( list );
                                           }
                                },
                                " : "")."
                                ".(jQWE::newInstance()->jQWE_get('jQWE_bold') == "1" ? "
                                bold: {
                                    title: '"._e('Bold (CTRL + B)', 'jquery_wysiwyg_editor')."',
                                    image: '\uf032',
                                    hotkey: 'b'
                                },
                                " : "")."
                                ".(jQWE::newInstance()->jQWE_get('jQWE_italic') == "1" ? "
                                italic: {
                                    title: '"._e('Italic (CTRL + I)', 'jquery_wysiwyg_editor')."',
                                    image: '\uf033',
                                    hotkey: 'i'
                                },
                                " : "")."
                                ".(jQWE::newInstance()->jQWE_get('jQWE_underline') == "1" ? "
                                underline: {
                                    title: '"._e('Underline (CTRL + U)', 'jquery_wysiwyg_editor')."',
                                    image: '\uf0cd',
                                    hotkey: 'u'
                                },
                                " : "")."
                                ".(jQWE::newInstance()->jQWE_get('jQWE_strikethrough') == "1" ? "
                                strikethrough: {
                                    title: '"._e('Strikethrough (CTRL + S)', 'jquery_wysiwyg_editor')."',
                                    image: '\uf0cc',
                                    hotkey: 's'    
                                },
                                " : "")."
                                ".(jQWE::newInstance()->jQWE_get('jQWE_link') == "1" ? "
                                insertlink: {
                                    title: '"._e('Insert Link', 'jquery_wysiwyg_editor')."',
                                    image: '\uf08e'
                                },
                                " : "")."
                                ".(jQWE::newInstance()->jQWE_get('jQWE_textcolor') == "1" ? "
                                forecolor: {
                                    title: '"._e('Textcolor', 'jquery_wysiwyg_editor')."',
                                    image: '\uf1fc'    
                                },
                                " : "")."
                                ".(jQWE::newInstance()->jQWE_get('jQWE_bgsize') == "1" ? "
                                highlight: {
                                    title: '"._e('Backgroundcolor', 'jquery_wysiwyg_editor')."',
                                    image: '\uf043'    
                                },
                                " : "")."
                                ".(jQWE::newInstance()->jQWE_get('jQWE_alignleft') == "1" ? "
                                alignleft: index != 0 ? false : {
                                    title: '"._e('Align Left', 'jquery_wysiwyg_editor')."',
                                    image: '\uf036'    
                                },
                                " : "")."
                                ".(jQWE::newInstance()->jQWE_get('jQWE_aligncenter') == "1" ? "
                                aligncenter: index != 0 ? false : {
                                    title: '"._e('Align Center', 'jquery_wysiwyg_editor')."',
                                    image: '\uf037'    
                                },
                                " : "")."
                                ".(jQWE::newInstance()->jQWE_get('jQWE_alignright') == "1" ? "
                                alignright: index != 0 ? false : {
                                    title: '"._e('Align Right', 'jquery_wysiwyg_editor')."',
                                    image: '\uf038'    
                                },
                                " : "")."
                                ".(jQWE::newInstance()->jQWE_get('jQWE_alignjustified') == "1" ? "
                                alignjustify: index != 0 ? false : {
                                    title: '"._e('Justify', 'jquery_wysiwyg_editor')."',
                                    image: '\uf039'    
                                },
                                " : "")."
                                ".(jQWE::newInstance()->jQWE_get('jQWE_subscript') == "1" ? "
                                subscript: index == 1 ? false : {
                                    title: '"._e('Subscript', 'jquery_wysiwyg_editor')."',
                                    image: '\uf12c'    
                                },
                                " : "")."
                                ".(jQWE::newInstance()->jQWE_get('jQWE_superscript') == "1" ? "
                                superscript: index == 1 ? false : {
                                    title: '"._e('Superscript', 'jquery_wysiwyg_editor')."',
                                    image: '\uf12b'    
                                },
                                " : "")."
                                ".(jQWE::newInstance()->jQWE_get('jQWE_indent') == "1" ? "
                                indent: index != 0 ? false : {
                                    title: '"._e('Indent', 'jquery_wysiwyg_editor')."',
                                    image: '\uf03c'    
                                },
                                " : "")."
                                ".(jQWE::newInstance()->jQWE_get('jQWE_outdent') == "1" ? "
                                outdent: index != 0 ? false : {
                                    title: '"._e('Outdent', 'jquery_wysiwyg_editor')."',
                                    image: '\uf03b'    
                                },
                                " : "")."
                                ".(jQWE::newInstance()->jQWE_get('jQWE_ordered') == "1" ? "
                                orderedList: index != 0 ? false : {
                                    title: '"._e('Ordered List', 'jquery_wysiwyg_editor')."',
                                    image: '\uf0cb'    
                                },
                                " : "")."
                                ".(jQWE::newInstance()->jQWE_get('jQWE_unordered') == "1" ? "
                                unorderedList: index != 0 ? false : {
                                    title: '"._e('Unordered List', 'jquery_wysiwyg_editor')."',
                                    image: '\uf0ca'    
                                },
                                " : "")."
                                ".(jQWE::newInstance()->jQWE_get('jQWE_clear') == "1" ? "
                                removeformat: {
                                    title: '"._e('Clear Format', 'jquery_wysiwyg_editor')."',
                                    image: '\uf12d'    
                                }
                                " : "")."
                            }
                        });
                    });
                }
                $(document).ready(function () {
                    htmleditor('textarea[id^=description]');
                });
            </script>
            ";
            
            if (!$editor_toggle && $editor_height) {
                $script .= '
            <style>
            .wysiwyg-container {
                height: '.$editor_height.'px;
            }
            </style>
                ';
            } elseif ($editor_toggle && $editor_min && $editor_max) {
                $script .= '
            <style>
            .wysiwyg-container {
                height: '.$editor_min.'px !important;
                
            }
            .wysiwyg-container.wysiwyg-active {
                height: '.$editor_max.'px !important;
                
            }
            </style>
                ';    
            }
        }
        
        return $script;
    }           
}

?>