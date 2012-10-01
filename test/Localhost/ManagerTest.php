<?php
require realpath(__DIR__.'/../../classes/Localhost/Manager.php');
// require realpath(__DIR__.'/../../classes/Localhost/View.php');

use Localhost\Manager,
    Localhost\View;

class ManagerTest extends  PHPUnit_Framework_Testcase
{
    private $manager;
    
    public function setUp()
    {
        $this->manager = new Manager();
    }
    public function testInstanceOf() {
        $this->assertInstanceOf('Localhost\Manager', $this->manager);
    }
    
    public function testCanListDirectories()
    {
        $array = $this->manager->listDir(__DIR__);
        $check = $array[0]["name"];
        
        $test = is_dir($check) || is_file($check);
        $this->assertTrue($test);
    }
    
    public function testListDirFailsWhenPassedNotPathToDirectory()
    {
        $array = $this->manager->listDir('this\should\fail');
        $check = $array[0]["name"];
        
        $test = is_dir($check) || is_file($check);
        $this->assertFalse($test);
    }
    
    public function testReadyResultDoesNotPassExceptions()
    {
        $dir = array(dirname(__DIR__).'/data/.test_read');
        
        $false = $this->manager->readyResults($dir);
        $this->assertFalse($false);
    }
}
