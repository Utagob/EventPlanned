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

document.addEventListener("DOMContentLoaded", () => {
    const langBtn = document.getElementById("langToggleBtn");
    
    const savedLang = localStorage.getItem("selectedLanguage") || "RO";
    changeLanguage(savedLang);

    if (langBtn) {
        langBtn.addEventListener("click", () => {
            const currentLang = langBtn.getAttribute("data-current-lang") || "RO";
            
            let currentIndex = langOrder.indexOf(currentLang);
            
            let nextIndex = (currentIndex + 1) % langOrder.length;
            const nextLang = langOrder[nextIndex];
            
            changeLanguage(nextLang);
        });
    }
});

const hearts = document.querySelectorAll('.eventHeart');

const emptyHeartSvg = `<svg width="15" height="15" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M10.1 16.9482L10 17.0572L9.89 16.9482C5.14 12.2507 2 9.14441 2 5.99455C2 3.81471 3.5 2.17984 5.5 2.17984C7.04 2.17984 8.54 3.26975 9.07 4.75204H10.93C11.46 3.26975 12.96 2.17984 14.5 2.17984C16.5 2.17984 18 3.81471 18 5.99455C18 9.14441 14.86 12.2507 10.1 16.9482ZM14.5 0C12.76 0 11.09 0.882834 10 2.26703C8.91 0.882834 7.24 0 5.5 0C2.42 0 0 2.6267 0 5.99455C0 10.1035 3.4 13.4714 8.55 18.5613L10 20L11.45 18.5613C16.6 13.4714 20 10.1035 20 5.99455C20 2.6267 17.58 0 14.5 0Z" fill="black"/> </svg>`;

const filledHeartSvg = `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 8C12 8 12 8 12.76 7C13.64 5.84 14.94 5 16.5 5C18.99 5 21 7.01 21 9.5C21 10.43 20.72 11.29 20.24 12C19.43 13.21 12 21 12 21C12 21 4.57 13.21 3.76 12C3.28 11.29 3 10.43 3 9.5C3 7.01 5.01 5 7.5 5C9.06 5 10.37 5.84 11.24 7C12 8 12 8 12 8Z" fill="black"/><path d="M11.24 7L12 8L12.76 7C13.64 5.84 14.94 5 16.5 5C18.99 5 21 7.01 21 9.5C21 10.43 20.72 11.29 20.24 12C19.43 13.21 12 21 12 21C12 21 4.57 13.21 3.76 12C3.28 11.29 3 10.43 3 9.5C3 7.01 5.01 5 7.5 5C9.06 5 10.36 5.84 11.24 7Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>`;

hearts.forEach(heart => {
    heart.addEventListener("click", async () => {
        const eventId = heart.getAttribute("data-event-id");

        try {
            const response = await fetch("include/like_event.inc.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ event_id: eventId })
            });

            if (!response.ok) {
                throw new Error("HTTP connection failure.");
            }

            const data = await response.json();

            if (data.success) {
                if (data.status === "liked") {
                    heart.classList.add('a');
                    // Only override innerHTML if it's an index grid card, NOT the details page
                    if (!heart.classList.contains('details-heart')) {
                        heart.innerHTML = filledHeartSvg;
                    }
                } else if (data.status === "unliked") {
                    heart.classList.remove('a');
                    // Only override innerHTML if it's an index grid card, NOT the details page
                    if (!heart.classList.contains('details-heart')) {
                        heart.innerHTML = emptyHeartSvg;
                    }
                }
            } else if (data.error === "not_logged_in") {
                const modal = document.getElementById("accountModal");
                if (modal) {
                    modal.style.display = "flex";
                } else {
                    alert("Vă rugăm să vă autentificați pentru a salva evenimente!");
                }
            } else {
                console.error("Database status warning:", data.error);
            }
        } catch (error) {
            console.error("AJAX Connection Failure:", error);
        }
    });
});