@extends('master')

@section('content')

    <h1 class="my-4" id="listtitle">List
        <small></small>

    </h1>

    <div class="mb-12">
        <div class="card h-100">
            <div class="card-body">
                <div class="input-group mb-3">
                    <a class="btn btn-outline-primary" id="back_link" href="">Back to list</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row my-4" id="top_row">
    </div>
@stop

@section('script')
    <script type="text/javascript">
        function populate(list){
            top_row = document.getElementById("top_row");
            listtitle = document.getElementById("listtitle");
            back_link = document.getElementById("back_link");
            back_link.href = backlink;
            listtitle.innerHTML = list.name + " users";
            items = list.items;
            users = list.users;
            teams = list.teams;

            let grights = 0;
            for(let i = 0; i < users.length; i++) {
                let user = users[i];
                if(user.name == getUserName()) grights = user.rights;
            }

            let row_html = "";
            if(grights >= 100){//Admin or moderator
                row_html =
                    "<div class=\"col-lg-4 col-sm-6 mb-4\">\n" +
                    "    <div class=\"card bg-light h-100\">\n" +
                    "        <input type=\"text\" class=\"form-control mb-1\" placeholder=\"User\" aria-label=\"User\" aria-describedby=\"basic-addon2\" id=\"newUserName\">\n" +
                    "        <input class=\"btn btn-outline-primary\" type=\"button\" value=\"Add user\" onclick=\"add_list_user(" + id + ",document.getElementById('newUserName').value, repopulate)\" style=\"\">\n" +
                    "    </div>\n" +
                    "</div>";
            }
            for(let i = 0; i < users.length; i++){
                let user = users[i];

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
                        row_html += "<button class=\"btn btn-outline-success\" type=\"button\" onclick=\"set_user_rights_list(" + id + ", '" + user.name + "', 0, repopulate)\">User</button>\n";
                    if(user.rights < 100 || user.rights >= 2500 && grights >= 2500)
                        row_html += "<button class=\"btn btn-outline-success\" type=\"button\" onclick=\"set_user_rights_list(" + id + ", '" + user.name + "', 100, repopulate)\">Moderator</button>\n";
                    if(user.rights < 2500 && grights >= 2500)
                        row_html += "<button class=\"btn btn-outline-success\" type=\"button\" onclick=\"set_user_rights_list(" + id + ", '" + user.name + "', 2500, repopulate)\">Admin</button>\n";

                    row_html +=
                        "    </div>\n" +
                        "    <div class=\"input-group-append\">\n" +
                        "        <button class=\"btn btn-outline-danger\" type=\"button\" onclick=\"remove_list_user(" + id + ", '" + user.name + "', repopulate)\">Remove</button>\n" +
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
            if(group == true){
                backlink = "/project_website/public/list/list?group=true&name=" + name + "&id=" + id;
                get_group_list(name, id, populate);
            }else{
                backlink = "/project_website/public/list/list?group=false&id=" + id;
                get_user_list(id, populate);
            }
        }
        var group = findGetParameter("group").toLowerCase().startsWith("t");
        var name = findGetParameter("name");
        var id = findGetParameter("id");
        var backlink = "";

        repopulate();
    </script>
@stop