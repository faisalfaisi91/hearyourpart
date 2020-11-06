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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'hearyourpart-dev' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '12345' );

/** MySQL hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'P}K~Mvh.;9)toAR,Lb5&[7$u@s)+&~Y&G61*d,8=(w{BD%C?GOj(xp<vWKoy&nk,' );
define( 'SECURE_AUTH_KEY',  'HPYz`rul{  9_3<p03=7j2_[-1ZY/`[,L/^RvsXu~lYw}xx_ch-tq&uc=Rt#{4vj' );
define( 'LOGGED_IN_KEY',    '?zN,P)!iu!2%R)3SJEr:(F6%,c365a vfjGW6wk>){VcGv5NTRBsA|z2>4ojOj][' );
define( 'NONCE_KEY',        '_M@5b+1^M(9,,$RP[)x~AE.;{}03Sd1.QAx=W[!g,};dL,K~w?m rMhf&vTJ#FY$' );
define( 'AUTH_SALT',        '9=y20&)[U|ryW.,6!&q&9HdpWc`,rWt;HY$+CpCi!#TOvSl-WIpCM-dx.3DpcBRh' );
define( 'SECURE_AUTH_SALT', '`O_R~H%OgPAY:bFH5rZ%YbFMdc)9|6Y(`1O&9(!-xDKie;N I,oFKxD&(!jDQ=Lf' );
define( 'LOGGED_IN_SALT',   'Ly@@B{WP|06XSK[,WY=pONWaAZt?y!A+CE^8^xOr4-]HMP}Z!E>ULY>fK4Y_!HLM' );
define( 'NONCE_SALT',       '}^#sTao%7|u}vm>mA&FiXM<-}:D;*SA@iOJ=A0ViYjA*+B,RD02UH=ceK&,H{42g' );

/**#@-*/

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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );
define('FS_METHOD', 'direct');
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
