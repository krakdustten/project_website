
function validateIsEmail(emailForm){
    let re = /\S+@\S+\.\S+/;
    return re.test(String(emailForm.value).toLowerCase())
}