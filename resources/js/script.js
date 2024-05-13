import { getData, renderCard, plus, minus } from "./utils.js";

let data = await getData()
// console.log (data)

const cards = document.querySelector('.cards')
renderCard(data, cards)

const allBuy = []

cards.addEventListener('click' , (event) => {
    let targ = event.target
    if (targ.classList.contains('plus')) {
        plus(targ.dataset.id, allBuy)
        localStorage.setItem('basket', JSON.stringify(allBuy))
    } else if (targ.classList.contains('minus')) {
        minus(targ.dataset.id, allBuy)
        localStorage.setItem('basket', JSON.stringify(allBuy))
    }
})