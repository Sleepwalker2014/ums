$(document).ready(
        function() {
            $(function() {
                $("#furColour").select2({
                    'placeholder' : 'Fellfarbe...',
                });
                $("#eyeColour").select2({
                    'placeholder' : 'Augenfarbe...',
                });

                $("#saveAnimalBtn").click(
                        function() {
                            $(this).attr("disabled");
                            var postData = {
                                'actionCode' : "13",
                                'animal' : $('#animalId').val(),
                                'name' : $('#callingName').val(),
                                'birthDay' : $('#birthDay').val(),
                                'sex' : getCheckedSex(),
                                'furColour' : $("#furColour").val(),
                                'eyeColour' : $("#eyeColour").val(),
                                'race' : $("#race").val(),
                                'species' : $("#species").val(),
                                'size' : $('#weight').val(),
                                'specification' : $("#specification").val()
                            };

                            ajaxCall('php/routingHandler.php', postData)
                                    .always(function(result) {
                                        $(this).removeAttr('disabled');
                                    });
                        });

                $("#animalOverviewBtn").click(function() {
                    ajaxCall('php/routingHandler.php', {
                        'actionCode' : "9"
                    }).done(function(result) {
                        $('#content').html(result);
                    });
                });

                function formatRepo(repo) {
                    return repo.text;
                }

                function formatRepoSelection(repo) {
                    return repo.text;
                }

                /*
                 * $("#race").select2({ initSelection : function(element,
                 * callback) { var elementText =
                 * $(element).attr('data-init-text'); var elementId =
                 * $(element).attr('data-init-id'); callback([{ id : elementId,
                 * text : "noob" }]); }, ajax : { url :
                 * "php/routingHandler.php", dataType : 'json', delay : 250,
                 * type : 'POST', data : function(term, page) { return { term :
                 * term, actionCode : 6 }; }, results : function(data) { return {
                 * results : data }; }, cache : true }, escapeMarkup :
                 * function(markup) { return markup; }, formatResult :
                 * formatRepo, // omitted for brevity, see // the // source of
                 * this page formatSelection : formatRepoSelection, // omitted
                 * for // brevity, // see the source of // this page placeholder :
                 * "Rasse auswählen...", allowClear : true });
                 */

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
                 * $("#species").select2({ initSelection : function(element,
                 * callback) { var elementText =
                 * $(element).attr('data-init-text'); var elementId =
                 * $(element).attr('data-init-id'); callback({ id : elementId,
                 * }); }, ajax : { url : "php/routingHandler.php", dataType :
                 * 'json', delay : 250, type : 'POST', data : function(term,
                 * page) { return { term : term, actionCode : 12 }; }, results :
                 * function(data) { return { results : data }; }, cache : true },
                 * escapeMarkup : function(markup) { return markup; },
                 * formatResult : formatRepo, // omitted for brevity, see // the //
                 * source of this page formatSelection : formatRepoSelection, //
                 * omitted for // brevity, // see the source of // this page
                 * placeholder : "Tierart auswählen...", allowClear : true });
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