$(document).ready(function() {
    $(function() {
        var hasInitialImage = false;
        var updatedImage = false;
        
        $("#furColour").select2({
            'placeholder' : 'Fellfarbe...',
        });
        $("#eyeColour").select2({
            'placeholder' : 'Augenfarbe...',
        });

        $("#saveAnimalBtn").click(function() {
            var image = $("#animalImg")[0].files[0];
            var imageData = new FormData();

            if (image !== undefined && updatedImage) {
                imageData.append('image', image);
            }

            imageData.append('actionCode', 13);
            imageData.append('animal', $('#animalId').val());
            imageData.append('name', $('#callingName').val());
            imageData.append('birthDay', $('#birthDay').val());
            imageData.append('sex', getCheckedSex());
            imageData.append('furColour', $("#furColour").val());
            imageData.append('eyeColour', $("#eyeColour").val());
            imageData.append('race', $("#race").val());
            imageData.append('species', $("#species").val());
            imageData.append('size', $('#weight').val());
            imageData.append('specification', $("#specification").val());
            imageData.append('hasInitialImage', hasInitialImage);

            $(this).attr("disabled");

            $.ajax({
                url : "php/routingHandler.php",
                type : "POST",
                data : imageData,
                processData : false,
                contentType : false,
                always : function(result) {
                    $(this).removeAttr('disabled');
                }
            });
        });

        $("#animalOverviewBtn").click(function() {
            ajaxCall('php/routingHandler.php', {
                'actionCode' : "9"
            }).done(function(result) {
                $('#content').html(result);
            });
        });

        $("#animalImg").change(function(e) {
            var files = e.target.files[0]; // FileList object
            var reader = new FileReader();

            // Closure to capture the file information.
            reader.onload = function(theFile) {
                updatedImage = true;
                $('#animalPreview').attr("src", theFile.target.result);
                $("#removeImage").show();
            };

            // Read in the image file as a data URL.
            reader.readAsDataURL(files);
        });
        
        $("#removeImage").click(function() {
            $('#animalPreview').attr("src", 'pictures/placeholder.png');
            $(this).hide();
        });

        function formatRepo(repo) {
            return repo.text;
        }

        function formatRepoSelection(repo) {
            return repo.text;
        }

        $('#race').select2({
            placeholder : "Rasse auswählen...",
            ajax : {
                url : 'php/routingHandler.php',
                dataType : 'json',
                type : 'POST',
                allowClear : true,
                quietMillis : 100,
                data : function(term, page) { // page is the one-based
                    // page number tracked
                    // by Select2
                    return {
                        val : term, // search term
                        pageLimit : 10, // page size
                        page : page, // page number
                        actionCode : 6
                    };
                },
                results : function(data, page) {
                    var more = (page * 10) < data.total; // whether
                    // or not
                    // there are
                    // more
                    // results
                    // available
                    // notice we return the value of more so Select2
                    // knows if more results can be loaded
                    return {
                        results : data,
                        more : more
                    };
                }
            },

            initSelection : function(element, callback) {
                var race = {
                    'id' : $(element).val(),
                    'text' : (element).data('name')
                };
                callback(race);
            },

            formatResult : formatRepo, // omitted for brevity, see the
            // source of this page
            formatSelection : formatRepoSelection
        });

        $('#species').select2({
            placeholder : "Tierart auswählen...",
            ajax : {
                url : 'php/routingHandler.php',
                dataType : 'json',
                type : 'POST',
                allowClear : true,
                quietMillis : 100,
                data : function(term, page) { // page is the one-based
                    // page number tracked
                    // by Select2
                    return {
                        val : term, // search term
                        pageLimit : 10, // page size
                        page : page, // page number
                        actionCode : 12
                    };
                },
                results : function(data, page) {
                    var more = (page * 10) < data.total; // whether
                    // or not
                    // there are
                    // more
                    // results
                    // available
                    // notice we return the value of more so Select2
                    // knows if more results can be loaded
                    return {
                        results : data,
                        more : more
                    };
                }
            },

            initSelection : function(element, callback) {
                var species = {
                    'id' : $(element).val(),
                    'text' : (element).data('name')
                };
                callback(species);
            },

            formatResult : formatRepo, // omitted for brevity, see the
            // source of this page
            formatSelection : formatRepoSelection
        });

        /*
         * $("#species").select2({ initSelection : function(element, callback) {
         * var elementText = $(element).attr('data-init-text'); var elementId =
         * $(element).attr('data-init-id'); callback({ id : elementId, }); },
         * ajax : { url : "php/routingHandler.php", dataType : 'json', delay :
         * 250, type : 'POST', data : function(term, page) { return { term :
         * term, actionCode : 12 }; }, results : function(data) { return {
         * results : data }; }, cache : true }, escapeMarkup : function(markup) {
         * return markup; }, formatResult : formatRepo, // omitted for brevity,
         * see // the // source of this page formatSelection :
         * formatRepoSelection, // omitted for // brevity, // see the source of //
         * this page placeholder : "Tierart auswählen...", allowClear : true });
         */

        $('#birthDay').datetimepicker({
            locale : 'de-DE',
            format : 'DD.MM.YYYY'
        });
    });
});

function getCheckedSex() {
    return $('#sexGroup .active input[type=radio]').val();
}