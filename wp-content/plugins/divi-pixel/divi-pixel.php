<?php
/*
Plugin Name: Divi Pixel
Plugin URI:  https://www.divi-pixel.com
Description: Divi Pixel is an all-in-one solution for all Divi users, from absolute beginners to professionals.
Version:     2.29.2
Author:      Octolab OÜ
Author URI:  https://www.divi-pixel.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: dipi-divi-pixel
Domain Path: /languages
 */

/*************
 * Constants *
 *************/
define('DIPI_PLUGIN_FILE', __FILE__);
define('DIPI_VERSION', '2.29.2');
define('DIPI_ITEM_ID', 32718);
define('DIPI_BASE', plugin_basename(DIPI_PLUGIN_FILE));
define('DIPI_DIR', plugin_dir_path(DIPI_PLUGIN_FILE));
define('DIPI_URI', plugins_url('/', DIPI_PLUGIN_FILE));
define('DIPI_PASSWORD_MASK', "************************");
define('DIPI_STORE_URL', 'https://www.divi-pixel.com');
define('DIPI_AUTHOR', 'Divi Pixel');

define('DIPI_INSTAGRAM_REDIRECT_URL', 'https://auth.divi-pixel.com/instagram');
define('DIPI_INSTAGRAM_AUTH_TYPE_BASIC', 'basic');
define('DIPI_INSTAGRAM_AUTH_TYPE_GRAPH', 'graph');

/*********************
 * Plugin Activation *
 *********************/
if (!is_network_admin()) {
    if (dipi_is_theme('Divi') || dipi_is_theme('Extra') || dipi_is_divi_builder_plugin_active()) {
        require_once plugin_dir_path(__FILE__) . 'includes/plugin.php';
    }
}

function dipi_is_divi_builder_plugin_active()
{
    $pluginList = get_option('active_plugins');
    $plugin = 'divi-builder/divi-builder.php';
    return in_array($plugin, $pluginList);
}

function is_divi_builder_active()
{
    if (!function_exists('is_plugin_active')) {
        include_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    return is_plugin_active('divi-builder/divi-builder.php');
}

function dipi_is_theme($target)
{
    $theme = wp_get_theme();

    if ($theme->name == $target || stripos($theme->parent_theme, $target) !== false) {
        return true;
    }

    if (apply_filters('divi_ghoster_ghosted_theme', '') == $target) {
        return true;
    }

    // List of known third party clones of the Divi theme
    $themes = ['Maestro'];
    if (in_array($theme->name, $themes) || in_array($theme->parent_theme, $themes)) {
        return true;
    }

    return false;
}

if (!function_exists('dipi_is_vb')) {
    function dipi_is_vb()
    {
        return function_exists('et_core_is_fb_enabled') && et_core_is_fb_enabled();
    }
}
function dipi_closing_tags($html) {
    preg_match_all('#<([a-zA-Z0-9]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
    $openedtags = $result[1];
    preg_match_all('#</([a-zA-Z0-9]+)>#iU', $html, $result);
    $single_tags = ["br", "input", "img"];
    $closedtags = $result[1];
    $len_opened = count($openedtags);

    if (count($closedtags) == $len_opened) {
        return $html;
    }
    $openedtags = array_reverse($openedtags);
    for ($i=0; $i < $len_opened; $i++) {
        if (!in_array($openedtags[$i], $closedtags)) {
            if (!in_array($openedtags[$i], $single_tags)) {
                $html .= '</'.$openedtags[$i].'>';
            }
        } else {
            unset($closedtags[array_search($openedtags[$i], $closedtags)]);
        }
    }
    return $html;
}
function dipi_is_latin($string) {
    return !preg_match('/[^\x00-\x7F]/', strip_tags($string));
}
function dipi_implode_words($words) {
    $result = '';
    $prevChar = '';
  
    foreach ($words as $word) {
      $firstChar = mb_substr($word, 0, 1);
      if ($word === "," || $word === ".") {
        $result .= $word;
      } else {
        $result .= ' ' . $word;
      }
      $prevChar = mb_substr($word, -1);
    }
  
    return ltrim($result);
  }
function dipi_multilingual_word_count($string) {
    // Use the \p{L} Unicode property to match any letter (including Arabic and non-Arabic letters)
    preg_match_all('/\p{L}+/u', $string, $matches);
    // Return the count of matched words
    return count($matches[0]);
}
function dipi_get_non_latin_words($string, $numWords) {
    preg_match_all('/(?:[\p{L}\'’❜0-9~!@#$%^&*()_{}:;\"\/\[\]\-+]+(?:\'[\p{L}\'’❜0-9~!@#$%^&*()_{}:;\"\/\[\]\.\>\<+]*)*)|[^\s]+/u', $string, $matches);
    $words = $matches[0];
    $numWords = min(count($words), $numWords);
    $selectedWords = array_slice($words, 0, $numWords);
    $selectedText = dipi_implode_words($selectedWords);
    $remainderText = mb_substr($string, mb_strlen($selectedText));
    $suffix = dipi_multilingual_word_count($string) > dipi_multilingual_word_count($selectedText) ? "..." : "";
    return [
        'text' => $selectedText.$suffix,
        'overflowed' => dipi_multilingual_word_count($string) > dipi_multilingual_word_count($selectedText)
    ];
}
function dipi_limit_length_of_html($text, $length) {
    $overflowed = false;
    if (dipi_is_latin($text)) {
        if (str_word_count($text, 0) > $length) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$length])."...";
            $text = dipi_closing_tags($text);
            $overflowed = true;
        } else {
            $text = dipi_closing_tags($text);
        }
    } else if(preg_match("/\p{Han}+/u", $text) > 0) { // For Chinese
        if (mb_strlen($text) > $length) {
            $text = mb_substr( $text, 0, $length )."...";
            $text = dipi_closing_tags($text);
            $overflowed = true;
        } else {
            $text = dipi_closing_tags($text);
        }
    } else { // For non-Latin
        $limit_text = dipi_get_non_latin_words($text, $length );
        $text = dipi_closing_tags($limit_text['text']);
        $overflowed = $limit_text['overflowed'];
    }
    return [
        'text' => $text,
        'overflowed' => $overflowed
    ];
}
/* Get limited text when html length is larger than maxLength.
   This is better than getting limited HTML when html length is larger than maxLength.
*/
function dipi_limit_length_text_of_html($html, $maxLength) {
    $dom = new DOMDocument();
    libxml_use_internal_errors(true); // Suppress any potential warnings/errors from the DOMDocument
    $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

    $currentLength = 0;
    $output = '';

    foreach ($dom->childNodes as $node) {
        if ($currentLength >= $maxLength) {
            break;
        }

        $nodeLength = mb_strlen($node->nodeValue, 'UTF-8');

        if (($currentLength + $nodeLength) <= $maxLength) {
            $output .= $dom->saveHTML($node);
            $currentLength += $nodeLength;
        } else {
            $remainingLength = $maxLength - $currentLength;
            $trimmedContent = mb_substr($node->nodeValue, 0, $remainingLength, 'UTF-8');
            $output .= htmlspecialchars($trimmedContent, ENT_COMPAT | ENT_HTML5, 'UTF-8');
            break;
        }
    }

    return $output;
}

function dipi_limit_length_letters_of_string($string, $maxLength) {
    if (strlen($string) > $maxLength) {
        $shortenedString = substr($string, 0, $maxLength);
        return $shortenedString."..."; // Output: "This is a long stri"
    } else {
        return $string; // Output the original string if it's shorter than the limit
    }
}