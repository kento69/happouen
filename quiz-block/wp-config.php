<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'xs720879_wp8' );

/** Database username */
define( 'DB_USER', 'xs720879_wp8' );

/** Database password */
define( 'DB_PASSWORD', 'jp69llu3ye' );

/** Database hostname */
define( 'DB_HOST', 'mysql10008.xserver.jp' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'p=%kgzYW!g:_wcG,6YhS:FEyBe[K%ymD22UjI =ZSIO8%mPU(@X0QG4j&6Rs(Y;@' );
define( 'SECURE_AUTH_KEY',  '7bSuDiF/JhU}7f0|:r9j,5N07rk}lf9KNIgJQHH7X885TJ*u0`oHZ8=fv%%mFzMU' );
define( 'LOGGED_IN_KEY',    'lOqI=rL_QSVLhjLk(<n^Q*aaQL1)b?K6ukAf+aW6{gl10xwlbu&jJ)4vU`QJ@mfP' );
define( 'NONCE_KEY',        '-f;3GHQe2R3Wo)6~/Jq0OP|8I&6TG-=J0ytE]n8055;I(!~Y.kh)dG{ZK[F~oBi%' );
define( 'AUTH_SALT',        'MHtvj kv*7nY/YE(]-,TKT!?DgvKR{(#$c ;;~?F7}?=;U+,1~@f0=3DU2YWcy,$' );
define( 'SECURE_AUTH_SALT', 'lG[`BoO:~{Mq6~^{|^:BR%O$9.BaenCcs`:MECZOtGxF,IH-MPGlPLjru@FTq0LA' );
define( 'LOGGED_IN_SALT',   ';U#l`kIq_vX87wX$0|vOxv(|_AQK+ 0&n5$yQ%|F-J%:WJ0sOOG6U6(|lQsyMM_O' );
define( 'NONCE_SALT',       'a?3Ni?RVAe~e8_i^tQ-4G}4EOu$;A?6r@Ee+I^LqX35  %F5+t/tO3JoNxh0qKCa' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', true );
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', true);
@ini_set('display_errors', 1);


/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
