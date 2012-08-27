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

namespace AlphaLemon\Block\BusinessDropCapBundle\Core\Block;

use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\JsonBlock\AlBlockManagerJsonBlock;
use AlphaLemon\Block\BusinessDropCapBundle\Core\Form\Editor\DropCap;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Validator\AlParametersValidatorInterface;
use AlphaLemon\AlphaLemonCmsBundle\Core\Repository\Factory\AlFactoryRepositoryInterface;
use Symfony\Component\Validator\ValidatorInterface;

/**
 * AlBlockManagerBusinessDropCap
 *
 * @author alphalemon
 */
class AlBlockManagerBusinessDropCap extends AlBlockManagerJsonBlock
{
    private $sfValidator = null;

    public function __construct(EventDispatcherInterface $dispatcher, ValidatorInterface $sfValidator, AlFactoryRepositoryInterface $factoryRepository = null, AlParametersValidatorInterface $validator = null)
    {
        parent::__construct($dispatcher, $factoryRepository, $validator);

        $this->sfValidator = $sfValidator;
    }

    public function getDefaultValue()
    {
        $value =
        '{
            "0" : {
                "dropcap" : "A",
                "title" : "A Dropcap",
                "subtitle" : "Title"
            }
        }';

        return array(
            'HtmlContent' => $value,
            'InternalJavascript' => '$(\'.business-dropcap h3\').doCufon();',
        );
    }

    public function getHtmlContentForDeploy()
    {
        if (null === $this->alBlock) {
           return ''; 
        }
                
        $value = json_decode($this->alBlock->getHtmlContent(), true);
        $value = $value[0];

        return sprintf('<div class="business-dropcap"><h3><span class="dropcap">%s</span>%s<span>%s</span></h3></div>', $value["dropcap"], $value["title"], $value["subtitle"]);
    }
}
