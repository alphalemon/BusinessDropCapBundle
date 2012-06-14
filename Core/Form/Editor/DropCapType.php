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

namespace AlphaLemon\Block\BusinessDropCapBundle\Core\Form\Editor;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * Defines the languages form
 *
 * @author alphalemon <webmaster@alphalemon.com>
 */
class DropCapType extends AbstractType
{
    /*
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }*/
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('dropcap');
        $builder->add('title');
        $builder->add('subtitle');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'AlphaLemon\Block\BusinessDropCapBundle\Core\Form\Editor\DropCap',
        );
    }
    
    public function getName()
    {
        return 'dropcap';
    }
}