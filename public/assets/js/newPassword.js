const newPasswordDiv = document.getElementById('newPassword'); 
const checkChangePassword = document.getElementById('changeMdp'); 


checkChangePassword.addEventListener('click', () =>{

    newPasswordDiv.classList.toggle('hidden'); 
})
