<?php
/**
 * Checks that Full-Site Editing themes have the required Tags.
 *
 * @package Theme Check
 */

/**
 * Class FSE_Required_Tags_Check
 *
 * Checks that Full-Site Editing themes have the required Tags and customizer,widget funciton are included or not.
 *
 * This check is not added to the global array of checks, because it  apply to all themes.
 */
class Hybrid_theme_Tags_Check implements themecheck {
	/**
	 * Error messages, warnings and info notices.
	 *
	 * @var array $error
	 */
	protected $error = array();

	/**
	 * Check that return true for good/okay/acceptable, false for bad/not-okay/unacceptable.
	 *
	 * @param array $php_files File paths and content for PHP files.
	 * @param array $css_files File paths and content for CSS files.
	 * @param array $other_files Folder names, file paths and content for other files.
	 */
	public function check($php_files, $css_files, $other_files) {

        global $theme_check_current_theme;

		$ret = true;
		$theme_tags_list = $theme_check_current_theme["Tags"];
	
		//Check full-site-editing tag is exist or not in theme
		 if(in_array('full-site-editing',$theme_tags_list)){
			 
			$php = implode( ' ', $php_files );
			//Check register_widget  is exist or not
			if (strpos( $php, 'register_widget' ) !== false){
				$this->error[] = sprintf( '<span class="tc-lead tc-warning">' . __( 'WARNING', 'theme-check' ) . '</span>: ' . __( 'Full Site Editing Theme must not have Widgets', 'theme-check' ), '<strong>Widgets</strong>' );
				$ret           = false;
			}
			//Check customize_register is exist or not
			if (strpos( $php, 'customize_register' ) !== false){
				$this->error[] = sprintf( '<span class="tc-lead tc-warning">' . __( 'WARNING', 'theme-check' ) . '</span>: ' . __( 'Full Site Editing Theme must not have Customizer', 'theme-check' ), '<strong>Customizer</strong>' );
				$ret           = false;
			}
			foreach ( $php_files as $file_path => $file_content ) {
				if ( preg_match_all( '/\$wp_customize->add_setting\(([^;]+)/', $file_content, $matches ) ) {
					$this->error[] = sprintf( '<span class="tc-lead tc-warning">' . __( 'WARNING', 'theme-check' ) . '</span>: ' . __( 'Full Site Editing Theme must not have Customizer', 'theme-check' ), '<strong>Customizer</strong>' );
					 $ret           = false;
					   
				}
			}
			//Check custom-header, custom-background, custom-logo is exist or not in add_theme_support.
			$checks = array(
				'#add_theme_support\s*\(\s*[\'|"]custom-header#' => __( ' <strong>add_theme_support( "custom-header", $args )</strong> Full Site Editing  Theme does not allow custom-header.', 'theme-check' ),
				'#add_theme_support\s*\(\s*[\'|"]custom-background#' => __( '<strong>add_theme_support( "custom-background", $args )</strong> was found in the theme. Full Site Editing  Theme does not allow custom-background.', 'theme-check' ),
				'#add_theme_support\s*\(\s*[\'|"]custom-logo#' => __( ' <strong>add_theme_support( "custom-logo", $args )</strong> was found in the theme. Full Site Editing  does not allow custom-logo.', 'theme-check' ),
			);
			foreach ( $checks as $key => $check ) {
				if (  preg_match( $key, $php ) ) {
					$this->error[] = sprintf(
						'<span class="tc-lead tc-warning">%s</span>: %s',
						__( 'WARNING', 'theme-check' ),
						$check
					);
				}
			}
		}

		return $ret;
	}
	

	/**
	 * Get error messages from the checks.
	 *
	 * @return array Error message.
	 */
	public function getError() {
		return $this->error;
	}
}

$themechecks[] = new Hybrid_theme_Tags_Check();
