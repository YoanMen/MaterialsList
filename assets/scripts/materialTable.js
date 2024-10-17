import DataTable from 'datatables.net-dt';
import "datatables.net-dt/css/dataTables.dataTables.min.css"


document.addEventListener("DOMContentLoaded", () => {
  const table = new DataTable('#tableMaterials', {
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

  function openModal(id) {
    alert(id);
  }

  async function decrement(id) {
    try {
      await fetch(`/material/${id}/decrement`, {
        method: "POST"
      }).then(() => table.ajax.reload(null, false));
    } catch (error) {
      console.error(error.message);
    }
  }

  window.openModal = openModal;
  window.decrement = decrement;


})


