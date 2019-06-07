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
            listtitle.innerHTML = list.name + " groups";
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
                    "        <input type=\"text\" class=\"form-control mb-1\" placeholder=\"Group\" aria-label=\"Group\" aria-describedby=\"basic-addon2\" id=\"newTeamName\">\n" +
                    "        <input class=\"btn btn-outline-primary\" type=\"button\" value=\"Add group\" onclick=\"add_list_team(" + id + ",document.getElementById('newTeamName').value, repopulate)\" style=\"\">\n" +
                    "    </div>\n" +
                    "</div>";
            }
            for(let i = 0; i < teams.length; i++){
                let team = teams[i];
                row_html +=
                    "<div class=\"col-lg-4 col-sm-6 mb-4\">\n" +
                    "    <div class=\"card h-100\">\n" +
                    "        <div class=\"card-body\">\n" +
                    "            <h4 class=\"card-title\">\n" +
                    "                " + team.name + "\n" +
                    "            </h4>\n" +
                    "        <button class=\"btn btn-outline-danger\" type=\"button\" onclick=\"remove_list_team(" + id + ", '" + team.name + "', new function(){window.location.href = '/project_website/public/'})\">Remove</button>\n" +
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