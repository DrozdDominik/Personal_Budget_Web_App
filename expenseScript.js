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

const cash =  document.querySelector("#cash");

const debit = document.querySelector("#debit");

const credit =  document.querySelector("#credit");

const select = document.querySelector('#inputSelect');

const textarea = document.querySelector(".textarea");

cancelBtn.addEventListener('click', () => {
    amountInput.value = "";
    dateInput.value = date;
    select[0].selected = "true";
    textarea.value = "";

    if(cash.checked)
    {
        cash.checked = false
    }
    else if(debit.checked)
    {
        debit.checked = false;
    }
    else if(credit.checked)
    {
        credit.checked = false
    }
});