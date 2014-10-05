<?php
/*----------------------------------------------------------------------------------------------------------------------
Plugin Name: Category Extra Content
Description: Adds additional content to posts in categories
Version: 0.1.0
Author: Matthias Kleine
Author URI: http://mkleine.de/
Plugin URI: http://www.yarpp.com/
----------------------------------------------------------------------------------------------------------------------*/

define('CATEGORY_EXTRA_DIR', dirname(__FILE__));

include_once(CATEGORY_EXTRA_DIR.'/classes/Core.php');
$categoryExtraContent = new CategoryExtraContent();