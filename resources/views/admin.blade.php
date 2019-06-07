@extends('master')

@section('content')

    <h1 class="my-4">Admin
        <small></small>
    </h1>

    <div class="mb-12">
        <div class="card h-100">
            <div class="card-body">
                <h4 class="card-title">
                    Filters
                </h4>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="CBAdmins" value="option1" checked="checked" onchange="repopulateOld()">
                        <label class="form-check-label" for="inlineCheckbox1">Admins</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="CBModerators" value="option2" checked="checked" onchange="repopulateOld()">
                        <label class="form-check-label" for="inlineCheckbox2">Moderators</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="CBRUsers" value="option3" checked="checked" onchange="repopulateOld()">
                        <label class="form-check-label" for="inlineCheckbox2">Users</label>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Username:</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" id="filterUsername" onchange="repopulateOld()">
                </div>
            </div>
        </div>
    </div>

    <div class="row my-4" id="top_row">

    </div>
@stop

@section('script')
    <script type="text/javascript">
        var oldUsers = null;
        function populate(users){
            oldUsers = users;
            top_row = document.getElementById("top_row");
            CBAdmins = document.getElementById("CBAdmins");
            CBModerators = document.getElementById("CBModerators");
            CBRUsers = document.getElementById("CBRUsers");
            filterUsername = document.getElementById("filterUsername");
            row_html = "";

            for(let i = 0; i < users.length; i++) {
                let user = users[i];

                let date = new Date(user.validUntilID);
                let dateTime = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate() + " " +
                    date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();

                if(user.name.includes(filterUsername.value)){
                    if(user.rights < 100){//user
                        if(CBRUsers.checked){
                            row_html +=
                                "<div class=\"col-lg-4 col-sm-6 mb-4\">\n" +
                                "    <div class=\"card h-100\">\n" +
                                "        <div class=\"card-body\">\n" +
                                "            <h4 class=\"card-title\">\n" +
                                "                " + user.name + "\n" +
                                "            </h4>\n" +
                                "            <h6 class=\"card-subtitle mb-2 text-muted\">\n" +
                                "                User\n" +
                                "            </h6>\n" +
                                "            <div class=\"input-group mb-1\">\n" +
                                "                <div class=\"input-group-prepend\">\n" +
                                "                    <span class=\"input-group-text\" id=\"basic-addon1\">Email</span>\n" +
                                "                </div>\n" +
                                "                <input type=\"text\" class=\"form-control\" placeholder=\"Username\" aria-label=\"Email\" aria-describedby=\"basic-addon1\" value=\"" + user.email + "\" disabled>\n" +
                                "            </div>" +
                                "            <div class=\"input-group mb-1\">\n" +
                                "                <div class=\"input-group-prepend\">\n" +
                                "                    <span class=\"input-group-text\" id=\"basic-addon1\">LogedIn until</span>\n" +
                                "                </div>\n" +
                                "                <input type=\"text\" class=\"form-control\" placeholder=\"Username\" aria-label=\"Email\" aria-describedby=\"basic-addon1\" value=\"" + dateTime + "\" disabled>\n" +
                                "            </div>\n" +
                                "            <div class=\"input-group\" style='width: 100%;' >\n" +
                                "                <div class=\"input-group-prepend\">\n" +
                                "                    <button class=\"btn btn-outline-success\" type=\"button\" onclick=\"user_setRole('" + user.name + "', 2500, repopulate)\">Admin</button>\n" +
                                "                    <button class=\"btn btn-outline-success\" type=\"button\" onclick=\"user_setRole('" + user.name + "', 100, repopulate)\">Moderator</button>\n" +
                                "                </div>\n" +
                                "                <div class=\"input-group-append\">\n" +
                                "                    <button class=\"btn btn-outline-danger\" type=\"button\" onclick=\"user_remove('" + user.name + "', repopulate)\">Remove</button>\n" +
                                "                </div>\n" +
                                "            </div>\n" +
                                "        </div>\n" +
                                "    </div>\n" +
                                "</div>";
                        }
                    }
                    else if(user.rights < 2500){//moderator
                        if(CBModerators.checked){
                            row_html +=
                                "<div class=\"col-lg-4 col-sm-6 mb-4\">\n" +
                                "    <div class=\"card h-100\">\n" +
                                "        <div class=\"card-body\">\n" +
                                "            <h4 class=\"card-title\">\n" +
                                "                " + user.name + "\n" +
                                "            </h4>\n" +
                                "            <h6 class=\"card-subtitle mb-2 text-muted\">\n" +
                                "                Moderator\n" +
                                "            </h6>\n" +
                                "            <div class=\"input-group mb-1\">\n" +
                                "                <div class=\"input-group-prepend\">\n" +
                                "                    <span class=\"input-group-text\" id=\"basic-addon1\">Email</span>\n" +
                                "                </div>\n" +
                                "                <input type=\"text\" class=\"form-control\" placeholder=\"Username\" aria-label=\"Email\" aria-describedby=\"basic-addon1\" value=\"" + user.email + "\" disabled>\n" +
                                "            </div>" +
                                "            <div class=\"input-group mb-1\">\n" +
                                "                <div class=\"input-group-prepend\">\n" +
                                "                    <span class=\"input-group-text\" id=\"basic-addon1\">LogedIn until</span>\n" +
                                "                </div>\n" +
                                "                <input type=\"text\" class=\"form-control\" placeholder=\"Username\" aria-label=\"Email\" aria-describedby=\"basic-addon1\" value=\"" + dateTime + "\" disabled>\n" +
                                "            </div>\n" +
                                "            <div class=\"input-group\" style='width: 100%;' >\n" +
                                "                <div class=\"input-group-prepend\">\n" +
                                "                    <button class=\"btn btn-outline-success\" type=\"button\" onclick=\"user_setRole('" + user.name + "', 2500, repopulate)\">Admin</button>\n" +
                                "                    <button class=\"btn btn-outline-success\" type=\"button\" onclick=\"user_setRole('" + user.name + "', 0, repopulate)\">User</button>\n" +
                                "                </div>\n" +
                                "                <div class=\"input-group-append\">\n" +
                                "                    <button class=\"btn btn-outline-danger\" type=\"button\" onclick=\"user_remove('" + user.name + "', repopulate)\">Remove</button>\n" +
                                "                </div>\n" +
                                "            </div>\n" +
                                "        </div>\n" +
                                "    </div>\n" +
                                "</div>";
                        }
                    }
                    else{//admin
                        if(CBAdmins.checked){
                            row_html +=
                                "<div class=\"col-lg-4 col-sm-6 mb-4\">\n" +
                                "    <div class=\"card h-100\">\n" +
                                "        <div class=\"card-body\">\n" +
                                "            <h4 class=\"card-title\">\n" +
                                "                " + user.name + "\n" +
                                "            </h4>\n" +
                                "            <h6 class=\"card-subtitle mb-2 text-muted\">\n" +
                                "                Admin\n" +
                                "            </h6>\n" +
                                "            <div class=\"input-group mb-1\">\n" +
                                "                <div class=\"input-group-prepend\">\n" +
                                "                    <span class=\"input-group-text\" id=\"basic-addon1\">Email</span>\n" +
                                "                </div>\n" +
                                "                <input type=\"text\" class=\"form-control\" placeholder=\"Username\" aria-label=\"Email\" aria-describedby=\"basic-addon1\" value=\"" + user.email + "\" disabled>\n" +
                                "            </div>" +
                                "            <div class=\"input-group mb-1\">\n" +
                                "                <div class=\"input-group-prepend\">\n" +
                                "                    <span class=\"input-group-text\" id=\"basic-addon1\">LogedIn until</span>\n" +
                                "                </div>\n" +
                                "                <input type=\"text\" class=\"form-control\" placeholder=\"Username\" aria-label=\"Email\" aria-describedby=\"basic-addon1\" value=\"" + dateTime + "\" disabled>\n" +
                                "            </div>\n" +
                                "            <div class=\"input-group\" style='width: 100%;' >\n" +
                                "                <div class=\"input-group-prepend\">\n" +
                                "                    <button class=\"btn btn-outline-success\" type=\"button\" onclick=\"user_setRole('" + user.name + "', 100, repopulate)\">Moderator</button>\n" +
                                "                    <button class=\"btn btn-outline-success\" type=\"button\" onclick=\"user_setRole('" + user.name + "', 0, repopulate)\">User</button>\n" +
                                "                </div>\n" +
                                "                <div class=\"input-group-append\">\n" +
                                "                    <button class=\"btn btn-outline-danger\" type=\"button\" onclick=\"user_remove('" + user.name + "', repopulate)\">Remove</button>\n" +
                                "                </div>\n" +
                                "            </div>\n" +
                                "        </div>\n" +
                                "    </div>\n" +
                                "</div>";
                        }
                    }
                }
            }

            top_row.innerHTML = row_html;
        }

        function repopulate(){
            user_getAll(populate);
        }

        function repopulateOld() {
            if(oldUsers != null)
                populate(oldUsers);
            else
                repopulate()
        }

        repopulate();
    </script>
@stop