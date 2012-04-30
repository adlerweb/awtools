<?php

/**
 * AwSmarty
 *
 * Wrapper to load Smarty
 *
 * @package awtools
 * @author Florian Knodt <adlerweb@adlerweb.info>
 * @see http://smarty.net
 *
 * @env AW_SMARTY_CACHE  bool Disable and clear Smarty's cache
 * @env AW_SMARTY_DEBUG  bool Enable Smarty's debugging
 * @env AW_SMARTY_NOAUTO bool if defined auto-instantiate is turned off
 */

class adlerweb_smarty {
    
    /**
     * Load Smarty (if not done so already) and initialize some basic stuff
     * @var string $prefix defaults to tpl - change to instanciate multiple template sessions
     */
    function __construct($prefix = 'tpl') {
        if(!class_exists('Smarty')) {
            if(file_exists('smarty/Smarty.class.php')) {
                require_once('smarty/Smarty.class.php');
            }elseif(file_exists('../smarty/Smarty.class.php')) {
                require_once('../smarty/Smarty.class.php');
            }elseif(file_exists('lib/smarty/Smarty.class.php')) {
                require_once('lib/smarty/Smarty.class.php');
            }else{
                if(!@include('Smarty.class.php')) {
                    trigger_error('Could not find Smarty', E_USER_ERROR);
                    return false;
                }
            }
        }
        
        $GLOBALS['adlerweb'][$prefix] = new Smarty;

        if(defined('AW_SMARTY_CACHE') && AW_SMARTY_CACHE === false) $GLOBALS['adlerweb'][$prefix]->clear_all_cache();
        
        $GLOBALS['adlerweb'][$prefix]->template_dir = 'tpl/src/';
        $GLOBALS['adlerweb'][$prefix]->compile_dir  = 'tpl/compile/';
        $GLOBALS['adlerweb'][$prefix]->config_dir   = 'tpl/config/';
        if(defined('AW_SMARTY_DEBUG')) $GLOBALS['adlerweb'][$prefix]->debugging    = AW_SMARTY_DEBUG;
        
        $GLOBALS['adlerweb'][$prefix]->assign('currentYear', strftime("%Y", time())); //Used for copyright etc
    }
}

/**
 * Instantiate new global AwSmarty-object if not deactivated
 */
if(!defined('AW_SMARTY_NOAUTO')) {
    $GLOBALS['adlerweb']['tpl_wrapper'] = new adlerweb_smarty();
}

?>
