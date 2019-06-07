@extends('master')

@section('content')

    <h1 class="my-4">Messages
        <small></small>

    </h1>


    <div class="mb-12">
        <div class="card h-100">
            <div class="card-body">
                <h4 class="card-title">
                    Filters
                </h4>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="CBSendMessages" value="option1" checked="checked" onchange="repopulateOld()">
                    <label class="form-check-label" for="inlineCheckbox1">Send messages</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="CBReceivedMessages" value="option2" checked="checked" onchange="repopulateOld()">
                    <label class="form-check-label" for="inlineCheckbox2">Received messages</label>
                </div>
            </div>
        </div>
    </div>


    <div class="row my-4" id="top_row">
    </div>
@stop

@section('script')
    <script type="text/javascript">
        var oldMessages = null;
        function populate(messages){
            oldMessages = messages;
            top_row = document.getElementById("top_row");
            CBSendMessages = document.getElementById("CBSendMessages");
            CBReceivedMessages = document.getElementById("CBReceivedMessages");
            row_html =
                "<div class=\"col-lg-4 col-sm-6 mb-4\">\n" +
                "    <div class=\"card bg-light h-100\">\n" +
                "        <input type=\"text\" class=\"form-control\" placeholder=\"Username\" aria-label=\"Username\" aria-describedby=\"basic-addon2\" id=\"newmessageusername\">" +
                "        <div class=\"input-group\">\n" +
                "            <textarea class=\"form-control\" id=\"newmessagemessage\" placeholder=\"Message\" aria-label=\"With textarea\"></textarea>\n" +
                "            <div class=\"input-group-append\">\n" +
                "                <button class=\"btn btn-primary\" type=\"button\" onclick=\"new_message(document.getElementById('newmessageusername').value, document.getElementById('newmessagemessage').value, repopulate)\">✉</button>\n" +
                "            </div>\n" +
                "        </div>\n" +
                "    </div>\n" +
                "</div>";

            for(let i = 0; i < messages.length; i++) {
                let message = messages[i];

                let date = new Date(message.sendTime);
                let dateTime = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate() + " " +
                    date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
                if(message.sender == getUserName()){
                    if(CBSendMessages.checked )
                        row_html +=
                            "<div class=\"col-lg-4 col-sm-6 mb-4\">\n" +
                            "    <div class=\"card h-100\">\n" +
                            "        <div class=\"card-body\">\n" +
                            "            <h4 class=\"card-title\">\n" +
                            "                " + message.receiver + "\n" +
                            "            </h4>\n" +
                            "            <h6 class=\"card-subtitle mb-2 text-muted\">\n" +
                            "                send at " + dateTime + "\n" +
                            "            </h6>\n" +
                            "            <p>" + message.message + "</p>\n" +
                            "        </div>\n" +
                            "    </div>\n" +
                            "</div>";
                }else{
                    if(CBReceivedMessages.checked )
                        row_html +=
                            "<div class=\"col-lg-4 col-sm-6 mb-4\">\n" +
                            "    <div class=\"card h-100\">\n" +
                            "        <div class=\"card-body\">\n" +
                            "            <h4 class=\"card-title\">\n" +
                            "                " + message.sender + "\n" +
                            "            </h4>\n" +
                            "            <h6 class=\"card-subtitle mb-2 text-muted\">\n" +
                            "                received at " + dateTime + "\n" +
                            "            </h6>\n" +
                            "            <p>" + message.message + "</p>\n" +
                            "            <input class=\"btn btn-danger\" type=\"button\" value=\"Remove\" onclick=\"remove_message(" + message.id + ", repopulate)\" style='width: 100%'>\n" +
                            "        </div>\n" +
                            "    </div>\n" +
                            "</div>";
                }
            }

            top_row.innerHTML = row_html;
        }

        function repopulate(){
            get_messages(populate);
        }

        function repopulateOld() {
            console.log(oldMessages);
            if(oldMessages != null)
                populate(oldMessages);
            else
                repopulate()
        }

        repopulate();
    </script>
@stop