<!--Flatpickr |  Inclure les fichiers CSS et JS de Flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Input -->
<input type="text" class="form-control" id="datepicker" name="datePicker_start" placeholder="Start date" required>

<!-- Script pour initialiser Flatpickr -->
<script>
    flatpickr("#datepicker", {
        dateFormat: "d.m.Y",  // Format de la date
        inline: true          // Afficher le calendrier inline
    });
</script>





<!-- Pikaday | Inclure les fichiers CSS et JS de Pikaday -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>

<!-- Input -->
<input type="text" class="form-control" id="datepicker" name="datePicker_start" placeholder="Start date" required>

<!-- Script pour initialiser Pikaday -->
<script>
    new Pikaday({
        field: document.getElementById('datepicker'),
        format: 'DD.MM.YYYY'  // Format de la date
    });
</script>



