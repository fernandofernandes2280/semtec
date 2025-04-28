window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple, {
            labels: {
                placeholder: "Pesquisar...",
                searchTitle: "Pesquisar na tabela",
                pageTitle: "Pág. {page}",
                perPage: "registros por página",
                noRows: "Nenhum entrada encontrada",
                info: "Exibindo {start} até {end} de {rows} registros",
                noResults: "Nenhum resultado correspondente a sua pesquisa",
            }

        });



    }
});

