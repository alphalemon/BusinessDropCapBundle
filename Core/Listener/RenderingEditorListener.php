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

namespace AlphaLemon\Block\BusinessDropCapBundle\Core\Listener; 

use Symfony\Component\HttpFoundation\Request;
use AlphaLemon\AlphaLemonCmsBundle\Core\Event\Actions\Block\BlockEditorRenderingEvent;
use AlphaLemon\Block\BusinessDropCapBundle\Core\Block\AlBlockManagerBusinessDropCap;
use AlphaLemon\Block\BusinessDropCapBundle\Core\Form\Editor\DropCapType;
use AlphaLemon\Block\BusinessDropCapBundle\Core\Form\Editor\DropCap;

/**
 * Manipulates the block's editor response when the editor has been rendered 
 *
 * @author alphalemon <webmaster@alphalemon.com>
 */
class RenderingEditorListener 
{
    public function onBlockEditorRendering(BlockEditorRenderingEvent $event)
    {
        try
        {
            $alBlockManager = $event->getAlBlockManager();            
            if($alBlockManager instanceof AlBlockManagerBusinessDropCap)
            {
                $content = json_decode($alBlockManager->get()->getHtmlContent(), true);
                
                $dropCap = new DropCap();
                $dropCap->setDropcap($content["dropcap"]);
                $dropCap->setTitle($content["title"]);
                $dropCap->setSubtitle($content["subtitle"]);
                
                $form = $event->getContainer()->get('form.factory')->create(new DropCapType(), $dropCap);
                
                $request = $event->getRequest();
                $template = sprintf('%sBundle:Block:%s_editor.html.twig', $alBlockManager->get()->getClassName(), strtolower($alBlockManager->get()->getClassName()));
                $editor = $event->getContainer()->get('templating')->render($template, array("form" => $form->createView(),
                                                                                               "language" => $request->get('language'),
                                                                                               "page" => $request->get('page')));
                $event->setEditor($editor);
            }
        }
        catch(\Exception $ex)
        {
            throw $ex;
        }
    }
}
