
const chevronDropFilter = document.getElementById("chevronDropFilter"); 
const menuFilter = document.getElementById('menuFilter'); 
const btnFilter = document.getElementById('btnFilter'); 





window.addEventListener('resize', () => {

        if (window.innerWidth <= 765){
            menuFilter.classList.add('form-filter-active');
        }
});

chevronDropFilter.addEventListener('click', () => {

    menuFilter.classList.toggle('form-filter-active'); 

})

btnFilter.addEventListener('click', () => {
    if(window.innerWidth <= 765){

        menuFilter.classList.add('form-filter-active'); 
        console.log('hello');

    }
})

function hideFilter(){

    if(window.innerWidth <= 765){
        menuFilter.classList.add('form-filter-active');
        console.log("hi");
    }
}