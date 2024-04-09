import './bootstrap';

// Méthode ES6 (utilisant import)
import Swal from 'sweetalert2';
window.Swal = Swal;


document.addEventListener('DOMContentLoaded', function() {
    function toggleDropdown(dropdownId ) {
        const dropdown = document.getElementById(dropdownId);
        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
        } else {
            // Sinon, cacher le menu
            dropdown.classList.add('hidden');
        }
    }

    /********menu deroulant eleves inscrits pour incription*******/

    // Écouteur d'événement pour ouvrir/fermer le menu déroulant lors du clic sur le bouton
    const menuDeroulantInscrit = document.getElementById('dropdownBoutonFiltreInscrit');
    if(menuDeroulantInscrit){
        menuDeroulantInscrit.addEventListener('click', function() {
            toggleDropdown('dropdownFiltreInscrit');
        });

        // Ajouter des écouteurs d'événements pour mettre à jour le texte du bouton lors de la sélection d'une option
        const dropdownItems1 = document.querySelectorAll('#dropdownFiltreInscrit a');
        dropdownItems1.forEach(function(item) {
            item.addEventListener('click', function() {
                const selectedOptionText = item.textContent.trim(); // Récupérer le texte de l'option sélectionnée
                toggleDropdown('dropdownFiltreInscrit'); // Cacher le menu déroulant après la sélection*/

            });
        });
    }



    /*******menu deroulant niveau pour incription**********/

    // Écouteur d'événement pour ouvrir/fermer le menu déroulant lors du clic sur le bouton
    const menuDeroulantNiveau = document.getElementById('dropdownBoutonFiltreNiveau');
    if(menuDeroulantNiveau){
        menuDeroulantNiveau.addEventListener('click', function() {
            toggleDropdown('dropdownFiltreNiveau');
        });

        // Ajouter des écouteurs d'événements pour mettre à jour le texte du bouton lors de la sélection d'une option
        const dropdownItems2 = document.querySelectorAll('#dropdownFiltreNiveau a');
        dropdownItems2.forEach(function(item) {
            item.addEventListener('click', function() {
                const selectedOptionText = item.textContent.trim(); // Récupérer le texte de l'option sélectionnée
                toggleDropdown('dropdownFiltreNiveau'); // Cacher le menu déroulant après la sélection
            });
        });
    }


    /******menu deroulant affecter ou non affecter pour affectaion*****/

    // Écouteur d'événement pour ouvrir/fermer le  menu déroulant lors du clic sur le bouton
    const menuDeroulantAffecter = document.getElementById('dropdownBoutonFiltreAffecter');
    if(menuDeroulantAffecter){
        menuDeroulantAffecter.addEventListener('click', function() {
            toggleDropdown('dropdownFiltreAffecter');
        });

        // Ajouter des écouteurs d'événements pour mettre à jour le texte du bouton lors de la sélection d'une option
        const dropdownItems3 = document.querySelectorAll('#dropdownFiltreAffecter a');
        dropdownItems3.forEach(function(item) {
            item.addEventListener('click', function() {
                const selectedOptionText = item.textContent.trim(); // Récupérer le texte de l'option sélectionnée
                toggleDropdown('dropdownFiltreAffecter'); // Cacher le menu déroulant après la sélection
            });
        });
    }




    /******menu deroulant filtrer par classe pour affectaion*****/

    // Écouteur d'événement pour ouvrir/fermer le  menu déroulant lors du clic sur le bouton
    const menuDeroulantClasse = document.getElementById('dropdownBoutonFiltreClasse');
    if(menuDeroulantClasse){
        menuDeroulantClasse.addEventListener('click', function() {
            toggleDropdown('dropdownFiltreClasse');
        });

        // Ajouter des écouteurs d'événements pour mettre à jour le texte du bouton lors de la sélection d'une option
        const dropdownItems4 = document.querySelectorAll('#dropdownFiltreClasse a');
        dropdownItems4.forEach(function(item) {
            item.addEventListener('click', function() {
                const selectedOptionText = item.textContent.trim(); // Récupérer le texte de l'option sélectionnée
                toggleDropdown('dropdownFiltreClasse'); // Cacher le menu déroulant après la sélection
            });
        });
    }


    /**** fermer le menu deroulant lors d'un click a l'exterieur */

    // Ajouter un écouteur d'événement supplémentaire si vous souhaitez fermer les menus déroulants lorsque l'utilisateur clique en dehors de ceux-ci
    document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('.dropdown');
        dropdowns.forEach(function(dropdown) {
            const dropdownButton = document.getElementById(dropdown.dataset.dropdownToggle);
            if (!dropdown.contains(event.target) && event.target !== dropdownButton) {
                dropdown.classList.add('hidden');
            }
        });
    });
});




