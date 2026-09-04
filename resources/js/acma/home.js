const chart1Ctx = document.querySelector('#chart-1');
const chart2Ctx = document.querySelector('#chart-2');
const chart3Ctx = document.querySelector('#chart-3');
const chart4Ctx = document.querySelector('#chart-4');

Alpine.data('app', () => ({
    chart1: null,
    chart2: null,
    chart3: null,
    chart4: null,
    loadingCharts: true,
    headerTable: null,
    header:{
        card1: "<i class='fa fa-spinner fa-spin'></i>",
        Pcard1: 100,
        card2: "<i class='fa fa-spinner fa-spin'></i>",
        Pcard2: 100,
        card3: "<i class='fa fa-spinner fa-spin'></i>",
        Pcard3: 100,
        card4: "<i class='fa fa-spinner fa-spin'></i>",
        Pcard4: 100,
        card5: "<i class='fa fa-spinner fa-spin'></i>",
        Pcard5: 100,
        card6: "<i class='fa fa-spinner fa-spin'></i>",
        Pcard6: 100,
        card7: "<i class='fa fa-spinner fa-spin'></i>",
        Pcard7: 100,
    },

    init() {

        /*
        this.chart1 = new Chart(chart1Ctx, {
            type: 'line',
            options: {
                legend: { display: false },
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
                datasets: [
                    {
                        label: '# of Votes',
                        backgroundColor: '#22BAA0',
                        data: [12, 19, 3, 5, 2, 3],
                        borderWidth: 1
                    },
                    {
                        label: '# of Votes',
                        backgroundColor: '#0ff000',
                        data: [15, 12, 6, 15, 12, 3],
                        borderWidth: 1
                    }
                ]
            }
        });
        */
        //this.getDataChart1();
        this.getPage();
    },

    getPage(){
        axios.post(`/acma/json/home-json`)
            .then((res) => {
                console.log(res.data);
                this.header.card1 = res.data.header.total ?? '000';
                this.header.card2 = res.data.header.classificacao ?? '000';
                this.header.card3 = res.data.header.aprazamento ?? '000';
                this.header.card4 = res.data.header.dentro_prazo ?? '000';
                this.header.card5 = res.data.header.fora_prazo ?? '000';
                this.header.card6 = res.data.header.suporte ?? '000';
                this.header.card7 = res.data.header.projetos ?? '000';
                this.headerTable = res.data.table ?? null;
            })
            .finally(() => {
            });
    },

    getDataChart1() {
        this.loadingCharts = true;

        setTimeout(() => {
            this.chart1.data.labels = ['Janeiro', 'Fevereiro', 'Marco', 'Abril', 'Maio', 'Junho', 'Julho'];
            this.chart1.data.datasets = [{
                label: 'My First Dataset',
                data: [65, 59, 80, 81, 56, 55, 40],
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }];

            this.chart1.update();

            this.loadingCharts = false;
        }, 5000);
    }
}));
