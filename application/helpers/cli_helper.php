<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('cli_color')) {

    /**
     * Makes a cli clored string
     * @param string $text The text to be colored
     * @param string $color Accepts only red, green, yellow, cyan
     * 
     * @return string
     */
    function cli_color($text, $color, $formated_text = NULL) {
        
        $formated_text = (!is_null($formated_text)) ? $formated_text : $text;

        $colors = [
            "red" => "1;31",
            "green" => "1;32",
            "yellow" => "1;33",
            "cyan" => "1;36"
        ];

        $allowed_colors = array_keys($colors);

        if (!in_array($color, $allowed_colors)) {
            return PHP_EOL . "\033[1;31mThe color '$color' is not allowed!\033[0m" . PHP_EOL;
        }

        $colored = sprintf("\033[%sm$text\033[0m", $colors[$color]);
        
        return str_replace($text, $colored, $formated_text);
    }

}

if (!function_exists('cli_cell')) {

    /**
     * Makes a cli cell like string
     * @param string $text The text to be formated
     * @param int $length Accepts only red, green, yellow, cyan
     * @param string $align Accepts left, right, center
     * 
     * @return string
     */
    function cli_cell($text, $length, $align = 'left'): string
    {

        $text_length = mb_strlen($text);

        if ($length < $text_length) {
            $text = mb_substr($text, 0, $length);
        }

        $result = "";

        switch ($align) {
            case "right":
                $result = sprintf("%" . $length . "s", $text);
                break;
            case "center":
                $rm = floor(($length - $text_length) / 2);
                $lm = $length - $text_length - $rm;
                $result = sprintf("%" . ($lm + $text_length) . "s", $text);
                $result .= str_repeat(" ", $rm);
                break;
            default:
                $result = sprintf("%-" . $length . "s", $text);
        }

        return $result;
        
    }

}
