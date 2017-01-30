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
define('DB_NAME', 'calionbf_wordpress_7');

/** MySQL database username */
define('DB_USER',       'wordpress_36');

/** MySQL database password */
define('DB_PASSWORD',       'Ro#2zVO07s');

/** MySQL hostname */
define('DB_HOST', 'localhost:3306');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',       'LG10UU3hf45tJ19u!H7L727E6aar4ea*^KI^pmCt7XP)dz%mLSI1@5q8jkbf!(IV');
define('SECURE_AUTH_KEY',       'f%NZPSCr(LLEnoHg)skfq0@LB8tA1g6X*VhEgfhlFkxN5eU%y&TVw8cW)3nraNMJ');
define('LOGGED_IN_KEY',       'OAI1js0vnhs*6x7e@Lnm4EYnXBWyeN0UQlsgfbdgi!XvQDDspirT3Cdkw(Ane7XE');
define('NONCE_KEY',       'C*hO&DoCgL7^ZDACR8kN6b&c8urdO#M!@kDp)p6)T)JG44Pt!1IsPtQ!^O(Dh(eu');
define('AUTH_SALT',       'Ol^W5Pm2XY^tngr5K7ZH16%EYg2iCzL)Q9!Occ@r5(hzr7g3*0&zEsA05j4U%B0v');
define('SECURE_AUTH_SALT',       'DveDDJMf@T@fKH%O#rUqmqrZlCma(vjpli5Wf^GnLe5V9BH(RbZJ@k8!GWm#LAuU');
define('LOGGED_IN_SALT',       'ST)4@JJ61LlJOzgv15CYak5RD050jKGVXL251M(r*)Av%6gUVJgbQjM%ro5TQ9Z7');
define('NONCE_SALT',       'Z3TJKayipJ^%I7jvy^tbZBMkLp3^ni4*yiWR*xhTEmxTF@WaUh7fLclcNPc8#Fe&');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

define( 'WP_ALLOW_MULTISITE', true );

define ('FS_METHOD', 'direct');
?>