import DataTable from 'datatables.net-dt';
import "datatables.net-dt/css/dataTables.dataTables.min.css"

document.addEventListener("DOMContentLoaded", () => {

  const modal = document.getElementById('modal')
  const modalContent = document.getElementById('modal-content');
  const closeBtn = document.getElementById('modal-close');

  closeBtn.addEventListener('click', () => modal.close())

  // datatable
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

  // listener clicks on table and set action depending attribute name
  document.getElementById('tableMaterials').addEventListener("click", (event) => {
    const id = event.target.dataset.material;

    if (event.target.hasAttribute('decrement-action')) {
      decrement(id)
    }

    if (event.target.hasAttribute('show-action')) {
      showDetail(id);
    }
  })

  async function showDetail(id) {
    modalContent.innerHTML = '';

    const loadingElement = document.createElement('p');
    loadingElement.innerText = 'loading...';
    modalContent.appendChild(loadingElement);

    modal.showModal();

    const material = await getMaterial(id);

    modalContent.innerHTML = '';

    const pdfElement = document.createElement('a');
    pdfElement.innerText = 'pdf';
    pdfElement.href = `material/${id}/pdf`;

    const nameElement = document.createElement('p');
    nameElement.innerText = material.data.name;

    const quantityElement = document.createElement('p');
    quantityElement.innerText = 'quantité : ' + material.data.quantity;

    const createdAtElement = document.createElement('p');
    createdAtElement.innerText = 'Crée le : ' + material.data.createdAt;

    const priceHTElement = document.createElement('p');
    priceHTElement.innerText = 'HT : ' + material.data.priceHT + ' €';

    const priceTTCElement = document.createElement('p');
    priceTTCElement.innerText = 'TTC : ' + material.data.priceTTC + ' €';

    const tvaElement = document.createElement('p');
    tvaElement.innerText = 'TVA : ' + material.data.tva.label;

    const editElement = document.createElement('a');
    editElement.innerText = 'modifier';
    editElement.href = `/material/${id}`;

    modalContent.appendChild(pdfElement);
    modalContent.appendChild(nameElement);
    modalContent.appendChild(quantityElement);
    modalContent.appendChild(createdAtElement);
    modalContent.appendChild(priceHTElement);
    modalContent.appendChild(priceTTCElement);
    modalContent.appendChild(tvaElement);
    modalContent.appendChild(editElement);

  }

  async function decrement(id) {
    const tokenCsrf = document.getElementById('token-csrf').value;

    try {
      await fetch(`/material/${id}/decrement`, {
        method: "POST",
        headers: {
          'Accept': 'application/json',
        },
        body: JSON.stringify({
          tokenCsrf
        })
      }).then(() => table.ajax.reload(null, false));
    } catch (error) {
      console.error(error.message);
    }
  }

  async function getMaterial(id) {
    try {
      const response = await fetch(`/api/material/${id}`, {
        method: "POST", headers: {
          'Accept': 'application/json',
        },
      });

      if (!response) {
        throw new Error(`Response status: ${response.status}`);
      }

      const json = await response.json();

      return json;

    } catch (error) {
      console.error(error.message);
      return null;
    }
  }

})


