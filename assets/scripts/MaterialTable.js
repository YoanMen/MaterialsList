import $ from 'jquery'
import DataTable from 'datatables.net-dt';
import "datatables.net-dt/css/dataTables.dataTables.min.css"

$('#tableMaterials').DataTable({
  columnDefs: [
    { orderable: false, targets: [6, 7] }
  ],
  language: {
    "decimal": "",
    "emptyTable": "Aucune données disponible",
    "info": "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
    "infoEmpty": "Affichage de 0 à 0 sur 0 entrées",
    "infoFiltered": "(filtré à partir de _MAX_ entrées totales)",
    "infoPostFix": "",
    "thousands": ",",
    "lengthMenu": "Afficher _MENU_ matériels",
    "loadingRecords": "Chargement...",
    "search": "Rechercher un matériel :",
    "zeroRecords": "Aucun materiel trouvé",
    "paginate": {
      "first": "Début",
      "last": "Fin",
      "next": "Suivant",
      "previous": "Précédent"
    },
    "aria": {
      "orderable": "Trier la colonne",
      "orderableReverse": "Inverser l'ordre de la colonne"
    }
  },
  serverSide: true,
  processing: true,
  ajax: {
    url: '/api/material',
    method: 'POST'
  },
});
