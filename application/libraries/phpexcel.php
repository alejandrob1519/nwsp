<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel.php';
 
class Excel extends phpexcel
{
    function __construct()
    {
        parent::__construct();
    }
}
