//import * as $ from "jquery";
import "datatables";

export default (function() {
    $("#dataTable").DataTable({
        order: [[0, "desc"]],
        language: {
            sEmptyTable: "Nenhum registro encontrado",
            sProcessing: "Processando...",
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "Não foram encontrados resultados",
            sInfo: "Mostrando de _START_ até _END_ de _TOTAL_ registos",
            sInfoEmpty: "Mostrando de 0 até 0 de 0 registos",
            sInfoFiltered: "(filtrado de _MAX_ registos no total)",
            sInfoPostFix: "",
            sSearch: "Procurar",
            sUrl: "",
            oPaginate: {
                sFirst: "Primeiro",
                sPrevious: "Anterior",
                sNext: "Seguinte",
                sLast: "Último"
            },
            oAria: {
                sSortAscending: ": Ordenar colunas de forma ascendente",
                sSortDescending: ": Ordenar colunas de forma descendente"
            }
        }
    });
})();
