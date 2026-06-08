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