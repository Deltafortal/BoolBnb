// Promotions button (bronze, silver, gold)
const button1 = document.getElementById("button-1");
const button2 = document.getElementById("button-2");
const button3 = document.getElementById("button-3");
// Promotions card (father of prmotions button)
const promoCard1 = document.getElementById("promo-card-1");
const promoCard2 = document.getElementById("promo-card-2");
const promoCard3 = document.getElementById("promo-card-3");
// Promotions details (card with promotions detail)
const promoDetaisl1 = document.getElementById("promo-details-1");
const promoDetails2 = document.getElementById("promo-details-2");
const promoDetails3 = document.getElementById("promo-details-3");
// Promotion checkbox radio
const promoRadio1 = document.getElementById('promotion-1');
const promoRadio2 = document.getElementById('promotion-2');
const promoRadio3 = document.getElementById('promotion-3');


promoDetaisl1.classList.remove('d-none');
promoCard1.classList.add('show');
promoRadio1.checked = true;

button1.addEventListener('click', ()=>{
    promoDetaisl1.classList.remove('d-none');
    promoCard1.classList.add('show');

    promoDetails2.classList.add('d-none');
    promoCard2.classList.remove('show');

    promoDetails3.classList.add('d-none');
    promoCard3.classList.remove('show');

    promoRadio1.checked = true;
    promoRadio2.checked = false;
    promoRadio3.checked = false;
});

button2.addEventListener('click', ()=>{
    promoDetaisl1.classList.add('d-none');
    promoCard1.classList.remove('show');

    promoDetails2.classList.remove('d-none');
    promoCard2.classList.add('show');

    promoDetails3.classList.add('d-none');
    promoCard3.classList.remove('show');
       
    promoRadio1.checked = false;
    promoRadio2.checked = true;
    promoRadio3.checked = false;
});

button3.addEventListener('click', ()=>{
    promoDetaisl1.classList.add('d-none');
    promoCard1.classList.remove('show');;

    promoDetails2.classList.add('d-none');
    promoCard2.classList.remove('show');

    promoCard3.classList.add('show');
    promoDetails3.classList.remove('d-none');
    
    promoRadio1.checked = false;
    promoRadio2.checked = false;
    promoRadio3.checked = true;
});