<?php

namespace uk\co\neontabs;

abstract class Base {

  function __call($method, $params) {
    $var = lcfirst(substr($method, 3));

    if (strncasecmp($method, "get", 3)) {
      return $this->$var;
    }
    if (strncasecmp($method, "set", 3)) {
      $this->$var = $params[0];
    }
  }

}
