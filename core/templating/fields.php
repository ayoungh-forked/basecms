<?php
  
    namespace BaseCMS\core\templating;
    
    use BaseCMS\core\Text as t;
    
    class Fields {
    
        private $view = null;
        private $fieldmap;
        private $defaults;
        private $output = '';
        private $store_output ;
        private $hidden_fields = '';
    
        function __construct($fieldmap, $row_obj, $store_output = true, $view = null) {
            $defaults = $row_obj->_get_row();
            $this->view = $view;
            if (!$this->view) $this->view = $row_obj->_get_table();
            $this->fieldmap = $fieldmap;
            $this->defaults = $defaults;
            $this->store_output = $store_output;
            foreach($fieldmap as $name => $type) {
                if ($type == 'hidden') {
                    $value = $defaults[$name];
                    $this->hidden_fields .= "<input type=\"hidden\" name=\"$name\" value=\"$value\" />";
                }
            }
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
            <form action="<?=$action?>" method="<?=$method?>" enctype="<?=$enctype?>">
                <input type="hidden" name="id" value="<?=$this->defaults['id']?>" />
                <input type="hidden" name="view" value="<?=$this->view?>" />
                <?=$this->hidden_fields?>
            <?php
        }
        
        function form_end($save_button_label = "Save", $show_delete_button = true, $delete_button_label = "Delete") {
          ?>
            <div class="form_buttons">
                <button name="submit" class="save btn btn-primary" value="1">
                    <?=$save_button_label?>
                </button>
                <?php
                    if ($show_delete_button) {
                ?>
                <button name="delete" class="delete btn" value="1">
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
            echo '<div class="form_field ' . $type . '_field" id="form_field_' . $name . '">';
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
                case 'tags':
                    if (!$type_attr) $type_attr = 'text';
                    $classes .= 'tag-input';
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
                case 'password':
                    if ($placeholder) $attrs .= 'placeholder="'.$placeholder.'"';
                    ?>
                    <label for="<?=$name?>"><?=$display_title?></label>
                    <input type="password" name="<?=$name?>" id="<?=$name?>" value="" class="<?=$classes?>" <?=$attrs?>/>
                    <?php
                        echo $description;
                        if ($qualifier == 'new') {
                    ?>
                        <label for="<?=$name?>_confirm" class="confirm"></label>
                        <input type="password" name="<?=$name?>_confirm" id="<?=$name?>_confirm" value="" class="<?=$classes?> confirm" <?=$attrs?>/>
                        <div class="description">
                            Re-enter the new password to confirm that it is correct.
                        </div>
                    <?php
                        }
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
                            $this->html_toolbar($name);    
                        }
                    ?>
                    <div class="fs-wrapper">
                        <textarea name="<?=$name?>" id="<?=$name?>" <?=$attrs?> class="<?=$classes?>"><?=$default_value?></textarea>
                    </div>
                    <?=$description?>
                    <?php 
                    break;
                case 'bool':
                    $attrs .= $default_value ? 'checked="checked"' : '';
                    ?>
                    <label for="<?=$name?>"><?=$display_title?></label>
                    <div class="input_bounding">
                        <input type="checkbox" name="<?=$name?>" id="<?=$name?>" class="<?=$classes?>" <?=$attrs?> value="1" />
                    </div>
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
        
        protected function html_toolbar($name) {
            ?>
            <div id="wysihtml5-toolbar-<?=$name?>" class="wysihtml5-toolbar" style="display:none">
                <a data-wysihtml5-command="insertSpeech">e</a>
                <a data-wysihtml5-command="insertImage">I</a> 
                <a data-wysihtml5-command="createLink">K</a> 
                <a data-wysihtml5-command="justifyLeft">&#xF036;</a> 
                <a data-wysihtml5-command="justifyFull">&#61497;</a> 
                <a data-wysihtml5-command="justifyCenter">&#xF037;</a> 
                <a data-wysihtml5-command="justifyRight">&#61496;</a> 
                <select>
                    <option  data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="p">No heading</option>
                    <option data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h1">Heading 1</option>
                    <option data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h2">Heading 2</option>
                    <option data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h3">Heading 3</option>
                    <option data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h4">Heading 4</option>
                    <option data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h5">Heading 5</option>
                    <option data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h6">Heading 6</option>
                </select> 
                <a data-wysihtml5-command="insertUnorderedList">&#xF03A;</a> 
                <a data-wysihtml5-command="insertOrderedList">&#xF0CB;</a> 
                <select>
                    <option data-wysihtml5-command="foreColor" data-wysihtml5-command-value="auto">Default text color</option>
                    <option data-wysihtml5-command="foreColor" data-wysihtml5-command-value="red" style="color:red;">Red</option>
                    <option data-wysihtml5-command="foreColor" data-wysihtml5-command-value="green" style="color:green;">Green</option>
                    <option data-wysihtml5-command="foreColor" data-wysihtml5-command-value="blue" style="color:blue;">Blue</option>
                    <option data-wysihtml5-command="foreColor" data-wysihtml5-command-value="yellow" style="color:yellow;">Yellow</option>
                    <option data-wysihtml5-command="foreColor" data-wysihtml5-command-value="black" style="color:black;">Black</option>
                    <option data-wysihtml5-command="foreColor" data-wysihtml5-command-value="white" style="color:white;">White</option>
                </select> 
                <a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="blockquote">&#xF10D;</a>
                <a data-wysihtml5-action="change_view" data-toggle="a">H</a>
                <a class="toggle-fullscreen" data-toggle="&#xF066;">&#xF065;</a>
                
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
    
    }