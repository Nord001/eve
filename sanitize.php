<?php
function sanitize($string, $length = null)
{
  # Remove dead spaces from string.
  $string = trim($string);
  $string = preg_replace('/\s+/', ' ', $string);
  
  # Prevent potential Unicode codec problems.
  utf8_decode($string);

  # Converts HTML characters into their respective HTML entities.
  htmlentities($string, ENT_NOQUOTES);  
  $string = str_replace("#", "&#35;", $string);
  $string = str_replace("%", "&#37;", $string);
  
  # Trims string to given length (prevents excessive strings).
  $length = intval($length);
  if($length > 0)
  {
    $string = substr($string, 0, $length);
  }
  
  return $string;
}
?>