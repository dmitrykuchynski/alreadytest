import '../../styles/gutenberg/offers-section.scss';

document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.offer-card__more-btn');

    buttons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const offerCard = btn.closest('.offer-card');
            const details = offerCard.querySelector('.offer-card__details');
            const paymentsIcons = offerCard.querySelector('.offer-card__payments-icons');
            const paymentsWrapper = offerCard.querySelector('.offer-card__payments');
            const chevronIcon = btn.querySelector('i');
            const textNode = btn.firstChild;

            if (!details) return;

            const isVisible = details.classList.contains('is-visible');

            if (isVisible) {
                details.classList.remove('is-visible');
                btn.classList.remove('is-rotated');
                if (paymentsIcons) paymentsIcons.classList.remove('is-visible');
                if (paymentsWrapper) paymentsWrapper.classList.remove('is-visible');

                textNode.textContent = 'More info ';
                chevronIcon.classList.remove('fa-chevron-up');
                chevronIcon.classList.add('fa-chevron-down');
            } else {
                details.classList.add('is-visible');
                btn.classList.add('is-rotated');
                if (paymentsIcons) paymentsIcons.classList.add('is-visible');
                if (paymentsWrapper) paymentsWrapper.classList.add('is-visible');

                textNode.textContent = 'Hide info ';
                chevronIcon.classList.remove('fa-chevron-down');
                chevronIcon.classList.add('fa-chevron-up');
            }
        });
    });
});
