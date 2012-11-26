<?php

namespace Symfony\Cmf\Bundle\ContentBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCRODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @PHPCRODM\Document(translator="child", referenceable=true)
 */
class MultilangStaticContent extends StaticContent
{
    /**
     * @PHPCRODM\Locale
     */
    protected $locale;

    /**
     * @Assert\NotBlank
     * @PHPCRODM\String(translated=true)
     */
    protected $title;

    /**
     * @PHPCRODM\String(translated=true)
     */
    protected $body;

    /**
     * @PHPCRODM\String(multivalue=true, translated=true)
     */
    protected $tags = array();

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
    }
}
