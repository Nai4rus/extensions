function socalAuth(token) {
    $.getJSON("//ulogin.ru/token.php?host=" +
        encodeURIComponent(location.toString()) + "&token=" + token + "&callback=?",
        function (data) {
            data = $.parseJSON(data.toString());
            if (!data.error) {
                $.request('onSocialAuth', {
                    data: {
                        data: data
                    },
                });
            }
        });
}
