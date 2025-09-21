<?php
/**
* Debug functions
  *
  * @package WordPress
  * @subpackage Ninjapiraten
  * @since 1.4
  */

defined ('ABSPATH') || exit;

/**
 * Print $var in <pre> tags
 *
 * @param mixed $var - the value to print_r
 */
function pre_printr($var)
{
    echo "<pre style='background: lightgrey; font-family:monospace;padding: 8px;'>\n";
    print_r($var);
    echo "\n</pre>\n";
}


/**
 * Dump $var in <pre> tags
 *
 * @param mixed $var - the value to var_dump
 */
function pre_var_dump(...$var)
{
    echo "<pre style='background:lightgrey; font-family:monospace;padding: 8px;'>\n";
    var_dump(...$var);
    echo "\n</pre>\n";
}

/**
 * Write $callable in debug.log
 *
 * @param mixed $callable - the value to write in debug.log
 */
function debug_print($callable)
{
    static $fh;

    if (!$fh) {
        $fh = fopen(NP_THEME_TEMPLATE_PATH . "log/debug.log", "w+");
    }

    ob_start();
    echo $callable();
    $content = ob_get_contents();
    ob_end_clean();

    fwrite($fh, $content . "\n");

    fclose($fh);
}
