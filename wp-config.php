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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '1');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'nY_kD1sIcP07zLiP=H-=+)?/G$N[W+afcN%p%b{eejy!X:Z75D Mj$S_4-3Gs/<:');
define('SECURE_AUTH_KEY',  'q8c>6y;DRx .y|KKlom(&)Z(<!zA0-(ymkB> VYOrXR#r`aO1p8#~(gJ/rn|uZVf');
define('LOGGED_IN_KEY',    'o*Pq,#SdbdPyXwYk29=Np0)zf<BLs<|{&g.mBDR)t#2<VVY<Q5;]mJa~g1G&{l2q');
define('NONCE_KEY',        '`Vmi%OzjEL7Be;CGuf0r9fA(@mZ&}IqPOcv1C1Pq^0w.O3QeP{MCOB%O,^9gZf2U');
define('AUTH_SALT',        'RTT3N|?w|grrQSX)1Ao!_|/zRN_mNEE]`,$l)J CRUkO2v5(:`-{*pEnCJ;fCkVD');
define('SECURE_AUTH_SALT', 'o{X7RA%0.fJ6EAvY8]lr-#B$Jv^<<B&>A1?Q-PwVFk?DByF&/-dUj2KN6@GOm}wF');
define('LOGGED_IN_SALT',   'yZ<TIB4~H{EHp%tHLC8Buj}#b s-.(%*{Sk.-5bbpG%5AYZBt^wOMoR&U@w9Hu7`');
define('NONCE_SALT',       '$RpM*6t4tbh6KfpJ4X<VIPeq_nPa)37j_Tl#!geFb}~TrncOQD$e?<.xP$_Fu+xG');

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
