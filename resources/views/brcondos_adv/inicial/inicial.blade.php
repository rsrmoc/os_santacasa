<x-layout.brcondos_adv.layout>


    <div id="main-wrapper" x-data="app">

        <div class="row">
            <div class="col-lg-2 col-md-4">
                <div class="panel info-box panel-white">
                    <div class="panel-body" style="border: 1px solid rgb(236, 203, 140)">
                        <div class="info-box-stats">
                            <p class="counter">107</p>
                            <span class="info-box-title">Total de Boletos em Aberto</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="fa fa-barcode" style="color: orange;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4">
                <div class="panel info-box panel-white">
                    <div class="panel-body" style="border: 1px solid rgb(147, 147, 236)">
                        <div class="info-box-stats">
                            <p class="counter">107</p>
                            <span class="info-box-title">Boletos em Aberto</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="fa fa-barcode" style="color: blue;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4">
                <div class="panel info-box panel-white">
                    <div class="panel-body" style="border: 1px solid rgb(240, 159, 159)">
                        <div class="info-box-stats">
                            <p class="counter">180</p>
                            <span class="info-box-title">Boletos Atrasados</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="fa fa-barcode" style="color: red;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4">
                <div class="panel info-box panel-white">
                    <div class="panel-body" style="border: 1px solid rgb(236, 203, 140)">
                        <div class="info-box-stats">
                            <p>$<span class="counter">201</span></p>
                            <span class="info-box-title">Total de Negoc. em Aberto</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="fa fa fa-comment" style="color: orange;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4">
                <div class="panel info-box panel-white">
                    <div class="panel-body" style="border: 1px solid rgb(147, 147, 236)">
                        <div class="info-box-stats">
                            <p>$<span class="counter">201</span></p>
                            <span class="info-box-title">Negociações em Aberto</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="fa fa fa-comment" style="color: blue;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4">
                <div class="panel info-box panel-white">
                    <div class="panel-body" style="border: 1px solid rgb(240, 159, 159)">
                        <div class="info-box-stats">
                            <p class="counter">180</p>
                            <span class="info-box-title">Negociações em atrasos</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="fa fa fa-comment" style="color: red;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div style="text-align: center; padding: 100px;">

            <img src="{{ asset('assets/images/logo_emp_preto.jpeg') }}">

        </div> --}}

                <!--
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
        
                -->
    </div>

    <x-slot name="scripts">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
        <script src="{{ asset('js/paginas/home.js') }}"></script>
    </x-slot>
</x-layout.brcondos_adv.layout>
