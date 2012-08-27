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
use AlphaLemon\Block\BusinessDropCapBundle\Core\Listener\RenderingEditorListener;


class TestBusinessDropCapEditorListener extends RenderingEditorListener
{
    protected $configureParams = null;

    public function configure()
    {
        return parent::configure();
    }
}

/**
 * RenderingEditorListenerTest
 *
 * @author alphalemon <webmaster@alphalemon.com>
 */
class RenderingEditorListenerTest extends TestCase
{
    public function testTheEditorHasBeenRendered()
    {
        $expectedResult = array(
            'blockClass' => '\AlphaLemon\Block\BusinessDropCapBundle\Core\Block\AlBlockManagerBusinessDropCap',
            'formClass' => '\AlphaLemon\Block\BusinessDropCapBundle\Core\Form\Editor\DropCapType',
        );
        $listener = new TestBusinessDropCapEditorListener();
        $this->assertEquals($expectedResult, $listener->configure());
    }
}