const dropdownMenu = document.querySelector('.dropdown-menu');

const lead = document.querySelector('.leadTarget');

dropdownMenu.addEventListener('click', (e) =>{

   lead.innerHTML =  e.target.innerHTML;
})

google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {

   const data = google.visualization.arrayToDataTable([
      ['Wydatek', 'zł'],
      ['Jedzenie',     99.55],
      ['Transport',      153.80],
      ['Mieszkanie',  553.40]
   ]);

   const options = {
      legend: {position: 'bottom', alignment: 'center'},
      chartArea:{width:'100%',height:'400px'},
   };

   const chart = new google.visualization.PieChart(document.getElementById('piechart'));

   chart.draw(data, options);
}

let x = window.outerWidth;

window.addEventListener("resize", () => {
   if(Math.abs((window.outerWidth - x)/x *100) > 15)
   {
      document.location.reload();
   }
});