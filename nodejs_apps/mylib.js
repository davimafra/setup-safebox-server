var _sub = function(a,b){

    return a-b;

}

var _div = function(a,b){

    return a/b;

}
var _mult = function(a,b){

    return a*b;

}
var _sum = function(a,b){

    return a+b;

}

function teste(numero){
    return numero + 1;
}

function prefixo(text1){
    return "prefixo:" + text1;
}


module.exports = {
    _sub:_sub,
    _sum:_sum,
    teste: teste,
    prefixo: prefixo
};