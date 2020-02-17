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

const dateInput = document.querySelector('.form__date');

dateInput.value = date;

//Czyszczenie formularza przyciskiem "Anuluj"

const cancelBtn = document.querySelector(".form__cancel");

const amountInput = document.querySelector(".form__amount");

const categoryInput = document.querySelector(".form__category");

const paymentInput = document.querySelector(".form__payment");

const textarea = document.querySelector(".form__comment");

cancelBtn.addEventListener('click', () => {
    amountInput.value = "";
    dateInput.value = date;
    paymentInput.value = "cash";
    categoryInput.value = "food";
    textarea.value = "";
});