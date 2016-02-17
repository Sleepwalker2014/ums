$(document).ready(function() {
    $(".editAnimal").click(function() {
        editAnimal($(this).data('animal'));
    });

    $(".searchAnimal").click(function() {
        ajaxCall('php/routingHandler.php', {
            'actionCode' : "15",
            'animalId' : $(this).data('animal')
        }).done(function(result) {
            $('#content').html(result);
        });
    });
    
    $(".removeAnimal").click(function() {
        ajaxCall('php/routingHandler.php', {
            'actionCode' : "19",
            'animalId' : $(this).data('animal')
        }).done(function(result) {
        	$(this).closest('.removable').remove();
        });
    });

    $(".printAnimal").click(function() {
        window.print();
    });
});

function editAnimal(animalId) {
    ajaxCall('php/routingHandler.php', {
        'actionCode' : "10",
        'animal' : animalId
    }).done(function(result) {
        $('#content').html(result);
    });
}

function removeItem(item) {
    item.remove();
}