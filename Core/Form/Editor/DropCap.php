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

use Symfony\Component\Validator\Validator;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Defines the dropcap form fields
 *
 * @author alphalemon <webmaster@alphalemon.com>
 */
class DropCap
{
    /**
     * @Assert\NotBlank(message = "Dropcap field should not be blank")
     * @Assert\MaxLength(1)
     */
    protected $dropcap;

    /**
     * @Assert\NotBlank(message = "Title field should not be blank")
     */
    protected $title = "";
    
    /**
     * @Assert\NotBlank(message = "Subtitle field value should not be blank")
     */
    protected $subtitle = "";
    
    public function getDropcap()
    {
        return $this->dropcap;
    }

    public function setDropcap($v)
    {
        $this->dropcap = $v;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($v)
    {
        $this->title = $v;
    }
    
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    public function setSubtitle($v)
    {
        $this->subtitle = $v;
    }
}