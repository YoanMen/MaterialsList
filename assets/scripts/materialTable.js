import DataTable from 'datatables.net-dt';
import 'datatables.net-responsive'
import { fetchMaterial } from 'fetchMaterial';

const modal = document.getElementById('modal')
const modalName = document.getElementById('modal-name');
const modalQuantity = document.getElementById('modal-quantity');
const modalCreatedAt = document.getElementById('modal-createdAt');
const modalHT = document.getElementById('modal-ht');
const modalTTC = document.getElementById('modal-ttc');
const modalTVA = document.getElementById('modal-tva');
const modalCloseBtn = document.getElementById('modal-close');
const modalEditBtn = document.getElementById('modal-edit');
const modalExportBtn = document.getElementById('modal-export');

modal.addEventListener('click', (event) => {
  const dialogDimensions = modal.getBoundingClientRect()
  if (event.clientX < dialogDimensions.left ||
    event.clientX > dialogDimensions.right ||
    event.clientY < dialogDimensions.top ||
    event.clientY > dialogDimensions.bottom) {
    modal.close();
  }
})

modalCloseBtn.addEventListener('click', () => modal.close())


// datatable
const table = new DataTable('#tableMaterials', {
  responsive: true,
  scrollY: '60vh',
  columnDefs: [
    { orderable: false, targets: [6, 7] },
    { responsivePriority: 1, targets: [6, 7] },
    {
      targets: 0,
      className: 'table__name'
    },
    {
      targets: 1,
      className: 'center-text'
    }
  ],
  language: {
    "decimal": "",
    "emptyTable": "Aucune données disponible",
    "info": "Affichage de <strong>_START_</strong> à <strong>_END_</strong> sur <strong>_TOTAL_</strong>",
    "infoEmpty": "Affichage de 0 à 0 sur 0 entrées",
    "infoFiltered": "(filtré à partir de _MAX_ entrées totales)",
    "infoPostFix": "",
    "thousands": ",",
    "lengthMenu": "Afficher _MENU_ matériels",
    "loadingRecords": "",
    "search": "",
    "searchPlaceholder": 'Rechercher un produit',
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

// listener clicks on table and set action depending attribute name
document.getElementById('tableMaterials').addEventListener("click", (event) => {
  const id = event.target.dataset.material;

  if (event.target.hasAttribute('decrement-action')) {
    fetchMaterial.decrement(id).then(() => table.ajax.reload(null, false)
    );
  }

  if (event.target.hasAttribute('show-action')) {
    showDetail(id);
  }
})

async function showDetail(id) {

  await fetchMaterial.getMaterial(id).then((material) => {

    modalName.innerText = material.data.name;
    modalQuantity.innerText = material.data.quantity;
    modalCreatedAt.innerText = material.data.createdAt;
    modalHT.innerText = material.data.priceHT + ' €';
    modalTTC.innerText = material.data.priceTTC + ' €';
    modalTVA.innerText = material.data.tva.label;
    modalEditBtn.href = `material/${id}`;
    modalExportBtn.href = `material/${id}/pdf`;

    modal.showModal();

  }).catch(() => modal.close());

}

