<?php
/**
 * Plugin Name: Conditional Language Shortcodes
 * Plugin URI:  https://github.com/demartis/conditional-language
 * Description: Displays content based on the language code detected in the URL via shortcodes. Supports standalone [if_lang] usage as well as a [conditional_language] container with a fallback [otherwise].
 * Version:     1.1.0
 * Author:      Riccardo De Martis
 * Author URI:  https://www.linkedin.com/in/rdemartis
 * License:     LGPL
 * Text Domain: conditional-language-shortcodes
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Class Conditional_Language_Plugin
 *
 * Provides functionality for showing language-based content via shortcodes.
 */
class Conditional_Language_Plugin {

    /**
     * Flag to indicate if we are inside a [conditional_language] container.
     *
     * @var bool
     */
    private static $inside_container = false;

    /**
     * Flag to indicate if a language block has already been output in the container.
     *
     * @var bool
     */
    private static $match_found = false;

    /**
     * Initialize hooks and register shortcodes.
     */
    public static function init() {
        add_shortcode( 'conditional_language', array( __CLASS__, 'conditional_language_handler' ) );
        add_shortcode( 'if_lang', array( __CLASS__, 'if_lang_handler' ) );
        add_shortcode( 'otherwise', array( __CLASS__, 'otherwise_handler' ) );

        // Optionally expose helper function for developers.
        add_action( 'plugins_loaded', array( __CLASS__, 'load_helper_function' ) );
    }

    /**
     * Load helper function into global namespace if it doesn't exist.
     */
    public static function load_helper_function() {
        if ( ! function_exists( 'conditional_language_is' ) ) {
            /**
             * Check if the current language matches the given two-letter language code.
             *
             * @param string $lang Two-letter language code.
             * @return bool True if match; false otherwise.
             */
            function conditional_language_is( $lang ) {
                return ( strtolower( $lang ) === Conditional_Language_Plugin::get_current_language() );
            }
        }
    }

    /**
     * Retrieve the current language from the URL based on $_SERVER['PHP_SELF'].
     *
     * This method supports any 2-letter language code. It looks for a pattern like:
     *   /{lang}/...-{lang}/
     * For example: /gb/something-gb/ or /en/some-page-en/
     *
     * @return string Two-letter language code in lowercase or an empty string if no match.
     */
    public static function get_current_language() {
        if ( ! empty( $_SERVER['PHP_SELF'] ) ) {
            // The following regex matches URLs starting with a slash, followed by any two letters,
            // then a slash, then any characters, a hyphen, the same two letters, and optionally a trailing slash.
            if ( preg_match( '#^/([a-z]{2})/.*-\1/?$#i', $_SERVER['PHP_SELF'], $matches ) ) {
                return strtolower( $matches[1] );
            }
        }
        return '';
    }

    /**
     * Handler for the [conditional_language] container shortcode.
     *
     * This container processes its nested shortcodes and ensures only one matching [if_lang]
     * block is rendered. If no match is found, any [otherwise] content is rendered.
     *
     * @param array  $atts    Unused shortcode attributes.
     * @param string $content Content containing nested [if_lang] and/or [otherwise] shortcodes.
     * @return string Processed output based on the current language.
     */
    public static function conditional_language_handler( $atts, $content = null ) {
        // Initialize container state.
        self::$inside_container = true;
        self::$match_found     = false;

        // Process nested shortcodes.
        $output = do_shortcode( $content );

        // Reset container flag.
        self::$inside_container = false;
        return $output;
    }

    /**
     * Handler for the [if_lang] shortcode.
     *
     * Outputs the enclosed content if the current language (extracted from the URL)
     * matches the provided "code" attribute.
     *
     * @param array  $atts    Shortcode attributes. Expects a "code" attribute for the language code.
     * @param string $content Content to display when the language condition is met.
     * @return string The processed content if the condition is met, otherwise an empty string.
     */
    public static function if_lang_handler( $atts, $content = null ) {
        // Merge shortcode attributes with defaults.
        $atts = shortcode_atts( array(
            'code' => '',
        ), $atts, 'if_lang' );

        $current_lang = self::get_current_language();

        // If the provided language code matches the current language, output the content.
        if ( strtolower( $atts['code'] ) === $current_lang ) {
            // If we are in a container, mark that a match has been found so that subsequent blocks are ignored.
            if ( self::$inside_container && ! self::$match_found ) {
                self::$match_found = true;
            }
            return do_shortcode( $content );
        }
        return ''; // No match found.
    }

    /**
     * Handler for the [otherwise] shortcode.
     *
     * Outputs fallback content if no previous [if_lang] block in the container has produced output.
     *
     * @param array  $atts    Unused shortcode attributes.
     * @param string $content Fallback content to display if no language-specific match is detected.
     * @return string The fallback content or an empty string if a match was already processed.
     */
    public static function otherwise_handler( $atts, $content = null ) {
        // Only output fallback content if within a container and no match was found.
        if ( self::$inside_container && ! self::$match_found ) {
            self::$match_found = true;
            return do_shortcode( $content );
        }
        return ''; // Either outside container or a match already exists.
    }
}

// Initialize the plugin.
add_action( 'init', array( 'Conditional_Language_Plugin', 'init' ) );
