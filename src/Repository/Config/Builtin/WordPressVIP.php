<?php

/**
 * Repository definition for the WordPress VIP plugins repository.
 */

namespace BalBuf\ComposerWP\Repository\Config\Builtin;

use BalBuf\ComposerWP\Repository\Config\SVNRepositoryConfig;
use Composer\Package\CompletePackage;

class WordPressVIP extends SVNRepositoryConfig {

	protected $config = array(
		'url' => 'https://vip-svn.wordpress.com/plugins/',
		'provider-paths' => array( '/', 'release-candidates/' ),
		'package-paths' => array( '' ),
		'types' => array( 'wordpress-plugin-vip' => 'wordpress-vip' ),
		'provider-filter' => array( __CLASS__, 'filterProvider' ),
		'version-filter' => array( __CLASS__, 'filterVersion' ),
		'package-filter' => array( __CLASS__, 'filterPackage' ),
	);

	static function filterProvider( $name, $path, $url ) {
		if ( $name === 'release-candidates' ) {
			return '';
		}
		if ( $path === 'release-candidates/' ) {
			return "$name-rc";
		}
		return $name;
	}

	/**
	 * The WordPress VIP plugins are not versioned and should not be considered stable.
	 */
	static function filterVersion( $version ) {
		return 'dev-master';
	}

	static function filterPackage( CompletePackage $package ) {
		// set the type to basic wordpress plugin
		$package->setType( 'wordpress-plugin' );
	}

}
