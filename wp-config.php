<?php
/** 
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information by
 * visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress_ce');

/** MySQL database username */
define('DB_USER', 'wordpress_ce');

/** MySQL database password */
define('DB_PASSWORD', 'K0C_ckd7Y2');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link http://api.wordpress.org/secret-key/1.1/ WordPress.org secret-key service}
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '#LqbZ@$6kTQNXLBvqk9Xcod6kVSVaxR#k^@hh8RPxpIZ3#Vx3s)JEUZXPK5hM^k6');
define('SECURE_AUTH_KEY',  '#%LBWCyT1p$Qu(FOuVNk$vx1aCKi$NZNK4VP2@N0K5M&NjYUk*AtwB&sZ3#XB8we');
define('LOGGED_IN_KEY',    '34jr*5yEccyZs!BzmTd3tkD4vEjxcJwyy2crrgQ5F$zWXVpKygAmHjjJuHSAT1AP');
define('NONCE_KEY',        ')fFF8Aa51KhQ!#Qz9rkH%2lgOiqO9Z!qj9h302zlC*Jvh%D3NdXjW%MFKAxeVWo&');
define('AUTH_SALT',        'bXSFp3(M@gQ^Pi7HL86sdIt$Y$@&bDtwW#Ff8Yqn&PUl1!Og0qiR*L7l*tyra9Rk');
define('SECURE_AUTH_SALT', 'r75ijfa%SrXCcpar^igv(J1caaG#LO@TP06EB3xbR5ksRNnOKx5W7!S2P8gHChXH');
define('LOGGED_IN_SALT',   'Ly5heP$vo$J#OxIwcN9l*ot3GZw&33G*GOpLl#ftpB^j3OmXamKXy##@%)m!Y8Mb');
define('NONCE_SALT',       'PEDuNR#&HPvO^2q5@ke$%QT(PtINr*n(sDk1@s$MSAWE#6mZJyU7hti@i9HCIV9s');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', 'en_US');

define ('FS_METHOD', 'direct');

define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

?>
