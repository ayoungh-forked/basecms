<?php
  
    namespace BaseCMS\core\templating;
    
    use BaseCMS\core\Text as t;
    
    class Fields {
    
        private $fieldmap;
        private $defaults;
        private $output = '';
        private $store_output ;
    
        function __construct($fieldmap, $defaults, $store_output = true) {
            $this->fieldmap = $fieldmap;
            $this->defaults = $defaults;
            $this->store_output = $store_output;
        }
  
        function render($name, $display_title, $description, $placholder) {
            $default_value = $this->defaults[$name];
            $typeinfo = $this->fieldmap[$name];
            $typeinfo = explode(':', $typeinfo);
            $type = array_shift($typeinfo);
            if (!empty($typeinfo))
                $type_qualifier = array_shift($typeinfo);
            else
                $type_qualifier = null;
            $input_html = $this->get_input($name, $type, $type_qualifier, $default_value, $display_title, $description, $placeholder);
            if ($this->store_output)
                $this->output .= $input_html;
            else
                echo $input_html;
        }
        
        function render_dropdown() {}
        function render_radio() {}
        function render_checkboxes() {}
        
        function form_start($action = '', $method = "POST", $enctype = "multipart/form-data") {
            ?>
            <form action="<?=$action?>" method="<?=$post?>" enctype="<?=$enctype?>">
                <input type="hidden" name="id" value="<?=$this->defaults['id']?>" />
            <?php
        }
        
        function form_end($save_button_label = "Save", $show_delete_button = true, $delete_button_label = "Delete") {
          ?>
            <div class="form_buttons">
                <button name="submit" class="save">
                    <?=$save_button_label?>
                </button>
                <?php
                    if ($show_delete_button) {
                ?>
                <button name="delete" class="delete">
                    <?=$delete_button_label?>
                </button>
                <?php
                    }
                ?>
            </div>
        </form>
          <?php
          
        }
        
        function render_form($button_label = "Save", $show_delete_button = true, $delete_button_label = "Delete", $action = '', $method = "POST", $enctype = "multipart/form-data") {
            $this->form_start($button_label, $action, $method, $enctype);
            echo $this->output;
            $this->form_end($button_label);
        }
  
        private function get_input($name, $type, $qualifier, $default_value, $display_title, $description, $placeholder) {
  
            if (!$display_title) 
                $display_title = t::snakecase_to_titlecase($name);
            if ($description)
                $description = '<div class="description">' . $description . '</div>';
            else
                $description = '';
                
            ob_start();
            echo '<div class="form_field" id="form_field_' . $name . '">';
            $attrs = '';
            $classes = '';
            $type_attr = null;
            switch ($type) {
                case 'range':
                    if (!$type_attr) $type_attr = 'range';
                case 'number':
                    if ($qualifier) {
                        list($range, $step) = explode(',', $qualifier);
                        list($rangemin, $rangemax) = explode('-', $range);
                        if ($rangemin) $attrs .= 'min="'.$rangemin.'" ';
                        if ($rangemax) $attrs .= 'max="'.$rangemax.'" ';
                        if ($step) $attrs .= 'step="'.$step.'" ';
                        $qualifier = null; // Don't let this bleed over
                    }
                    if (!$type_attr) $type_attr = 'number';
                /*
                 * Not all of these HTML5 input types are widely supported yet,
                 * but we can use them to create fallbacks as needed if we set
                 * them here.
                 * 
                 */
                case 'search':
                    if (!$type_attr) $type_attr = 'search';
                case 'date':
                    if (!$type_attr) $type_attr = 'date';
                case 'datetime':
                    if (!$type_attr) $type_attr = 'datetime';
                case 'month':
                    if (!$type_attr) $type_attr = 'month';
                case 'week':
                    if (!$type_attr) $type_attr = 'week';
                case 'time':
                    if (!$type_attr) $type_attr = 'time';
                case 'datetime-local':
                    if (!$type_attr) $type_attr = 'datetime-local';
                case 'email':
                    if (!$type_attr) $type_attr = 'email';
                case 'url':
                    if (!$type_attr) $type_attr = 'url';
                    if ($qualifier == 'path_fragment') {
                        $type_attr = 'text';
                        $attrs .= 'maxlen="100" ';
                        $classes .= 'url_path ';
                        $qualifier = null; // Don't let this bleed over
                    }
                case 'text':
                    if (!$type_attr) $type_attr = 'text';
                    if ($placeholder) $attrs .= 'placeholder="'.$placeholder.'"';
                    ?>
                    <label for="<?=$name?>"><?=$display_title?></label>
                    <input type="<?=$type_attr?>" name="<?=$name?>" id="<?=$name?>" value="<?=$default_value?>" class="<?=$classes?>" <?=$attrs?>/>
                    <?=$description?>
                    <?php 
                    break;
                case 'html':
                    if ($placeholder) $attrs .= 'placeholder="'.$placeholder.'" ';
                    $classes .= "html ";
                    $type_attr = 'html';
                case 'textarea':
                    if ($placeholder) $attrs .= 'placeholder="'.$placeholder.'" ';
                    ?>
                    <label for="<?=$name?>"><?=$display_title?></label>
                    <?php
                        if ($type_attr == 'html') {
                            ?>
                            <div id="wysihtml5-toolbar-<?=$name?>" class="wysihtml5-toolbar" style="display:none">
                                <a data-wysihtml5-command="bold" title="CTRL+B">bold</a> |
                                <a data-wysihtml5-command="italic" title="CTRL+I">italic</a> |
                                <a data-wysihtml5-command="createLink">insert link</a> |
                                <a data-wysihtml5-command="insertImage">insert image</a> |
                                <a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h1">h1</a> |
                                <a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h2">h2</a> |
                                <a data-wysihtml5-command="insertUnorderedList">insertUnorderedList</a> |
                                <a data-wysihtml5-command="insertOrderedList">insertOrderedList</a> |
                                <a data-wysihtml5-command="foreColor" data-wysihtml5-command-value="red">red</a> |
                                <a data-wysihtml5-command="foreColor" data-wysihtml5-command-value="green">green</a> |
                                <a data-wysihtml5-command="foreColor" data-wysihtml5-command-value="blue">blue</a> |
                                <a data-wysihtml5-command="undo">undo</a> |
                                <a data-wysihtml5-command="redo">redo</a> |
                                <a data-wysihtml5-command="insertSpeech">speech</a>
                                <a data-wysihtml5-action="change_view">switch to html view</a>
                                
                                <div data-wysihtml5-dialog="createLink" style="display: none;">
                                  <label>
                                    Link:
                                    <input data-wysihtml5-dialog-field="href" value="http://">
                                  </label>
                                  <a data-wysihtml5-dialog-action="save">OK</a>&nbsp;<a data-wysihtml5-dialog-action="cancel">Cancel</a>
                                </div>
                                
                                <div data-wysihtml5-dialog="insertImage" style="display: none;">
                                  <label>
                                    Image:
                                    <input data-wysihtml5-dialog-field="src" value="http://">
                                  </label>
                                  <label>
                                    Align:
                                    <select data-wysihtml5-dialog-field="className">
                                      <option value="">default</option>
                                      <option value="wysiwyg-float-left">left</option>
                                      <option value="wysiwyg-float-right">right</option>
                                    </select>
                                  </label>
                                  <a data-wysihtml5-dialog-action="save">OK</a>&nbsp;<a data-wysihtml5-dialog-action="cancel">Cancel</a>
                                </div>
                                
                            </div>
                            <?php
                            }
                    ?>
                    <textarea name="<?=$name?>" id="<?=$name?>" <?=$attrs?> class="<?=$classes?>"><?=$default_value?></textarea>
                    <?=$description?>
                    <?php 
                    break;
                case 'bool':
                    $attrs .= $default_value ? 'checked="checked"' : '';
                    ?>
                    <label for="<?=$name?>"><?=$display_title?></label>
                    <input type="checkbox" name="<?=$name?>" id="<?=$name?>" class="<?=$classes?>" <?=$attrs?> value="1" />
                    <?=$description?>
                    <?php
                    break;
  //                case 'template':
                default:
                    echo '';
            }
            echo '</div>';
            $output = ob_get_contents();
            ob_end_clean();
            return $output;
        }
    
    }