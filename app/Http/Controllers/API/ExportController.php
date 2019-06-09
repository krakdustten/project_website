<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class ExportController extends Controller
{
    public static function getUserList($items){
        $data = [];

        //TODO bulk prices fix

        foreach ($items as $k=>$v) {
            $minimum_amount = 100000000;
            $price_per_piece = 100000000;
            $min_price_per_piece = 100000000;

            foreach ($v['prices'] as $kp=>$vp){
                if($vp['amount'] < $minimum_amount){
                    $minimum_amount = $vp['amount'];
                    $min_price_per_piece = $vp['price'];
                }
            }

            if ($price_per_piece >= 100000000)
                $price_per_piece = $min_price_per_piece;

            $buy_amount = ceil($v['useramount'] / $minimum_amount) * $minimum_amount;
            foreach ($v['prices'] as $kp=>$vp){
                if($vp['amount'] <= $buy_amount){
                    if($vp['price'] <= $price_per_piece)
                        $price_per_piece = $vp['price'];
                }
            }

            $subd = array(
                $v['link'],
                $v['componentnumber'],
                $v['vender'],
                $v['useramount'],
                $minimum_amount,
                "",
                $price_per_piece
            );
            array_push($data, $subd);
        }

        $json_d = [
            'header' => [
                'titles' => [
                    "Link",
                    "Component number",
                    "Vender"
                ],
                'columnType' => [
                    "",
                    "",
                    "",
                    "an",
                    "mamt",
                    "amt",
                    "ppp",
                    "p"
                ]
            ],
            'data' => $data
        ];
        return ExportController::getFromExportManager($json_d);
    }

    public static function getFullList($items){
        $data = [];

        foreach ($items as $k=>$v) {
            $minimum_amount = 100000000;
            $price_per_piece = 100000000;
            $min_price_per_piece = 100000000;

            foreach ($v['prices'] as $kp=>$vp){
                if($vp['amount'] < $minimum_amount){
                    $minimum_amount = $vp['amount'];
                    $min_price_per_piece = $vp['price'];
                }
            }

            if ($price_per_piece >= 100000000)
                $price_per_piece = $min_price_per_piece;

            $buy_amount = ceil($v['amount'] / $minimum_amount) * $minimum_amount;
            foreach ($v['prices'] as $kp=>$vp){
                if($vp['amount'] <= $buy_amount){
                    if($vp['price'] <= $price_per_piece)
                        $price_per_piece = $vp['price'];
                }
            }

            $subd = array(
                $v['link'],
                $v['componentnumber'],
                $v['vender'],
                $v['amount'],
                $minimum_amount,
                "",
                $price_per_piece
            );
            array_push($data, $subd);
        }

        $json_d = [
            'header' => [
                'titles' => [
                    "Link",
                    "Component number",
                    "Vender"
                ],
                'columnType' => [
                    "",
                    "",
                    "",
                    "an",
                    "mamt",
                    "amt",
                    "ppp",
                    "p"
                ]
            ],
            'data' => $data
        ];
        return ExportController::getFromExportManager($json_d);
    }

    private static function getFromExportManager($dataArray, $post = true){
        $data_string = json_encode($dataArray);

        if($post){
            $ch = curl_init('http://35.181.159.77:5000');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
            );
        }else{
            $functionL = $functionL . "?";
            foreach ($dataArray as $key => $value){
                $functionL = $functionL . $key . "=" . $value . "&";
            }
            $functionL = substr($functionL, 0, -1);
            $ch = curl_init('http://127.0.0.1:5000' . $functionL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        }
        $result = curl_exec($ch);



        $response = response($result, 200);
        $response->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        return $response;
    }
}