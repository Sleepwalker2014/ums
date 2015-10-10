$(document).ready(function() {
    $(".editAnimal").click(function() {
        editAnimal($(this).data('animal'));
    });

    $(".searchAnimal").click(function() {
        alert("muh");
    });


/*    $(".removable").click(function() {
        removeItem($(this));
    });*/
});

function editAnimal(animalId) {
    ajaxCall('php/routingHandler.php', {'actionCode': "10", 'animal': animalId}).done(function(result) {
        $('#content').html(result);
    });
}

function removeItem(item) {
    item.remove();
}