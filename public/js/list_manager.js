

function get_user_lists(done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseL("getAllUserLists", {username: userName, currentID: currentID})
        .then(function(myJson) {
            done(myJson);
        })
        .catch(error => console.error(error));
}

function get_group_lists(groupname, done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseL("getAllTeamLists", {username: userName, currentID: currentID, teamname: groupname})
        .then(function(myJson) {
            done(myJson);
        })
        .catch(error => console.error(error));
}

function get_group_list(groupname, id, done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseL("getTeamList", {username: userName, currentID: currentID, teamname: groupname, id: id})
        .then(function(myJson) {
            done(myJson);
        })
        .catch(error => console.error(error));
}

function get_user_list(id, done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseL("getUserList", {username: userName, currentID: currentID, id: id})
        .then(function(myJson) {
            done(myJson);
        })
        .catch(error => console.error(error));
}

function get_all_venders(done){
    getJsonResponseL("getVenders", {})
        .then(function(myJson) {
            done(myJson);
        })
        .catch(error => console.error(error));
}

function get_item_from_link(link, done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseL("getItemFromLink", {username: userName, currentID: currentID, link: link})
        .then(function(myJson) {
            done(myJson);
        })
        .catch(error => console.error(error));
}

function get_item_from_vender_component(vendername, componentnumber, done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseL("getItemFromVenderComponent", {username: userName, currentID: currentID, vendername: vendername, componentnumber: componentnumber})
        .then(function(myJson) {
            done(myJson);
        })
        .catch(error => console.error(error));
}

function set_user_rights_list(id, username, rights, done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseL("setUserRights", {username: userName, currentID: currentID, id: id, addusername:username, rights: rights})
        .then(function(myJson) {
            done();
        })
        .catch(error => console.error(error));
}

function create_user_list(listname, done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseL("createUserList", {
        username: userName, currentID: currentID, listname: listname
    })
        .then(function(myJson) {
            done();
        })
        .catch(error => console.error(error));
}

function create_group_list(groupname, listname, done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseL("createTeamList", {
        username: userName, currentID: currentID, teamname: groupname, listname: listname
    })
        .then(function(myJson) {
            done();
        })
        .catch(error => console.error(error));
}

function remove_list(id, done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseL("removeList", {username: userName, currentID: currentID, id: id})
        .then(function(myJson) {
            done();
        })
        .catch(error => console.error(error));
}

function add_list_user(id, addUser, done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseL("addUserToList", {username: userName, currentID: currentID, id: id, addusername: addUser})
        .then(function(myJson) {
            done();
        })
        .catch(error => console.error(error));
}

function remove_list_user(id, removeUser, done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseL("removeUserFromList", {username: userName, currentID: currentID, id: id, addusername: removeUser})
        .then(function(myJson) {
            done();
        })
        .catch(error => console.error(error));
}

function add_list_team(id, addteam, done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseL("addTeamToList", {username: userName, currentID: currentID, id: id, teamname: addteam})
        .then(function(myJson) {
            done();
        })
        .catch(error => console.error(error));
}

function remove_list_team(id, removeTeam, done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseL("removeTeamFromList", {username: userName, currentID: currentID, id: id, teamname: removeTeam})
        .then(function(myJson) {
            done();
        })
        .catch(error => console.error(error));
}

function set_item_amount(id, item_id, amount, done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseL("setItemAmount", {username: userName, currentID: currentID, id: id, item_id: item_id, amount:amount})
        .then(function(myJson) {
            done();
        })
        .catch(error => console.error(error));
}

function add_item(id, vendername, componentnumber, manufacturer, manufacturernumber, prices, link, amount, done) {
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseL("setItemOnList", {username: userName, currentID: currentID, id: id,
        vendername: vendername, componentnumber: componentnumber, manufacturer: manufacturer,
        manufacturernumber: manufacturernumber, prices: prices, link: link, amount: amount})
        .then(function(myJson) {
            done();
        })
        .catch(error => console.error(error));
}

function export_user_list(id) {
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getFileResponseL("exportUserList", {username: userName, currentID: currentID, id: id})
        .catch(error => console.error(error));
}

function export_full_list(id) {
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getFileResponseL("exportFullList", {username: userName, currentID: currentID, id: id})
        .catch(error => console.error(error));
}

function getJsonResponseL(type, datas){
    let urlString = "&";
    for (let key in datas) urlString = urlString + key + "=" + encodeURIComponent(datas[key]) + "&";
    urlString = urlString.substring(0, urlString.length-1);

    return fetch('/public/Listings_manager/?function=' + type + urlString)
        .then(function (response) {
            return response.json();
        });
}

function getFileResponseL(type, datas){
    let urlString = "&";
    for (let key in datas) urlString = urlString + key + "=" + encodeURIComponent(datas[key]) + "&";
    urlString = urlString.substring(0, urlString.length-1);

    window.open('/public/Listings_manager/?function=' + type + urlString);


    /*let urlString = "&";
    for (let key in datas) urlString = urlString + key + "=" + datas[key] + "&";
    urlString = urlString.substring(0, urlString.length-1);

    return fetch('/public/Listings_manager/?function=' + type + urlString)
        .then(async res => ({
            filename: 'file.xslx',
            blob: await res.blob()
        }))*/
}


function getPriceArrayFromString(str){
    let ret = [];
    let peices = str.split(",");
    for(let i = 0; i < peices.length; i++){
        let amnu = peices[i].split(":");
        if(amnu.length == 2){
            ret.push({
                amount:parseInt(amnu[0], 10),
                price:parseFloat(amnu[1])
            });
        }
    }
    return ret;
}
