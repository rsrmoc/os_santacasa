<div {{ $attributes->merge(['class' => 'loader_carregando']) }}>
    <div class="fa-3x CarregaPagina" style="  margin-top: 40%; text-align: center; margin: 0 auto; width: 100%; 
    height: 100%;   z-index: 9999999999; overflow: hidden;  "> <Br> 
        <!--<i class="fa fa-spinner fa-pulse has-text-danger" style="font-size: 2.5em; "></i>-->
        <img src="{{ asset('assets/images/sc_logo.png') }}" style="height: 60px;">
        <br> 
        <section class="fa-1x "> 
            <div class="loading loading01">
              <span>C</span>
              <span>a</span>
              <span>r</span>
              <span>r</span>
              <span>e</span>
              <span>g</span>
              <span>a</span>
              <span>n</span>
              <span>d</span>
              <span>o</span>
            </div>
          </section>
    </div>
</div>
