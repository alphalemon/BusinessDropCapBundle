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

use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\AlBlockManager;
use AlphaLemon\Block\BusinessDropCapBundle\Core\Form\Editor\DropCap;use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Validator\AlParametersValidatorInterface;
use AlphaLemon\AlphaLemonCmsBundle\Core\Repository\Factory\AlFactoryRepositoryInterface;
use Symfony\Component\Validator\ValidatorInterface;

/**
 * AlBlockManagerBusinessDropCap
 *
 * @author alphalemon
 */
class AlBlockManagerBusinessDropCap extends AlBlockManager
{
    private $sfValidator = null;

    public function __construct(EventDispatcherInterface $dispatcher, ValidatorInterface $sfValidator, AlFactoryRepositoryInterface $factoryRepository = null, AlParametersValidatorInterface $validator = null)
    {
        parent::__construct($dispatcher, $factoryRepository, $validator);

        $this->sfValidator = $sfValidator;
    }

    public function getDefaultValue() {

        $defaultValue = "{\n\t";
        $defaultValue .= "\"dropcap\": \"A\",\n\t";
        $defaultValue .= "\"title\": \"A Dropcap\",\n\t";
        $defaultValue .= "\"subtitle\": \"Title!\"\n";
        $defaultValue .= "}";

        return array('HtmlContent' => $defaultValue);
    }

    public function getHtmlContentForDeploy()
    {
        $value = $this->decodeJson($this->alBlock->getHtmlContent());

        return sprintf('<div class="business-dropcap"><h3><span class="dropcap">%s</span>%s<span>%s</span></h3></div>', $value["dropcap"], $value["title"], $value["subtitle"]);
    }

    public function getHtmlContent()
    {
        return $this->getHtmlContentForDeploy() . '<script type="text/javascript">$(document).ready(function(){ $(\'.business-dropcap h3\').doCufon(); });</script>';
    }

    protected function edit(array $values)
    {
        try
        {
            // Decodes the jquery serialized form
            $unserializedData = array();
            $serializedData = $values['HtmlContent'];
            parse_str($serializedData, $unserializedData);
            $content = $unserializedData["dropcap"];

            // Builds and populates a DropCap object
            $dropCap = new DropCap();
            $dropCap->setDropcap($content["dropcap"]);
            $dropCap->setTitle($content["title"]);
            $dropCap->setSubtitle($content["subtitle"]);

            // Validates the given data
            $errors = array();
            //$validator = $this->container->get('validator');
            $formErrors = $this->sfValidator->validate($dropCap);
            foreach($formErrors as $formError)
            {
                $errors[] = $formError->getMessage();
            }

            // An exception is thrown when the validator found errors
            if(count($errors) > 0) {
                throw new \RuntimeException("Some errors occoured during the editing operation:<br /><br />" . implode("<br />", $errors));
            }

            // encodes to json and saves
            $value = json_encode($content);
            $values['HtmlContent'] = $value;

            return parent::edit($values);
        }
        catch(\InvalidArgumentException $ex)
        {
            throw $ex;
        }
    }

    private function decodeJson($value) {
        $value = json_decode($value, true);

        if(!is_array($value))
        {
            throw new \InvalidArgumentException("The value you entered is not valid.");
        }

        $diff = array_diff_key(array("dropcap" => '', "title" => '', "subtitle" => ''), $value);
        if(!empty($diff))
        {
            throw new \InvalidArgumentException("Some required parameters for the block are missing: " . implode(",", $diff) . ". Please fix the content.");
        }

        return $value;
    }
}
