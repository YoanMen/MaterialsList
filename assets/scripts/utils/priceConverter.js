function changeTTCcalculHT(ttc, tva) {
  const result = ttc / (1 + tva);

  return result.toFixed(2);
}

function changeHTcalculTTC(ht, tva) {
  const result = ht * (1 + tva);

  return result.toFixed(2);
}
export const priceConverter = { changeTTCcalculHT, changeHTcalculTTC }