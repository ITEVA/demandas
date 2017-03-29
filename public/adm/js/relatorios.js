$(document).ready(function () {
    $('#imprimirUsuarios').click(function(){
        $('#filtro').attr('action', 'relatorios/usuarios/imprimir');
        $('#filtro').attr('target', '_blank');
        $('#filtro').submit();
        $('#filtro').attr('action', 'relatorios/usuarios');
        $('#filtro').attr('target', '_self');
    });
});