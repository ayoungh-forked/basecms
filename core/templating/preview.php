<?php

    namespace BaseCMS\core\templating;

    use BaseCMS\db\RowObject as RowObject;

    class Preview {

        function __construct() {

            session_start();
            $_SESSION['previews'] = array();

        }

        function save($table, $row_obj) {

            session_start();
            if (!$_SESSION['previews'][$table])
                $_SESSION['previews'][$table] = array();

            $row = $row_obj->_get_row();
            if (!$row['id'])
                throw new Exception('Preview cannot save a RowObject without an id!');

            $_SESSION['preview'][$table][$row['id']] = $row;

        }

        function get_one($table, $id) {

            session_start();
            

        }



    }
