$(function() {
     $('.confirmation').on('click', function (e) {
         var msg = $(e.currentTarget).data("confirmation");
         if (msg == '') {
            msg = "Ali si prepričan";
         }
         return confirm(msg);
     });
});
