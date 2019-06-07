<?php


namespace App\wrappers;


class GetComponentFromLinkRequest
{
    protected $link;

    public function __construct($link)
    {
        $this->link = $link;
    }

    public function getLink()
    {
        return $this->link;
    }
}