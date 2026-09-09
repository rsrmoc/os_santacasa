<x-layout.acma.layout>

    <style>
        .progress-bar-alert {
            background-color: #FF9800 !important;
        }

        .icon-bar {
            color: #7a6fbe !important;
        }

        .icon-bar-info {
            color: #12AFCB !important;
        }

        .icon-bar-success {
            color: #22BAA0 !important;
        }

        .icon-bar-warning {
            color: #f6d433 !important;
        }

        .icon-bar-alert {
            color: #FF9800 !important;
        }

        .icon-bar-danger {
            color: #f25656 !important;
        }
        .table td, .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            padding: 5px !important;
        }
    </style>
    <div id="main-wrapper" x-data="app">

        <div class="row" style="margin-left: 0px; margin-right: 0px;">

            <div class="col-lg-4 col-md-8" style="padding-right: 3px; padding-left: 3px;">
                <div class="panel info-box panel-white" style="margin: 10px; margin-left: 0px; margin-right: 0px;">
                    <div class="panel-body" style="padding: 10px;">
                        <div class="info-box-stats">
                            <p class="counter" x-html="header.card1"></p>
                            <span class="info-box-title">Ordens de Serviços Abertas</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="glyphicon glyphicon-folder-open icon-bar"></i>
                        </div>
                        <div class="info-box-progress">
                            <div class="progress progress-xs progress-squared bs-n">
                                <div class="progress-bar progress-bar" role="progressbar" aria-valuenow="40"
                                    aria-valuemin="0" aria-valuemax="100" :style="'width: ' + header.Pcard1 + '%'">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-8" style="padding-right: 3px; padding-left: 3px;">
                <div class="panel info-box panel-white" style="margin: 10px; margin-left: 0px; margin-right: 0px;">
                    <div class="panel-body" style="padding: 10px;">
                        <div class="info-box-stats">
                            <p class="counter" x-html="header.card2"></p>
                            <span class="info-box-title">Aguardando Classificação</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="glyphicon glyphicon-edit icon-bar-alert"></i>
                        </div>
                        <div class="info-box-progress">
                            <div class="progress progress-xs progress-squared bs-n">
                                <div class="progress-bar progress-bar-alert" role="progressbar" aria-valuenow="40"
                                    aria-valuemin="0" aria-valuemax="100" :style="'width: ' + header.Pcard2 + '%'">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-8" style="padding-right: 3px; padding-left: 3px;">
                <div class="panel info-box panel-white" style="margin: 10px; margin-left: 0px; margin-right: 0px;">
                    <div class="panel-body" style="padding: 10px;">
                        <div class="info-box-stats">
                            <p class="counter" x-html="header.card3"></p>
                            <span class="info-box-title">Aguardando Aprazamento</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="glyphicon glyphicon-calendar icon-bar-warning"></i>
                        </div>
                        <div class="info-box-progress">
                            <div class="progress progress-xs progress-squared bs-n">
                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="40"
                                    aria-valuemin="0" aria-valuemax="100" :style="'width: ' + header.Pcard3 + '%'">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" style="padding-right: 3px; padding-left: 3px;">
                <div class="panel info-box panel-white"
                    style="margin: 10px; margin-left: 0px; margin-right: 0px; margin-top: 0px;">
                    <div class="panel-body" style="padding: 10px;">
                        <div class="info-box-stats">
                            <p class="counter" x-html="header.card4" style="margin-bottom: 8px; font-size: 25px;"></p>
                            <span class="info-box-title" style="margin-bottom: 5px;">Dentro do Prazo</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="glyphicon glyphicon-ok-sign icon-bar-info"></i>
                        </div>
                        <div class="info-box-progress">
                            <div class="progress progress-xs progress-squared bs-n">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="80"
                                    aria-valuemin="0" aria-valuemax="100" :style="'width: ' + header.Pcard4 + '%'">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" style="padding-right: 3px; padding-left: 3px;">
                <div class="panel info-box panel-white"
                    style="margin: 10px; margin-left: 0px; margin-right: 0px; margin-top: 0px;">
                    <div class="panel-body" style="padding: 10px;">
                        <div class="info-box-stats">
                            <p class="counter" x-html="header.card5" style="margin-bottom: 8px; font-size: 25px;"></p>
                            <span class="info-box-title" style="margin-bottom: 5px;">Vencidas</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="glyphicon glyphicon-remove-sign icon-bar-danger"></i>
                        </div>
                        <div class="info-box-progress">
                            <div class="progress progress-xs progress-squared bs-n">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="60"
                                    aria-valuemin="0" aria-valuemax="100" :style="'width: ' + header.Pcard5 + '%'">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" style="padding-right: 3px; padding-left: 3px;">
                <div class="panel info-box panel-white"
                    style="margin: 10px; margin-left: 0px; margin-right: 0px; margin-top: 0px;">
                    <div class="panel-body" style="padding: 10px;">
                        <div class="info-box-stats">
                            <p class="counter" x-html="header.card6" style="margin-bottom: 8px; font-size: 25px;">
                            </p>
                            <span class="info-box-title" style="margin-bottom: 5px;">Suporte</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="glyphicon glyphicon-earphone icon-bar-success"></i>
                        </div>
                        <div class="info-box-progress">
                            <div class="progress progress-xs progress-squared bs-n">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50"
                                    aria-valuemin="0" aria-valuemax="100" :style="'width: ' + header.Pcard6 + '%'">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" style="padding-right: 3px; padding-left: 3px;">
                <div class="panel info-box panel-white"
                    style="margin: 10px; margin-left: 0px; margin-right: 0px; margin-top: 0px;">
                    <div class="panel-body" style="padding: 10px;">
                        <div class="info-box-stats">
                            <p class="counter" x-html="header.card7" style="margin-bottom: 8px; font-size: 25px;">
                            </p>
                            <span class="info-box-title" style="margin-bottom: 5px;">Projetos</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="glyphicon glyphicon-tasks icon-bar-success"></i>
                        </div>
                        <div class="info-box-progress">
                            <div class="progress progress-xs progress-squared bs-n">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50"
                                    aria-valuemin="0" aria-valuemax="100" :style="'width: ' + header.Pcard7 + '%'">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="row" style="margin-left: 0px; margin-right: 0px;">
            <div class="col-lg-12 panel"  >

                <template x-if="headerTable.length > 0">

                    <div class="table-responsive project-stats">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>Funcionario</th>
                                    <th class="text-center">OS em Aberto</th>
                                    <th class="text-center">Aguardando Aprazamento</th>
                                    <th class="text-center">Dentro do Prazo</th>
                                    <th class="text-center">Fora do Prazo</th>
                                    <th class="text-center">Suporte</th>
                                    <th class="text-center">Projetos</th>
                                </tr>
                            </thead>
                            <tbody>

                                <template x-for="row in headerTable" :key="row.cd_func">
                                    <tr>
                                        <th scope="row" x-text="row.nm_func"></th>
                                        <td class="text-center" ><span class="label label-primary" x-text="row.total_os"></span></td>
                                        <td class="text-center" ><span class="label label-warning" x-text="row.aguardando_aprazamento"></span></td>
                                        <td class="text-center" ><span class="label label-info" x-text="row.a_vencer"></span></td>
                                        <td class="text-center" ><span class="label label-danger" x-text="row.vencido"></span></td>
                                        <th class="text-center" x-text="row.suporte"></th>
                                        <th class="text-center" x-text="row.projetos"></th>
                                    </tr>
                                </template>

                            </tbody>
                        </table>
                    </div>

                </template>

            </div>
        </div>



        {{-- <div style="text-align: center; padding: 100px;">

            <img src="{{ asset('assets/images/logo_emp_preto.jpeg') }}">

        </div> --}}

            </div>        {{--
        <div class="panel">
            <div class="panel-body">
                <div class="row" style="margin-bottom: 24px">
                    <div class="col-md-6">
                        <template x-if="loadingCharts">
                            <x-loader class="absolute-loader"/>
                        </template>

                        <h4 style="margin-top: 0">Chart 1</h4>
                        <canvas id="chart-1"></canvas>
                    </div>

                    <div class="col-md-6">
                        <template x-if="loadingCharts">
                            <x-loader class="absolute-loader"/>
                        </template>

                        <h4 style="margin-top: 0">Chart 2</h4>
                        <canvas id="chart-2"></canvas>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <template x-if="loadingCharts">
                            <x-loader class="absolute-loader"/>
                        </template>

                        <h4 style="margin-top: 0">Chart 3</h4>
                        <canvas id="chart-3"></canvas>
                    </div>

                    <div class="col-md-6">
                        <template x-if="loadingCharts">
                            <x-loader class="absolute-loader"/>
                        </template>

                        <h4 style="margin-top: 0">Chart 4</h4>
                        <canvas id="chart-4"></canvas>
                    </div>
                </div>
            </div>
        </div>
        --}}


    </div>

    <x-slot name="scripts">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
        <script src="{{ asset('js/acma/home.js') }}"></script>
    </x-slot>

</x-layout.acma.layout>
