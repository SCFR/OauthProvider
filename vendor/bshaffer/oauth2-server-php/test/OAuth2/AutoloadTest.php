<?php

namespace SCFROAuth2;

class AutoloadTest extends \PHPUnit_Framework_TestCase
{
    public function testClassesExist()
    {
        // autoloader is called in test/bootstrap.php
        $this->assertTrue(class_exists('SCFROAuth2\Server'));
        $this->assertTrue(class_exists('SCFROAuth2\Request'));
        $this->assertTrue(class_exists('SCFROAuth2\Response'));
        $this->assertTrue(class_exists('SCFROAuth2\GrantType\UserCredentials'));
        $this->assertTrue(interface_exists('SCFROAuth2\Storage\AccessTokenInterface'));
    }
}
