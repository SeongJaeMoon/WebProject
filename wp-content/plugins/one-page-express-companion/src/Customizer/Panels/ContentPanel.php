<?php

namespace OnePageExpress\Customizer\Panels;

class ContentPanel extends \OnePageExpress\Customizer\BasePanel
{

    private $popupTemplatesLoaded = false;

    public function init()
    {
        $this->companion()->customizer()->registerScripts(array($this, 'addScripts'));
        $this->companion()->customizer()->previewInit(array($this, '__addPreviewScripts'));
        add_action('cloudpress\customizer\global_scripts', array($this, '__popupsTemplates'));
        add_action('cloudpress\customizer\preview_scripts', array($this, 'loadWPEditor'));

        $this->addSections(
            array(
                "page_layout_reorder"   => array(
                    "wp_data" => array(
                        "title" => "Reorder and remove sections",
                        "panel" => $this->id,
                    ),
                ),
                "page_content_section"  => array(
                    "wp_data" => array(
                        "title" => "Add sections into page",
                        "panel" => $this->id,
                    ),
                ),
                "page_content_settings" => array(
                    "wp_data" => array(
                        "panel" => $this->id,
                    ),
                ),
            )
        );
        $this->addSettings(
            array(
                "page_content" => array(
                    "class"   => "OnePageExpress\\Customizer\\Settings\\ContentSetting",
                    "section" => "page_content_section",
                    "wp_data" => array(
                        "transport" => "postMessage",
                        "default"   => "homepage",
                    ),
                    "control" => array(
                        "class"      => "OnePageExpress\\Customizer\\Controls\\ContentSectionsListControl",
                        "insertText" => "Add Section",
                        "selection"  => "check",
                        "wp_data"    => array(),
                        "dataSource" => "data:sections",
                    ),
                ),
            )
        );
    }


    public function addScripts()
    {
        $jsUrl = $this->companion()->assetsRootURL() . "/js/customizer/";
        wp_enqueue_script('cp-customizer-content', $jsUrl . "customizer-content.js", array(), false, true);
        wp_enqueue_script('cp-customizer-content-tpls', $jsUrl . "customizer-content-tpls.js", array(), false, true);
        wp_enqueue_script('cp-customizer-content-handles', $jsUrl . "customizer-content-handles.js", array(), false, true);
        wp_enqueue_script('customizer-content-sections-overlays', $jsUrl . "customizer-content-sections-overlays.js", array(), false, true);
        wp_enqueue_script('cp-customizer-menu', $jsUrl . "customizer-menu.js", array(), false, true);
    }

    public function __addPreviewScripts()
    {
        $jsUrl = $this->companion()->assetsRootURL() . "/js/customizer/";
    }

    public function loadWPEditor()
    {
        wp_enqueue_script('tinymce_js', includes_url('js/tinymce/') . 'wp-tinymce.php', array('jquery'), false, true);
    }

    public function __popupsTemplates()
    {
        if ($this->popupTemplatesLoaded) {
            return;
        }

        $this->popupTemplatesLoaded = true;

        ?>
        <!--suppress JSAnnotator -->
        <div id="cp-container-editor" style="display:none">
            <ul id="cp-items">
            </ul>
            <div id="cp-items-footer">
                <button type="button" class="button button-large" id="cp-item-cancel"><?php _e('Cancel', 'reiki-companion'); ?></button>
                <button type="button" class="button button-large button-primary" id="cp-item-ok"><?php _e('Apply Changes', 'reiki-companion'); ?></button>
            </div>
        </div>

        <script id="toolbar-template" type="text/template">
            <div class="overlay-tooltip-panel fixed-overlay">
                <div class="overlay-toolbar">
                    <div class="name-group overlay-tooltip-group fixed-overlay">
                        <div class="tab_text">
                            <i class="overlay-toolbar-element-type">
                            </i>
                        </div>
                    </div>
                    <div class="options-group cog overlay-tooltip-group fixed-overlay">
                        <div class="overlay-contextual-menu">
                        </div>
                    </div>
                    <div style="clear:both;width:0px">
                    </div>
                </div>
            </div>
        </script>

        <script id="cp-content-templates-text" type="text/template">
            <li class="customize-control customize-control-text">
                <label>
                    <span class="customize-control-title">{{{ label }}}</span>
                    <input type="text" value="{{ value }}" id="{{{ id }}}">
                </label>
            </li>
        </script>


        <script id="cp-content-templates-text-with-checkbox" type="text/template">
            <li class="customize-control customize-control-checkbox">
                <#  if (canHide) {  #>
                    <label for="{{  id  }}__visible">
                        <input id="{{  id  }}__visible" type="checkbox">
                        {{ enableLabel }}
                </label>
                    <#  if (description) {  #>
                <span class="description customize-control-description">
                                {{  description  }}
                            </span>
                        <#  }  #>
                            <#  }  #>
            </li>
            <li class="customize-control customize-control-text">
                <label id="{{  id  }}_container">
                    <span class="customize-control-title">{{{  label  }}}</span>
                    <input type="text" value="{{{  value.value  }}}" id="{{{  id  }}}">
                </label>
                <inline-script>
                    jQuery("#{{ id }}__visible").prop("checked", {{ value.visible }});
                    jQuery("#{{ id }}__visible").change(function(){
                    if (jQuery(this).prop("checked")) {
                    jQuery("#{{ id }}_container").show();
                    } else {
                    jQuery("#{{ id }}_container").hide();
                    }
                    })
                    jQuery("#{{ id }}__visible").trigger("change");
                </inline-script>
            </li>
        </script>


        <script id="cp-content-templates-link" type="text/template">
            <li class="customize-control customize-control-text">
                <label class="link-options-group">
                    <div class="link-option">
                        <span class="customize-control-title">{{{  label  }}}</span>
                        <input type="text" value="{{{  value.link  }}}" id="{{  id  }}__link">
                    </div>
                    <#  if (value.target ) {  #>
                    <div class="target-option">
                        <span class="customize-control-title">Target</span>
                            <select type="text" id="{{  id  }}__target">
                            <option value="_self">Same tab</option>
                            <option value="_blank">New tab</option>
                                <# if(CP_Customizer.IS_PRO) { #>
                                    <option style="display:{{   (CP_Customizer.IS_PRO?'':'none')  }}" value="lightbox">Lightbox</option>
                                    <# } #>
                        </select>
                        <inline-script>
                                jQuery("#{{ id }}__target").val("{{{ value.target }}}")
                        </inline-script>
                    </div>
                        <#  }  #>
                </label>
            </li>
        </script>

        <script id="cp-content-templates-list" type="text/template">
            <li class="customize-control customize-control-text">
                <div class="list-control list" id="{{{  id  }}}">
                    <#  _.each(value, function(item, index) {  #>
                    <div class="section-list-item">
                        <div class="handle reorder-handler"></div>
                            <input class="item-editor" type="text" value="{{{  item.value  }}}">
                        <div class="item-actions">
                            <span class="item-remove" title="Delete section from page" onClick='jQuery(this).parents(".section-list-item").remove()'></span>
                        </div>
                    </div>
                        <#  });  #>
                </div>
                <a class="add-item button-primary" id="add_{{  id  }}">Add Item</a>
                <inline-script>
                    jQuery("#{{ id }}").sortable({"axis" : "y"});
                    jQuery("#add_{{ id }}").click(function(){
                    var list = jQuery("#{{ id }}");
                    var $item = list.children().first().clone();
                    list.append($item);
                    })
                </inline-script>
            </li>
        </script>
        <script id="cp-content-templates-image" type="text/template">
            <li class="customize-control customize-control-text" style="display: list-item;">
                <label>
                    <span class="customize-control-title">{{{  label  }}}</span>

                    <div class="image-wrapper">
                        <img id="preview-{{  id  }}" src="{{{  value  }}}">
                    </div>
                    <div class="image-controls">
                        <input type="text" value="{{{  value  }}}" id="{{{  id  }}}">
                        <button type="button" onClick='CP_Customizer.openMediaBrowser("{{{  mediaType  }}}", jQuery("#{{  id  }}"), {{  JSON.stringify(mediaData)  }})' class="button upload-button cp-image-select" data-cp-src="{{{  id  }}}">Browse Image</button>
                    </div>
                    <inline-script>
                        jQuery("#{{ id }}").change(function(){ jQuery("#preview-{{ id }}").attr("src",this.value)})
                    </inline-script>
                </label>
            </li>
        </script>

        <script id="cp-content-templates-linked-icon" type="text/template">
            <li class="customize-control customize-control-text" style="display: list-item;">
                <div class="label">
                    <span class="customize-control-title">{{{  label  }}}</span>
                    <div class="image-wrapper">
                        <i id="preview-icon-{{  id  }}" class="fa {{  value.icon  }}"></i>
                        <#  if (canHide) {  #>
                            <label for="{{  id  }}__visible">
                                <input id="{{  id  }}__visible" type="checkbox" {{ (value.visible?"checked='true'":"") }}>
                            Visible
                        </label>
                            <#  }  #>
                    </div>
                    <div class="image-controls">
                        <div style="float: left;width: calc( 100% - 110px);box-sizing: border-box;">
                            <span class="customize-control-title">Link</span>
                            <input type="text" value="{{{  value.link  }}}" id="{{  id  }}__link">
                        </div>

                        <div style="float: left;width: 110px;padding-left: 4px;box-sizing: border-box;<#  if (!value.target) {  #>display:none<#  }  #>">
                            <span class="customize-control-title">Target</span>
                            <select type="text" id="{{  id  }}__target">
                                <option value="_self">Same tab</option>
                                <option value="_blank">New tab</option>
                                <# if(CP_Customizer.IS_PRO) { #>
                                <option style="display:{{   (CP_Customizer.IS_PRO?'':'none')  }}" value="lightbox">Lightbox</option>
                                <# } #>
                            </select>
                        </div>

                        <input type="hidden" value="{{{  value.icon  }}}" id="{{  id  }}__icon">
                        <button type="button" onClick='CP_Customizer.openMediaBrowser("{{{  mediaType }}}", jQuery("#{{  id  }}__icon"), {{  JSON.stringify(mediaData)  }})' class="button upload-button cp-fa-select" data-cp-src="{{  id  }}__icon">Browse Icon</button>
                    </div>
                    </div>
                <inline-script>
                    jQuery("#{{ id }}__target").val("{{{ value.target }}}")
                    jQuery("#{{ id }}__icon").change(function(){ jQuery("#preview-icon-{{ id }}").attr("class","fa " + this.value)})
                </inline-script>
            </li>
        </script>

        <script id="cp-content-templates-icon" type="text/template">
            <li class="customize-control customize-control-text" style="display: list-item;">
                <div>
                    <span class="customize-control-title">{{{  label  }}}</span>
                    <div class="image-wrapper">
                        <i id="preview-icon-{{  id  }}" class="fa {{  value.icon  }}"></i>
                        <#  if (canHide) {  #>
                            <label for="{{  id  }}__visible">
                                <input id="{{  id  }}__visible" type="checkbox" {{ (value.visible?"checked='true'":"") }}>
                            Visible
                        </label>
                            <#  }  #>
                    </div>
                    <div class="image-controls">
                        <input type="hidden" value="{{{  value.icon  }}}" id="{{  id  }}__icon">
                        <button type="button" onClick='CP_Customizer.openMediaBrowser("{{{  mediaType }}}", jQuery("#{{  id  }}__icon"), {{  JSON.stringify(mediaData)  }})' class="button upload-button cp-fa-select" data-cp-src="{{  id  }}__icon">Browse Icon</button>
                        <div>
                            <# if(typeof styles !== 'undefined') { #>
                                <div style="float: left;width: 180px;">
                                    <span class="customize-control-title" style="margin:0.5rem 0">Icon Style</span>
                                    <select type="text" id="{{  id  }}__style">
                                        <# _.each(styles, function(item, index) {  #>
                                            <option value="{{{ item.value }}}">{{ item.label }}</option>
                                            <#  }) #>
                                    </select>
                                    <inline-script>
                                        try{
                                            jQuery("[id={{ id }}__style").val("{{{ value.style }}}")
                                        } catch(e){}
                                    </inline-script>
                    </div>

                            <# } #>

                            <# if(typeof sizes !== 'undefined') { #>
                                <div style="float: left;margin-left: 10px;width: 130px;">
                                    <span class="customize-control-title" style="margin:0.5rem 0">Icon Size</span>
                                    <select type="text" id="{{  id  }}__size">
                                        <#  _.each(sizes, function(item, index) {  #>
                                            <option value="{{{ item.value }}}">{{ item.label }}</option>
                                            <#  }) #>
                                    </select>
                <inline-script>
                                        try{
                                        jQuery("[id={{ id }}__size").val("{{{ value.size }}}")
                                        } catch(e){}
                                    </inline-script>
                                </div>
                            <# } #>
                        </div>

                    </div>
                </div>
                <inline-script>
                    jQuery("#{{ id }}__icon").change(function(){ jQuery("#preview-icon-{{ id }}").attr("class","fa " + this.value)})
                </inline-script>
            </li>
        </script>


        <?php

    }

    public function render_template()
    {
        ?>
        <li id="accordion-panel-{{ data.id }}" data-name="{{{ data.id }}}" class="accordion-section control-section control-panel control-panel-{{ data.type }}">
            <h3 class="accordion-section-title no-chevron" tabindex="0">
                {{ data.title }}

                <span title="Add Section" class="add-section-plus section-icon"></span>

            </h3>


            <div class="sections-list-reorder">
                <span class="customize-control-title"><?php _e('Manage page sections', 'cloudpress-companion'); ?></span>
                <ul id="page_full_rows" class="list list-order">
                    <li class="empty">No section added</li>
                </ul>
                <div class="add-section-container">
                    <a class="cp-add-section available-item-hover-button button-primary"><?php _e('Add Section', 'cloudpress-companion'); ?></a>
                </div>
            </div>
        </li>
        <?php ;
    }
}
