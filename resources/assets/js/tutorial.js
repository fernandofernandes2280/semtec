
//carrega pagina ao iniciar
$(function(){
    $("#conteudo").load('comandosql_importante.php');
});
//carrega comandos sql ao clicar no link
$("ul#menu a").click(function(){
    pagina = $(this).attr('href');
    $("#conteudo").loasd(pagina);
    //desabilita o link
    return false
});
