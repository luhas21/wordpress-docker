<?php
namespace Codexonics\PrimeMoverFramework\utilities;

/*
 * This file is part of the Codexonics.PrimeMoverFramework package.
 *
 * (c) Codexonics Ltd
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Codexonics\PrimeMoverFramework\classes\PrimeMoverSystemFunctions;

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Prime Mover Lock Utilities
 * Helper functionality for locking resources during export/import processes
 *
 */
class PrimeMoverLockUtilities
{        
    private $system_functions;
    
    /**
     * Constructor
     * @param PrimeMoverSystemFunctions $system_functions
     */
    public function __construct(PrimeMoverSystemFunctions $system_functions)
    {
        $this->system_functions = $system_functions;
    }
    
    /**
     * Init hooks
     */
    public function initHooks()
    {
        add_filter('pre_get_ready_cron_jobs', [$this, 'maybeDisableCronSystemSchedulerOnMigration'], 10, 1);
    }
    
    /**
     * Disable cron jobs via direct system scheduler call if we are running migrations
     * @param mixed $cronjobs
     * @return array|NULL
     */
    public function maybeDisableCronSystemSchedulerOnMigration($cronjobs = null)
    {
        if ($this->getSystemFunctions()->nonCachedFileExists($this->getDoingMigrationLockFile())) {
            return [];
        } 
        return null;
    }
    
    /**
     * Get system functions
     * @return \Codexonics\PrimeMoverFramework\classes\PrimeMoverSystemFunctions
     */
    public function getSystemFunctions()
    {
        return $this->system_functions;
    }
    
    /**
     * Get system initialization
     * @return \Codexonics\PrimeMoverFramework\classes\PrimeMoverSystemInitialization
     */
    public function getSystemInitialization()
    {
        return $this->getSystemFunctions()->getSystemInitialization();
    }
    
    /**
     * Get system authorizations
     * @return \Codexonics\PrimeMoverFramework\classes\PrimeMoverSystemAuthorization
     */
    public function getSystemAuthorization()
    {
        return $this->getSystemFunctions()->getSystemAuthorization();
    }

    /**
     * Get doing migration lock file
     * @return string
     */
    public function getDoingMigrationLockFile()
    {
        $lock_files_directory = trailingslashit(wp_normalize_path($this->getSystemInitialization()->getLockFilesFolder()));
        return $lock_files_directory . '.prime_mover_doing_migration';        
    }
    
    /**
     * Check if WP cron action is enabled so we can use this to determine if we running a Prime Mover process
     */
    public function hasCronAction()
    {
        if (!$this->getSystemAuthorization()->isUserAuthorized()) {
            return;
        }
        
        $doing_migration_lock = $this->getDoingMigrationLockFile();
        $has_cron_action = false;
        if (has_action('init', 'wp_cron')) {
            $has_cron_action = true;            
        } 
        
        if ($has_cron_action && $this->getSystemFunctions()->nonCachedFileExists($doing_migration_lock)) {
            $this->getSystemFunctions()->unLink($doing_migration_lock);
        } 
           
        if (!$has_cron_action && !$this->getSystemFunctions()->nonCachedFileExists($doing_migration_lock)) {
            $this->getSystemFunctions()->filePutContentsAppend($doing_migration_lock, 'ongoing migration..');
        }       
    }
    
    /**
     * Open lock file
     * @param string $lock_file
     * @return boolean|resource handle
     * @codeCoverageIgnore
     */
    public function openLockFile($lock_file = '', $render_absolute = true)
    {
        if ( ! $lock_file ) {
            return false;
        }
        global $wp_filesystem;
        if ($render_absolute) {
            $lock_file_path = $wp_filesystem->abspath() . $lock_file;
        } else {
            $lock_file_path = $lock_file;
        }
        
        return @fopen($lock_file_path, "wb");
    }
    
    /**
     * Create lock file using native PHP flock
     * @param $fp
     * @return boolean
     * @codeCoverageIgnore
     */
    public function createProcessLockFile($fp)
    {
        return flock($fp, LOCK_EX);
    }
    
    /**
     * Unlock file after processing
     * @codeCoverageIgnore
     */
    public function unLockFile($fp)
    {
        return flock($fp, LOCK_UN);
    }
    
    /**
     * Close dropbox lock
     * @param $fp
     * @codeCoverageIgnore
     */
    public function closeLock($fp)
    {
        @fclose($fp);
    }    
}