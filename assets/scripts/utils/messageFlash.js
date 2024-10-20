
export default function messageFlash(message, type = "alert-error") {
  const alert = document.createElement('div');
  const text = document.createElement('p');
  alert.className = `alert ${type}`;
  text.innerText = message;

  alert.appendChild(text);
  document.body.appendChild(alert);

  setTimeout(() => {
    alert.remove();
  }, 4000)

}