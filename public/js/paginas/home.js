/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**************************************!*\
  !*** ./resources/js/paginas/home.js ***!
  \**************************************/
var chart1Ctx = document.querySelector('#chart-1');
var chart2Ctx = document.querySelector('#chart-2');
var chart3Ctx = document.querySelector('#chart-3');
var chart4Ctx = document.querySelector('#chart-4');
Alpine.data('app', function () {
  return {
    chart1: null,
    chart2: null,
    chart3: null,
    chart4: null,
    loadingCharts: true,
    init: function init() {
      this.chart1 = new Chart(chart1Ctx, {
        type: 'line',
        options: {
          legend: {
            display: false
          },
          responsive: true
        }
      });
      this.chart2 = new Chart(chart2Ctx, {
        type: 'bar',
        data: {
          labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
          datasets: [{
            label: '# of Votes',
            backgroundColor: '#22BAA0',
            data: [12, 19, 3, 5, 3, 3],
            borderWidth: 1
          }]
        }
      });
      this.chart3 = new Chart(chart3Ctx, {
        type: 'pie',
        data: {
          labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
          datasets: [{
            backgroundColor: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            borderWidth: 1
          }]
        }
      });
      this.chart4 = new Chart(chart4Ctx, {
        type: 'horizontalBar',
        data: {
          labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
          datasets: [{
            label: '# of Votes',
            backgroundColor: '#22BAA0',
            data: [12, 19, 3, 5, 2, 3],
            borderWidth: 1
          }, {
            label: '# of Votes',
            backgroundColor: '#0ff000',
            data: [15, 12, 6, 15, 12, 3],
            borderWidth: 1
          }]
        }
      });
      this.getDataChart1();
    },
    getDataChart1: function getDataChart1() {
      var _this = this;
      this.loadingCharts = true;
      setTimeout(function () {
        _this.chart1.data.labels = ['Janeiro', 'Fevereiro', 'Marco', 'Abril', 'Maio', 'Junho', 'Julho'];
        _this.chart1.data.datasets = [{
          label: 'My First Dataset',
          data: [65, 59, 80, 81, 56, 55, 40],
          fill: false,
          borderColor: 'rgb(75, 192, 192)',
          tension: 0.1
        }];
        _this.chart1.update();
        _this.loadingCharts = false;
      }, 5000);
    }
  };
});
/******/ })()
;