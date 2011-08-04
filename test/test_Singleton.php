<?php

$t_root_path = '/eve/';
require_once('../Singleton.php');

function test_setClass() {
    $class = 'Singleton';
    
    echo 'Testing Singleton::setClass(' . $class . ').<br />';
    
    try {
        Singleton::setClass($class);
        $result = Singleton::getClass();
    } catch(Exception $e) {
        echo 'Caught exception: ' . $e->getMessage() . '<br />';
        echo 'Failed.<br /><br />';
    }

    echo 'Singleton::getClass() returned: ';
    echo var_dump($result) . '<br />';
    echo 'Passed.<br /><br />';
}

function test_getInstance() {
    echo 'Testing Singleton::getInstance().<br />';
    
    try {
        $result = Singleton::getInstance();
    } catch(Exception $e) {
        echo 'Caught exception: ' . $e->getMessage() . '<br />';
        echo 'Failed.<br /><br />';
    }
    
    if(is_object($result)) {
        echo 'Singleton::getInstance() returned object: ';
        echo var_dump($result) . '<br />';
        echo 'Passed.<br /><br />';
    } else {
        echo 'Singleton::getInstance() returned non-object: ';
        echo var_dump($result) . '<br />';
        echo 'Failed.<br /><br />';
    }
}

function initiateTest() {
    test_setClass();
    test_getInstance();
}

initiateTest();

?>
