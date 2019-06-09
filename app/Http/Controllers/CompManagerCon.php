<?php

namespace App\Http\Controllers;

use App\wrappers\GetComponentFromLinkRequest;
use App\wrappers\GetComponentFromVenderRequest;
use App\wrappers\GetSupportedVendersRequest;
use Illuminate\Support\Facades\Input;
use Artisaninweb\SoapWrapper\SoapWrapper;


class CompManagerCon extends Controller
{
    private static $soapWrapper = null;
    private static function init()
    {
        CompManagerCon::$soapWrapper = new SoapWrapper();
        CompManagerCon::$soapWrapper->add('ComponentService', function ($service){
            $service
                ->wsdl('http://52.47.57.218/ComponentService.asmx?WSDL')
                ->trace(true)
                ->classmap([
                    GetComponentFromLinkRequest::class,
                    GetComponentFromVenderRequest::class,
                    GetSupportedVendersRequest::class
                ]);
        });
    }

    public function request_get(){
        if (!Input::has('function')) {
            return ['error' => 1];
        }
        $function = Input::get('function');

        switch ($function){
            case "fromLink":
                $result = $this->getComponentFromLink(Input::get('link'));
                $out = [
                    'Name' => $result->Name,
                    'Manufacturer' => $result->Manufacturer,
                    'ManufacturerNumber' => $result->ManufacturerNumber,
                    'Vendername' => $result->Vendername,
                    'VerderComponentNumber' => $result->VerderComponentNumber,
                    'Prices' => [],
                    'Link' => $result->Link,
                    'CheckedAt' => $result->CheckedAt,
                ];
                foreach($result->Prices->CompPrice as $key=>$value) {
                    array_push($out['Prices'], [
                        'Amount' => $value->Amount,
                        'Price' => $value->Price
                    ]);
                }
                return $out;
            case "fromNumber":
                $result = $this->GetComponentFromVender(Input::get('vendername'),Input::get('vendernumber'));
                $out = [
                    'Name' => $result->Name,
                    'Manufacturer' => $result->Manufacturer,
                    'ManufacturerNumber' => $result->ManufacturerNumber,
                    'Vendername' => $result->Vendername,
                    'VerderComponentNumber' => $result->VerderComponentNumber,
                    'Prices' => [],
                    'Link' => $result->Link,
                    'CheckedAt' => $result->CheckedAt,
                ];
                foreach($result->Prices->CompPrice as $key=>$value) {
                    array_push($out['Prices'], [
                        'Amount' => $value->Amount,
                        'Price' => $value->Price
                    ]);
                }
                return $out;
            case "venders":
                $result = $this->GetSupportedVenders();
                $out = [];
                foreach($result->string as $key=>$value)
                    array_push($out, ['vender' => $value]);
                return $out;
            default:
                return ['error' => 1];
        }
    }

    public static function getComponentFromLink($link){
        if(CompManagerCon::$soapWrapper == null) CompManagerCon::init();

        $response = CompManagerCon::$soapWrapper->call('ComponentService.GetComponentFromLink', [
            new GetComponentFromLinkRequest($link)
        ]);
        return $response->GetComponentFromLinkResult;
    }

    public static function GetComponentFromVender($vendername, $vendernumber){
        if(CompManagerCon::$soapWrapper == null) CompManagerCon::init();

        $response = CompManagerCon::$soapWrapper->call('ComponentService.GetComponentFromVender', [
            new GetComponentFromVenderRequest($vendername, $vendernumber)
        ]);
        return $response->GetComponentFromVenderResult;
    }

    public static function GetSupportedVenders(){
        if(CompManagerCon::$soapWrapper == null) CompManagerCon::init();

        $response = CompManagerCon::$soapWrapper->call('ComponentService.GetSupportedVenders', [
            new GetSupportedVendersRequest()
        ]);
        return $response->GetSupportedVendersResult->string;
    }
}