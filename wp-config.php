<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings savali S codes
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
define( 'DB_NAME', 'car_gariweza' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'Dq9X?z{pUA>Z,eUFaOh$OB|K><b_A*`c`F/F6J}p!)KO,yd#MVtSa>Sl4E&sV c}' );
define( 'SECURE_AUTH_KEY',  '+5sL#Qv x~MS+|ITgHj,PSgs:+8dIj}A^FfeoU,!;;K3_R@h5I~Zo!!ZN%&:}A|Z' );
define( 'LOGGED_IN_KEY',    'vhoaZS<x=`2J#Ua{x{0o &|P_:iEsUKbF%?.Ge/<ck-3]U1{wh*du=iAwL%JG}Wx' );
define( 'NONCE_KEY',        'V4CKfLyc)MNWky-!Ez*?UQIKf(h(axe7% l3tY:``7~$g.S(Bb=h/p;4JV}Yf}HZ' );
define( 'AUTH_SALT',        '9beM2U~yAsQ@4R=Mwh]vrC(gUZLRCH-D_(&0$O?5EnSF;#T8t] fvKcN G4(ejnX' );
define( 'SECURE_AUTH_SALT', '|5S]Ovs>ERPUAIS%-T$y:Zz$6L/ 7Gq+>hx0UinW=W!/+W$~8AHf$`Y:3glJ%?3~' );
define( 'LOGGED_IN_SALT',   '9B x+7RU^zJ,PTCW0%oIx8]LuBW5gf*xg*Mwvh77Y/ul/5u;ZV5^=9&#SdU[k>Ju' );
define( 'NONCE_SALT',       '}PD ($wt<#2j%K<I_95Rp` uRt^Pfj8x!?4Z)[*RJ7Er&1)]V:^gQy_xKX$]dYTc' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', false);
define('SAVEQUERIES', true);


/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. wejofe was*/ 

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
