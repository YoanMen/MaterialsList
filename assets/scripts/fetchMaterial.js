import messageFlash from 'messageFlash';

export async function decrement(id) {
  const tokenCsrf = document.getElementById('token-csrf').value;
  try {
    const response = await fetch(`/material/${id}/decrement`, {
      method: "POST",
      headers: {
        'Accept': 'application/json',
      },
      body: JSON.stringify({
        tokenCsrf
      })
    });

    if (!response.ok) {
      throw new Error(`Response status: ${response.status}`);
    }

    messageFlash("Le matériel a été décrémenté", "alert-success")

  } catch (error) {
    messageFlash("erreur : " + error.message)
    console.error(error.message);

  }
}

export async function getMaterial(id) {
  try {
    const response = await fetch(`/api/material/${id}`, {
      method: "POST", headers: {
        'Accept': 'application/json',
      },
    });

    if (!response.ok) {
      throw new Error(`Response status: ${response.status}`);
    }

    const json = await response.json();

    if (!json.success) {
      throw new Error(`Erreur: ${json.error}`);
    }

    return json;

  } catch (error) {
    console.error(error.message);
    messageFlash("impossible de récupéré le matériel : " + error.message)
  }
}

export const fetchMaterial = { getMaterial, decrement }