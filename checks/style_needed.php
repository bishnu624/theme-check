<?php
class Style_Needed implements themecheck {
	protected $error = array();

	function check( $php_files, $css_files, $other_files ) {

		$css = implode( ' ', $css_files );
		$ret = true;

		$checks = array(
			'[ \t\/*#]*Theme Name:'   => __( '<strong>Theme name:</strong> is missing from your style.css header.', 'theme-check' ),
			'[ \t\/*#]*Description:'  => __( '<strong>Description:</strong> is missing from your style.css header.', 'theme-check' ),
			'[ \t\/*#]*Author:'       => __( '<strong>Author:</strong> is missing from your style.css header.', 'theme-check' ),
			'[ \t\/*#]*Version'       => __( '<strong>Version:</strong> is missing from your style.css header.', 'theme-check' ),
			'[ \t\/*#]*License:'      => __( '<strong>License:</strong> is missing from your style.css header.', 'theme-check' ),
			'[ \t\/*#]*License URI:'  => __( '<strong>License URI:</strong> is missing from your style.css header.', 'theme-check' ),
			'[ \t\/*#]*Text Domain:'  => __( '<strong>Text Domain:</strong> is missing from your style.css header.', 'theme-check' ),
			'[ \t\/*#]*Tested up to:' => __( '<strong>Tested up to:</strong> is missing from your style.css header. Also, this should be numbers only, so <em>5.0</em> and not <em>WP 5.0</em>', 'theme-check' ),
			'[ \t\/*#]*Requires PHP:' => __( '<strong>Requires PHP:</strong> is missing from your style.css header.', 'theme-check' ),
			'\.screen-reader-text'    => __( '<strong>.screen-reader-text</strong> css class is needed in your theme css. See See: <a href="http://codex.wordpress.org/CSS#WordPress_Generated_Classes">the Codex</a> for an example implementation.', 'theme-check' ),
		);

		foreach ( $checks as $key => $check ) {
			checkcount();
			if ( ! preg_match( '/' . $key . '/i', $css, $matches ) ) {
				$this->error[] = sprintf(
					'<span class="tc-lead tc-required">%s</span> %s',
					__( 'REQUIRED', 'theme-check' ),
					$check
				);
				$ret           = false;
			}
		}

		return $ret;
	}
	function getError() {
		return $this->error;
	}
}
$themechecks[] = new Style_Needed();
