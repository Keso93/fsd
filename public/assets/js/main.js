$(document).ready(function () {
    $(".dropdown-trigger").dropdown({
        hover: true
    });
});

$(document).ready(function() {
    $('.js-example-basic-multiple').select2({
        placeholder: "Select a title"
    });;
});

$(document).ready(function(){
    $('select:not(.js-example-responsive)').formSelect();
});

$(document).ready(function() {
    $('.js-example-responsive').select2();
});

var adapter = {
    post: function (route, data, successFn, ctx) {
        $.ajax({
            type: "POST",
            url: route,
            data: JSON.stringify(data),
            success: function (data) {
                successFn(data, ctx);
            },
            contentType:"application/json; charset=utf-8",
            dataType:'json'
        });
    },
    delete: function (route, data, successFn, ctx) {
        $.ajax({
            type: "DELETE",
            url: route,
            data: JSON.stringify(data),
            success: function (data) {
                successFn(data, ctx);
            },
            contentType:"application/json; charset=utf-8",
            dataType:'json'
        });
    }
};

var validator = {
    empty: function (val) {
        return val.length === 0;
    }
};






