<?php
/**
 * Internationalization helper.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

if ( ! class_exists( 'Kirki_l10n' ) ) {

	/**
	 * Handles translations
	 */
	class Kirki_l10n {

		/**
		 * The plugin textdomain
		 *
		 * @access protected
		 * @var string
		 */
		protected $textdomain = 'one-page-express';

		/**
		 * The class constructor.
		 * Adds actions & filters to handle the rest of the methods.
		 *
		 * @access public
		 */
		public function __construct() {

			add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

		}

		/**
		 * Load the plugin textdomain
		 *
		 * @access public
		 */
		public function load_textdomain() {

			if ( null !== $this->get_path() ) {
				load_textdomain( $this->textdomain, $this->get_path() );
			}
			load_plugin_textdomain( $this->textdomain, false, Kirki::$path . '/languages' );

		}

		/**
		 * Gets the path to a translation file.
		 *
		 * @access protected
		 * @return string Absolute path to the translation file.
		 */
		protected function get_path() {
			$path_found = false;
			$found_path = null;
			foreach ( $this->get_paths() as $path ) {
				if ( $path_found ) {
					continue;
				}
				$path = wp_normalize_path( $path );
				if ( file_exists( $path ) ) {
					$path_found = true;
					$found_path = $path;
				}
			}

			return $found_path;

		}

		/**
		 * Returns an array of paths where translation files may be located.
		 *
		 * @access protected
		 * @return array
		 */
		protected function get_paths() {

			return array(
				WP_LANG_DIR . '/' . $this->textdomain . '-' . get_locale() . '.mo',
				Kirki::$path . '/languages/' . $this->textdomain . '-' . get_locale() . '.mo',
			);

		}

		/**
		 * Shortcut method to get the translation strings
		 *
		 * @static
		 * @access public
		 * @param string $config_id The config ID. See Kirki_Config.
		 * @return array
		 */
		public static function get_strings( $config_id = 'global' ) {

			$translation_strings = array(
				'background-color'      => esc_attr__( 'Background Color', 'one-page-express' ),
				'background-image'      => esc_attr__( 'Background Image', 'one-page-express' ),
				'no-repeat'             => esc_attr__( 'No Repeat', 'one-page-express' ),
				'repeat-all'            => esc_attr__( 'Repeat All', 'one-page-express' ),
				'repeat-x'              => esc_attr__( 'Repeat Horizontally', 'one-page-express' ),
				'repeat-y'              => esc_attr__( 'Repeat Vertically', 'one-page-express' ),
				'inherit'               => esc_attr__( 'Inherit', 'one-page-express' ),
				'background-repeat'     => esc_attr__( 'Background Repeat', 'one-page-express' ),
				'cover'                 => esc_attr__( 'Cover', 'one-page-express' ),
				'contain'               => esc_attr__( 'Contain', 'one-page-express' ),
				'background-size'       => esc_attr__( 'Background Size', 'one-page-express' ),
				'fixed'                 => esc_attr__( 'Fixed', 'one-page-express' ),
				'scroll'                => esc_attr__( 'Scroll', 'one-page-express' ),
				'background-attachment' => esc_attr__( 'Background Attachment', 'one-page-express' ),
				'left-top'              => esc_attr__( 'Left Top', 'one-page-express' ),
				'left-center'           => esc_attr__( 'Left Center', 'one-page-express' ),
				'left-bottom'           => esc_attr__( 'Left Bottom', 'one-page-express' ),
				'right-top'             => esc_attr__( 'Right Top', 'one-page-express' ),
				'right-center'          => esc_attr__( 'Right Center', 'one-page-express' ),
				'right-bottom'          => esc_attr__( 'Right Bottom', 'one-page-express' ),
				'center-top'            => esc_attr__( 'Center Top', 'one-page-express' ),
				'center-center'         => esc_attr__( 'Center Center', 'one-page-express' ),
				'center-bottom'         => esc_attr__( 'Center Bottom', 'one-page-express' ),
				'background-position'   => esc_attr__( 'Background Position', 'one-page-express' ),
				'background-opacity'    => esc_attr__( 'Background Opacity', 'one-page-express' ),
				'on'                    => esc_attr__( 'ON', 'one-page-express' ),
				'off'                   => esc_attr__( 'OFF', 'one-page-express' ),
				'all'                   => esc_attr__( 'All', 'one-page-express' ),
				'cyrillic'              => esc_attr__( 'Cyrillic', 'one-page-express' ),
				'cyrillic-ext'          => esc_attr__( 'Cyrillic Extended', 'one-page-express' ),
				'devanagari'            => esc_attr__( 'Devanagari', 'one-page-express' ),
				'greek'                 => esc_attr__( 'Greek', 'one-page-express' ),
				'greek-ext'             => esc_attr__( 'Greek Extended', 'one-page-express' ),
				'khmer'                 => esc_attr__( 'Khmer', 'one-page-express' ),
				'latin'                 => esc_attr__( 'Latin', 'one-page-express' ),
				'latin-ext'             => esc_attr__( 'Latin Extended', 'one-page-express' ),
				'vietnamese'            => esc_attr__( 'Vietnamese', 'one-page-express' ),
				'hebrew'                => esc_attr__( 'Hebrew', 'one-page-express' ),
				'arabic'                => esc_attr__( 'Arabic', 'one-page-express' ),
				'bengali'               => esc_attr__( 'Bengali', 'one-page-express' ),
				'gujarati'              => esc_attr__( 'Gujarati', 'one-page-express' ),
				'tamil'                 => esc_attr__( 'Tamil', 'one-page-express' ),
				'telugu'                => esc_attr__( 'Telugu', 'one-page-express' ),
				'thai'                  => esc_attr__( 'Thai', 'one-page-express' ),
				'serif'                 => _x( 'Serif', 'font style', 'one-page-express' ),
				'sans-serif'            => _x( 'Sans Serif', 'font style', 'one-page-express' ),
				'monospace'             => _x( 'Monospace', 'font style', 'one-page-express' ),
				'font-family'           => esc_attr__( 'Font Family', 'one-page-express' ),
				'font-size'             => esc_attr__( 'Font Size', 'one-page-express' ),
				'mobile-font-size'             => esc_attr__( 'Mobile Font Size', 'one-page-express' ),
				'font-weight'           => esc_attr__( 'Font Weight', 'one-page-express' ),
				'line-height'           => esc_attr__( 'Line Height', 'one-page-express' ),
				'font-style'            => esc_attr__( 'Font Style', 'one-page-express' ),
				'letter-spacing'        => esc_attr__( 'Letter Spacing', 'one-page-express' ),
				'top'                   => esc_attr__( 'Top', 'one-page-express' ),
				'bottom'                => esc_attr__( 'Bottom', 'one-page-express' ),
				'left'                  => esc_attr__( 'Left', 'one-page-express' ),
				'right'                 => esc_attr__( 'Right', 'one-page-express' ),
				'center'                => esc_attr__( 'Center', 'one-page-express' ),
				'justify'               => esc_attr__( 'Justify', 'one-page-express' ),
				'color'                 => esc_attr__( 'Color', 'one-page-express' ),
				'add-image'             => esc_attr__( 'Add Image', 'one-page-express' ),
				'change-image'          => esc_attr__( 'Change Image', 'one-page-express' ),
				'no-image-selected'     => esc_attr__( 'No Image Selected', 'one-page-express' ),
				'add-file'              => esc_attr__( 'Add File', 'one-page-express' ),
				'change-file'           => esc_attr__( 'Change File', 'one-page-express' ),
				'no-file-selected'      => esc_attr__( 'No File Selected', 'one-page-express' ),
				'remove'                => esc_attr__( 'Remove', 'one-page-express' ),
				'select-font-family'    => esc_attr__( 'Select a font-family', 'one-page-express' ),
				'variant'               => esc_attr__( 'Variant', 'one-page-express' ),
				'subsets'               => esc_attr__( 'Subset', 'one-page-express' ),
				'size'                  => esc_attr__( 'Size', 'one-page-express' ),
				'height'                => esc_attr__( 'Height', 'one-page-express' ),
				'spacing'               => esc_attr__( 'Spacing', 'one-page-express' ),
				'ultra-light'           => esc_attr__( 'Ultra-Light 100', 'one-page-express' ),
				'ultra-light-italic'    => esc_attr__( 'Ultra-Light 100 Italic', 'one-page-express' ),
				'light'                 => esc_attr__( 'Light 200', 'one-page-express' ),
				'light-italic'          => esc_attr__( 'Light 200 Italic', 'one-page-express' ),
				'book'                  => esc_attr__( 'Book 300', 'one-page-express' ),
				'book-italic'           => esc_attr__( 'Book 300 Italic', 'one-page-express' ),
				'regular'               => esc_attr__( 'Normal 400', 'one-page-express' ),
				'italic'                => esc_attr__( 'Normal 400 Italic', 'one-page-express' ),
				'medium'                => esc_attr__( 'Medium 500', 'one-page-express' ),
				'medium-italic'         => esc_attr__( 'Medium 500 Italic', 'one-page-express' ),
				'semi-bold'             => esc_attr__( 'Semi-Bold 600', 'one-page-express' ),
				'semi-bold-italic'      => esc_attr__( 'Semi-Bold 600 Italic', 'one-page-express' ),
				'bold'                  => esc_attr__( 'Bold 700', 'one-page-express' ),
				'bold-italic'           => esc_attr__( 'Bold 700 Italic', 'one-page-express' ),
				'extra-bold'            => esc_attr__( 'Extra-Bold 800', 'one-page-express' ),
				'extra-bold-italic'     => esc_attr__( 'Extra-Bold 800 Italic', 'one-page-express' ),
				'ultra-bold'            => esc_attr__( 'Ultra-Bold 900', 'one-page-express' ),
				'ultra-bold-italic'     => esc_attr__( 'Ultra-Bold 900 Italic', 'one-page-express' ),
				'invalid-value'         => esc_attr__( 'Invalid Value', 'one-page-express' ),
				'add-new'           	=> esc_attr__( 'Add new', 'one-page-express' ),
				'row'           		=> esc_attr__( 'row', 'one-page-express' ),
				'limit-rows'            => esc_attr__( 'Limit: %s rows', 'one-page-express' ),
				'open-section'          => esc_attr__( 'Press return or enter to open this section', 'one-page-express' ),
				'back'                  => esc_attr__( 'Back', 'one-page-express' ),
				'reset-with-icon'       => sprintf( esc_attr__( '%s Reset', 'one-page-express' ), '<span class="dashicons dashicons-image-rotate"></span>' ),
				'text-align'            => esc_attr__( 'Text Align', 'one-page-express' ),
				'text-transform'        => esc_attr__( 'Text Transform', 'one-page-express' ),
				'none'                  => esc_attr__( 'None', 'one-page-express' ),
				'capitalize'            => esc_attr__( 'Capitalize', 'one-page-express' ),
				'uppercase'             => esc_attr__( 'Uppercase', 'one-page-express' ),
				'lowercase'             => esc_attr__( 'Lowercase', 'one-page-express' ),
				'initial'               => esc_attr__( 'Initial', 'one-page-express' ),
				'select-page'           => esc_attr__( 'Select a Page', 'one-page-express' ),
				'open-editor'           => esc_attr__( 'Open Editor', 'one-page-express' ),
				'close-editor'          => esc_attr__( 'Close Editor', 'one-page-express' ),
				'switch-editor'         => esc_attr__( 'Switch Editor', 'one-page-express' ),
				'hex-value'             => esc_attr__( 'Hex Value', 'one-page-express' ),
				'addwebfont'             => esc_attr__( 'Add Web Font', 'one-page-express' ),
			);

			// Apply global changes from the kirki/config filter.
			// This is generally to be avoided.
			// It is ONLY provided here for backwards-compatibility reasons.
			// Please use the kirki/{$config_id}/l10n filter instead.
			$config = apply_filters( 'kirki/config', array() );
			if ( isset( $config['i18n'] ) ) {
				$translation_strings = wp_parse_args( $config['i18n'], $translation_strings );
			}

			// Apply l10n changes using the kirki/{$config_id}/l10n filter.
			return apply_filters( 'kirki/' . $config_id . '/l10n', $translation_strings );

		}
	}
}
