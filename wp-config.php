<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'bitnami_wordpress');

/** MySQL database username */
define('DB_USER', 'bn_wordpress');

/** MySQL database password */
define('DB_PASSWORD', 'f672f8ac15');

/** MySQL hostname */
define('DB_HOST', 'localhost:3307');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/* * #@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'ebfbbcceabc088fbd2d45e0853f055aeecb54e9ef8ec75675210560dfd141d71');
define('SECURE_AUTH_KEY', '472fa4ae8e23376d0b138222c33fa3f851531a8ef71d20adaf3a7e881d5293f6');
define('LOGGED_IN_KEY', 'f241c9ac0a85b47ac1285208ecdc9e26bf083036da5d5b11d644d9cb2e155061');
define('NONCE_KEY', '59f782c57cc2cb611a0b61809685559e51a452c7018a62038daf3093827b5df7');
define('AUTH_SALT', '5dbb65e75fcc9ca4917c2601f16ec7e54fd06baccd59dded76918e3a776bf8d6');
define('SECURE_AUTH_SALT', '5ffd6d0863a7745f0a61a3c7bd62caf7f697bc00a6938603184b94e70c548ebb');
define('LOGGED_IN_SALT', '4812c325dd473e60223e53a37ab1b185a5f9022c48bcfe31aaa179c123ab5d19');
define('NONCE_SALT', '9ddf42e4f92ed6d2041bd91e9e9ad64b6792906b632a3e59f2c74426444783e2');

/* * #@- */

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */
/**
 * The WP_SITEURL and WP_HOME options are configured to access from any hostname or IP address.
 * If you want to access only from an specific domain, you can modify them. For example:
 *  define('WP_HOME','http://example.com');
 *  define('WP_SITEURL','http://example.com');
 *
 */
define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] . '/wordpress');
define('WP_HOME', 'http://' . $_SERVER['HTTP_HOST'] . '/wordpress');


/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH'))
    define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

define('WP_TEMP_DIR', '/opt/lampp/apps/wordpress/tmp');


define('FS_METHOD', 'direct');


//  Disable pingback.ping xmlrpc method to prevent Wordpress from participating in DDoS attacks
//  More info at: https://docs.bitnami.com/?page=apps&name=wordpress&section=how-to-re-enable-the-xml-rpc-pingback-feature
// remove x-pingback HTTP header
add_filter('wp_headers', function($headers) {
    unset($headers['X-Pingback']);
    return $headers;
});
// disable pingbacks
add_filter('xmlrpc_methods', function( $methods ) {
    unset($methods['pingback.ping']);
    return $methods;
});
add_filter('auto_update_translation', '__return_false');
