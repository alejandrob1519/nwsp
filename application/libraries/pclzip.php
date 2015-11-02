<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
require_once dirname(__FILE__) . '/PclZip/pclzip.lib.php';
 
class Zip extends PclZip
{
    function __construct()
    {
        parent::__construct();
    }
}
