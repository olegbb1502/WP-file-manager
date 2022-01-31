<?php

/**
 * Fired during plugin activation
 *
 * @link       http://cad.kpi.ua
 * @since      1.0.0
 *
 * @package    Fmc
 * @subpackage Fmc/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Fmc
 * @subpackage Fmc/includes
 * @author     CAD IASA <mollp1956@gmail.com>
 */


require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

class Fmc_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		$plugin_name_db_version = '1.0';
		$table_prefix = $wpdb->prefix . "fmc"; 
		$charset_collate = $wpdb->get_charset_collate();
		$tables = ['files', 'section', 'author'];
		$query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );

		foreach($tables as $table) {
			$table_name = $table_prefix."-".$table;
			if ( ! $wpdb->get_var( $query ) ==  $table_name) {
				switch($table) {
					case 'files':
						$sql = "
							CREATE TABLE $table_name (
								id mediumint(9) NOT NULL AUTO_INCREMENT,
								created timestamp NOT NULL default CURRENT_TIMESTAMP,
								title tinytext NULL,
								uri varchar(255) DEFAULT '' NOT NULL,
								cat_author integer DEFAULT NULL,
								cat_section integer DEFAULT NULL,
								cat_year integer DEFAULT YEAR(GETDATE()),
								creation_date DATE 
								PRIMARY KEY (id),
								UNIQUE KEY id (id)
							) $charset_collate;
						";
					case 'author':
						$sql = "
							CREATE TABLE $table_name-author (
								id mediumint(9) NOT NULL AUTO_INCREMENT,
								author_name varchar(255) NULL,
								rating integer,
								created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
								PRIMARY KEY (id),
								CONSTRAINT fmc-files FOREIGN KEY (file-id)
									REFERENCES $table_prefix-files(id)
									ON DELETE CASCADE,
								CONSTRAINT fmc-section FOREIGN KEY (section-id)
									REFERENCES $table_prefix-section(id)
									ON DELETE CASCADE,
							) $charset_collate;
						";
					case 'section':
						$sql = "
							CREATE TABLE $table_name (
								id mediumint(9) NOT NULL AUTO_INCREMENT,
								section_name varchar(255) NULL,
								description varchar(255) NULL,
								created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
								PRIMARY KEY (id),
								FOREIGN KEY (file-id)
									REFERENCES $table_prefix-files(id)
									ON DELETE CASCADE
							) $charset_collate;
						";
				}
				dbDelta( $sql );
			}
		}
		
		add_option( 'plugin_name_db_version', $plugin_name_db_version );
	}

}
