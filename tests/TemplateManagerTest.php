<?php

namespace Arrilot\Tests\DotEnv;

use Arrilot\VueTemplates\TemplateManager;
use PHPUnit\Framework\TestCase;

class TemplateManagerTest extends TestCase
{
    /**
     * @var TemplateManager
     */
    protected $vue;

    public function setUp()
    {
        $this->vue = new TemplateManager(__DIR__.'/fixtures');
    }

    public function test_printing_simple_template()
    {
        $this->vue->addTemplate('test');
        ob_start();
        $this->vue->printTemplates();

        $this->assertSame('<script type="text/x-template" id="vue-test-template">test template</script>', ob_get_clean());
    }
    
    public function test_printing_several_templates()
    {
        $this->vue->addTemplate('test');
        $this->vue->addTemplate('test2');

        ob_start();
        $this->vue->printTemplates();
        $expected = '<script type="text/x-template" id="vue-test-template">test template</script>';
        $expected .= '<script type="text/x-template" id="vue-test2-template">test template2</script>';
        
        $this->assertSame($expected, ob_get_clean());
    }
    
    public function test_no_duplication_are_done()
    {
        $this->vue->addTemplate('test');
        $this->vue->addTemplate('test2');
        $this->vue->addTemplate('test');

        ob_start();
        $this->vue->printTemplates();
        $expected = '<script type="text/x-template" id="vue-test-template">test template</script>';
        $expected .= '<script type="text/x-template" id="vue-test2-template">test template2</script>';
        
        $this->assertSame($expected, ob_get_clean());
    }

    public function test_recursive_templates_work_well()
    {
        $this->vue->addTemplate('test3');
        
        ob_start();
        $this->vue->printTemplates();
        $expected = '<script type="text/x-template" id="vue-test3-template">test template3</script>';
        $expected .= '<script type="text/x-template" id="vue-test4-template">test template4</script>';
        
        $this->assertSame($expected, ob_get_clean());
    }
    
    public function test_templates_in_subfolders()
    {
        $this->vue->addTemplate('some_dir/test5');
        
        ob_start();
        $this->vue->printTemplates();
        $expected = '<script type="text/x-template" id="vue-some_dir-test5-template">test template5</script>';

        $this->assertSame($expected, ob_get_clean());
    }

    public function test_that_data_can_be_passed_to_template()
    {
        $this->vue->addTemplate('test7', ['foo' => 'bar']);
        
        ob_start();
        $this->vue->printTemplates();
        $expected = '<script type="text/x-template" id="vue-test7-template">test template7 bar</script>';
        
        $this->assertSame($expected, ob_get_clean());
    }
}
