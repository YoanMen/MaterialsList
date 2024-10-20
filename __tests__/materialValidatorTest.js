import { priceConverter } from "../assets/scripts/utils/priceConverter";

test('calcul HT from TTC', async () => {
  const result = priceConverter.changeTTCcalculHT(164.20, 0.200)
  expect(result).toBe('136.83');
});

test('calcul TTC from HT', async () => {
  const result = priceConverter.changeHTcalculTTC(45.45, 0.100)
  expect(result).toBe('50.00');
});