const email = document.querySelector("#email");
const password = document.querySelector("#password");
const error_e = document.querySelector(".email-error");
const error_p = document.querySelector(".password-error");
email.onblur = ()=>{
    if(email.value.trim() == ''){
        email.style.border = '2px solid red';
        error_e.innerHTML = 'Fill the email input!'
    }
    else if(!email.value.includes('@')){
        email.style.border = '2px solid red';
        error_e.innerHTML = 'email is invalid!'
    }
    else{
        email.style.border = '2px solid green';
        error_e.innerHTML = '';
    }
}
password.onblur = ()=>{
    if(password.value.trim() == ''){
        password.style.border = '2px solid red';
        error_p.innerHTML = 'Fill the password input!'
    }
    else{
        password.style.border = '2px solid green';
        error_p.innerHTML = '';
    }
}
