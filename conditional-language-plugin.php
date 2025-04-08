<?php
/*
Plugin Name: Conditional Language Shortcodes
Description: Displays content based on language detected in the URL. Supports [conditional_language] container with [if_lang] and [otherwise] shortcodes.
Version: 1.0
Author:      Riccardo De Martis
Author URI:  https://www.linkedin.com/in/rdemartis
Domain Path: /languages
Text Domain: conditional-language-shortcodes
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Conditional_Language_Plugin {

    // Flag to detect whether we're processing a container shortcode.
    private static $inside_container = false;

    // Flag to check if a matching if_lang has been output.
    private static $match_found = false;

    /**
     * Initialize plugin: register shortcodes.
     */
    public static function init() {
        add_shortcode( 'conditional_language', array( __CLASS__, 'conditional_language_handler' ) );
        add_shortcode( 'if_lang', array( __CLASS__, 'if_lang_handler' ) );
        add_shortcode( 'otherwise', array( __CLASS__, 'otherwise_handler' ) );
    }

    /**
     * Detect the current language code based on $_SERVER['PHP_SELF'].
     *
     * Using regex pattern ^/(gb|au|us)/(.+)-\1(/)?$.
     *
     * @return string Current language code (lowercase) or empty string if not found.
     */
    public static function get_current_language() {
        if ( ! empty( $_SERVER['PHP_SELF'] ) ) {
            // The regex pattern is case insensitive.
            if ( preg_match( '#^/(gb|au|us)/(.+)-\\1/?$#i', $_SERVER['PHP_SELF'], $matches ) ) {
                return strtolower( $matches[1] );
            }
        }
        return '';
    }

    /**
     * Handler for the [conditional_language] container shortcode.
     *
     * Sets internal flags, processes inner shortcodes,
     * and then resets the flags.
     *
     * @param array  $atts Attributes (none needed).
     * @param string $content The inner content containing if_lang/otherwise shortcodes.
     * @return string Processed content based on language.
     */
    public static function conditional_language_handler( $atts, $content = null ) {
        // Set the container flag and reset our match state.
        self::$inside_container = true;
        self::$match_found     = false;

        // Process the inner shortcodes.
        $output = do_shortcode( $content );

        // Reset the container flag.
        self::$inside_container = false;

        // If nothing was matched inside, you can decide if output should be empty.
        return $output;
    }

    /**
     * Handler for the [if_lang] shortcode.
     *
     * Outputs its content if the 'code' attribute matches the current language.
     *
     * @param array  $atts Attributes, expects a 'code' attribute.
     * @param string $content The content to display if language matches.
     * @return string Content if matched, empty string otherwise.
     */
    public static function if_lang_handler( $atts, $content = null ) {
        // Parse shortcode attributes.
        $atts = shortcode_atts( array(
            'code' => '',
        ), $atts, 'if_lang' );

        $current_lang = self::get_current_language();

        print( 'Current Language: ' );
        print_r( $current_lang );


        // Check if the shortcode attribute matches the current language.
        // When inside the container, only output if we have not yet output any match.
        if ( strtolower( $atts['code'] ) === $current_lang ) {
            // If within a container and no match has been found yet, mark as matched.
            if ( self::$inside_container && ! self::$match_found ) {
                self::$match_found = true;
            }
            // Process nested shortcodes within content.
            return do_shortcode( $content );
        }

        return ''; // No match—no output.
    }

    /**
     * Handler for the [otherwise] shortcode.
     *
     * Outputs its content only if no language match was found within
     * the [conditional_language] container.
     *
     * @param array  $atts Attributes (none needed).
     * @param string $content The fallback content.
     * @return string Content if no previous match was found, empty string otherwise.
     */
    public static function otherwise_handler( $atts, $content = null ) {
        // Only output if we're inside the container and no match has been found yet.
        if ( self::$inside_container && ! self::$match_found ) {
            // Optionally, mark as matched to prevent multiple otherwise blocks.
            self::$match_found = true;
            return do_shortcode( $content );
        }
        // If used outside the container, you may choose to return content unconditionally.
        return '';
    }
}

// Initialize the plugin.
add_action( 'init', array( 'Conditional_Language_Plugin', 'init' ) );
