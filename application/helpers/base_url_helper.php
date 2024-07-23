<?php
defined('BASEPATH') or exit('No direct script access allowed');

function staticPath()
{
  $ci = &get_instance();
  return $ci->config->item('static_path');
}