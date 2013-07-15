<?php

namespace Symfony\Cmf\Bundle\ContentBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCRODM;

class MultilangStaticContent extends StaticContent
{
    /**
     * Locale
     */
    protected $locale;

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
    }
}
