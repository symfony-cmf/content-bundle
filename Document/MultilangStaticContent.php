<?php

namespace Symfony\Cmf\Bundle\ContentBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCRODM;

class MultilangStaticContent extends StaticContent
{
    /**
     * Locale
     */
    protected $locale;

    /**
     * Title
     */
    protected $title;

    /**
     * Body
     */
    protected $body;

    /**
     * Tags
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
