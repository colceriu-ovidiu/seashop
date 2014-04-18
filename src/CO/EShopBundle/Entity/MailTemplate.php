<?php

namespace CO\EShopBundle\Entity;

class MailTemplate
{
    private $content;

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }
    
}