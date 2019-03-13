$(document).ready(function () {
    $(document).on('change', '.switcher-slider input', function () {
        var inp = $(this);
        $.request('onSwitchInList', {
            data: {
                value: inp.prop('checked'),
                model: inp.data()
            },
            error: function (response) {
                inp.prop("checked", !inp.prop("checked"));
                $.oc.flashMsg({text: response.responseText, class: 'error'});
            }
        });
    })
});