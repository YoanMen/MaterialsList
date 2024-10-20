
export default function messageFlash(message, type = "alert-error") {
  const alert = document.createElement('div')
  alert.className = `alert ${type}`;
  alert.innerText = message;

  document.body.appendChild(alert);

  setTimeout(() => {
    alert.remove();
  }, 4000)

}