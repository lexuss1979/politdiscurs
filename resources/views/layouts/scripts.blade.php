@if(Route::current()->getName() == 'main')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="/js/materialize.min.js"></script>
    <script>
        $(document).ready(function(){
           initCarousel('magazines');
           initCarousel('books');
        });

        function enlarge(parent,id){
            let $elem = $(parent + ' .carousel-item.active');
            if($elem.hasClass('big') && id === $elem.data('mgid')){
                $elem.removeClass('big');
            } else {
                $elem.addClass('big');
            }

        }

        function goto(parent,id){
            let $elem = $(parent + ' .carousel-item.active');
            if( id === $elem.data('mgid')){
                window.location.href=$elem.data('url');
            }

        }

        function initCarousel(selector){
            let magEl = $('.'+selector+'  .carousel');
            document[selector+'Car'] = M.Carousel.init(magEl, {
                numVisible:7,
                dist: -25,
                padding: 20,
                shift: 10
            })[0];
            $('.'+selector+' .left-btn').on('click',function(){
                document[selector+'Car'].next();
            });
            $('.'+selector+' .right-btn').on('click',function(){
                document[selector+'Car'].prev();
            });
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

            $('.pagination .current> input').keyup(function(event){
                if(event.keyCode == 13){
                    event.preventDefault();
                    let $el = $(event.target);
                    let wanted = $el.val();
                    let total = $el.data('total');
                    if(wanted > 0 && wanted <= total){
                        let url = $el.data('route').replace('page=' + $el.data('current'), 'page=' + wanted);
                        window.location.href=url;
                    }
                }
            });
        });


    </script>
@endif

<script>
    (function($){
        $(function ($) {
            $(window)
                .scroll(function() { updateBackground(false); })
                .resize(function() { updateBackground(true); });
        });

        function updateBackground(AForceUpdate)
        {
            var lBGHeigt = 2416;
            var lWinH = $(window).height();
            var lPos, lAttachment;
            var lNeedFixBG = $(window).scrollTop() + lWinH > lBGHeigt;
            var lPrevFixedState = $(window).data('BGFixed');
            if (AForceUpdate
                || lPrevFixedState === undefined
                || lPrevFixedState != lNeedFixBG)
            {
                if (lNeedFixBG)
                {
                    lPos = '50% ' + (lWinH - lBGHeigt) + 'px';
                    lAttachment = 'fixed';
                }
                else
                {
                    lPos = 'top center';
                    lAttachment = 'scroll';
                }

                $('body').css({
                    'background-position': lPos,
                    'background-attachment': lAttachment
                });

                $(window).data('BGFixed', lNeedFixBG);
            }
        }
    })(jQuery);
</script>


