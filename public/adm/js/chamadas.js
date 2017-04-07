$(document).ready(function () {
    $(document).on('click', '.detalhesChamada', (function (){
        $('#detalhesChamadas'+$(this).attr('iid')).modal();
    }));
});
