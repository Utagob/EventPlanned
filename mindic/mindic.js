const body = document.body;
const legendbtn = document.querySelector('.legend');

const legenddiv = document.createElement('div');
legenddiv.className = "overlay";

const legendDiv = document.createElement('div');
legendDiv.className = "overlayDiv"

const paragraph = document.createElement('p');
paragraph.textContent = "Satul Mândâc, din ținutul Sorocii, este atestat documentar pentru prima dată într-un hrisov data cu 11 martie 1631, moșia aparținând boierului Gheorghe Moțoc, în timpul domniei lui Moise Movilă. Apoi satul apare apare într-un document din 25 martie 1671 prin care Vasile Moțoc, din Mândic, vinde lui Ilie Moțoc, pitar partea lui din satul Șolcani, ținutul Soroca, cu 15 lei bătuți. Martori ai tranzacției au fost Prodan, Dămian vătaful și alții din Horodiște, Mândic și Tilișăuca.";

legendDiv.appendChild(paragraph);
legenddiv.appendChild(legendDiv);

body.appendChild(legenddiv);

legendbtn.addEventListener("click", function (e) {
    legenddiv.classList.add("active");
});

legenddiv.addEventListener("click", function(e) {
    if (e.target === legenddiv) {
        legenddiv.classList.remove("active");
    }
});

const slides = [
    news1 = {
        image: "image/image1.png",
        p: "A șaptea ediție a festivalului “Portului Popular și al Pâinii”"
    },
    news2 = {
        image: "image/image2.png",
        p: "Vila Ohanovicz în 2024. Oportunități"
    },
    news3 = {
        image: "image/image3.png",
        p: "Revenirea lui Dorin Recean în satul de baștină"
    },
    news4 = {
        image: "image/image4.png",
        p: "A șaptea ediție a festivalului “Portului Popular și al Pâinii”"
    },
    news5 = {
        image: "image/image5.png",
        p: "Vila Ohanovicz în 2024. Oportunități"
    },
    news6 = {
        image: "image/image6.png",
        p: "Revenirea lui Dorin Recean în satul de baștină"
    }
]

const newsMain = document.querySelector('.newsMain');
let currentIndex = 0;

// 1. Create Left Arrow SVG
const prev = document.createElementNS("http://www.w3.org/2000/svg", "svg");
prev.setAttribute("class", "arrow arrowL");
prev.setAttribute("viewBox", "0 0 24 24");
prev.innerHTML = '<path d="M6 12H18M6 12L11 7M6 12L11 17" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>';
newsMain.appendChild(prev);

// 2. Create the sliding track structure
const trackContainer = document.createElement('div');
trackContainer.className = 'carousel-track-container';

const track = document.createElement('div');
track.className = 'carousel-track';

trackContainer.appendChild(track);
newsMain.appendChild(trackContainer);

// 3. Render all cards directly inside the track
// 3. Render all cards directly inside the track with inner text containers
slides.forEach(slideData => {
    const card = document.createElement('div');
    card.className = "card";

    const img = document.createElement('img');
    img.src = slideData.image;
    img.alt = slideData.p;

    // Notice we create a dedicated paragraph element explicitly scoped to the card
    const cardText = document.createElement('p');
    cardText.innerText = slideData.p;

    const button = document.createElement('button');
    button.innerText = "Vezi";

    card.appendChild(img);
    card.appendChild(cardText);
    card.appendChild(button);
    track.appendChild(card); 
});

// 4. Create Right Arrow SVG
const next = document.createElementNS("http://www.w3.org/2000/svg", "svg");
next.setAttribute("class", "arrow arrowR");
next.setAttribute("viewBox", "0 0 24 24");
next.innerHTML = '<path d="M6 12H18M18 12L13 7M18 12L13 17" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>';
newsMain.appendChild(next);

const domCards = track.querySelectorAll('.card');

// 5. Function to calculate slide shift distances and handle class highlights
function updateSlidePosition() {
    // Highlight the active 3 cards in view
    domCards.forEach((card, index) => {
        // Calculate if the card falls into the current visible window of 3
        if (index >= currentIndex && index < currentIndex + 3) {
            card.classList.add('carousel__item--selected');
        } else {
            card.classList.remove('carousel__item--selected');
        }
    });

    // Dynamically calculate the precise slide width + gap offset
    if (domCards.length > 0) {
        const firstCardWidth = domCards[0].getBoundingClientRect().width;
        // Grab the actual CSS gap dynamically (defaults to 20 if undetected)
        const computedGap = parseFloat(window.getComputedStyle(track).gap) || 20; 
        const cardOffsetWidth = firstCardWidth + computedGap;
        
        // Shift the track left horizontally
        track.style.transform = `translateX(-${currentIndex * cardOffsetWidth}px)`;
    }
}

// 6. Click Actions
next.addEventListener('click', () => {
    // Loop back smoothly if reaching the end of the slide deck
    if (currentIndex < slides.length - 3) {
        currentIndex++;
    } else {
        currentIndex = 0; 
    }
    updateSlidePosition();
});

prev.addEventListener('click', () => {
    if (currentIndex > 0) {
        currentIndex--;
    } else {
        currentIndex = slides.length - 3; 
    }
    updateSlidePosition();
});

// Run initial position assignment
updateSlidePosition();