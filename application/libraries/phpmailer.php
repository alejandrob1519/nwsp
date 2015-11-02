<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
require_once dirname(__FILE__) . '/PHPMailer/class.phpmailer.php';
 
class mailer extends phpmailer
{
    function __construct()
    {
        parent::__construct();
    }
}
