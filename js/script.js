const translations = {
    RO: {
        search_placeholder: "Caută...",
        cat_concerts: "Concerte",
        cat_festivals: "Festivaluri",
        cat_expositions: "Expoziții",
        cat_acts: "Spectacole",
        cat_sports: "Sport",
        cat_more: "Mai mult",
        cat_training: "Instruiri",
        cat_kids: "Pentru Copii",
        popular_events: "Evenimente Populare",
        event_date: "5-6 Octombrie",
        event_location: "Chișinău",
        event_title: "Ziua Vinului",
        footer_home: "Acasă",
        footer_about_us: "Despre noi",
        footer_contact: "Contactează"
    },
    EN: {
        search_placeholder: "Search...",
        cat_concerts: "Concerts",
        cat_festivals: "Festivals",
        cat_expositions: "Expositions",
        cat_acts: "Acts",
        cat_sports: "Sports",
        cat_more: "More",
        cat_training: "Training",
        cat_kids: "For kids",
        popular_events: "Popular events",
        event_date: "October 5-6",
        event_location: "Chisinau",
        event_title: "Wine Day",
        footer_home: "Home",
        footer_about_us: "About us",
        footer_contact: "Contact"
    },
    RU: {
        search_placeholder: "Поиск...",
        cat_concerts: "Концерты",
        cat_festivals: "Фестивали",
        cat_expositions: "Выставки",
        cat_acts: "Представления",
        cat_sports: "Спорт",
        cat_more: "Еще",
        cat_training: "Тренинги",
        cat_kids: "Для детей",
        popular_events: "Популярные события",
        event_date: "5-6 Октября",
        event_location: "Кишинёв",
        event_title: "День Вина",
        footer_home: "Дома",
        footer_about_us: "О нас",
        footer_contact: "Контакт"
    }
};

const langOrder = ["EN", "RO", "RU"];

// Track the globally active category filter state
let currentSelectedCategory = "";

// Core SVGs preserved from your original codebase
const emptyHeartSvg = `<svg width="15" height="15" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M10.1 16.9482L10 17.0572L9.89 16.9482C5.14 12.2507 2 9.14441 2 5.99455C2 3.81471 3.5 2.17984 5.5 2.17984C7.04 2.17984 8.54 3.26975 9.07 4.75204H10.93C11.46 3.26975 12.96 2.17984 14.5 2.17984C16.5 2.17984 18 3.81471 18 5.99455C18 9.14441 14.86 12.2507 10.1 16.9482ZM14.5 0C12.76 0 11.09 0.882834 10 2.26703C8.91 0.882834 7.24 0 5.5 0C2.42 0 0 2.6267 0 5.99455C0 10.1035 3.4 13.4714 8.55 18.5613L10 20L11.45 18.5613C16.6 13.4714 20 10.1035 20 5.99455C20 2.6267 17.58 0 14.5 0Z" fill="black"/> </svg>`;
const filledHeartSvg = `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 8C12 8 12 8 12.76 7C13.64 5.84 14.94 5 16.5 5C18.99 5 21 7.01 21 9.5C21 10.43 20.72 11.29 20.24 12C19.43 13.21 12 21 12 21C12 21 4.57 13.21 3.76 12C3.28 11.29 3 10.43 3 9.5C3 7.01 5.01 5 7.5 5C9.06 5 10.37 5.84 11.24 7C12 8 12 8 12 8Z" fill="black"/><path d="M11.24 7L12 8L12.76 7C13.64 5.84 14.94 5 16.5 5C18.99 5 21 7.01 21 9.5C21 10.43 20.72 11.29 20.24 12C19.43 13.21 12 21 12 21C12 21 4.57 13.21 3.76 12C3.28 11.29 3 10.43 3 9.5C3 7.01 5.01 5 7.5 5C9.06 5 10.36 5.84 11.24 7Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>`;

function changeLanguage(lang) {
    if (!translations[lang]) return;

    const elements = document.querySelectorAll("[data-key]");
    elements.forEach(element => {
        const key = element.getAttribute("data-key");
        const translationText = translations[lang][key];

        if (translationText) {
            if (element.tagName === "INPUT") {
                element.placeholder = translationText;
            } else {
                element.textContent = translationText;
            }
        }
    });
 
    const langBtn = document.getElementById("langToggleBtn");
    const langLabel = document.getElementById("langLabel");
    
    if (langBtn && langLabel) {
        langBtn.setAttribute("data-current-lang", lang);
        langLabel.textContent = lang;
    }

    localStorage.setItem("selectedLanguage", lang);
}

// Reusable asynchronous card listener registration (keeps likes active after refreshing layout panels)
function initializeHeartClickHandlers() {
    const hearts = document.querySelectorAll('.eventHeart');
    hearts.forEach(heart => {
        const freshHeart = heart.cloneNode(true);
        heart.parentNode.replaceChild(freshHeart, heart);

        freshHeart.addEventListener("click", async () => {
            const eventId = freshHeart.getAttribute("data-event-id");

            try {
                const response = await fetch("include/like_event.inc.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ event_id: eventId })
                });

                if (!response.ok) throw new Error("HTTP connection failure.");
                const data = await response.json();

                if (data.success) {
                    if (data.status === "liked") {
                        freshHeart.classList.add('a');
                        if (!freshHeart.classList.contains('details-heart')) {
                            freshHeart.innerHTML = filledHeartSvg;
                        }
                    } else if (data.status === "unliked") {
                        freshHeart.classList.remove('a');
                        if (!freshHeart.classList.contains('details-heart')) {
                            freshHeart.innerHTML = emptyHeartSvg;
                        }
                    }
                } else if (data.error === "not_logged_in") {
                    const modal = document.getElementById("accountModal");
                    if (modal) modal.style.display = "flex";
                    else alert("Vă rugăm să vă autentificați pentru a salva evenimente!");
                }
            } catch (error) {
                console.error("AJAX Connection Failure:", error);
            }
        });
    });
}

// Async dynamic category grid pipeline updater
function loadFilteredEvents() {
    const eventItemsContainer = document.querySelector(".event-items");
    const showcase = document.querySelector(".showcase"); // Select the showcase element

    if (!eventItemsContainer) return;

    // Toggle visibility based on whether a category is selected
    if (showcase) {
        showcase.style.display = currentSelectedCategory === "" ? "flex" : "none";
    }

    const url = `include/events.inc.php?category=${encodeURIComponent(currentSelectedCategory)}`;

    fetch(url)
        .then(response => response.text())
        .then(htmlContent => {
            eventItemsContainer.innerHTML = htmlContent;
            initializeHeartClickHandlers();
        })
        .catch(err => console.error("Error fetching filtered events layout content:", err));
}

// Global safety sanitizing utility function preventing malicious user text breakouts
function escapeHtml(stringText) {
    const divNode = document.createElement("div");
    divNode.textContent = stringText;
    return divNode.innerHTML;
}

document.addEventListener("DOMContentLoaded", () => {
    // 1. Language Toggle Setup
    const langBtn = document.getElementById("langToggleBtn");
    const savedLang = localStorage.getItem("selectedLanguage") || "RO";
    changeLanguage(savedLang);

    if (langBtn) {
        langBtn.addEventListener("click", () => {
            const currentLang = langBtn.getAttribute("data-current-lang") || "RO";
            let currentIndex = langOrder.indexOf(currentLang);
            let nextIndex = (currentIndex + 1) % langOrder.length;
            changeLanguage(langOrder[nextIndex]);
        });
    }

    // Initialize baseline heart interactive structures
    initializeHeartClickHandlers();

    // 2. Google-Style Autocomplete Live Search Setup
    const liveInput = document.querySelector(".center .input");
    const clearInputBtn = document.querySelector(".center .reset");
    
    let suggestionsBox = document.getElementById("searchSuggestionsDropdown");

    if (liveInput) {
        liveInput.setAttribute("autocomplete", "off");

        // Dynamically create the drops overlay box container if it does not exist inside header templates
        if (!suggestionsBox) {
            suggestionsBox = document.createElement("div");
            suggestionsBox.id = "searchSuggestionsDropdown";
            suggestionsBox.className = "search-autocomplete-dropdown";
            suggestionsBox.style.display = "none";
            liveInput.parentNode.appendChild(suggestionsBox);
        }

        liveInput.addEventListener("input", () => {
            const queryText = liveInput.value.trim();

            if (queryText.length === 0) {
                suggestionsBox.innerHTML = "";
                suggestionsBox.style.display = "none";
                return;
            }

            // Hit the endpoint to generate suggestions payload fragments
            fetch(`include/search_suggestions.inc.php?q=${encodeURIComponent(queryText)}`)
                .then(res => res.json())
                .then(recordsList => {
                    if (recordsList.length === 0) {
                        suggestionsBox.innerHTML = '<p class="no-suggestions-alert">Niciun rezultat găsit</p>';
                        suggestionsBox.style.display = "block";
                        return;
                    }

                    let htmlItemsPayload = "";
                    recordsList.forEach(item => {
                        htmlItemsPayload += `
                            <a href="event.php?id=${item.id}" class="suggestion-item-link">
                                <img src="${item.image}" class="suggestion-thumbnail" alt="Poster">
                                <div class="suggestion-metadata">
                                    <span class="suggestion-title">${escapeHtml(item.event_name)}</span>
                                    <span class="suggestion-location">${escapeHtml(item.event_location)}</span>
                                </div>
                            </a>
                        `;
                    });

                    suggestionsBox.innerHTML = htmlItemsPayload;
                    suggestionsBox.style.display = "block";
                })
                .catch(err => console.error("Error drawing live autocomplete layout:", err));
        });

        // Close dropdown when clicking anywhere else outside search components boundary
        document.addEventListener("click", (e) => {
            if (!liveInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                suggestionsBox.style.display = "none";
            }
        });

        // Bring back suggestion card box view instantly when input fields are re-focused
        liveInput.addEventListener("focus", () => {
            if (liveInput.value.trim().length > 0) {
                suggestionsBox.style.display = "block";
            }
        });
    }

    if (clearInputBtn) {
        clearInputBtn.addEventListener("click", () => {
            if (suggestionsBox) {
                suggestionsBox.innerHTML = "";
                suggestionsBox.style.display = "none";
            }
        });
    }

    const categoryButtons = document.querySelectorAll(".categoriesButton");
    categoryButtons.forEach(button => {
        const targetCategory = button.getAttribute("data-category") || button.textContent.trim();

        button.addEventListener("click", () => {
            if (currentSelectedCategory === targetCategory) {
                currentSelectedCategory = "";
                button.style.background = "";
                button.style.color = "";
            } else {
                categoryButtons.forEach(btn => {
                    btn.style.background = "";
                    btn.style.color = "";
                });

                currentSelectedCategory = targetCategory;
                button.style.background = "var(--button-bg, #03cad8)";
                button.style.color = "#ffffff";
            }
            loadFilteredEvents();
        });
    });

    const logoElement = document.querySelector(".logo");
    if (logoElement) {
        logoElement.style.cursor = "pointer";
        logoElement.addEventListener("click", () => {
            currentSelectedCategory = "";
            const showcase = document.querySelector(".showcase"); // Ensure visibility on reset
            if (showcase) showcase.style.display = "flex"; 
            
            if (liveInput) liveInput.value = "";
            if (suggestionsBox) {
                suggestionsBox.innerHTML = "";
                suggestionsBox.style.display = "none";
            }
            
            categoryButtons.forEach(btn => {
                btn.style.background = "";
                btn.style.color = "";
            });

            loadFilteredEvents();
        });
    }
});