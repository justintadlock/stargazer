<?php
/**
 * Custom locked section for the customizer.
 *
 * @package    Extant
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2016, Justin Tadlock
 * @link       http://themehybrid.com/themes/extant
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Locked customizer section.
 *
 * @since  1.0.0
 * @access public
 */
class Stargazer_Customize_Section_Locked extends WP_Customize_Section {

	/**
	 * The type of customize section being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'locked';

	/**
	 * Custom button text to output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $button = '';

	/**
	 * Loads the section scripts/styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {

		wp_enqueue_script( 'stargazer-customize-controls' );
		wp_enqueue_style(  'stargazer-customize-controls' );
	}

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function json() {
		$json = parent::json();

		$json['button'] = $this->button;

		return $json;
	}

	/**
	 * Outputs the Underscore.js template.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	protected function render_template() { ?>

		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }}">

			<h3 class="accordion-section-title" tabindex="0">
				{{ data.title }}

				<# if ( data.button ) { #>
					<button type="button" class="button button-secondary">{{ data.button }}</button>
				<# } #>
			</h3>

			<ul class="accordion-section-content">
				<li class="customize-section-description-container">

					<div class="customize-section-title">
						<button type="button" class="customize-section-back" tabindex="-1">
							<span class="screen-reader-text"><?php _e( 'Back', 'stargazer' ); ?></span>
						</button>
						<h3>
							<span class="customize-action">
								{{{ data.customizeAction }}}
							</span>
							{{ data.title }}
						</h3>
					</div>

					<# if ( data.description ) { #>
						<div class="description customize-section-description">
							{{{ data.description }}}
						</div>
					<# } #>
				</li>
			</ul>
		</li>
	<?php }
}
