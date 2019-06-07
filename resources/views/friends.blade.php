@extends('master')

@section('content')

    <h1 class="my-4">Friends
        <small></small>
    </h1>

    <div class="row" id="top_row">
    </div>
@stop

@section('script')
    <script type="text/javascript">
        function populate(friends){
            top_row = document.getElementById("top_row");
            row_html =
                "    <div class=\"col-lg-4 col-sm-6 mb-4\">\n" +
                "        <div class=\"card bg-light h-100\">\n" +
                "            <input type=\"text\" class=\"form-control mb-1\" placeholder=\"Username\" aria-label=\"Username\" aria-describedby=\"basic-addon2\" id=\"newfriendname\">" +
                "            <input class=\"btn btn-outline-primary\" type=\"button\" value=\"➕\" onclick=\"add_friend(newfriendname.value,added_friend)\" style=\"\">\n" +
                "        </div>\n" +
                "    </div>";

            for(let i = 0; i < friends.length; i++){
                let friend = friends[i];
                row_html +=
                    "<div class=\"col-lg-4 col-sm-6 mb-4\">\n" +
                    "    <div class=\"card h-100\">\n" +
                    "        <img class=\"card-img-top\" src=\"http://placehold.it/700x700\" alt=\"\">\n" +
                    "        <div class=\"card-body\">\n" +
                    "            <h4 class=\"card-title\">\n" +
                    "                <a data-toggle=\"collapse\" href=\"#collapse" + i + "\" aria-expanded=\"false\" aria-controls=\"collapseExample\">\n" +
                    "                    " + friend.name + "\n" +
                    "                </a>\n" +
                    "            </h4>\n" +
                    "            <div class=\"collapse\" id=\"collapse" + i + "\">\n";

                if(!friend.accepted){
                    if(friend.askedByUser){
                        row_html += "<p>Not Accepted yet</p>";
                    }
                    else{
                        row_html += "<input class=\"btn btn-primary\" type=\"button\" value=\"Accept\" onclick=\"accept_friend('" + friend.name + "', repopulate)\" style=\"width: 100%; height: 100%\">";
                    }
                }else{
                    row_html +=
                        "<div class=\"input-group mb-1 \">\n" +
                        "    <textarea class=\"form-control\" id=\"messageSend_" + friend.name + "\" aria-label=\"With textarea\"></textarea>\n" +
                        "    <div class=\"input-group-append\">\n" +
                        "        <button class=\"btn btn-primary\" type=\"button\" onclick=\"new_message('" + friend.name + "', document.getElementById('messageSend_" + friend.name + "').value, repopulate)\">✉</button>\n" +
                        "    </div>\n" +
                        "</div>\n" +
                        "<input class=\"btn btn-danger\" type=\"button\" value=\"Remove\" onclick=\"remove_friend('" + friend.name + "', repopulate)\" style=\"width: 100%\"'>\n";
                }


                row_html +=
                    "            </div>\n" +
                    "        </div>\n" +
                    "    </div>\n" +
                    "</div>";
            }

            top_row.innerHTML = row_html;
        }

        function repopulate(){
            get_friends(populate);
        }

        function added_friend(error){
            friend_error = document.getElementById("friend_error");
            if(error != null){
                friend_error.innerHTML = error;
            }
            repopulate();
        }

        repopulate();
    </script>
@stop