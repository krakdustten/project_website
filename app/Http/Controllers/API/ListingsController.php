<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\CompManagerCon;
use App\Http\Controllers\UserManagerCon;
use App\Listing;
use App\Http\Controllers\Controller;
use App\Listing_item;
use App\Listing_item_amount;
use App\Listing_user;
use App\Listing_vender;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Team;
use App\Listing_team;

class ListingsController extends Controller
{
    //TODO add possebility for public listings
    //TODO updateAutoList

    public function request_get()
    {
        if (!Input::has('function')) {
            return ['error' => 1];
        }
        $function = Input::get('function');
        if($function == "getAllPublicLists") return $this->getAllPublicLists();
        if($function == "getVenders") return $this->getVenders();
        if($function == "getPublicList"){
            if (!Input::has('id')) return ['error' => 100];
            return $this->getPublicList(Input::get('id'));
        }
        if($function == "getItemFromVenderComponent"){
            if (!Input::has('vendername') || !Input::has('componentnumber')) return ['error' => 100];
            return $this->getItemFromVenderComponent(Input::get('vendername'), Input::get('componentnumber'));
        }

        //you should be logged in for the next functions

        if (!Input::has('username') || !Input::has('currentID')) {
            return ['error' => 100];
        }
        $username = Input::get('username');
        $currentID = Input::get('currentID');

        if($function == "getAllUserLists") return $this->getAllUserLists($username, $currentID);
        if($function == "getUserList"){
            if (!Input::has('id')) return ['error' => 100];
                return $this->getUserList($username, $currentID, Input::get('id'));
        }
        if($function == "createUserList"){
            if (!Input::has('listname')) return ['error' => 100];
            return $this->createUserList($username, $currentID, Input::get('listname'));
        }
        if($function == "addUserToList"){
            if (!Input::has('id') || !Input::has('addusername')) return ['error' => 100];
            return $this->addUserToList($username, $currentID, Input::get('id'), Input::get('addusername'));
        }
        if($function == "setUserRights"){
            if (!Input::has('id') || !Input::has('addusername') || !Input::has('rights')) return ['error' => 100];
            return $this->setUserRights($username, $currentID, Input::get('id'), Input::get('addusername'), Input::get('rights'));
        }
        if($function == "removeUserFromList"){
            if (!Input::has('id') || !Input::has('addusername')) return ['error' => 100];
            return $this->removeUserFromList($username, $currentID, Input::get('id'), Input::get('addusername'));
        }
        if($function == "removeList"){
            if (!Input::has('id')) return ['error' => 100];
            return $this->removeList($username, $currentID, Input::get('id'));
        }
        if($function == "setItemOnList") {
            if (!Input::has('id') || !Input::has('vendername') || !Input::has('componentnumber') ||
                !Input::has('manufacturer') || !Input::has('manufacturernumber') || !Input::has('prices') ||
                !Input::has('link') || !Input::has('amount'))
                return ['error' => 100];
            return $this->setItemOnList($username, $currentID, Input::get('id'), Input::get('vendername'),
                Input::get('componentnumber'), Input::get('manufacturer'),
                Input::get('manufacturernumber'), Input::get('prices'), Input::get('link'),
                Input::get('amount'));
        }
        if($function == "setItemAmount"){
            if (!Input::has('id') || !Input::has('item_id') || !Input::has('amount'))
                return ['error' => 100];
            return $this->setItemAmount($username, $currentID, Input::get('id'), Input::get('item_id'),
                Input::get('amount'));
        }
        if($function == "getItemFromLink"){
            if (!Input::has('link')) return ['error' => 100];
            return $this->getItemFromLink($username, $currentID, Input::get('link'));
        }
        if($function == "exportUserList"){
            if (!Input::has('id')) return ['error' => 100];
            return $this->exportUserList($username, $currentID, Input::get('id'));
        }
        if($function == "exportFullList"){
            if (!Input::has('id')) return ['error' => 100];
            return $this->exportFullList($username, $currentID, Input::get('id'));
        }

        //you should give a team name for the next functions

        if (!Input::has('teamname')) return ['error' => 100];
        $teamname = Input::get('teamname');

        if($function == "getAllTeamLists") return $this->getAllTeamLists($username, $currentID, $teamname);
        if($function == "getTeamList"){
            if (!Input::has('id')) return ['error' => 100];
            return $this->getTeamList($username, $currentID, $teamname, Input::get('id'));
        }
        if($function == "createTeamList"){
            if (!Input::has('listname')) return ['error' => 100];
            return $this->createTeamList($username, $currentID, $teamname, Input::get('listname'));
        }
        if($function == "addTeamToList"){
            if (!Input::has('id')) return ['error' => 100];
            return $this->addTeamToList($username, $currentID, Input::get('id'), $teamname);
        }
        if($function == "removeTeamFromList"){
            if (!Input::has('id')) return ['error' => 100];
            return $this->removeTeamFromList($username, $currentID, Input::get('id'), $teamname);
        }
        return "";
    }

    public function getAllUserLists(String $username, String $currentID){
        $remuser = UserManagerCon::getLogedinUser($username, $currentID);
        if($remuser == null) return ['error' => 202];
        $user = User::where('name', $remuser->name)->where('usermanager_id', $remuser->id)->first();
        if($user == null) return ['error' => 201];
        $retArr = [];
        foreach($user->listing_users as $key=>$value) {
            if($value->listing != null)
                array_push($retArr, [
                    'rights' => $value->rights,
                    'name' => $value->listing->name,
                    'id' => $value->listing->id,
                    'private' => $value->listing->private
                ]);
        }
        return $retArr;
    }

    public function getAllTeamLists(String $username, String $currentID, String $teamname){
        $remteam = UserManagerCon::getLogedinUserTeam($username, $currentID, $teamname);
        if($remteam == null) return ['error' => 302];
        $team = Team::where('name', $teamname)->where('usermanager_id', $remteam->id)->first();
        if($team == null) return ['error' => 301];
        $retArr = [];
        foreach($team->listing_teams as $key=>$value) {
            if($value->listing != null)
                array_push($retArr, [
                    'rights' => $value->rights,
                    'name' => $value->listing->name,
                    'id' => $value->listing->id,
                    'private' => $value->listing->private
                ]);
        }
        return $retArr;
    }

    public function getAllPublicLists(){
        $listings = Listing::where('private', false)->get();
        $retArr = [];
        foreach($listings as $key=>$value) {
            array_push($retArr, [
                'name' => $value->name,
                'id' => $value->id
            ]);
        }
        return $retArr;
    }

    public function getPublicList($id){
        $listing = Listing::find($id);

        return $this->getListingArray($listing);
    }

    public function getUserList(String $username, String $currentID, $id){
        $remuser = UserManagerCon::getLogedinUser($username, $currentID);
        if($remuser == null) return ['error' => 202];
        $user = User::where('name', $remuser->name)->where('usermanager_id', $remuser->id)->first();
        if($user == null) return ['error' => 201];
        $luser = Listing_user::where('user_id', $user->id)->where('listing_id', $id)->first();
        if($luser == null) return null;
        $listing = $luser->listing;
        if($listing == null) return null;

        return $this->getListingArray($listing, true, $luser);
    }

    public function getTeamList(String $username, String $currentID, String $teamname, $id){
        $remteam = UserManagerCon::getLogedinUserTeam($username, $currentID, $teamname);
        if($remteam == null) return ['error' => 302];
        $team = Team::where('name', $teamname)->where('usermanager_id', $remteam->id)->first();
        if($team == null) return ['error' => 301];
        $lteam = Listing_team::where('team_id', $team->id)->where('listing_id', $id)->first();
        if($lteam == null) return null;
        $listing = $lteam->listing;
        if($listing == null) return null;

        return $this->getListingArray($listing, true);
    }

    public function createUserList(String $username, String $currentID, String $listname){
        $remuser = UserManagerCon::getLogedinUser($username, $currentID);
        if($remuser == null) return ['error' => 202];
        $user = $this->getOrCreateUser($remuser->name, $remuser->id);
        if($user == null) return ['error' => 201];

        $listN = new Listing;
        $listN->name = $listname;
        $listN->private = true;
        $listN->save();

        $listing_userN = new Listing_user;
        $listing_userN->listing_id = $listN->id;
        $listing_userN->user_id = $user->id;
        $listing_userN->rights = 2500;
        $listing_userN->save();

        return ['done' => 'ok'];
    }

    public function createTeamList(String $username, String $currentID, String $teamname, String $listname){
        $remuser = UserManagerCon::getLogedinUser($username, $currentID);
        if($remuser == null) return ['error' => 202];
        $user = $this->getOrCreateUser($remuser->name, $remuser->id);
        if($user == null) return ['error' => 201];
        $remteam = UserManagerCon::getLogedinUserTeam($username, $currentID, $teamname);
        if($remteam == null) return ['error' => 302];
        $team = $this->getOrCreateTeam($teamname, $remteam->id);
        if($team == null) return ['error' => 301];

        $listN = new Listing;
        $listN->name = $listname;
        $listN->private = true;
        $listN->save();

        $listing_userN = new Listing_user;
        $listing_userN->listing_id = $listN->id;
        $listing_userN->user_id = $user->id;
        $listing_userN->rights = 2500;
        $listing_userN->save();

        $listing_teamN = new Listing_team;
        $listing_teamN->listing_id = $listN->id;
        $listing_teamN->team_id = $team->id;
        $listing_teamN->rights = 2500;
        $listing_teamN->save();

        return ['done' => 'ok'];
    }

    public function addUserToList(String $username, String $currentID, $id, String $addusername){
        $remuser = UserManagerCon::getLogedinUser($username, $currentID);
        if($remuser == null) return ['error' => 202];
        $user = User::where('name', $remuser->name)->where('usermanager_id', $remuser->id)->first();
        if($user == null) return ['error' => 201];
        $remadduser = UserManagerCon::getUser($addusername);
        $adduser = $this->getOrCreateUser($remadduser->name, $remadduser->id);
        if($adduser == null) return ['error' => 11];
        $luser = Listing_user::where('user_id', $user->id)->where('listing_id', $id)->first();
        if($luser == null) return ['error' => 12];
        $listing = $luser->listing;
        if($listing == null) return ['error' => 13];
        if($luser->rights < 100) return ['error' => 14];
        $adduserl = Listing_user::where('user_id', $adduser->id)->where('listing_id', $id)->first();
        if($adduserl != null) return ['error' => 15];

        $listing_userN = new Listing_user;
        $listing_userN->listing_id = $listing->id;
        $listing_userN->user_id = $adduser->id;
        $listing_userN->rights = 0;
        $listing_userN->save();

        return ['done' => 'ok'];
    }

    public function setUserRights(String $username, String $currentID, $id, String $addusername, $rights){
        $remuser = UserManagerCon::getLogedinUser($username, $currentID);
        if($remuser == null) return null;
        $user = User::where('name', $remuser->name)->where('usermanager_id', $remuser->id)->first();
        if($user == null) return null;
        $remadduser = UserManagerCon::getUser($addusername);
        if($remadduser == null) return null;
        $adduser = $this->getOrCreateUser($remadduser->name, $remadduser->id);
        if($adduser == null) return null;
        $luser = Listing_user::where('user_id', $user->id)->where('listing_id', $id)->first();
        if($luser == null) return null;
        $listing = $luser->listing;
        if($listing == null) return null;
        $ladduser = Listing_user::where('user_id', $adduser->id)->where('listing_id', $id)->first();
        if($ladduser == null) return ['error' => 1];

        if($rights >= 100 && $luser->rights < 2500) return ['error' => 1];
        if($luser->rights < 100) return ['error' => 1];

        if($ladduser->rights >= 2500 && $rights < 2500){ //there must be one admin
            $highestRights = new Listing_user;
            $highestRights->rights = 0;
            $highestRights->id = -1;
            foreach ($listing->listing_users as $k=>$v){
                if($v->user_id != $ladduser->user_id){
                    if($highestRights->rights < $v->rights)
                        $highestRights = $v;
                }
            }
            if($highestRights->id < 0) return ['error' => 1];//last user in listing
            if($highestRights->rights < 2500){
                $highestRights->rights = 2500;
                $highestRights->save();
            }
        }

        $ladduser->rights = $rights;
        $ladduser->save();

        return ['done' => 'ok'];
    }

    public function removeUserFromList(String $username, String $currentID, $id, String $addusername){
        $remuser = UserManagerCon::getLogedinUser($username, $currentID);
        if($remuser == null) return ['error' => 202];
        $user = User::where('name', $remuser->name)->where('usermanager_id', $remuser->id)->first();
        if($user == null) return ['error' => 201];
        $remadduser = UserManagerCon::getUser($addusername);
        if($remadduser == null) return null;
        $adduser = $this->getOrCreateUser($remadduser->name, $remadduser->id);
        if($adduser == null) return null;
        $luser = Listing_user::where('user_id', $user->id)->where('listing_id', $id)->first();
        if($luser == null) return null;
        $listing = $luser->listing;
        if($listing == null) return null;
        $ladduser = Listing_user::where('user_id', $adduser->id)->where('listing_id', $id)->first();
        if($ladduser == null) return ['error' => 1];

        if($user->id != $adduser->id){
            if($ladduser->rights >= 100 && $luser->rights < 2500) return ['error' => 1];
            if($luser->rights < 100) return ['error' => 1];
        }


        if($ladduser->rights >= 2500){ //there must be one admin
            $highestRights = new Listing_user;
            $highestRights->rights = -1;
            $highestRights->id = -1;
            foreach ($listing->listing_users as $k=>$v){
                if($v->user_id != $ladduser->user_id){
                    if($highestRights->rights < $v->rights)
                        $highestRights = $v;
                }
            }
            if($highestRights->id < 0){//last user in listing
                return $this->removeList($username, $currentID, $id);
            }
            if($highestRights->rights < 2500){
                $highestRights->rights = 2500;
                $highestRights->save();
            }
        }

        foreach ($ladduser->listing_item_amount as $ka=>$va){
            $va->delete();
        }
        $ladduser->delete();

        return ['done' => 'ok'];
    }

    public function addTeamToList(String $username, String $currentID, $id, String $addteamname){
        $remuser = UserManagerCon::getLogedinUser($username, $currentID);
        if($remuser == null) return ['error' => 202];
        $user = User::where('name', $remuser->name)->where('usermanager_id', $remuser->id)->first();
        if($user == null) return ['error' => 201];
        $remaddteam = UserManagerCon::getLogedinUserTeam($username, $currentID, $addteamname);
        if($remaddteam == null) return ['error' => 302];
        $addteam = $this->getOrCreateTeam($addteamname, $remaddteam->id);
        if($addteam == null) return ['error' => 301];
        $luser = Listing_user::where('user_id', $user->id)->where('listing_id', $id)->first();
        if($luser == null) return null;
        $listing = $luser->listing;
        if($listing == null) return null;
        $laddteam = Listing_team::where('team_id', $addteam->id)->where('listing_id', $id)->first();
        if($laddteam != null) return ['error' => 1];
        if($luser->rights < 100) return ['error' => 1];
        $listing_teamN = new Listing_team();
        $listing_teamN->listing_id = $listing->id;
        $listing_teamN->team_id = $addteam->id;
        $listing_teamN->rights = 0;
        $listing_teamN->save();

        return ['done' => 'ok'];
    }

    public function removeTeamFromList(String $username, String $currentID, $id, String $addteamname){
        $remuser = UserManagerCon::getLogedinUser($username, $currentID);
        if($remuser == null) return ['error' => 202];
        $user = User::where('name', $remuser->name)->where('usermanager_id', $remuser->id)->first();
        if($user == null) return ['error' => 201];
        $remaddteam = UserManagerCon::getLogedinUserTeam($username, $currentID, $addteamname);
        if($remaddteam == null) return ['error' => 302];
        $addteam = $this->getOrCreateTeam($addteamname, $remaddteam->id);
        if($addteam == null) return ['error' => 301];
        $luser = Listing_user::where('user_id', $user->id)->where('listing_id', $id)->first();
        if($luser == null) return ['error' => 231];
        $listing = $luser->listing;
        if($listing == null) return ['error' => 501];
        $laddteam = Listing_team::where('team_id', $addteam->id)->where('listing_id', $id)->first();
        if($laddteam == null) return ['error' => 331];
        if($luser->rights < 100) return ['error' => 251];

        $laddteam->delete();

        return ['done' => 'ok'];
    }

    public function removeList(String $username, String $currentID, $id){
        $remuser = UserManagerCon::getLogedinUser($username, $currentID);
        if($remuser == null) return ['error' => 202];
        $user = User::where('name', $remuser->name)->where('usermanager_id', $remuser->id)->first();
        if($user == null) return ['error' => 201];
        $luser = Listing_user::where('user_id', $user->id)->where('listing_id', $id)->first();
        if($luser == null) return null;
        if($luser->rights < 2500) return ['error' => 1];
        $listing = $luser->listing;
        if($listing == null) return null;
        foreach ($listing->listing_teams as $k=>$v){
            $v->delete();
        }

        foreach ($listing->listing_users as $ku=>$vu){
            foreach ($vu->listing_item_amount as $ka=>$va){
                $va->delete();
            }
            $vu->delete();
        }
        $listing->delete();

        return ['done' => 'ok'];
    }

    public function setItemOnList(String $username, String $currentID, $id, String $vendername,
                                  String $componentnumber, String $manufacturer, String $manufacturernumber,
                                  String $prices, String $link, $amount){
        $remuser = UserManagerCon::getLogedinUser($username, $currentID);
        if($remuser == null) return ['error' => 202];
        $user = User::where('name', $remuser->name)->where('usermanager_id', $remuser->id)->first();
        if($user == null) return ['error' => 201];
        $luser = Listing_user::where('user_id', $user->id)->where('listing_id', $id)->first();
        if($luser == null) return null;

        $item = [
            'componentnumber' => $componentnumber,
            'manufacturer' => $manufacturer,
            'manufacturernumber' => $manufacturernumber,
            'prices' => $prices,
            'link' => $link
        ];

        $vender = Listing_vender::where('name', strtolower($vendername))->first();
        if($vender == null) {
            $venders = CompManagerCon::GetSupportedVenders();
            $automatic = false;
            foreach ($venders as $k => $v)
                if (strtolower($v) == strtolower($vendername))
                    $automatic = true;

            $vender = new Listing_vender;
            $vender->name = strtolower($vendername);
            $vender->automatic = $automatic;
            $vender->save();
        }

        $querryBuilder = Listing_item::where('vender_id', $vender->id);
        foreach ($item as $k=>$v)
            $querryBuilder = $querryBuilder->where($k, $v);
        $listing_item = $querryBuilder->first();
        if($listing_item == null){
            $listing_item = new Listing_item;
            $listing_item->vender_id = $vender->id;
            $listing_item->componentnumber = $componentnumber;
            $listing_item->manufacturer = $manufacturer;
            $listing_item->manufacturernumber = $manufacturernumber;
            $listing_item->prices = $this->getPriceString($this->getPriceArray($prices));
            $listing_item->link = $link;
            $listing_item->save();
        }

        $listing_item_amount = Listing_item_amount::where('listing_user_id', $luser->id)
            ->where('listing_item_id', $listing_item->id)->first();
        if($listing_item_amount == null){
            $listing_item_amount = new Listing_item_amount;
            $listing_item_amount->listing_user_id = $luser->id;
            $listing_item_amount->listing_item_id = $listing_item->id;
            $listing_item_amount->amount = 0;
        }
        $listing_item_amount->amount = $listing_item_amount->amount + $amount;
        $listing_item_amount->save();
        return ['done' => 'ok'];
    }

    public function setItemAmount(String $username, String $currentID, $id, $item_id, $amount){
        $remuser = UserManagerCon::getLogedinUser($username, $currentID);
        if($remuser == null) return ['error' => 202];
        $user = User::where('name', $remuser->name)->where('usermanager_id', $remuser->id)->first();
        if($user == null) return ['error' => 201];
        $luser = Listing_user::where('user_id', $user->id)->where('listing_id', $id)->first();
        if($luser == null) return null;
        $listing_item = Listing_item::where('id', $item_id)->first();
        if($listing_item == null) return null;
        $listing_item_amount = Listing_item_amount::where('listing_user_id', $luser->id)
            ->where('listing_item_id', $item_id)->first();
        if($amount <= 0){
            if($listing_item_amount != null){
                $listing_item_amount->delete();
            }
            return ['done' => 'ok'];
        }
        if($listing_item_amount == null){
            $listing_item_amount = new Listing_item_amount;
            $listing_item_amount->listing_user_id = $luser->id;
            $listing_item_amount->listing_item_id = $listing_item->id;
        }
        $listing_item_amount->amount = $amount;
        $listing_item_amount->save();
        return ['done' => 'ok'];
    }

    public function removeItemFromList(String $username, String $currentID, $id, $item_id){
        $remuser = UserManagerCon::getLogedinUser($username, $currentID);
        if($remuser == null) return ['error' => 202];
        $user = User::where('name', $remuser->name)->where('usermanager_id', $remuser->id)->first();
        if($user == null) return ['error' => 201];
        $luser = Listing_user::where('user_id', $user->id)->where('listing_id', $id)->first();
        if($luser == null) return null;
        $listing_item = Listing_item::where('id', $item_id)->first();
        if($listing_item == null) return null;
        $listing_item_amount = Listing_item_amount::where('listing_user_id', $user->id)
            ->where('listing_item_id', $item_id)->first();
        if($listing_item_amount != null){
            $listing_item_amount->delete();
        }
        return ['done' => 'ok'];
    }

    public function getVenders(){
        $venders = Listing_vender::all();

        $retV = [];
        foreach ($venders as $k=>$v) {
            array_push($retV, [
                'name' => $v->name,
                'automatic' => $v->automatic
            ]);
        }
        return $retV;
    }

    public function getItemFromVenderComponent(String $vendername, String $componentnumber){
        $linked_item = CompManagerCon::GetComponentFromVender($vendername, $componentnumber);
        $out = [
            'Name' => $linked_item->Name,
            'Manufacturer' => $linked_item->Manufacturer,
            'ManufacturerNumber' => $linked_item->ManufacturerNumber,
            'Vendername' => $linked_item->Vendername,
            'VerderComponentNumber' => $linked_item->VerderComponentNumber,
            'Prices' => "",
            'Link' => $linked_item->Link,
            'CheckedAt' => $linked_item->CheckedAt,
        ];
        if(is_array($linked_item->Prices->CompPrice)){
            foreach($linked_item->Prices->CompPrice as $key=>$value) {
                if(array_key_exists('Amount', $value) && array_key_exists('Price', $value))
                    $out['Prices'] = $out['Prices']."{$value->Amount}:{$value->Price},";
            }
            $out['Prices'] = rtrim($out['Prices'],',');
        }else{
            $out['Prices'] = $out['Prices']."{$linked_item->Prices->CompPrice->Amount}:{$linked_item->Prices->CompPrice->Price}";
        }
        $out['Prices'] = $this->getPriceArray($out['Prices']);
        return $out;
    }

    public function getItemFromLink(String $username, String $currentID, String $link){
        $remuser = UserManagerCon::getLogedinUser($username, $currentID);
        if($remuser == null) return ['error' => 202];

        $linked_item = CompManagerCon::getComponentFromLink($link);
        $out = [
            'Name' => $linked_item->Name,
            'Manufacturer' => $linked_item->Manufacturer,
            'ManufacturerNumber' => $linked_item->ManufacturerNumber,
            'Vendername' => $linked_item->Vendername,
            'VerderComponentNumber' => $linked_item->VerderComponentNumber,
            'Prices' => "",
            'Link' => $linked_item->Link,
            'CheckedAt' => $linked_item->CheckedAt,
        ];
        if(is_array($linked_item->Prices->CompPrice)){
            foreach($linked_item->Prices->CompPrice as $key=>$value) {
                if(array_key_exists('Amount', $value) && array_key_exists('Price', $value))
                    $out['Prices'] = $out['Prices']."{$value->Amount}:{$value->Price},";
            }
            $out['Prices'] = rtrim($out['Prices'],',');
        }else{
            $out['Prices'] = $out['Prices']."{$linked_item->Prices->CompPrice->Amount}:{$linked_item->Prices->CompPrice->Price}";
        }
        $out['Prices'] = $this->getPriceArray($out['Prices']);
        return $out;
    }

    public function exportUserList(String $username, String $currentID, String $id){
        $remuser = UserManagerCon::getLogedinUser($username, $currentID);
        if($remuser == null) return ['error' => 202];
        $user = User::where('name', $remuser->name)->where('usermanager_id', $remuser->id)->first();
        if($user == null) return ['error' => 201];
        $luser = Listing_user::where('user_id', $user->id)->where('listing_id', $id)->first();
        if($luser == null) return null;
        $listing = $luser->listing;
        if($listing == null) return null;

        $list = $this->getListingArray($listing, true, $luser)['items'];

        return ExportController::getUserList($list);
    }

    public function exportFullList(String $username, String $currentID, String $id){
        $remuser = UserManagerCon::getLogedinUser($username, $currentID);
        if($remuser == null) return ['error' => 202];
        $user = User::where('name', $remuser->name)->where('usermanager_id', $remuser->id)->first();
        if($user == null) return ['error' => 201];
        $luser = Listing_user::where('user_id', $user->id)->where('listing_id', $id)->first();
        if($luser == null) return null;
        $listing = $luser->listing;
        if($listing == null) return null;

        $list = $this->getListingArray($listing, true, $luser)['items'];

        return ExportController::getFullList($list);
    }

    private function getListingArray($listing, $private=false, $luser = null){
        $retI = [];
        if($private) $retU = [];
        foreach($listing->listing_users as $klu=>$vlu) {
            foreach($vlu->listing_item_amount as $klia=>$vlia) {
                $I = $vlia->listing_item_id;
                $item = $vlia->listing_item;
                if(!array_key_exists($I, $retI)){
                    if($item->vender != null) $vender = $item->vender->name; else $vender = null;

                    $retI[$I] = [
                        'id' => $item->id,
                        'vender' => $vender,
                        'componentnumber' => $item->componentnumber,
                        'manufacturer' => $item->manufacturer,
                        'manufacturernumber' => $item->manufacturernumber,
                        'prices' => $this->getPriceArray($item->prices),
                        'link' => $item->link,
                        'amount' => $vlia->amount
                    ];

                    if($luser != null)
                        $retI[$I]['useramount'] = ($vlia->listing_user_id == $luser->id ? $vlia->amount : 0);
                }
                else{
                    $retI[$I]['amount'] += $vlia->amount;
                    if($luser != null)
                        $retI[$I]['useramount'] += $vlia->listing_user_id == $luser->id ? $vlia->amount : 0;
                }
            }

            if($private){
                $user = $vlu->user;
                array_push($retU, [
                    'name' => $user->name,
                    'rights' => $vlu->rights
                ]);
            }

        }
        $retI2 = [];
        foreach($retI as $k=>$v) {
            array_push($retI2, $v);
        }

        if($private){
            $retT = [];
            foreach ($listing->listing_teams as $k=>$v) {
                $team = $v->team;
                if($team != null){
                    array_push($retT, [
                        'name' => $team->name,
                        'rights' => $v->rights
                    ]);
                }
            }
        }
        if($private){
            return [
                'items' => $retI2,
                'users' => $retU,
                'teams' => $retT,
                'name' => $listing->name,
                'private' => $listing->private
            ];
        }
        return [
            'items' => $retI2
        ];
    }

    private function getPriceArray(String $price){
        $ret = [];
        $peices = explode(",", $price);
        foreach ($peices as $k=>$v){
            $amnu = explode(":", $v);
            if(sizeof($amnu) == 2){
                array_push($ret, [
                    'amount' => (int)$amnu[0],
                    'price' => (float)$amnu[1]
                ]);
            }
        }
        return $ret;
    }

    private function getPriceString($array){
        $ret = "";
        foreach ($array as $k=>$v){
            $ret = $ret."{$v['amount']}:{$v['price']},";
        }
        return rtrim($ret,',');
    }

    private function getOrCreateUser(String $username, String $usermanager_id){
        $user = User::where('name', $username)->where('usermanager_id', $usermanager_id)->first();
        if($user == null) {
            $userN = new User;
            $userN->name = $username;
            $userN->usermanager_id = $usermanager_id;
            $userN->save();
            return $userN;
        }
        return $user;
    }

    private function getOrCreateTeam(String $teamname, String $usermanager_id){
        $team = Team::where('name', $teamname)->where('usermanager_id', $usermanager_id)->first();
        if($team == null) {
            $teamN = new Team;
            $teamN->name = $teamname;
            $teamN->usermanager_id = $usermanager_id;
            $teamN->save();
            return $teamN;
        }
        return $team;
    }
}
