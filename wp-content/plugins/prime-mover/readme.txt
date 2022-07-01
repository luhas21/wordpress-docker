=== Migrate WordPress Website & Backups - Prime Mover ===
Contributors: codexonics, freemius
Donate link: https://codexonics.com
Tags: migrate wordpress, multisite migration, wordpress backup, multisite, backup, database backup, migration
Requires at least: 4.9.8
Tested up to: 6.0
Requires PHP: 5.6
Stable tag: 1.6.2
License: GPLv3 or later
License URI: https://codexonics.com

The simplest all-around WordPress migration tool/backup plugin. These support multisite backup/migration or clone WP site/multisite subsite.

== Description ==

= Easily Transfer WordPress Site to New Host/Server/Domain =

*   Move single-site installation to another single site server.
*   Move WP single-site to existing multisite sub-site.
*   Migrate subsite to another multisite sub-site.
*   Migrate multisite sub-site to single-site.
*   Migrate within WordPress admin.
*   WordPress backup and restore packages within single-site or multisite.
*   Backup WordPress subsite (in multisite).
*   You can backup the WordPress database within admin before testing something and restore it with one click.
*   Cross-platform compatible (Nginx / Apache / Litespeed / Microsoft IIS / Localhost).
*   Clone single site and restore it to any server.
*   Clone subsite in multisite and restore it as single-site or multisite.
*   Supports legacy multisites.
*   Debug package.

https://youtu.be/QAVVXcoQU8g

= PRO Features =

*   Save tons of time during migration with the direct site to site package transfer.
*   Move the backup location outside WordPress public directory for better security.
*   Migrate or backup WordPress multisite main site.
*   Encrypt WordPress database in backups for maximum data privacy.
*   Encrypt WordPress upload files inside backup for better security.
*   Encrypt plugin and theme files inside the backup/package for protection.
*   Export and restore the backup package from Dropbox.
*   Save and restore packages from and to Google Drive.
*   Exclude plugins from the backup (or network activated plugins if multisite).
*   Exclude upload directory files from the backup to reduce the package size.
*   Create a new multisite subsite with a specific blog ID.
*   Disable network maintenance in multisite so only affected subsite is in maintenance mode.
*   Configure migration parameters to optimize and tweak backup/migration packages.
*   It includes all complete restoration options at your own choice and convenience.
*   Full access to settings screen to manage all basic and plugin advanced configurations.

= Documentation =

*	[Prime Mover Documentation](https://codexonics.com/prime_mover/prime-mover/)

== Installation ==

1. Upload to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Optionally, opt in to security & feature updates notification including non-sensitive diagnostic tracking with freemius.com. If you skip this, that's okay! Prime Mover will still work just fine.
4. You should see the Prime Mover Control Panel. Click "Go to Migration Tools" to start migrating sites.

== Frequently Asked Questions ==

= What makes Prime Mover unique to other existing migration and backup plugins? =
	
* The free version has no restriction on package size, number of websites, mode of migration (single-site or multisite will work). We don't put that kind of limitation.
* The free version supports full WordPress multisite migration.
* It can backup WordPress multisite sub-sites or migrate multisite.
* No need to delete your WordPress installation, create/delete the database, and all other technical stuff. It will save you a lot of time.
* This is not hosting-dependent. Prime Mover is designed to work with any hosting companies you want to work with.
* The free version has full multisite migration functionality. This feature is usually missing in most migration plugins free version.
* Full versatility - migrating from your localhost, dev site, or from a live site to another live site.
* You will be doing the entire migration inside the WordPress admin. Anyone with administrator access can do it. There is no need to hire a freelancer to do the job - saves you money.
* No messing with complicated migration settings, the free version has built-in settings. Only choose a few options to export and migrate, that's it. 
* You can save, download, delete, and migrate packages using the management page.
* No need to worry about PHP configuration and server settings. Compatible with most default PHP server settings even in limited shared hosting. 
* Prime Mover works with modern PHP versions 5.6 to 8.0 (Google Drive feature requires at least PHP 7.0).
* The code is following PHP-fig coding standards (standard PHP coding guidelines).
* You don't need to worry about setting up users or changing user passwords after migration. It does not overwrite existing site users after migration.

For more common questions, please read the [plugin FAQ listed in the developer site](https://codexonics.com/prime_mover/prime-mover/faq/).

== Screenshots ==

1. Single-site Migration Tools
2. Export options dialog
3. Export to single-site format example
4. Export to multisite subsite with blog ID of 23 example
5. Restore package via browser upload
6. Single-site package manager
7. Prime Mover network control panel
8. Export and restore package from Network Sites
9. Multisite network package manager

== Upgrade Notice ==

Update now to get all the latest bug fixes, improvements and features!

== Changelog ==

= 1.6.2 =

* Fixed: PHP errors during migration processes due to cron tasks running.
* Fixed: Unable to do remote URL request on a single site plan.
* Fixed: When package is deleted in package manager - remote URL request should return 404.
* Fixed: Search and replace issue with base64 encoded URLs.
* Fixed: MySQL errors in third party processing restore code when retrying.

= 1.6.1 =

* Fixed: Glitch in user adjustment during restore.
* Fixed: Missing database tables during restore due to duplicated constraints.
* Fixed: Auto-memory limit adjustments on runtime.
* Fixed: Missing database tables due to incomplete dB restore headers.
* Fixed: PHP notices during dB restore due to missing SQL variables.
* Fixed: Missing user in blog during multisite restore.
* Fixed: dB restore hang due to unhandled max_allowed_packet error. 
* Fixed: Unable to delete all packages due to third party code conflict.
* Fixed: PHP notices when deleting backups due to non-existing subsite.

= 1.6.0 =

* Feature: Added settings page in free version.
* Feature: Added MySQLdump and search-replace batch size setting.
* Compatibility: Tested for WordPress 6.0 release.
* Usability: Freemium content update.
* Usability: Added site health debug info to export site info.
* Usability: Auto-setup remote auth keys.
* Fixed: max_allowed_packet db error on import for privileged users.
* Fixed: Freemius licensing 100-sites limit issue.
* Fixed: Browser upload issues when package nears 4G in size.
* Fixed: Incorrect redirects to save permalinks after restore.
* Fixed: PHP 8.0 errors on search-replace class.

See the previous changelogs in changelog.txt.
