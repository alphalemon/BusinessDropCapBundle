<?php
/*
 * This file is part of the BusinessDropCapBundle and it is distributed
 * under the GPL LICENSE Version 2.0. To use this application you must leave
 * intact this copyright notice.
 *
 * Copyright (c) AlphaLemon <webmaster@alphalemon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For extra documentation and help please visit http://www.alphalemon.com
 *
 * @license    GPL LICENSE Version 2.0
 *
 */

namespace AlphaLemon\Block\BusinessDropCapBundle\Tests\Unit\Core\Block;

use AlphaLemon\Block\BusinessDropCapBundle\Tests\TestCase;
use AlphaLemon\Block\BusinessDropCapBundle\Core\Block\AlBlockManagerBusinessDropCap;

/**
 * AlBlockManagerBusinessDropCapTest
 *
 * @author alphalemon <webmaster@alphalemon.com>
 */
class AlBlockManagerBusinessDropCapTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $factoryRepository = $this->getMock('AlphaLemon\AlphaLemonCmsBundle\Core\Repository\Factory\AlFactoryRepositoryInterface');
        $validator = $this->getMock('Symfony\Component\Validator\ValidatorInterface');
        $eventsHandler = $this->getMock('AlphaLemon\AlphaLemonCmsBundle\Core\EventsHandler\AlEventsHandlerInterface');
        $this->blockManager = new AlBlockManagerBusinessDropCap($eventsHandler, $validator, $factoryRepository);
    }

    public function testDefaultValue()
    {
        $value =
        '{
            "0" : {
                "dropcap" : "A",
                "title" : "A Dropcap",
                "subtitle" : "Title"
            }
        }';
        $expectedValue = array(
            'Content' => $value,
            'InternalJavascript' => '$(\'.business-dropcap h3\').doCufon();',
        );
        $this->assertEquals($expectedValue, $this->blockManager->getDefaultValue());
    }

    public function testAnEmptyStringIsReturnedWhenTheBlockHasNotBeenSet()
    {
        $this->assertEquals('', $this->blockManager->getHtml());
    }

    public function testTheDropCapIsRendered()
    {
        $block = $this->setUpBlock();
        $this->blockManager->set($block);
        $content = $this->blockManager->getHtml();

        $expectedResult = '<div class="business-dropcap"><h3><span class="dropcap">A</span>A Dropcap<span>Title</span></h3></div>';
        $this->assertEquals($expectedResult, $content);
    }

    private function setUpBlock()
    {
        $value =
        '{
            "0" : {
                "dropcap" : "A",
                "title" : "A Dropcap",
                "subtitle" : "Title"
            }
        }';

        $block = $this->getMock('AlphaLemon\AlphaLemonCmsBundle\Model\AlBlock');
        $block->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue($value));

        return $block;
    }
}