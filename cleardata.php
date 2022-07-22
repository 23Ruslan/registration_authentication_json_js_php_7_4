<?php
function cleardata($text) { // basic injection protection
    return htmlspecialchars( (get_magic_quotes_gpc()==1) ? (stripslashes(trim($text))) : (trim($text)) );
} // stripslashes removes character escaping \