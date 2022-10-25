// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

let Qte_janvier = 0;
let Qte_fevrier = 0;
let Qte_mars = 0;
let Qte_avril = 0;
let Qte_mai = 0;
let Qte_juin = 0;
let Qte_juillet = 0;
let Qte_aout = 0;
let Qte_septembre = 0;
let Qte_octobre = 0;
let Qte_novembre = 0;
let Qte_deccembre = 0;


$(document).on('change', '#year_c', function(){
  if($(this).val()){
      let newCourDate = Array();
      let courriers = JSON.parse($(this).attr('data-courriers'));
      courriers.forEach(courrier => {
          if(parseInt($(this).val()) == parseInt(courrier.date_create.slice(0,4))){
              newCourDate.push(courrier);
          }
      });
      
      newCourDate.forEach(courrier => {
          let mois = parseInt(courrier.date_create.slice(5,7))
          switch (mois) {
              case 1:
                this.Qte_janvier +=1
                  break;
              case 2:
                this.Qte_fevrier +=1
                  break;
              case 3:
                this.Qte_mars +=1
                  break;
              case 4:
                this.Qte_avril +=1
                  break;
              case 5:
                this.Qte_mai +=1
                  break;
              case 6:
                this.Qte_juin +=1
                  break;
              case 7:
                this.Qte_juillet +=1
                  break;
              case 8:
                this.Qte_aout +=1
                  break;
              case 9:
                this.Qte_septembre +=1
                  break;
              case 10:
                this.Qte_octobre +=1
                  break;
              case 11:
                this.Qte_novembre +=1
                  break;
              case 12:
                Qte_deccembre +=1
                  break;
              default:
                  break;
          }
      });
  }
});

  var ctx = document.getElementById("myAreaChart_mois");
  var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ["JANVIER", "FEVRIER", "MARS", "AVRIL", "MAI", "JUIN", "JUILLET", "AOUT", "SEPTEMBRE", "OCTOBRE", "NOVEMBRE", "DECCEMBRE"],
      datasets: [{
        label: "Earnings",
        lineTension: 0.3,
        backgroundColor: "rgba(78, 115, 223, 0.05)",
        borderColor: "rgba(78, 115, 223, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(78, 115, 223, 1)",
        pointBorderColor: "rgba(78, 115, 223, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: [Qte_janvier, Qte_fevrier, Qte_mars, Qte_avril, Qte_mai, Qte_juin, Qte_juillet, Qte_aout, Qte_septembre, Qte_octobre, Qte_novembre, Qte_deccembre],
      }],
    },
    options: {
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 10,
          right: 25,
          top: 25,
          bottom: 0
        }
      },
      scales: {
        xAxes: [{
          time: {
            unit: 'date'
          },
          gridLines: {
            display: false,
            drawBorder: false
          },
          ticks: {
            maxTicksLimit: 12
          }
        }],
        yAxes: [{
          ticks: {
            maxTicksLimit: 5,
            padding: 10,
            // Include a dollar sign in the ticks
            //return '$' + number_format(value);
            callback: function(value, index, values) {
              return number_format(value);
            }
          },
          gridLines: {
            color: "rgb(234, 236, 244)",
            zeroLineColor: "rgb(234, 236, 244)",
            drawBorder: false,
            borderDash: [2],
            zeroLineBorderDash: [2]
          }
        }],
      },
      legend: {
        display: false
      },
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        titleMarginBottom: 10,
        titleFontColor: '#6e707e',
        titleFontSize: 14,
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        intersect: false,
        mode: 'index',
        caretPadding: 10,
        callbacks: {
          label: function(tooltipItem, chart) {
            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
            //return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
            return number_format(tooltipItem.yLabel);
          }
        }
      }
    }
  });
