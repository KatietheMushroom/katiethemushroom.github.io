<?php 

// Change special html characters to their code equivalent
// This prevents the insertion of scripts and other errors

function html($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'utf-8');
}

?>