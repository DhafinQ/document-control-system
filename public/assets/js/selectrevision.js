$(document).ready(function() {
    var oldSelections = JSON.parse(document.getElementById('oldSelections').value);
    var selectedOption = document.getElementById('selectedOption').value;
    var categoryDocElement = document.getElementById('categoryDoc');
    if (categoryDocElement) {
        var categoryDoc = categoryDocElement.value;
    }

    // Function to format the initial selections
    function formatInitialSelections(data) {
        return data.map(function(doc) {
            return {
                id: doc.id,
                text: doc.title
            };
        });
    }

    if (oldSelections && oldSelections.length > 0) {
        $.ajax({
            url: '/documents_category',
            dataType: 'json',
            data: {
                ids: oldSelections.join(',')
            },
            success: function(data) {
                var initialSelections = formatInitialSelections(data);
                $('#my-select').select2({
                    data: initialSelections,
                    ajax: {
                        url: '/documents_category',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            var queryParameters = {
                                q: params.term,
                            };
                            
                            if (selectedOption) {
                                queryParameters.id = selectedOption;
                            }

                            if(categoryDoc){
                                queryParameters.categoryID = categoryDoc;
                            }

                            return queryParameters;
                        },
                        processResults: function(data) {
                            return {
                                results: data.map(function(doc) {
                                    return {
                                        id: doc.id,
                                        text: doc.title
                                    };
                                })
                            };
                        },
                        cache: true
                    },
                    placeholder: 'Select documents',
                    allowClear: true,
                    multiple: true,
                    minimumInputLength: 3
                });

                // Set the initial selections
                $('#my-select').val(oldSelections).trigger('change');
                isChecked = true;
            },
            error: function(error) {
                console.error('Error fetching initial selections:', error);
            }
        });
    } else {
        console.log(categoryDoc);
        $('#my-select').select2({
            ajax: {
                url: '/documents_category',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    var queryParameters = {
                        q: params.term
                    };
                    if(categoryDoc){
                        queryParameters.categoryID = categoryDoc;
                    }

                    if (selectedOption) {
                        queryParameters.id = selectedOption;
                    }

                    console.log('queryParameters:', queryParameters);
                    
                    return queryParameters;
                },
                processResults: function(data) {
                    return {
                        results: data.map(function(doc) {
                            return {
                                id: doc.id,
                                text: doc.title
                            };
                        })
                    };
                },
                cache: true
            },
            placeholder: 'Select documents',
            allowClear: true,
            multiple: true,
            minimumInputLength: 3
        });
    }
});
