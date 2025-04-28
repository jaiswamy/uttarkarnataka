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
* * Database settings
* * Secret keys
* * Database table prefix
* * ABSPATH
*
* @link https://wordpress.org/documentation/article/editing-wp-config-php/
*
* @package WordPress
*/
// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u499940289_Uttarkarnataka' );
/** Database username */
define( 'DB_USER', 'u499940289_UttArKARnAtaka' );
/** Database password */
define( 'DB_PASSWORD', 'UttArKARnAtaka@2023' );
/** Database hostname */
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
define( 'AUTH_KEY',         'WIBzdyQ.Qf:cFF_/qz8x33HVdSmbEqZt$:CiAhyZ*H9{Rj8. CLj=83JO%1LQ>gm' );
define( 'SECURE_AUTH_KEY',  'V.MB7A!!4gpUDsS 6TSUC?v{KVi7JcyxfHP!H5|Ute*B{/uHZbSaP{zm!pxXYYvB' );
define( 'LOGGED_IN_KEY',    'vw4h4u_3|%41opl4!{,{a0cM^dvJG.Y,z(q?cz|M_Ut6u+*!hn/LvFQUc^o@Mu6V' );
define( 'NONCE_KEY',        'Vu3D0lhHIWMF${Dw=.%j-Hh)gnQ7MA<Mbq9C;7B4I.!M(rOz#Y.]9`M]C`X+_Xe&' );
define( 'AUTH_SALT',        'p-A+H%H@!4B2s2Y6>Vqc6bG`a2E.6im[rKzlk eAL8?^de5_G t)Or^#dw/x6=1e' );
define( 'SECURE_AUTH_SALT', '*%_KF$)ssqJ)11T*C a U[75iiTe=mxa9V9m#t8AeH,Bf-JRWt{vRy/DL-f 9@h}' );
define( 'LOGGED_IN_SALT',   'plzT,#K6bs-+H3n?N(ohFd+0[H9sTmlG<P[B0c}4bnMgVf~Zz;d9+R}<bQ/0s/E1' );
define( 'NONCE_SALT',       ':/G%3Ac1.#h,sj{e2R|QG!Bh]yG<R_gDg)VtKC=v9lVd1]{M{5 yHV6_B}x8U3[n' );
/**#@-*/
/**
* WordPress database table prefix.
*
* You can have multiple installations in one database if you give each
* a unique prefix. Only numbers, letters, and underscores please!
*/
$table_prefix = 'uknp_';
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
* @link https://wordpress.org/documentation/article/debugging-in-wordpress/
*/
define( 'WP_DEBUG', false );
/* Add any custom values between this line and the "stop editing" line. */
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
define( 'ABSPATH', __DIR__ . '/' );
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
