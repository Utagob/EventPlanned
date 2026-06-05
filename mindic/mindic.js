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