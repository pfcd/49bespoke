var numeric = function numeric() {};
if (typeof global !== "undefined") { global.numeric = numeric; }

numeric.version = "1.2.6";

numeric._myIndexOf = (function _myIndexOf(w) {
    var n = this.length,
        k;
    for (k = 0; k < n; ++k)
        if (this[k] === w) return k;
    return -1;
});
numeric.myIndexOf = (Array.prototype.indexOf) ? Array.prototype.indexOf : numeric._myIndexOf;

numeric.Function = Function;
numeric.precision = 4;
numeric.largeArray = 50;

// 2. Linear algebra with Arrays.
numeric._dim = function _dim(x) {
    var ret = [];
    while (typeof x === "object") {
        ret.push(x.length);
        x = x[0];
    }
    return ret;
}

numeric.dim = function dim(x) {
    var y, z;
    if (typeof x === "object") {
        y = x[0];
        if (typeof y === "object") {
            z = y[0];
            if (typeof z === "object") {
                return numeric._dim(x);
            }
            return [x.length, y.length];
        }
        return [x.length];
    }
    return [];
}

numeric.mapreduce = function mapreduce(body, init) {
    return Function('x', 'accum', '_s', '_k',
        'if(typeof accum === "undefined") accum = ' + init + ';\n' +
        'if(typeof x === "number") { var xi = x; ' + body + '; return accum; }\n' +
        'if(typeof _s === "undefined") _s = numeric.dim(x);\n' +
        'if(typeof _k === "undefined") _k = 0;\n' +
        'var _n = _s[_k];\n' +
        'var i,xi;\n' +
        'if(_k < _s.length-1) {\n' +
        '    for(i=_n-1;i>=0;i--) {\n' +
        '        accum = arguments.callee(x[i],accum,_s,_k+1);\n' +
        '    }' +
        '    return accum;\n' +
        '}\n' +
        'for(i=_n-1;i>=1;i-=2) { \n' +
        '    xi = x[i];\n' +
        '    ' + body + ';\n' +
        '    xi = x[i-1];\n' +
        '    ' + body + ';\n' +
        '}\n' +
        'if(i === 0) {\n' +
        '    xi = x[i];\n' +
        '    ' + body + '\n' +
        '}\n' +
        'return accum;'
    );
}
numeric.mapreduce2 = function mapreduce2(body, setup) {
    return Function('x',
        'var n = x.length;\n' +
        'var i,xi;\n' + setup + ';\n' +
        'for(i=n-1;i!==-1;--i) { \n' +
        '    xi = x[i];\n' +
        '    ' + body + ';\n' +
        '}\n' +
        'return accum;'
    );
}

numeric.dotMMsmall = function dotMMsmall(x, y) {
    var i, j, k, p, q, r, ret, foo, bar, woo, i0;
    p = x.length;
    q = y.length;
    r = y[0].length;
    ret = Array(p);
    for (i = p - 1; i >= 0; i--) {
        foo = Array(r);
        bar = x[i];
        for (k = r - 1; k >= 0; k--) {
            woo = bar[q - 1] * y[q - 1][k];
            for (j = q - 2; j >= 1; j -= 2) {
                i0 = j - 1;
                woo += bar[j] * y[j][k] + bar[i0] * y[i0][k];
            }
            if (j === 0) { woo += bar[0] * y[0][k]; }
            foo[k] = woo;
        }
        ret[i] = foo;
    }
    return ret;
}
numeric._getCol = function _getCol(A, j, x) {
    var n = A.length,
        i;
    for (i = n - 1; i > 0; --i) {
        x[i] = A[i][j];
        --i;
        x[i] = A[i][j];
    }
    if (i === 0) x[0] = A[0][j];
}
numeric.dotMMbig = function dotMMbig(x, y) {
    var gc = numeric._getCol,
        p = y.length,
        v = Array(p);
    var m = x.length,
        n = y[0].length,
        A = new Array(m),
        xj;
    var VV = numeric.dotVV;
    var i, j, z;
    --p;
    --m;
    for (i = m; i !== -1; --i) A[i] = Array(n);
    --n;
    for (i = n; i !== -1; --i) {
        gc(y, i, v);
        for (j = m; j !== -1; --j) {
            z = 0;
            xj = x[j];
            A[j][i] = VV(xj, v);
        }
    }
    return A;
}

numeric.dotMV = function dotMV(x, y) {
    var p = x.length,
        i;
    var ret = Array(p),
        dotVV = numeric.dotVV;
    for (i = p - 1; i >= 0; i--) { ret[i] = dotVV(x[i], y); }
    return ret;
}

numeric.dotVM = function dotVM(x, y) {
    var j, k, p, q, ret, woo, i0;
    p = x.length;
    q = y[0].length;
    ret = Array(q);
    for (k = q - 1; k >= 0; k--) {
        woo = x[p - 1] * y[p - 1][k];
        for (j = p - 2; j >= 1; j -= 2) {
            i0 = j - 1;
            woo += x[j] * y[j][k] + x[i0] * y[i0][k];
        }
        if (j === 0) { woo += x[0] * y[0][k]; }
        ret[k] = woo;
    }
    return ret;
}

numeric.dotVV = function dotVV(x, y) {
    var i, n = x.length,
        i1, ret = x[n - 1] * y[n - 1];
    for (i = n - 2; i >= 1; i -= 2) {
        i1 = i - 1;
        ret += x[i] * y[i] + x[i1] * y[i1];
    }
    if (i === 0) { ret += x[0] * y[0]; }
    return ret;
}

numeric.dot = function dot(x, y) {
    var d = numeric.dim;
    switch (d(x).length * 1000 + d(y).length) {
        case 2002:
            if (y.length < 10) return numeric.dotMMsmall(x, y);
            else return numeric.dotMMbig(x, y);
        case 2001:
            return numeric.dotMV(x, y);
        case 1002:
            return numeric.dotVM(x, y);

        case 1001:
            return numeric.dotVV(x, y);
        case 1000:
            return numeric.mulVS(x, y);
        case 1:
            return numeric.mulSV(x, y);
        case 0:
            return x * y;
        default:
            throw new Error('numeric.dot only works on vectors and matrices');
    }
}

numeric.pointwise2 = function pointwise2(params, body, setup) {
    if (typeof setup === "undefined") { setup = ""; }
    var fun = [];
    var k;
    var avec = /\[i\]$/,
        p, thevec = '';
    var haveret = false;
    for (k = 0; k < params.length; k++) {
        if (avec.test(params[k])) {
            p = params[k].substring(0, params[k].length - 3);
            thevec = p;
        } else { p = params[k]; }
        if (p === 'ret') haveret = true;
        fun.push(p);
    }
    fun[params.length] = (
        'var _n = ' + thevec + '.length;\n' +
        'var i' + (haveret ? '' : ', ret = Array(_n)') + ';\n' +
        setup + '\n' +
        'for(i=_n-1;i!==-1;--i) {\n' +
        body + '\n' +
        '}\n' +
        'return ret;'
    );
    return Function.apply(null, fun);
}

numeric._biforeach2 = (function _biforeach2(x, y, s, k, f) {
    if (k === s.length - 1) { return f(x, y); }
    var i, n = s[k],
        ret = Array(n);
    for (i = n - 1; i >= 0; --i) { ret[i] = _biforeach2(typeof x === "object" ? x[i] : x, typeof y === "object" ? y[i] : y, s, k + 1, f); }
    return ret;
});

numeric._foreach2 = (function _foreach2(x, s, k, f) {
    if (k === s.length - 1) { return f(x); }
    var i, n = s[k],
        ret = Array(n);
    for (i = n - 1; i >= 0; i--) { ret[i] = _foreach2(x[i], s, k + 1, f); }
    return ret;
});

numeric.ops2 = {
    add: '+',
    sub: '-',
    mul: '*',
    div: '/',
    mod: '%',
    and: '&&',
    or: '||',
    eq: '===',
    neq: '!==',
    lt: '<',
    gt: '>',
    leq: '<=',
    geq: '>=',
    band: '&',
    bor: '|',
    bxor: '^',
    lshift: '<<',
    rshift: '>>',
    rrshift: '>>>'
};
numeric.opseq = {
    addeq: '+=',
    subeq: '-=',
    muleq: '*=',
    diveq: '/=',
    modeq: '%=',
    lshifteq: '<<=',
    rshifteq: '>>=',
    rrshifteq: '>>>=',
    bandeq: '&=',
    boreq: '|=',
    bxoreq: '^='
};
numeric.mathfuns = [
    'abs', 
    'acos', 
    'asin', 
    'atan', 
    'ceil', 
    'cos',
    'exp', 'floor', 'log', 'round', 'sin', 'sqrt', 'tan',
    'isNaN', 'isFinite'
];
numeric.mathfuns2 = ['atan2', 'pow', 'max', 'min'];
numeric.ops1 = {
    neg: '-',
    not: '!',
    bnot: '~',
    clone: ''
};
numeric.mapreducers = {
    any: ['if(xi) return true;', 'var accum = false;'],
    all: ['if(!xi) return false;', 'var accum = true;'],
    sum: ['accum += xi;', 'var accum = 0;'],
    prod: ['accum *= xi;', 'var accum = 1;'],
    norm2Squared: ['accum += xi*xi;', 'var accum = 0;'],
    norminf: ['accum = max(accum,abs(xi));', 'var accum = 0, max = Math.max, abs = Math.abs;'],
    norm1: ['accum += abs(xi)', 'var accum = 0, abs = Math.abs;'],
    sup: ['accum = max(accum,xi);', 'var accum = -Infinity, max = Math.max;'],
    inf: ['accum = min(accum,xi);', 'var accum = Infinity, min = Math.min;']
};

(function() {
    var i, o;
    for (i = 0; i < numeric.mathfuns2.length; ++i) {
        o = numeric.mathfuns2[i];
        numeric.ops2[o] = o;
    }
    for (i in numeric.ops2) {
        if (numeric.ops2.hasOwnProperty(i)) {
            o = numeric.ops2[i];
            var code, codeeq, setup = '';
            if (numeric.myIndexOf.call(numeric.mathfuns2, i) !== -1) {
                setup = 'var ' + o + ' = Math.' + o + ';\n';
                code = function(r, x, y) { return r + ' = ' + o + '(' + x + ',' + y + ')'; };
                codeeq = function(x, y) { return x + ' = ' + o + '(' + x + ',' + y + ')'; };
            } else {
                code = function(r, x, y) { return r + ' = ' + x + ' ' + o + ' ' + y; };
                if (numeric.opseq.hasOwnProperty(i + 'eq')) {
                    codeeq = function(x, y) { return x + ' ' + o + '= ' + y; };
                } else {
                    codeeq = function(x, y) { return x + ' = ' + x + ' ' + o + ' ' + y; };
                }
            }
            numeric[i + 'VV'] = numeric.pointwise2(['x[i]', 'y[i]'], code('ret[i]', 'x[i]', 'y[i]'), setup);
            numeric[i + 'SV'] = numeric.pointwise2(['x', 'y[i]'], code('ret[i]', 'x', 'y[i]'), setup);
            numeric[i + 'VS'] = numeric.pointwise2(['x[i]', 'y'], code('ret[i]', 'x[i]', 'y'), setup);
            numeric[i] = Function(
                'var n = arguments.length, i, x = arguments[0], y;\n' +
                'var VV = numeric.' + i + 'VV, VS = numeric.' + i + 'VS, SV = numeric.' + i + 'SV;\n' +
                'var dim = numeric.dim;\n' +
                'for(i=1;i!==n;++i) { \n' +
                '  y = arguments[i];\n' +
                '  if(typeof x === "object") {\n' +
                '      if(typeof y === "object") x = numeric._biforeach2(x,y,dim(x),0,VV);\n' +
                '      else x = numeric._biforeach2(x,y,dim(x),0,VS);\n' +
                '  } else if(typeof y === "object") x = numeric._biforeach2(x,y,dim(y),0,SV);\n' +
                '  else ' + codeeq('x', 'y') + '\n' +
                '}\nreturn x;\n');
            numeric[o] = numeric[i];
            numeric[i + 'eqV'] = numeric.pointwise2(['ret[i]', 'x[i]'], codeeq('ret[i]', 'x[i]'), setup);
            numeric[i + 'eqS'] = numeric.pointwise2(['ret[i]', 'x'], codeeq('ret[i]', 'x'), setup);
            numeric[i + 'eq'] = Function(
                'var n = arguments.length, i, x = arguments[0], y;\n' +
                'var V = numeric.' + i + 'eqV, S = numeric.' + i + 'eqS\n' +
                'var s = numeric.dim(x);\n' +
                'for(i=1;i!==n;++i) { \n' +
                '  y = arguments[i];\n' +
                '  if(typeof y === "object") numeric._biforeach(x,y,s,0,V);\n' +
                '  else numeric._biforeach(x,y,s,0,S);\n' +
                '}\nreturn x;\n');
        }
    }
    for (i = 0; i < numeric.mathfuns2.length; ++i) {
        o = numeric.mathfuns2[i];
        delete numeric.ops2[o];
    }
    for (i = 0; i < numeric.mathfuns.length; ++i) {
        o = numeric.mathfuns[i];
        numeric.ops1[o] = o;
    }
    for (i in numeric.ops1) {
        if (numeric.ops1.hasOwnProperty(i)) {
            setup = '';
            o = numeric.ops1[i];
            if (numeric.myIndexOf.call(numeric.mathfuns, i) !== -1) {
                if (Math.hasOwnProperty(o)) setup = 'var ' + o + ' = Math.' + o + ';\n';
            }
            numeric[i + 'eqV'] = numeric.pointwise2(['ret[i]'], 'ret[i] = ' + o + '(ret[i]);', setup);
            numeric[i + 'eq'] = Function('x',
                'if(typeof x !== "object") return ' + o + 'x\n' +
                'var i;\n' +
                'var V = numeric.' + i + 'eqV;\n' +
                'var s = numeric.dim(x);\n' +
                'numeric._foreach(x,s,0,V);\n' +
                'return x;\n');
            numeric[i + 'V'] = numeric.pointwise2(['x[i]'], 'ret[i] = ' + o + '(x[i]);', setup);
            numeric[i] = Function('x',
                'if(typeof x !== "object") return ' + o + '(x)\n' +
                'var i;\n' +
                'var V = numeric.' + i + 'V;\n' +
                'var s = numeric.dim(x);\n' +
                'return numeric._foreach2(x,s,0,V);\n');
        }
    }
    for (i = 0; i < numeric.mathfuns.length; ++i) {
        o = numeric.mathfuns[i];
        delete numeric.ops1[o];
    }
    for (i in numeric.mapreducers) {
        if (numeric.mapreducers.hasOwnProperty(i)) {
            o = numeric.mapreducers[i];
            numeric[i + 'V'] = numeric.mapreduce2(o[0], o[1]);
            numeric[i] = Function('x', 's', 'k',
                o[1] +
                'if(typeof x !== "object") {' +
                '    xi = x;\n' +
                o[0] + ';\n' +
                '    return accum;\n' +
                '}' +
                'if(typeof s === "undefined") s = numeric.dim(x);\n' +
                'if(typeof k === "undefined") k = 0;\n' +
                'if(k === s.length-1) return numeric.' + i + 'V(x);\n' +
                'var xi;\n' +
                'var n = x.length, i;\n' +
                'for(i=n-1;i!==-1;--i) {\n' +
                '   xi = arguments.callee(x[i]);\n' +
                o[0] + ';\n' +
                '}\n' +
                'return accum;\n');
        }
    }
}());





numeric.norm2 = function norm2(x) { return Math.sqrt(numeric.norm2Squared(x)); }





numeric.transform_point = function(from, to) {
    var A, H, b, h, i, k_i, lhs, rhs, _i, _j, _k, _ref;
    console.assert((from.length === (_ref = to.length) && _ref === 4));
    A = [];
    for (i = _i = 0; _i < 4; i = ++_i) {
        A.push([from[i].x, from[i].y, 1, 0, 0, 0, -from[i].x * to[i].x, -from[i].y * to[i].x]);
        A.push([0, 0, 0, from[i].x, from[i].y, 1, -from[i].x * to[i].y, -from[i].y * to[i].y]);
    }
    b = [];
    for (i = _j = 0; _j < 4; i = ++_j) {
        b.push(to[i].x);
        b.push(to[i].y);
    }
    h = numeric.solve(A, b);
    H = [
        [h[0], h[1], 0, h[2]],
        [h[3], h[4], 0, h[5]],
        [0, 0, 1, 0],
        [h[6], h[7], 0, 1]
    ];
    for (i = _k = 0; _k < 4; i = ++_k) {
        lhs = numeric.dot(H, [from[i].x, from[i].y, 0, 1]);
        k_i = lhs[3];
        rhs = numeric.dot(k_i, [to[i].x, to[i].y, 0, 1]);

        console.assert(numeric.norm2(numeric.sub(lhs, rhs)) < 1e-9, "Not equal:", lhs, rhs);
    }
    return H;
};

numeric.solve = function solve(A, b, fast) { return numeric.LUsolve(numeric.LU(A, fast), b); }
numeric.LUsolve = function LUsolve(LUP, b) {
    var i, j;
    var LU = LUP.LU;
    var n = LU.length;
    var x = [];
    var P = LUP.P;
    var Pi, LUi, tmp;

    for (i = n - 1; i !== -1; --i) x[i] = b[i];
    for (i = 0; i < n; ++i) {
        Pi = P[i];
        if (P[i] !== i) {
            tmp = x[i];
            x[i] = x[Pi];
            x[Pi] = tmp;
        }

        LUi = LU[i];
        for (j = 0; j < i; ++j) {
            x[i] -= x[j] * LUi[j];
        }
    }

    for (i = n - 1; i >= 0; --i) {
        LUi = LU[i];
        for (j = i + 1; j < n; ++j) {
            x[i] -= x[j] * LUi[j];
        }

        x[i] /= LUi[i];
    }

    return x;
}
numeric.LU = function(A, fast) {
    fast = fast || false;

    var abs = Math.abs;
    var i, j, k, absAjk, Akk, Ak, Pk, Ai;
    var max;
    var n = A.length,
        n1 = n - 1;
    var P = new Array(n);

    for (k = 0; k < n; ++k) {
        Pk = k;
        Ak = A[k];
        max = abs(Ak[k]);
        for (j = k + 1; j < n; ++j) {
            absAjk = abs(A[j][k]);
            if (max < absAjk) {
                max = absAjk;
                Pk = j;
            }
        }
        P[k] = Pk;

        if (Pk !== k) {
            A[k] = A[Pk];
            A[Pk] = Ak;
            Ak = A[k];
        }

        Akk = Ak[k];

        for (i = k + 1; i < n; ++i) {
            A[i][k] /= Akk;
        }

        for (i = k + 1; i < n; ++i) {
            Ai = A[i];
            for (j = k + 1; j < n1; ++j) {
                Ai[j] -= Ai[k] * Ak[j];
                ++j;
                Ai[j] -= Ai[k] * Ak[j];
            }
            if (j === n1) Ai[j] -= Ai[k] * Ak[j];
        }
    }

    return {
        LU: A,
        P: P
    };
}

export default numeric;