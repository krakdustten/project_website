@extends('master')

@section('content')

    <div class="row justify-content-center align-items-center h-100">
        <div class="col-lg-6 col-sm-6 mb-4 mt-5">
            <div class="card bg-light text-center">
                <h5 class="card-header">
                    <strong>Register</strong>
                </h5>
                <div class="card-body px-lg-5 pt-0">
                    <form class="text-center mt-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">Username:</span>
                            </div>
                            <input type="text" class="form-control" id="register_username" aria-describedby="basic-addon3"/>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">Password:</span>
                            </div>
                            <input type="password" class="form-control" id="register_password" aria-describedby="basic-addon3"/>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">Email:</span>
                            </div>
                            <input type="text" class="form-control" id="register_email" aria-describedby="basic-addon3" onchange="validateIsEmail(register_email)"/>
                        </div>
                        <p style="color:red" id="register_error"></p>
                        <input class="btn btn-primary" type="button" value="Register" onclick="registerButton()">
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script type="text/javascript">
        function registeringDone(error, errorString){
            if(error){
                register_error.innerHTML = errorString;
            }else{
                register_error.innerHTML = "";
            }
        }

        function registerButton(){
            let register_username = document.getElementById("register_username");
            let register_password = document.getElementById("register_password");
            let register_email = document.getElementById("register_email");
            if(register_username.value.length < 8){
                register_error.innerHTML = "Username must be at least 8 characters.";
                register_username.style="background-color:lightcoral";
                return;
            }else{
                register_username.style = "background-color:#fff";
            }

            if(register_password.value.length < 8){
                register_error.innerHTML = "Password must be at least 8 characters.";
                register_password.style="background-color:lightcoral";
                return;
            }else{
                register_password.style = "background-color:#fff";
            }

            if(validateIsEmail(register_email)){
                register_email.style = "background-color:#fff";
            }else{
                register_email.style = "background-color:lightcoral";
                register_error.innerHTML = "Not an email.";
                return;
            }

            user_regsiter(register_username, register_password, register_email, registeringDone)
        }
    </script>
@stop