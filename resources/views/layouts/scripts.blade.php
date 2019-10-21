<script src="/js/app.js"></script>

<script>
    $(document).ready(function(){
        $('.bg-wrapper-overlay').height($(document).height());
        $(".fold-btn").click(function(e){
            $(e.target).parent().removeClass('folded');
        });
    });
</script>
