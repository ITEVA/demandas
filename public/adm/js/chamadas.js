$(document).ready(function () {
    $('.detalhesChamada').click(function(){
        $('#detalhesChamadas'+$(this).attr('iid')).modal();

    });
});