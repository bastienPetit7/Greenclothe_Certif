const newPasswordDiv = document.getElementById('newPassword'); 
const checkChangePassword = document.getElementById('changeMdp'); 
const newPasswordInput = document.getElementById('newPwd')


checkChangePassword.addEventListener('click', () =>{

    newPasswordDiv.classList.toggle('hidden'); 
})
