<?php


namespace App\wrappers;


class GetComponentFromVenderRequest
{
    protected $vendername;
    protected $vendernumber;

    public function __construct($vendername, $vendernumber)
    {
        $this->vendername = $vendername;
        $this->vendernumber = $vendernumber;
    }

    public function getVendername()
    {
        return $this->vendername;
    }

    public function getVendernumber()
    {
        return $this->vendernumber;
    }
}