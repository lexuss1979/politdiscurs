@if(Route::current()->getName() == 'main')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="/js/materialize.min.js"></script>
    <script>
        $(document).ready(function(){
            let magEl = $('.magazines  .carousel');
            document.magCar = M.Carousel.init(magEl, {
                numVisible:7,
                dist: -25,
                padding: 20,
                shift: 10
            })[0];
            $('.magazines .left-btn').on('click',function(){
                document.magCar.next();
            });
            $('.magazines .right-btn').on('click',function(){
                document.magCar.prev();
            });
        });

        function enlarge(parent,id){
            let $elem = $(parent + ' .carousel-item.active');
            if($elem.hasClass('big') && id === $elem.data('mgid')){
                window.location.href=$elem.data('url');
            }
            $elem.addClass('big');
        }
    </script>
@else
    <script src="{{ mix('/js/app.js') }}"></script>

    <script>
        $(document).ready(function(){
            $('.bg-wrapper-overlay').height($(document).height());
            $(".fold-btn").click(function(e){
                $(e.target).parent().removeClass('folded');
            });
        });
    </script>
@endif


