@extends('master')

@section('content')
    <h1 class="my-4" id="listtitle">List
        <small></small>

    </h1>

    <div class="mb-12">
        <div class="card h-100">
            <div class="card-body">
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <div class="input-group mb-3" id="returning_input_group">
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="btn-group mb-3" id="export_input_group">
                        </div>
                    </div>
                </div>

                <h4 class="card-title">
                    Filters
                </h4>
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <select multiple class="form-control" id="componentVenderFilter" onchange="populate_old()">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <input type="text" class="form-control" id="componentNumberFilter" placeholder="component number" onchange="populate_old()" onkeyup="populate_old()">
                    </div>
                    <div class="col-auto">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="itemsMineFilter" value="option1" checked="checked" onchange="populate_old()">
                            <label class="form-check-label" for="inlineCheckbox1">My components</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="itemsOtherFilter" value="option2" checked="checked" onchange="populate_old()">
                            <label class="form-check-label" for="inlineCheckbox2">Other components</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row my-4" id="top_row">
    </div>

    <div class="mb-5">
        <div class="card h-100">
            <h4 class="card-header">
                New item
            </h4>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Component link" aria-label="New component link" aria-describedby="basic-addon2" id="NI1_link">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary" type="button" onclick="NI1_get_information_click()">Get information</button>
                            <button class="btn btn-outline-primary" type="button" onclick="NI1_add_to_list_click()">Add to list</button>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="input-group">
                        <select class="custom-select" id="NI2_venders">
                            <option>Farnell</option>
                            <option>Mouser</option>
                            <option>DigiKey</option>
                            <option>RSOnline</option>
                        </select>
                        <input type="text" class="form-control" placeholder="Number" aria-label="Number" aria-describedby="basic-addon2" id="NI2_number">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary" type="button" onclick="NI2_get_information_click()">Get information</button>
                            <button class="btn btn-outline-primary" type="button" onclick="NI2_add_to_list_click()">Add to list</button>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="form-row align-items-center">
                        <div class="col-auto mb-2">
                            <input type="text" class="form-control" placeholder="Vender" aria-label="Vender" aria-describedby="basic-addon2" id="NI3_vender">
                        </div>
                        <div class="col-auto mb-2">
                            <input type="text" class="form-control" placeholder="Number" aria-label="Number" aria-describedby="basic-addon2" id="NI3_number">
                        </div>
                        <div class="col-auto mb-2">
                            <input type="text" class="form-control" placeholder="Manufacturer" aria-label="Manufacturer" aria-describedby="basic-addon2" id="NI3_manufacturer">
                        </div>
                        <div class="col-auto mb-2">
                            <input type="text" class="form-control" placeholder="Manufacturer number" aria-label="Manufacturer number" aria-describedby="basic-addon2" id="NI3_manufacturer_number">
                        </div>
                        <div class="col-auto mb-2">
                            <input type="text" class="form-control" placeholder="Prices (Am:Pr, Am:Pr)" aria-label="Prices (Am:Pr, Am:Pr)" aria-describedby="basic-addon2" id="NI3_prices">
                        </div>
                        <div class="col-auto mb-2">
                            <input type="text" class="form-control" placeholder="Link" aria-label="Link" aria-describedby="basic-addon2" id="NI3_link">
                        </div>
                        <div class="col-auto mb-2">
                            <button class="btn btn-outline-primary" type="button" onclick="NI3_add_to_list_click()">Add to list</button>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
@stop

@section('script')
    <script type="text/javascript">
        function populate(list){
            let top_row = document.getElementById("top_row");
            let listtitle = document.getElementById("listtitle");
            let returning_input_group = document.getElementById("returning_input_group");
            let export_input_group = document.getElementById("export_input_group");
            let componentVenderFilter = document.getElementById("componentVenderFilter");
            let componentNumberFilter = document.getElementById("componentNumberFilter");
            let itemsMineFilter = document.getElementById("itemsMineFilter");
            let itemsOtherFilter = document.getElementById("itemsOtherFilter");
            listtitle.innerHTML = list.name;
            items = list.items;
            users = list.users;
            teams = list.teams;

            let grights = 0;
            for(let i = 0; i < users.length; i++) {
                let user = users[i];
                if(user.name == getUserName()) grights = user.rights;
            }

            let venderInnerHtml = "";
            let svender = {};
            let temp = 0;
            for(let i = 0; i <items.length; i++){
                let item = items[i];
                if(svender[item.vender] == null){
                    svender[item.vender] = temp;
                    svender[item.vender + "-s"] = componentVenderFilter.options[temp].selected;
                    temp++;
                    venderInnerHtml += "<option>" + item.vender + "</option>";
                }
            }
            componentVenderFilter.innerHTML = venderInnerHtml;
            for(let i = 0; i < componentVenderFilter.options.length; i++){
                componentVenderFilter.options[i].selected = svender[ componentVenderFilter.options[i].text + "-s"];
            }

            returning_input_group.innerHTML =
                "<div class=\"input-group-prepend\">\n" +
                "    <a class=\"btn btn-outline-primary\" href=\"/public/list/teams" + link_data + "\">Groups</a>\n" +
                "    <a class=\"btn btn-outline-primary\" href=\"/public/list/users" + link_data + "\">Users</a>\n" +
                "</div>\n" +
                "<div class=\"input-group-append\">\n" +
                (grights >= 2500 ? "    <button class=\"btn btn-outline-danger\" type=\"button\" onclick=\"remove_list(" + id + ", redirectTo)\">Remove list</button>\n" : "" )+
                "    <button class=\"btn btn-outline-danger\" type=\"button\" onclick=\"remove_list_user(" + id + ", '" + getUserName() + "', redirectTo)\">Leave list</button>\n" +
                "</div>";

            export_input_group.innerHTML =
                //"<button class=\"btn btn-outline-success\" type=\"button\" onclick=\"export_vender()\">Export per vender</button>\n" +
                "<button class=\"btn btn-outline-success\" type=\"button\" onclick=\"export_user_list(" + id + ")\">Export user only</button>\n" +
                "<button class=\"btn btn-outline-success\" type=\"button\" onclick=\"export_full_list(" + id + ")\">Export all</button>\n";

            let row_html = "";
            row_html +=
                "<div class=\"col-lg-12 col-sm-12 mb-12\">\n" +
                "    <div class=\"card h-100\">\n" +
                "        <div class=\"card-body\">\n" +
                "            <div class=\"table-responsive\">\n" +
                "                <table class=\"table table-hover\">\n" +
                "                    <thead class=\"thead-light\">\n" +
                "                        <tr>\n" +
                "                            <th scope=\"col\" rowspan=\"2\" class=\"text-center\">Link</th>\n" +
                "                            <th scope=\"col\" rowspan=\"2\" class=\"text-center\">Component number</th>\n" +
                "                            <th scope=\"col\" rowspan=\"2\" class=\"text-center\">Vender</th>\n" +
                "                            <th scope=\"col\" colspan=\"3\" class=\"text-center\">Amount</th>\n" +
                "                            <th scope=\"col\" rowspan=\"2\" class=\"text-center\">Price/p</th>\n" +
                "                            <th scope=\"col\" colspan=\"2\" class=\"text-center\">Price</th>\n" +
                "                        </tr>\n" +
                "                        <tr>\n" +
                "                            <th scope=\"col\" class=\"text-center\">You</th>\n" +
                "                            <th scope=\"col\" class=\"text-center\">Other</th>\n" +
                "                            <th scope=\"col\" class=\"text-center\">Tot</th>\n" +
                "                            <th scope=\"col\" class=\"text-center\">You</th>\n" +
                "                            <th scope=\"col\" class=\"text-center\">Tot</th>\n" +
                "                        </tr>\n" +
                "                    </thead>\n" +
                "                    <tbody>\n";

            for(let i = 0; i < items.length; i++) {
                let item = items[i];

                showItem = true;
                if(componentVenderFilter.selectedIndex >= 0)
                    if(!svender[item.vender + "-s"])
                        showItem = false;
                if(!item.componentnumber.includes(componentNumberFilter.value))
                    showItem = false;
                if(item.useramount > 0 && (item.amount - item.useramount) > 0)
                    if(!itemsMineFilter.checked && !itemsOtherFilter.checked)
                        showItem = false;
                if(item.useramount > 0 && (item.amount - item.useramount) <= 0)
                        if(!itemsMineFilter.checked)
                            showItem = false;
                if(item.useramount <= 0 && (item.amount - item.useramount) > 0)
                    if(!itemsOtherFilter.checked)
                        showItem = false;
                if(showItem) {
                    let price_p = 10000000000;
                    let min_amount = 10000000000;
                    let min_price = 0;

                    for (let j = 0; j < item.prices.length; j++) {
                        pa = item.prices[j];
                        if (min_amount > pa.amount) {
                            min_amount = pa.amount;
                            min_price = pa.price;
                        }
                    }
                    if (price_p >= 10000000000)
                        price_p = min_price;

                    let buy_amount = Math.ceil(item.amount / min_amount) * min_amount;
                    for (let j = 0; j < item.prices.length; j++) {
                        pa = item.prices[j];
                        if (buy_amount >= pa.amount) {
                            if (price_p > pa.price)
                                price_p = pa.price;
                        }
                    }
                    let total_p = buy_amount * price_p;


                    row_html +=
                        "<tr>\n" +
                        "    <td><a href=\"" + item.link + "\">Link</a></td>\n" +
                        "    <td>" + item.componentnumber + "</td>\n" +
                        "    <td>" + item.vender + "</td>\n" +
                        "    <td class=\"text-right\">\n" +
                        "        <input type=\"number\" min=\"0\" step=\"1\" value=\"" + item.useramount + "\" style=\"width:80px;\" onchange=\"amount_changed(" + item.id + ", this.value)\"/> \n" +
                        "    </td>\n" +
                        "    <td class=\"text-right\">" + (item.amount - item.useramount) + "</td>\n" +
                        "    <td class=\"text-right\">" + buy_amount + "</td>\n" +
                        "    <td class=\"text-right\">" + price_p.toFixed(4) + "€</td>\n" +
                        "    <td class=\"text-right\">" + (price_p * (item.useramount / item.amount * buy_amount)).toFixed(2) + "€</td>\n" +
                        "    <td class=\"text-right\">" + total_p.toFixed(2) + "€</td>\n" +
                        "</tr>\n";
                }
            }
            row_html +=
                "                    </tbody>\n" +
                "                </table>\n" +
                "            </div>\n" +
                "        </div>\n" +
                "    </div>\n" +
                "</div>";

            top_row.innerHTML = row_html;
            old_list = list;
        }

        function populate_venders(venders){
            let NI2_venders = document.getElementById("NI2_venders");
            let jhtml = "";
            for(let i = 0; i < venders.length; i++){
                jhtml += "<option>" + venders[i].name + "</option>";
            }
            NI2_venders.innerHTML = jhtml;
        }

        function NI1_get_information_click(){
            let NI1_link = document.getElementById("NI1_link");
            get_item_from_link(NI1_link.value, return_NI1_get_information);
        }

        function return_NI1_get_information(item){
            let NI3_vender = document.getElementById("NI3_vender");
            let NI3_number = document.getElementById("NI3_number");
            let NI3_manufacturer = document.getElementById("NI3_manufacturer");
            let NI3_manufacturer_number = document.getElementById("NI3_manufacturer_number");
            let NI3_prices = document.getElementById("NI3_prices");
            let NI3_link = document.getElementById("NI3_link");

            prices = "";
            for(let i = 0; i < item.Prices.length; i++){
                let price = item.Prices[i];
                prices += price.amount + ":" + price.price + ",";
            }
            prices = prices.substr(0, prices.length - 1);

            NI3_vender.value = item.Vendername;
            NI3_number.value = item.VerderComponentNumber;
            NI3_manufacturer.value = item.Manufacturer;
            NI3_manufacturer_number.value = item.ManufacturerNumber;
            NI3_prices.value = prices;
            NI3_link.value = item.Link;
        }

        function NI1_add_to_list_click(){
            let NI1_link = document.getElementById("NI1_link");
            get_item_from_link(NI1_link.value, return_NI1_add_list);
        }

        function return_NI1_add_list(item){
            prices = "";
            for(let i = 0; i < item.Prices.length; i++){
                let price = item.Prices[i];
                prices += price.amount + ":" + price.price + ",";
            }
            prices = prices.substr(0, prices.length - 1);

            add_item(id, item.Vendername, item.VerderComponentNumber, item.Manufacturer, item.ManufacturerNumber,
                prices, item.Link, 1, repopulate);
        }

        function NI2_get_information_click(){
            let NI2_venders = document.getElementById("NI2_venders");
            let NI2_number = document.getElementById("NI2_number");
            get_item_from_vender_component(NI2_venders.value, NI2_number.value, return_NI1_get_information);
        }

        function NI2_add_to_list_click(){
            let NI2_venders = document.getElementById("NI2_venders");
            let NI2_number = document.getElementById("NI2_number");
            get_item_from_vender_component(NI2_venders.value, NI2_number.value, return_NI1_add_list);
        }

        function NI3_add_to_list_click(){
            let NI3_vender = document.getElementById("NI3_vender");
            let NI3_number = document.getElementById("NI3_number");
            let NI3_manufacturer = document.getElementById("NI3_manufacturer");
            let NI3_manufacturer_number = document.getElementById("NI3_manufacturer_number");
            let NI3_prices = document.getElementById("NI3_prices");
            let NI3_link = document.getElementById("NI3_link");
            add_item(id, NI3_vender.value, NI3_number.value, NI3_manufacturer.value, NI3_manufacturer_number.value,
                NI3_prices.value, encodeURIComponent(NI3_link.value), 1, repopulate);
        }

        function amount_changed(item_id, amount){
            set_item_amount(id, item_id, amount, repopulate);
        }

        function export_vender(){

        }

        function export_user(){

        }

        function export_all(){

        }

        function redirectTo(){
            window.location.href = "/public/";
        }

        function populate_old(){
            if(old_list == null)
                repopulate();
            else
                populate(old_list);
        }

        function repopulate(){
            if(group == true){
                link_data = "?group=true&name=" + name + "&id=" + id;
                get_user_list(id, populate);
            }else{
                link_data = "?group=false&id=" + id;
                get_user_list(id, populate);
            }
            //get_all_venders(populate_venders);
        }
        var group = findGetParameter("group").toLowerCase().startsWith("t");
        var name = findGetParameter("name");
        var id = findGetParameter("id");
        var link_data = "";
        var old_list;

        repopulate();
    </script>


@stop