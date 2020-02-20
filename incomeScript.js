// Ustawianie aktualnej daty jako domyślnej w formularzu

const now = new Date();

const year = now.getFullYear();

let mounth = now.getMonth()+1;

let day = now.getDate();

if(mounth < 10)
{
    mounth = `0${mounth}`;
};

if(day < 10)
{
    day = `0${day}`;
};

date = `${year}-${mounth}-${day}`;

const dateInput = document.querySelector('#date');

dateInput.value = date;

//Czyszczenie formularza przyciskiem "Anuluj"

const cancelBtn = document.querySelector(".cancelBtn");

const amountInput = document.querySelector("#amount");

const salary =  document.querySelector("#salary");

const interest = document.querySelector("#interest");

const allegro =  document.querySelector("#allegro");

const other = document.querySelector("#other");

const textarea = document.querySelector(".textarea");

cancelBtn.addEventListener('click', () => {
    amountInput.value = "";
    dateInput.value = date;
    textarea.value = "";

    if(salary.checked)
    {
        salary.checked = false
    }
    else if(interest.checked)
    {
        interest.checked = false;
    }
    else if(allegro.checked)
    {
        allegro.checked = false
    }
    else if(other.checked)
    {
        other.checked = false
    }
});