<?php
/**
 * Project: EVE Online Information System Project
 * 
 * Title: Sanitize.php
 * 
 * Author: Andy Lo
 * E-Mail: andy.lo@gmx.com
 */

function sanitize($p_string, $p_string_length = null) {
    // Remove dead whitespace from string.
    $p_string = trim($p_string);
    $p_string = preg_replace('/\s+/', ' ', $p_string);
  
    // Prevent potential Unicode codec problems.
    utf8_decode($p_string);

    // Converts HTML characters into their respective HTML entities.
    htmlentities($p_string, ENT_NOQUOTES);
    $p_string = str_replace("#", "&#35;", $p_string);
    $p_string = str_replace("%", "&#37;", $p_string);
  
    // Trims string to given length (prevents excessive strings).
    $c_string_length = intval($p_string_length);
    if(is_int($c_string_length) && $c_string_length > 0) {
        $p_string = substr($p_string, 0, $c_length);
    }
    
    $c_string = mysqli_real_escape_string($p_string);
    
    return $c_string;
}
?>