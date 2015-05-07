$(document).ready(function() {
    ajaxCall('http://localhost/marcel/ums/index.php?action=1', {'actionm': 2}).success(function(result) {
        $('#contentPlaceHolder').html(result);
    });

    $("[data-serverAction]").click(function() {
        ajaxCall('php/routingHandler.php', {'actionCode': $(this).attr("data-serverAction")}).success(function(result) {
            $('#mainContainer').html(result);
        });
    });

    $(".mapAction").click(function() {
        //$('#choseModal').modal('hide');
        getMarkerModal();
    });
    
    $.fn.modal.Constructor.prototype.enforceFocus = function () {
        var that = this;
        $(document).on('focusin.modal', function (e) {
           if ($(e.target).hasClass('select2-input')) {
              return true;
           }

           if (that.$element[0] !== e.target && !that.$element.has(e.target).length) {
              that.$element.focus();
           }
        });
     };
});
