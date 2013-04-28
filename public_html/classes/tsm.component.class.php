<?php

class TSM_COMPONENT{

  public function __call($name, $args) {
    if (substr($name, 0, 3) == 'set') {
      //print('called: ' . $name . ' with args: ' . print_r($args, true) . "\n");

      $field = substr($name, 3);

      $tmp = null;
      if (count($args) == 1) {
        $tmp = current($args);
        $this->_data[$field] = $tmp;
      } else {

      }

      return $tmp;
    } else if (substr($name, 0, 3) == 'get') {
      $field = substr($name, 3);

      //print('getting field: [' . $field . ']' . "\n");
      //print_r($this->_data);


      if (isset($this->_data[$field])) {
        if (isset($args[0]) and
          is_numeric($args[0])
        ) {
          // Trying to fetch a repeating element
          if (isset($this->_data[$field][$args[0]])) {
            return $this->_data[$field][$args[0]];
          }

          return null;
        } else if (!count($args) and
          isset($this->_data[$field]) and
            is_array($this->_data[$field])
        ) {
          return $this->_data[$field][0];
        } else {
          // Normal data
          return $this->_data[$field];
        }
      }

      return null;
    } else if (substr($name, 0, 5) == 'count') {
      $field = substr($name, 5);

      if (isset($this->_data[$field]) and
        is_array($this->_data[$field])
      ) {
        return count($this->_data[$field]);
      } else if (isset($this->_data[$field])) {
        return 1;
      } else {
        return 0;
      }
    } else if (substr($name, 0, 3) == 'add') {
      $field = substr($name, 3);

      if (!isset($this->_data[$field])) {
        $this->_data[$field] = array();
      }

      $tmp = current($args);
      $this->_data[$field][] = $tmp;

      return $tmp;
    } else if (substr($name, 0, 5) == 'unset') {
      $field = substr($name, 5);

      if (isset($this->_data[$field])) {
        if (isset($args[0]) and
          is_numeric($args[0])
        ) {
          // Trying to fetch a repeating element
          if (isset($this->_data[$field][$args[0]])) {
            unset($this->_data[$field][$args[0]]);
          }

          return true;
        } else {
          unset($this->_data[$field]);
        }
      }
    } else {
      trigger_error('Call to undefined method $'.get_class($this).'->'.$name.'(...)', E_USER_ERROR);
      return false;
    }
  }

}