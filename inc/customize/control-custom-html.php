<?php
/**
 * Custom HTML customizer control.
 *
 * @package    Stargazer
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2013 - 2018, Justin Tadlock
 * @link       https://themehybrid.com/themes/stargazer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Radio image customize control.
 *
 * @since  1.0.0
 * @access public
 */
class Stargazer_Customize_Control_Custom_HTML extends WP_Customize_Control {

	/**
	 * The type of customize control being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'custom-html';

	/**
	 * Custom HTML to be output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $html = '';

	/**
	 * Loads the framework scripts/styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {

		wp_enqueue_style( 'stargazer-customize-controls' );
	}

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function to_json() {
		parent::to_json();

		$this->json['html'] = $this->html;
	}

	/**
	 * Underscore JS template to handle the control's output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function content_template() { ?>

		<# if ( data.label ) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>

		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<# if ( data.html ) { #>
			{{{ data.html }}}
		<# } #>
	<?php }
}
