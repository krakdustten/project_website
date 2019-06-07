<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shop Homepage - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        body {
            padding-top: 56px;
        }
    </style>
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="/project_website/public/">Buy together</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#topNavbar" aria-controls="topNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="topNavbar">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Orders</a>
                <div class="dropdown-menu" aria-labelledby="dropdown04">
                    <a class="dropdown-item" href="#">Create order</a>
                    <a class="dropdown-item" href="/project_website/public/list/userlists/">Your Orders</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/project_website/public/group/groups/">Groups</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/project_website/public/user/friends/">Friends</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/project_website/public//user/messages/">Messages</a>
            </li>
            <li class="nav-item" id="navAdmin">

            </li>

        </ul>
        <div id="endOfNav">

        </div>

    </div>
</nav>

<!-- Page Content -->
<div class="container" style="min-height: 1000px">
    @yield('content')
</div>
<!-- /.container -->

<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; why not 2019</p>
    </div>
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="/project_website/public/js/crypto.js"></script>
<script src="/project_website/public/js/form_validation.js"></script>
<script src="/project_website/public/js/user_management.js"></script>
<script src="/project_website/public/js/list_manager.js"></script>

<script type="text/javascript">
    function checkUserLogin(redirect_register = true){
        let endOfNav = document.getElementById("endOfNav");
        if(user_logedin()){
            endOfNav.innerHTML =
                "<form class=\"form-inline\">\n" +
                "    <div class=\"input-group\">\n" +
                "        <div class=\"input-group-prepend\">\n" +
                "            <span class=\"input-group-text\">👤</span>\n" +
                "        </div>\n" +
                "        <div class=\"input-group-append\">\n" +
                "            <button type=\"button\" class=\"btn btn-secondary\" onclick=\"window.location.href = '/project_website/public/user/';\">" + getUserName() + "</button>\n" +
                "            <button type=\"button\" class=\"btn btn-outline-primary\" onclick=\"logout();reload_page()\">Logout</button>\n" +
                "        </div>\n" +
                "    </div>\n" +
                "</form>";
            if(user_isAdmin()){
                let navAdmin = document.getElementById("navAdmin");
                navAdmin.innerHTML = "<a class=\"nav-link\" href=\"/project_website/public//admin/\">Admin</a>"
            }
        }
        else if(redirect_register){
           window.location.href = "/project_website/public/user/register/";
        }
        else{
            endOfNav.innerHTML =
                "<form class=\"form-inline\">\n" +
                "    <div class=\"input-group\">\n" +
                "        <input type=\"text\" class=\"form-control\" placeholder=\"Username\" aria-label=\"Username\" aria-describedby=\"button-addon1\" id=\"LoginUsername\">\n" +
                "        <input type=\"password\" class=\"form-control\" placeholder=\"Password\" aria-label=\"Password\" aria-describedby=\"button-addon1\" id=\"LoginPassword\">\n" +
                "        <div class=\"input-group-append\">\n" +
                "            <button class=\"btn btn-outline-primary\" type=\"button\" id=\"button-addon2\" onclick=\"login(this.form.LoginUsername, this.form.LoginPassword, reload_page)\">Login</button>\n" +
                "        </div>\n" +
                "    </div>\n" +
                "</form>";
        }
        @yield('login_changed')
    }
    checkUserLogin(false);

    function reload_page() {
        location.reload();

    }
</script>

@yield('script')

</body>
</html>