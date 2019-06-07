

function login(usernameField, passwordField, done){
    let username = usernameField.value;
    let password = passwordField.value;

    getJsonResponseU("login", {username: username})
        .then(function(myJson) {
            if('error' in myJson)
                return myJson;
            let ency = getPBKDF2PS(password, myJson.salt);
            return getJsonResponseU("login", {username: username, password: ency});
        })
        .then(function (myJson) {
            if('error' in myJson){
                sessionStorage.removeItem("userName");
                sessionStorage.removeItem("currentID");
                sessionStorage.removeItem("rights");
            }else{
                sessionStorage.setItem("userName", username);
                sessionStorage.setItem("currentID", myJson.currentID);
                sessionStorage.setItem("rights", myJson.rights);
            }
            done();
        })
        .catch(error => console.error(error));

    //alert("You tried to login with " + username + " and " + password + ".");
}

function logout(){
    sessionStorage.removeItem("userName");
    sessionStorage.removeItem("currentID");
}

function user_logedin() {
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    if (currentID != null) {
        getJsonResponseU("user", {username: userName, currentID: currentID})
            .then(function (myJson) {
                if (!('name' in myJson)) {
                    sessionStorage.removeItem("userName");
                    sessionStorage.removeItem("currentID");
                }
                if('rights' in myJson){
                    sessionStorage.setItem("rights", myJson.rights);
                }else{
                    sessionStorage.removeItem("rights");
                }
            })
            .catch(error => console.error(error));

    }
    return currentID != null;
}

function user_regsiter(usernameField, passwordField, emailField, done) {
    let username = usernameField.value;
    let password = passwordField.value;
    let email = emailField.value;

    getJsonResponseU("register", {username: username, email:email})
        .then(function(myJson) {
            let ency = getPBKDF2PS(password, myJson.salt);
            return getJsonResponseU("register", {username: username, password: ency, email:email, salt: myJson.salt});
        })
        .then(function (myJson) {
            if('error' in myJson){
                done(true, myJson.error);
            }else{
                done(false, "");
            }
        })
        .catch(error => console.error(error));
}

function user_remove(userToRemove, done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseU("userRemove", {username: userName, currentID: currentID, usertoremove: userToRemove})
        .then(function(myJson) {
            done(myJson);
        })
        .catch(error => console.error(error));
}

function user_getAll(done) {
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseU("userAll", {username: userName, currentID: currentID})
        .then(function(myJson) {
            done(myJson);
        })
        .catch(error => console.error(error));
}

function user_setRole(userToSet, roleToSet, done) {
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseU("userRole", {username: userName, currentID: currentID, setname: userToSet, setrights: roleToSet})
        .then(function(myJson) {
            done(myJson);
        })
        .catch(error => console.error(error));
}

function get_friends(done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseU("friend", {username: userName, currentID: currentID})
        .then(function(myJson) {
            done(myJson);
        })
        .catch(error => console.error(error));
}

function accept_friend(friend_name, done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseU("friendAccept", {username: userName, currentID: currentID, friendsname: friend_name})
        .then(function(myJson) {
            done();
        })
        .catch(error => console.error(error));
}

function add_friend(friend_name, done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseU("friendAdd", {username: userName, currentID: currentID, friendsname: friend_name})
        .then(function(myJson) {
            if('error' in myJson){
                done(myJson.error);
            }else if(myJson.done === false){
                done("Already a friend.");
            }else{
                done(null);
            }

        })
        .catch(error => console.error(error));

}

function remove_friend(friend_name, done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseU("friendRemove", {username: userName, currentID: currentID, friendsname: friend_name})
        .then(function(myJson) {
            done(myJson)
        })
        .catch(error => console.error(error));
}

function new_message(receiver, message, done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseU("messageNew", {username: userName, currentID: currentID, receivername: receiver, message: message})
        .then(function (myJson) {
            if('error' in myJson){
                done(myJson.error);
            }else{
                done(null);
            }
        })
        .catch(error => console.error(error))
}

function remove_message(messageID, done) {
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseU("messageRemove", {username: userName, currentID: currentID, messageID: messageID})
        .then(function (myJson) {
            if('error' in myJson){
                done(myJson.error);
            }else{
                done(null);
            }
        })
        .catch(error => console.error(error))
}

function get_messages(done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseU("message", {username: userName, currentID: currentID})
        .then(function (myJson) {
            done(myJson);
        })
        .catch(error => console.error(error))
}

function get_groups(done) {
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseU("team", {username: userName, currentID: currentID})
        .then(function (myJson) {
            done(myJson);
        })
        .catch(error => console.error(error))
}

function get_groupUsers(groupName, done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseU("team", {username: userName, currentID: currentID, teamname: groupName})
        .then(function (myJson) {
            done(myJson);
        })
        .catch(error => console.error(error))
}

function add_group(groupname, done) {
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseU("teamCreate", {username: userName, currentID: currentID, teamname: groupname})
        .then(function (myJson) {
            done(myJson);
        })
        .catch(error => console.error(error))
}

function add_group_user(groupname, membername, done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseU("teamMemberAdd", {username: userName, currentID: currentID, teamname: groupname, membername: membername, memberrights: 0})
        .then(function (myJson) {
            done(myJson);
        })
        .catch(error => console.error(error))
}

function remove_group(groupname, done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseU("teamRemove", {username: userName, currentID: currentID, teamname: groupname})
        .then(function (myJson) {
            done(myJson);
        })
        .catch(error => console.error(error))
}

function remove_group_user(groupname, membername, done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseU("teamMemberRemove", {username: userName, currentID: currentID, teamname: groupname, membername: membername})
        .then(function (myJson) {
            done(myJson);
        })
        .catch(error => console.error(error))
}

function set_group_user_role(groupname, membername, role, done){
    let currentID = sessionStorage.getItem("currentID");
    let userName = sessionStorage.getItem("userName");

    getJsonResponseU("teamMemberRoleSet", {username: userName, currentID: currentID, teamname: groupname, membername: membername, memberrights: role})
        .then(function (myJson) {
            done(myJson);
        })
        .catch(error => console.error(error))
}

function getUserName(){
    return sessionStorage.getItem("userName");
}

function getCurrentID(){
    return sessionStorage.getItem("currentID");
}

function user_isAdmin(){
    rights = sessionStorage.getItem("rights");

    if(rights == null) return false;
    if(rights >= 2500) return true;
}

function user_isModerator(){
    rights = sessionStorage.getItem("rights");

    if(rights == null) return false;
    if(rights >= 100) return true;
}

function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    var items = location.search.substr(1).split("&");
    for (var index = 0; index < items.length; index++) {
        tmp = items[index].split("=");
        if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
    }
    return result;
}

function getJsonResponseU(type, datas){
    let urlString = "&";
    for (let key in datas) urlString = urlString + key + "=" + datas[key] + "&";
    urlString = urlString.substring(0, urlString.length-1);

    return fetch('/project_website/public/user_manager/?function=' + type + urlString)
        .then(function (response) {
            return response.json();
        });
}

function getPBKDF2PS(pass, salt)
{
    pass = strToHexPad(pass, 1024);
    salt = strToHexPad(salt, 512);
    its  = 1000;
    pbkd = CryptoJS.PBKDF2(CryptoJS.enc.Hex.parse(pass), CryptoJS.enc.Hex.parse(salt), { keySize: 512/32, iterations: its, hasher:CryptoJS.algo.SHA512 });
    // split result into the _actual_ pass and salt for the encryption
    pbkd = pbkd.toString();
    return pbkd;
}

function strToHexPad(val, length)
{
    val = toHex(val);
    if (val.length>length) { val = val.substring(0,length); }
    if (val.length<length) {
        while(val.length<length) {
            val = val + '0';
        }
        val = val.substring(0,length);
    }
    return val;
}

function toHex(str) {
    var hex = '';
    for(var i=0;i<str.length;i++) {
        hex += ''+str.charCodeAt(i).toString(16);
    }
    return hex.toLowerCase();
}
