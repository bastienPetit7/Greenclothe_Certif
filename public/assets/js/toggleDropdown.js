const chevronDown = document.getElementById('chevronDropdown'); 
const menuAcount = document.getElementById('menuAcount'); 






function checkChevron(){

    if(menuAcount.classList.contains('active')){

        chevronDown.classList.replace('fa-chevron-right', 'fa-chevron-down'); 
    } else chevronDown.classList.replace('fa-chevron-down', 'fa-chevron-right'); 

}


chevronDown.addEventListener('click', () =>{

    menuAcount.classList.toggle('active'); 

    checkChevron(); 

});
