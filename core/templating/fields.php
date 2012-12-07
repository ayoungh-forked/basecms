  <?php
  
      namespace BaseCMS\core\templating;
      
      use BaseCMS\core\Text as t;
      
      class Fields {
      
          private $fieldmap;
          private $defaults;
          private $output = '';
          private $store_output ;
      
          function __construct($fieldmap, $defaults) {
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
          
          function output() {
              echo $this->output;
          }
          
          function render_dropdown() {}
          function render_radio() {}
          function render_checkboxes() {}
  
          private function get_input($name, $type, $qualifier, $default_value, $display_title, $description, $placeholder) {
  
              if (!$display_title) 
                  $display_title = t::snakecase_to_titlecase($name);
              if ($description)
                  $description = '<div class="description">' . $description . '</div>';
              else
                  $description = '';
                  
              ob_start();
              echo '<div class="form_field" id="' . $name . '">';
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
                      if ($qualifier == 'path_fragment') {
                          $attrs .= 'maxlen="100" ';
                          $classes .= 'url_path ';
                          $qualifier = null; // Don't let this bleed over
                      }
                      if (!$type_attr) $type_attr = 'url';
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
                      if ($placeholder) $attrs .= 'placeholder="'.$placeholder.'"';
                      $classes .= "html ";
                  case 'textarea':
                      if ($placeholder) $attrs .= 'placeholder="'.$placeholder.'"';
                      ?>
                      <label for="<?=$name?>"><?=$display_title?></label>
                      <textarea name="<?=$name?>" id="<?=$name?>" <?=$attrs?> class="<?=$classes?>">
                          <?=$default_value?>
                      </textarea>
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
              $output = ob_end_flush();
              return $output;
          }
      
      }