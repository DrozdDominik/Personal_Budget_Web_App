//Bilans

const label = document.querySelector('.nav__label');

const pVisible = document.querySelector('.nav__visible');

const container = document.querySelector('.nav__container');

const currentMonth = document.querySelector('.nav__current-month');

const previousMonth = document.querySelector('.nav__previous-month');

const currentYear = document.querySelector('.nav__current-year');

const custom = document.querySelector('.nav__custom');

const dateRange = document.querySelector('.nav__date');

label.addEventListener('click', () => {

    container.style.visibility = "visible";
    dateRange.style.visibility = "hidden";
    
})

container.addEventListener('mouseleave', () => {

    container.style.visibility = "hidden";
    if(pVisible.innerHTML == "Niestandardowy" && container.style.visibility == "hidden")
    {
        dateRange.style.visibility = "visible";
    }

})

container.addEventListener('click', (e) =>{
      
    switch(e.target.className)
    {
        case "nav__current-month" :
             pVisible.innerHTML = e.target.innerHTML;
        break;

        case "nav__previous-month" :
             pVisible.innerHTML = e.target.innerHTML;
        break;

        case "nav__current-year" :
            pVisible.innerHTML = e.target.innerHTML;
        break;

        case "nav__custom" :
        pVisible.innerHTML = e.target.innerHTML;
        break;       
        
    }
})

google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {

const data = google.visualization.arrayToDataTable([
    ['Wydatek', 'zł'],
    ['Jedzenie',     1000],
    ['Transport',      1000],
    ['Komunikacja',  1000],
    ['Opieka zdrowotna', 1000],
    ['Ubranie',    1000],
    ['Higiena',     1000],
    ['Dzieci',      1000],
    ['Rozrywka',  1000],
    ['Wycieczka', 1000],
    ['Szkolenia',    1000],
    ['Książki',     1000],
    ['Oszczędności',      1000],
    ['Na emeryturę',  1000],
    ['Spłata długów', 1000],
    ['Darowizna',    1000],
    ['Inne wydatki',    1000]
]);

const options = {
    title: 'Wydatki'
};

const chart = new google.visualization.PieChart(document.getElementById('piechart'));

chart.draw(data, options);
}
  