import './bootstrap';
import 'flowbite';

export function setupDeleteItemForms() {
    document.querySelectorAll("[data-delete-form]").forEach(form => {
        form.addEventListener("submit", function(event) {
            event.preventDefault(); // Standardverhalten verhindern

            fetch(this.action, {
                method: "POST",
                body: new FormData(this),
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                }
            }).then(response => {
                if (response.ok) {
                    location.reload(); // Erfolgreich -> Seite neu laden
                } else {
                    alert("Fehler beim Löschen!");
                }
            }).catch(error => console.error("Fehler:", error));
        });
    });
}
