@extends('master')

@section('content')

    <h1 class="my-4">Groups
        <small></small>

    </h1>

    <div class="row my-4" id="top_row">
    </div>
@stop

@section('script')
    <script type="text/javascript">
        function populate(groups){
            top_row = document.getElementById("top_row");
            let row_html = "";
            if(user_isModerator()){
                row_html =
                    "    <div class=\"col-lg-4 col-sm-6 mb-4\">\n" +
                    "        <div class=\"card bg-light h-100\">\n" +
                    "            <input type=\"text\" class=\"form-control mb-1\" placeholder=\"Group name\" aria-label=\"Group name\" aria-describedby=\"basic-addon2\" id=\"newgroupname\">" +
                    "            <input class=\"btn btn-outline-primary\" type=\"button\" value=\"Create group\" onclick=\"add_group(document.getElementById('newgroupname').value, repopulate)\" style=\"\">\n" +
                    "        </div>\n" +
                    "    </div>";
            }
            for(let i = 0; i < groups.length; i++){
                let group = groups[i];
                let rights = "User";
                if(group.rights >= 2500) rights = "Admin";
                else if(group.rights >= 100) rights = "Moderator";

                row_html +=
                    "<div class=\"col-lg-4 col-sm-6 mb-4\">\n" +
                    "    <div class=\"card h-100\">\n" +
                    "        <div class=\"card-body\">\n" +
                    "            <h4 class=\"card-title\">\n" +
                    "                <a href=\"/public/group/group?name=" + group.name + "\">" + group.name + "</a>\n" +
                    "            </h4>\n" +
                    "            <h6 class=\"card-subtitle mb-2 text-muted\">\n" +
                    "                " + rights + "\n" +
                    "            </h6>\n" +
                    "        </div>\n" +
                    "    </div>\n" +
                    "</div>";
            }
            top_row.innerHTML = row_html;
        }

        function repopulate(){
            get_groups(populate);
        }

        repopulate();
    </script>
@stop