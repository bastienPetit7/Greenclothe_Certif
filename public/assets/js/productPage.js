// ====================== Page Product =====================================



const mainImg = document.getElementById('mainImgProduct'); 
const smallImg = Array.from(document.getElementsByClassName('small-img')); 


smallImg.forEach((img) => {
    img.onclick = () =>{
        mainImg.src = img.src;
    }
}); 