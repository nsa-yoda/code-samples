// Improper fraction to mixed number
// n = numerator
// d = denominator
// i = number
function improperFractionToMixedNumber(n, d) {
    i = parseInt(n / d);
    n -= i * d;
    return [i, reduce(n,d)];   
}


function reduce(numerator,denominator){
    if (isNaN(numerator) || isNaN(denominator))
      return NaN;
    var gcd = function gcd(a, b){ return b ? gcd(b, a%b) : a; };
    gcd = gcd(numerator, denominator);
    return [numerator/gcd, denominator/gcd];
}