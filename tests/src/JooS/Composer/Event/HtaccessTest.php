<?php

namespace JooS\Composer\Event;

use JooS\Files;

class HtaccessTest extends \PHPUnit_Framework_TestCase
{
  
  /**
   * @var Files
   */
  private $_files;
  
  /**
   * Test contents
   * 
   * @return null
   */
  public function testEmptyContent()
  {
    $path = $this->_files->tempnam();
    $htaccess = new Htaccess($path);
    
    $this->assertEquals($path, $htaccess->getPath());
    $this->assertTrue(!$htaccess->exists());
    $this->assertTrue($htaccess->writable());
    $this->assertEquals("", $htaccess->getContents());
    $this->assertEquals(array(), $htaccess->getContentsArray());
    
    $denyFromAll = "Deny from all";
    $expected = array($denyFromAll);

    file_put_contents($path, $denyFromAll);
    $this->assertEquals($expected, $htaccess->getContentsArray());

    file_put_contents($path, $denyFromAll . "\n");
    $this->assertEquals($expected, $htaccess->getContentsArray());
  }
  
  public function testAppend()
  {
    $path = $this->_files->tempnam();
    $htaccess = new Htaccess($path);
    
    $denyFromAll = "Deny from all";
    $htaccess->append($denyFromAll);
    $this->assertEquals($denyFromAll . PHP_EOL, $htaccess->getContents());

    $htaccess->append($denyFromAll);
    $this->assertEquals($denyFromAll . PHP_EOL, $htaccess->getContents());
  }
  
  protected function setUp()
  {
    $this->_files = new Files;
  }
  
  protected function tearDown()
  {
    unset($this->_files);
  }
  
}
