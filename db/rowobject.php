<?php

    namespace BaseCMS\db;
    
    use BaseCMS\db\DatabaseException as DatabaseException;
    
    class RowObject {
    
        private $table;
        private $row;
    
        function __construct($row_array, $table = null) {
        
            $this->row = $row_array;            
            $this->_set_table($table);
            
        }
        
        function __get($k) {
            if (array_key_exists($k, $this->row)) 
                return $this->row[$k];
            else
                return null;
        }
        
        function __set($k, $v) {
            if (array_key_exists($k, $this->row)) 
                $this->row[$k] = $v;
            else
                throw new \Exception('Can\'t set value in RowObject matching ' . $this->table . '.' . $k);
        }
        
        function _get_table() {
            return $this->table;
        }
        
        function _set_table($table) {
            if (strrpos('`', $table) !== false) {
                throw new DatabaseException('Bad table name in call to RowObject::_set_table');
            }
            $this->table = $table;
            return true;
        }
        
        function _get_row() {
            return $this->row;
        }

        function _update($new_array) {
            foreach($new_array as $k => $v) {
                if (array_key_exists($k, $this->row)) {
                    $this->row[$k] = $v;
                }
            }
        }

    }