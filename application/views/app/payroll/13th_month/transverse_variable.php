<?php
preg_match_all('~\{\$(.*?)\}~si',$for_translation,$matches);
if ( isset($matches[1])) {
    $r = compact($matches[1]);
    foreach ( $r as $var => $value ) {
        $for_translation = str_replace('{$'.$var.'}',$value,$for_translation);
    }
}

?>