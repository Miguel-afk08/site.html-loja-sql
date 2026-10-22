let quantidades = {
    pf: 0,
    frango: 0,
    carne: 0,
    feijoada: 0
};


let precos = {
    pf: 20,
    frango: 22,
    carne: 25,
    feijoada: 28
};


function aumentar(item) {

    quantidades[item]++;

    atualizar();

}


function diminuir(item) {

    if (quantidades[item] > 0) {

        quantidades[item]--;

    }

    atualizar();

}


function atualizar() {

    document.getElementById("pf").textContent =
        quantidades.pf;

    document.getElementById("frango").textContent =
        quantidades.frango;

    document.getElementById("carne").textContent =
        quantidades.carne;

    document.getElementById("feijoada").textContent =
        quantidades.feijoada;


    let total = 0;

    total += quantidades.pf * precos.pf;

    total += quantidades.frango * precos.frango;

    total += quantidades.carne * precos.carne;

    total += quantidades.feijoada * precos.feijoada;


    document.getElementById("total").textContent =
        total.toFixed(2).replace(".", ",");

}
