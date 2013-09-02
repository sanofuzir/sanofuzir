$(function() {
     $('.confirmation').on('click', function (e) {
         var msg = $(e.currentTarget).data("confirmation");
         if (msg == '') {
            msg = "Ali si prepričan";
         }
         return confirm(msg);
     });
});

$(document).ready(function () {
        $('ul.menu > li').click(function (e) {
            //e.preventDefault();
            $('ul.menu > li').removeClass('active');
            $(this).addClass('active');                
        });            
    });