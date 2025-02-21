import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['section']
    static values = {
        anchor: String
    }

    connect() {
        // On capture les liens de la navbar
        this.navLinks = this.element.querySelectorAll('.cyber-link');
        this.navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = link.textContent.toLowerCase();
                const targetSection = document.getElementById(targetId);
                if (targetSection) {
                    targetSection.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    }
}