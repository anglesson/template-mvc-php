<?php

function dd(...$args)
{
  echo '===== DEBUG MODE =====';
  foreach ($args as $arg)
  {
    echo '<pre>';
      print_r($arg);
    echo '<pre>';
  }
  exit;
}