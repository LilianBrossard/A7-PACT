import {getUser} from "../../user.js";
import {createOpinionCard} from "../../cards.js";

function debounce(func, wait) {
    let timeout;
    return function () {
        const context = this;
        const args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), wait);
    }
}

// ---------------------------------------------------------------------------------------------- //
// Filters
// ---------------------------------------------------------------------------------------------- //

let filterButtons = document.querySelectorAll('.filters .button');

// Toggle the radio input when the button is clicked
for (let button of filterButtons) {
    let input = button.querySelector('input');
    button.addEventListener('click', () => {
        input.checked = !input.checked;

        if (input.value === "read" && input.checked) {
            read = false;
        } else {
            read = null;
        }

        resetCards();
        loadCards();
    })
}

// ---------------------------------------------------------------------------------------------- //
// Opinions loading
// ---------------------------------------------------------------------------------------------- //

let offset = 0;
let read = null;
let opinionsContainer = document.querySelector('.opinions-container');
let loaderSection = document.querySelector('#loader-section');
let user = null; // Represents the current authenticated user

// Create intersection observer on loader section
const observer = new IntersectionObserver((entries) => {
    if (entries[0].isIntersecting) {
        loadCards();
    }
}, {
    root: null,
    rootMargin: '0px',
    threshold: 1.
})

getUser().then(u => {
    user = u;
    observer.observe(loaderSection);
});

function loadCards() {
    fetch(`/api/opinions?offer_pro_id=${user.account_id}&limit=3&offset=${offset}&read_on_load=true&read=${read}`)
        .then(response => response.json())
        .then(opinions => {
            if (opinions.length < 3) {
                loaderSection.classList.add('hidden');
            }

            for (let opinion of opinions) {
                if (user) {
                    if (opinion.user.account_id !== user.account_id) {
                        // insert before the loader button
                        opinionsContainer.insertBefore(createOpinionCard(opinion, true), loaderSection);
                    }
                } else {
                    opinionsContainer.insertBefore(createOpinionCard(opinion, true), loaderSection);
                }
            }

            offset += 3;
        })
}

function resetCards() {
    offset = 0;

    // Remove all opinion cards
    let cards = document.querySelectorAll('.opinion-card');

    for (let card of cards) {
        card.remove();
    }

    loaderSection.classList.remove('hidden');
}


// ---------------------------------------------------------------------------------------------- //
// Opinions search
// ---------------------------------------------------------------------------------------------- //

let searchInput = document.querySelector('#search-input');

searchInput.addEventListener('input', debounce(() => {
    resetCards();

    let value = searchInput.value.trim();

    fetch(`/api/opinions?offer_pro_id=${user.account_id}&limit=3&offset=${offset}&q=${value}&read_on_load=true&read=${read}`)
        .then(response => response.json())
        .then(opinions => {
            if (opinions.length < 3) {
                loaderSection.classList.add('hidden');
            }

            for (let opinion of opinions) {
                if (user) {
                    if (opinion.user.account_id !== user.account_id) {
                        // insert before the loader button
                        opinionsContainer.insertBefore(createOpinionCard(opinion, true), loaderSection);
                    }
                } else {
                    opinionsContainer.insertBefore(createOpinionCard(opinion, true), loaderSection);
                }
            }

            offset += 3;
        })
}, 300));