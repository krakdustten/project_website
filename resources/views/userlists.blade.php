@extends('master')

@section('content')

    <h1 class="my-4">User lists
        <small></small>

    </h1>

    <div class="row my-4" id="top_row">
    </div>
@stop

@section('script')
    <script type="text/javascript">
        function populate(lists){
            top_row = document.getElementById("top_row");
            let row_html =
                "    <div class=\"col-lg-4 col-sm-6 mb-4\">\n" +
                "        <div class=\"card bg-light h-100\">\n" +
                "            <input type=\"text\" class=\"form-control mb-1\" placeholder=\"List name\" aria-label=\"List name\" aria-describedby=\"basic-addon2\" id=\"newuserlistname\">" +
                "            <input class=\"btn btn-outline-primary\" type=\"button\" value=\"Create list\" onclick=\"create_user_list(document.getElementById('newuserlistname').value, repopulate)\" style=\"\">\n" +
                "        </div>\n" +
                "    </div>";
            for(let i = 0; i < lists.length; i++){
                let list = lists[i];
                let rights = "User";
                if(list.rights >= 2500) rights = "Admin";
                else if(list.rights >= 100) rights = "Moderator";

                row_html +=
                    "<div class=\"col-lg-4 col-sm-6 mb-4\">\n" +
                    "    <div class=\"card h-100\">\n" +
                    "        <div class=\"card-body\">\n" +
                    "            <h4 class=\"card-title\">\n" +
                    "                <a href=\"/public/list/list?group=false&name=n&id=" + list.id + "\">" + list.name + "</a>\n" +
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
            get_user_lists(populate);
        }

        repopulate();
    </script>
@stop