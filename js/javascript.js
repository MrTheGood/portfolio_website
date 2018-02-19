$(document).ready(function () {
    $(".expandable").hide();

    $(".expander").click(function () {
        $(this).toggleClass('rotated');
        $(this).parent().prev().children(".expandable:first").slideToggle(300);
    });
});