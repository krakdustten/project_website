@extends('master')

@section('content')
    <h1 class="my-4" id="grouptitle">
        <small></small>

    </h1>

    <div class="row my-4" id="top_row">
    </div>
@stop

@section('script')
    <script type="text/javascript">
        function populate(group){
            groupUsers = group.userlist;
            let grights = 0;
            for(let i = 0; i < groupUsers.length; i++) {
                let user = groupUsers[i];
                if(user.name == getUserName()) grights = user.rights;
            }

            top_row = document.getElementById("top_row");
            grouptitle = document.getElementById("grouptitle");
            grouptitle.innerHTML = groupname;

            let row_html = "";
            if(grights >= 2500){//Admin
                row_html =
                    "    <div class=\"col-lg-4 col-sm-6 mb-4\">\n" +
                    "        <div class=\"card bg-light h-100\">\n" +
                    "            <input type=\"text\" class=\"form-control mb-1\" placeholder=\"Username\" aria-label=\"Username\" aria-describedby=\"basic-addon2\" id=\"newMemberName\">" +
                    "            <input class=\"btn btn-outline-primary mb-1\" type=\"button\" value=\"Add user\" onclick=\"add_group_user('" + groupname + "', document.getElementById('newMemberName').value, repopulate)\" style=\"\">\n" +
                    "            <div class=\"input-group mb-1\">\n" +
                    "                <div class=\"input-group-prepend\">\n" +
                    "                    <button class=\"btn btn-outline-danger\" type=\"button\" onclick=\"remove_group_user('" + groupname + "', '" + getUserName() + "', redirect)\">Leave group</button>\n" +
                    "                </div>\n" +
                    "                <div class=\"input-group-append\">\n" +
                    "                    <button class=\"btn btn-outline-danger\" type=\"button\" onclick=\"remove_group('" + groupname + "', redirect)\">Remove group</button>\n" +
                    "                </div>\n" +
                    "            </div>\n" +
                    "            <a class=\"btn btn-outline-primary\"  href=\"/project_website/public/list/grouplists?name=" + groupname + "\">Show Order lists</a>\n" +
                    "        </div>\n" +
                    "    </div>";
            }else if(grights >= 100){//Moderator
                row_html =
                    "    <div class=\"col-lg-4 col-sm-6 mb-4\">\n" +
                    "        <div class=\"card bg-light h-100\">\n" +
                    "            <input type=\"text\" class=\"form-control mb-1\" placeholder=\"Username\" aria-label=\"Username\" aria-describedby=\"basic-addon2\" id=\"newMemberName\">" +
                    "            <input class=\"btn btn-outline-primary mb-1\" type=\"button\" value=\"Add user\" onclick=\"add_group_user('" + groupname + "', document.getElementById('newMemberName').value, repopulate)\" style=\"\">\n" +
                    "            <button class=\"btn btn-outline-danger\" type=\"button\" onclick=\"remove_group_user('" + groupname + "', '" + getUserName() + "', redirect)\">Leave group</button>\n" +
                    "        </div>\n" +
                    "    </div>";
            }else{//User
                row_html =
                    "    <div class=\"col-lg-4 col-sm-6 mb-4\">\n" +
                    "        <div class=\"card bg-light h-100\">\n" +
                    "            <button class=\"btn btn-outline-danger\" type=\"button\" onclick=\"remove_group_user('" + groupname + "', '" + getUserName() + "', redirect)\">Leave group</button>\n" +
                    "        </div>\n" +
                    "    </div>";
            }
            for(let i = 0; i < groupUsers.length; i++){
                let user = groupUsers[i];
                let rights = "User";
                if(user.rights >= 2500) rights = "Admin";
                else if(user.rights >= 100) rights = "Moderator";

                row_html +=
                    "<div class=\"col-lg-4 col-sm-6 mb-4\">\n" +
                    "    <div class=\"card h-100\">\n" +
                    "        <div class=\"card-body\">\n" +
                    "            <h4 class=\"card-title\">\n" +
                    "                " + user.name + "\n" +
                    "            </h4>\n" +
                    "            <h6 class=\"card-subtitle mb-2 text-muted\">\n" +
                    "                " + rights + "\n" +
                    "            </h6>\n";
                if(user.name != getUserName()) {
                    row_html +=
                        "            <div class=\"input-group mb-1\">\n" +
                        "                <textarea class=\"form-control\" id=\"messageSend_" + user.name + "\" aria-label=\"With textarea\"></textarea>\n" +
                        "                <div class=\"input-group-append\">\n" +
                        "                    <button class=\"btn btn-primary\" type=\"button\" onclick=\"new_message('" + user.name + "', document.getElementById('messageSend_" + user.name + "').value, repopulate)\">✉</button>\n" +
                        "                </div>\n" +
                        "            </div>\n";
                }
                if(grights >= 100 && user.rights < 2500 || grights >= 2500) {
                    row_html +=
                        "<div class=\"input-group\" style='width: 100%;' >\n" +
                        "    <div class=\"input-group-prepend\">\n";

                    if(user.rights >= 100 && (user.rights < 2500 || grights >= 2500))
                        row_html += "<button class=\"btn btn-outline-success\" type=\"button\" onclick=\"set_group_user_role('" + groupname + "', '" + user.name + "', 0, repopulate)\">User</button>\n";
                    if(user.rights < 100 || user.rights >= 2500 && grights >= 2500)
                        row_html += "<button class=\"btn btn-outline-success\" type=\"button\" onclick=\"set_group_user_role('" + groupname + "', '" + user.name + "', 100, repopulate)\">Moderator</button>\n";
                    if(user.rights < 2500 && grights >= 2500)
                        row_html += "<button class=\"btn btn-outline-success\" type=\"button\" onclick=\"set_group_user_role('" + groupname + "', '" + user.name + "', 2500, repopulate)\">Admin</button>\n";

                    row_html +=
                        "    </div>\n" +
                        "    <div class=\"input-group-append\">\n" +
                        "        <button class=\"btn btn-outline-danger\" type=\"button\" onclick=\"remove_group_user('" + groupname + "', '" + user.name + "', repopulate)\">Remove</button>\n" +
                        "    </div>\n" +
                        "</div>\n";
                }
                row_html +=
                    "        </div>\n" +
                    "    </div>\n" +
                    "</div>";
            }
            top_row.innerHTML = row_html;
        }

        function repopulate(){
            get_groupUsers(groupname, populate);
        }

        function redirect(){
            window.location.href = "/project_website/public/group/groups/";
        }

        var groupname = findGetParameter("name")

        repopulate();
    </script>
@stop
