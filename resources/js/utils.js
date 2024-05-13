export async function getData() {
    const cards = document.querySelectorAll('.card');
    const data = [];
    cards.forEach(card => {
        const id = card.dataset.id;
        const title = card.querySelector('.card-title').innerText;
        const price = card.querySelector('.card-price').innerText;
        const img = card.querySelector('.card-img').src;
        const description = card.querySelector('.card-description').innerText;
        data.push({id, title, price, img, description, quantity: 0});
    });
    return data;
}

export function renderCard(data, parent) {
    data.forEach(item => {
        parent.insertAdjacentHTML('afterbegin',`
        <div class="card" data-id='${item.id}'>
            <picture class="card__pic">
                <img class="card__img" src="${item.img}" alt="${item.title}" >
            </picture>
            <h2 class="card__title">${item.title}</h2>
            <h3 class="card__price">${item.price}руб </h3>
            <div class="control">
                <div class="quant">
                    <button class="quant__btn plus" data-id='${item.id}'>+</button>
                    <span class="quant__num">${item.quantity}</span>
                    <button class="quant__btn minus" data-id='${item.id}'>-</button>
                </div>
                <button class="control__btn">OK</button>
            </div>
        </div>
        `)
    })
}

export function plus(id, arr) {
    if (arr.length === 0) {
        arr.push({[id]: 1})
    } else {
        if (arr.some((item) => Object.keys(item)[0] === id)) {
            arr.forEach(item => {
                if (Object.keys(item)[0] === id) {
                    item[id]++
                }
            })
        } else {
            arr.push({[id]: 1})
        }
    }
    console.log(arr)
}

export function minus(id, arr) {
    if (arr.some((item) => Object.keys(item)[0] === id)) {
        arr.forEach((item, index) => {
            if (Object.keys(item)[0] === id) {
                if (item[id] > 1) {
                    item[id]--
                }
                else {
                    arr.splice(index, 1)
                }
            } 
        })
    }
    console.log(arr)
}