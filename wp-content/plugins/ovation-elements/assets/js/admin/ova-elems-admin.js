document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('ov-template-search-input');
    const templateCards = document.querySelectorAll('.inner-cards');

    searchInput.addEventListener('input', function () {
        const query = this.value.trim().toLowerCase();
        let anyVisible = false;

        templateCards.forEach(card => {
            const title = card.getAttribute('data-title');
            if (title.includes(query)) {
                card.style.display = '';
                anyVisible = true;
            } else {
                card.style.display = 'none';
            }
        });

        document.getElementById('no-templates-found').style.display = anyVisible ? 'none' : 'block';
    });
});

// for tabs functionality 
document.addEventListener('DOMContentLoaded', function () {

    const cards = document.querySelectorAll('.inner-cards');
    const noResult = document.getElementById('no-templates-found');
    function render(category) {
        document.querySelectorAll('.template-target').forEach(t => t.innerHTML = '');
        let count = 0;

        cards.forEach(card => {
            if (category === 'all' || card.dataset.category === category) {
                document.querySelector('.template-target[data-target="' + category + '"]')
                    .appendChild(card);
                count++;
            }
        });

        noResult.style.display = count ? 'none' : 'block';
    }
    render('all');
    document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function (e) {
            render(e.target.getAttribute('href').replace('#', ''));
        });
    });

});


jQuery(document).ready(function ($) {
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab');

    if (tab === 'sliders') {
        $('#ova_elems_ovationSliderTabs a[href="#ova_elems_tab2"]').tab('show');
    } else {
        $('#ova_elems_ovationSliderTabs a[href="#ova_elems_tab5"]').tab('show'); 
    }
});