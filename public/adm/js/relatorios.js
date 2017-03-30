$(document).ready(function () {
    $('#imprimirUsuarios').click(function(){
        $('#filtro').attr('action', 'relatorios/usuarios/imprimir');
        $('#filtro').attr('target', '_blank');
        $('#filtro').submit();
        $('#filtro').attr('action', 'relatorios/usuarios');
        $('#filtro').attr('target', '_self');
    });

    $('#imprimirChamadas').click(function(){
        $('#filtro').attr('action', 'relatorios/chamadas/imprimir');
        $('#filtro').attr('target', '_blank');
        $('#filtro').submit();
        $('#filtro').attr('action', 'relatorios/chamadas');
        $('#filtro').attr('target', '_self');
    });
});