<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;

class UserManagerCon extends Controller
{
    public function request_get()
    {
        if (!Input::has('function')) {
            return ['error' => 1];
        }
        $function = Input::get('function');

        $inputs = Input::all();
        unset($inputs['function']);

        switch($function){
            case "login":
                $url = "/user/login/";
                $post = true;
                break;
            case "register":
                $url = "/user/register/";
                $post = true;
                break;
            case "userRemove":
                $url = "/user/remove/";
                $post = true;
                break;
            case "user":
                $url = "/user/get/";
                $post = true;
                break;
            case "userAll":
                $url = "/user/getall/";
                $post = true;
                break;
            case "userRole":
                $url = "/user/role";
                $post = true;
                break;
            case "friendAdd":
                $url = "/friend/add/";
                $post = true;
                break;
            case "friendRemove":
                $url = "/friend/remove/";
                $post = true;
                break;
            case "friend":
                $url = "/friend/all/";
                $post = true;
                break;
            case "friendAccept":
                $url = "/friend/accept/";
                $post = true;
                break;
            case "messageNew":
                $url = "/message/new/";
                $post = true;
                break;
            case "messageRemove":
                $url = "/message/remove/";
                $post = true;
                break;
            case "message":
                $url = "/message/all/";
                $post = true;
                break;
            case "teamCreate":
                $url = "/team/create/";
                $post = true;
                break;
            case "teamRemove":
                $url = "/team/remove/";
                $post = true;
                break;
            case "team":
                $url = "/team/get/";
                $post = true;
                break;
            case "teamMemberAdd":
                $url = "/team/member/add/";
                $post = true;
                break;
            case "teamMemberRemove":
                $url = "/team/member/remove/";
                $post = true;
                break;
            case "teamMemberRoleSet":
                $url = "/team/member/role/";
                $post = true;
                break;
            default:
                return ['error' => $function];
        }

        return $this->getFromUserManager($url, $inputs, $post);
    }

    public static function getLogedinUser(String $username, String $currentID){
        $ret = json_decode(UserManagerCon::getFromUserManager("/user/get/", [
            'username' => $username,
            'currentID' => $currentID
        ]));
        if(array_key_exists('error', $ret)) return null;
        return $ret;
    }

    public static function getUser(String $username){
        $ret = json_decode(UserManagerCon::getFromUserManager("/user/get/", [
            'username' => $username
        ]));
        if(array_key_exists('error', $ret)) return null;
        return $ret;
    }

    public static function getLogedinUserTeam(String $username, String $currentID, String $teamname){
        $ret = json_decode(UserManagerCon::getFromUserManager("/team/get/", [
            'username' => $username,
            'currentID' => $currentID,
            'teamname' => $teamname
        ]));
        if(array_key_exists('error', $ret)) return null;
        return $ret;
    }


    private static function getFromUserManager($functionL, $dataArray, $post = true){
        $data_string = json_encode($dataArray);

        if($post){
            $ch = curl_init('http://35.181.131.32/rest' . $functionL);
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
            $ch = curl_init('http://35.181.131.32/rest' . $functionL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        }
        $result = curl_exec($ch);

        return $result;
    }
}
