const dropdownMenu = document.querySelector('.dropdown-menu');

const lead = document.querySelector('.leadTarget');

dropdownMenu.addEventListener('click', (e) =>{

   lead.innerHTML =  e.target.innerHTML;
})

let x = window.outerWidth;

    window.addEventListener("resize", () => {
    if(Math.abs((window.outerWidth - x)/x *100) > 15)
    {
        document.location.reload();
    }
});