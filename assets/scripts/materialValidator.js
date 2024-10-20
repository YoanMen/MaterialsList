import { priceConverter } from "priceConverter";

const inputPriceHT = document.getElementById('material_priceHT')
const inputPriceTTC = document.getElementById('material_priceTTC')
const inputTVA = document.getElementById('material_tva')
inputTVA.addEventListener("change", updateTVA);
inputPriceTTC.addEventListener("input", updateTTC)
inputPriceHT.addEventListener("input", updateHT)

async function getTVA() {
  // fetch tva value with id
  const response = await fetch(`/api/tva/${inputTVA.value}`, {
    method: 'GET',
    headers: {
      'Accept': 'application/json',
    },
  })

  if (!response) {
    throw new Error(`Response status: ${response.status}`);
  }

  const json = await response.json();

  if (!json.success) {
    throw new Error(`Erreur: ${json.error}`);
  }

  return json;
}

export async function updateHT() {
  const tva = await getTVA();
  const tvaValue = parseFloat(tva.data);
  const ht = parseFloat(inputPriceHT.value);

  const result = priceConverter.changeHTcalculTTC(ht, tvaValue);
  inputPriceTTC.value = (result === 'NaN' ? "TTC non valide" : result);
}

export async function updateTTC() {
  const tva = await getTVA();
  const tvaValue = parseFloat(tva.data);
  const ttc = parseFloat(inputPriceTTC.value);

  const result = priceConverter.changeTTCcalculHT(ttc, tvaValue);
  inputPriceHT.value = (result === 'NaN' ? "HT non valide" : result);
}

export async function updateTVA() {
  updateHT();
}

