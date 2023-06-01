'use strict';
!! => boolean ex: !!var
?. => chaining optional ex: 'test' ?. 'suite' => comme . mais ne genere pas d'erreur
new Function()
var user = true => (user !== null && user !== undefined ? user : not) == (user ?? not)
var n = 0 => (n !== null && n !== undefined && !n ? n : 100) == (n || 100)
let x = (1 && 2) ?? 3; // 2 != let x = 1 && 2 ?? 3; // syntax error
[...] // complete array
i = i ? i < 0 ? Math.max(0, len + i) : i : 0;
~~n
this[`get_${type}_list`]();
if(mode & 2 && typeof value != 'string')
Object.defineProperty(exports, '__esModule', { value: true });
var ns = Object.create(null);
Object.getOwnPropertyDescriptor
if (Object.prototype.hasOwnProperty.call(obj, key))
const {members} = node;
/(?:^|[^\\])(?:\\\\)*'/
(/((^|:)(0(:|$))+)/, '::')
/((^|:)(0(:|$)){2,})/g

Object.keys(_templateLiterals).forEach(function (key) {
  if (key === "default" || key === "__esModule") return;
  Object.defineProperty(exports, key, {
    enumerable: true,
    get: function () {
      return _templateLiterals[key];
    }
  });
});

this.word(`/${node.pattern}/${node.flags}`);
return ConditionalExpression(...arguments);

[type].concat(t.FLIPPED_ALIAS_KEYS[type] || []).forEach(function (type) {
    nodes[type] = function () {
      return amounts;
    };
 });

while (item = this._queue.pop()) this._append(...item);
Object.assign({quotes: "double", wrap: true}, opts.jsescOption)
for (i = 0; i < str.length && str[i] === " "; i++) continue;
debug("Auto-ignoring usage of config %o.", filepath);
return +_fs().default.statSync(filepath).mtime;
exports.default = void 0;
target.presets.push(...source.presets);
delete options.exclude;
passes.splice(1, 0, ...presets.map(o => o.pass).filter(p => p !== pass));

function chain(a, b) {
  const fns = [a, b].filter(Boolean);
  if (fns.length <= 1) return fns[0];
  return function (...args) {
    for (const fn of fns) {
      fn.apply(this, args);
    }
  };
}

Object.freeze(this);
const mergedGenerator = new (_sourceMap().default.SourceMapGenerator)();
for (let i = start; i < array.length && callback(array[i]) === 0; i++) {results.push(array[i]);}
if (!(this instanceof TestWritable))
if (hasToStringTag && value && typeof value === 'object' && Symbol.toStringTag in value)
Array.isArray(val)
for (i = k = 3; k >= 0; i = k += -1)
for (l = 0, len = ref.length; l < len; l++)
addr.parts.push(octets[0] << 8 | octets[1]);
string.match(/^(0|[1-9]\d*)(\.(0|[1-9]\d*)){3}$/)
for (i = 0; i < sections.length && sections[i] !== ''; i++);
var ipv4Regex = /^(\d{1,3}\.){3,3}\d{1,3}$/;
var ipv6Regex = /^(::)?(((\d{1,3}\.){3}(\d{1,3}){1})?([0-9a-f]){0,4}:{0,2}){1,8}(::)?$/i;
buff[i] = ~(0xff >> bits) & 0xff;
a[i] |= b[i];
process.emitWarning(message, "DeprecationWarning");
({});
?: