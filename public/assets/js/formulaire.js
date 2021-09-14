const form = document.getElementById('form'); 
const message = document.getElementById('message'); 
const labels = document.querySelectorAll('label'); 
const inputs = document.querySelectorAll('input');
const messageContainer = document.getElementById('messageContainer');
 



let password1 = '';
let password2 = '';
let formValid = false;
let passwordsMatch = false;




// Verification du formaulaire pour voir si valid
function isFormValid() {
    password1 = inputs[3].value;
    password2 = inputs[4].value;

    formValid = form.checkValidity()
    if(!formValid){
        message.textContent = 'Please fill up all the fields'; 
        message.style.color = 'red'; 
       
        return;
    }

    if (password1 !== password2){
        passwordsMatch = false;
        message.textContent = 'Make sure passwords match'; 
        message.style.color = 'red'; 
       
        inputs[3].style.borderColor = 'red';
        inputs[4].style.borderColor = 'red';
        return; 
        
    } else {
        passwordsMatch = true;
        inputs[3].style.borderColor = 'green';
        inputs[4].style.borderColor = 'green';
    }
         

    if (password1 === password2 && form.checkValidity() == true){
        message.textContent = 'Successfully register'; 
        message.style.color = "green"; 
       
        console.log('ok');
    }
}


function saveUserData() {
    const UserData = {
        name: inputs[0].value ,
        phone: inputs[1].value, 
        mail: inputs[2].value , 
        password: inputs[4].value,
    }
    console.log(UserData);
}


function submitForm(e) {

    e.preventDefault(); 
    console.log(e);
     
    isFormValid();

    if ( password1 === password2){
    saveUserData(); 
    }
}

// Event Listener 
form.addEventListener('submit', submitForm);




