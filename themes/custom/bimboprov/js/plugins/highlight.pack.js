var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/*
  Highlight.js 10.7.2 (00233d63)
  License: BSD-3-Clause
  Copyright (c) 2006-2021, Ivan Sagalaev
*/
var hljs = function () {
  "use strict";
  function e(t) {
    return t instanceof Map ? t.clear = t.delete = t.set = function () {
      throw Error("map is read-only");
    } : t instanceof Set && (t.add = t.clear = t.delete = function () {
      throw Error("set is read-only");
    }), Object.freeze(t), Object.getOwnPropertyNames(t).forEach(function (n) {
      var i = t[n];"object" != typeof i || Object.isFrozen(i) || e(i);
    }), t;
  }var t = e,
      n = e;t.default = n;
  var i = function () {
    function i(e) {
      _classCallCheck(this, i);

      void 0 === e.data && (e.data = {}), this.data = e.data, this.isMatchIgnored = !1;
    }

    _createClass(i, [{
      key: "ignoreMatch",
      value: function ignoreMatch() {
        this.isMatchIgnored = !0;
      }
    }]);

    return i;
  }();

  function s(e) {
    return e.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#x27;");
  }function a(e, ...t) {
    var n = Object.create(null);for (var _t in e) {
      n[_t] = e[_t];
    }return t.forEach(function (e) {
      for (var _t2 in e) {
        n[_t2] = e[_t2];
      }
    }), n;
  }var r = function (e) {
    return !!e.kind;
  };
  var l = function () {
    function l(e, t) {
      _classCallCheck(this, l);

      this.buffer = "", this.classPrefix = t.classPrefix, e.walk(this);
    }

    _createClass(l, [{
      key: "addText",
      value: function addText(e) {
        this.buffer += s(e);
      }
    }, {
      key: "openNode",
      value: function openNode(e) {
        if (!r(e)) return;var t = e.kind;e.sublanguage || (t = "" + this.classPrefix + t), this.span(t);
      }
    }, {
      key: "closeNode",
      value: function closeNode(e) {
        r(e) && (this.buffer += "</span>");
      }
    }, {
      key: "value",
      value: function value() {
        return this.buffer;
      }
    }, {
      key: "span",
      value: function span(e) {
        this.buffer += "<span class=\"" + e + "\">";
      }
    }]);

    return l;
  }();

  var o = function () {
    function o() {
      _classCallCheck(this, o);

      this.rootNode = {
        children: [] }, this.stack = [this.rootNode];
    }

    _createClass(o, [{
      key: "add",
      value: function add(e) {
        this.top.children.push(e);
      }
    }, {
      key: "openNode",
      value: function openNode(e) {
        var t = { kind: e, children: [] };this.add(t), this.stack.push(t);
      }
    }, {
      key: "closeNode",
      value: function closeNode() {
        if (this.stack.length > 1) return this.stack.pop();
      }
    }, {
      key: "closeAllNodes",
      value: function closeAllNodes() {
        for (; this.closeNode();) {}
      }
    }, {
      key: "toJSON",
      value: function toJSON() {
        return JSON.stringify(this.rootNode, null, 4);
      }
    }, {
      key: "walk",
      value: function walk(e) {
        return this.constructor._walk(e, this.rootNode);
      }
    }, {
      key: "top",
      get: function () {
        return this.stack[this.stack.length - 1];
      }
    }, {
      key: "root",
      get: function () {
        return this.rootNode;
      }
    }], [{
      key: "_walk",
      value: function _walk(e, t) {
        var _this = this;

        return "string" == typeof t ? e.addText(t) : t.children && (e.openNode(t), t.children.forEach(function (t) {
          return _this._walk(e, t);
        }), e.closeNode(t)), e;
      }
    }, {
      key: "_collapse",
      value: function _collapse(e) {
        "string" != typeof e && e.children && (e.children.every(function (e) {
          return "string" == typeof e;
        }) ? e.children = [e.children.join("")] : e.children.forEach(function (e) {
          o._collapse(e);
        }));
      }
    }]);

    return o;
  }();

  var c = function (_o) {
    _inherits(c, _o);

    function c(e) {
      var _this2;

      _classCallCheck(this, c);

      (_this2 = _possibleConstructorReturn(this, (c.__proto__ || Object.getPrototypeOf(c)).call(this)), _this2), _this2.options = e;return _this2;
    }

    _createClass(c, [{
      key: "addKeyword",
      value: function addKeyword(e, t) {
        "" !== e && (this.openNode(t), this.addText(e), this.closeNode());
      }
    }, {
      key: "addText",
      value: function addText(e) {
        "" !== e && this.add(e);
      }
    }, {
      key: "addSublanguage",
      value: function addSublanguage(e, t) {
        var n = e.root;n.kind = t, n.sublanguage = !0, this.add(n);
      }
    }, {
      key: "toHTML",
      value: function toHTML() {
        return new l(this, this.options).value();
      }
    }, {
      key: "finalize",
      value: function finalize() {
        return !0;
      }
    }]);

    return c;
  }(o);

  function g(e) {
    return e ? "string" == typeof e ? e : e.source : null;
  }
  var u = /\[(?:[^\\\]]|\\.)*\]|\(\??|\\([1-9][0-9]*)|\\./,
      h = "[a-zA-Z]\\w*",
      d = "[a-zA-Z_]\\w*",
      f = "\\b\\d+(\\.\\d+)?",
      p = "(-?)(\\b0[xX][a-fA-F0-9]+|(\\b\\d+(\\.\\d*)?|\\.\\d+)([eE][-+]?\\d+)?)",
      m = "\\b(0b[01]+)",
      b = {
    begin: "\\\\[\\s\\S]", relevance: 0 },
      E = { className: "string", begin: "'", end: "'",
    illegal: "\\n", contains: [b] },
      x = { className: "string", begin: '"', end: '"',
    illegal: "\\n", contains: [b] },
      v = {
    begin: /\b(a|an|the|are|I'm|isn't|don't|doesn't|won't|but|just|should|pretty|simply|enough|gonna|going|wtf|so|such|will|you|your|they|like|more)\b/
  },
      w = function (e, t, n = {}) {
    var i = a({ className: "comment", begin: e, end: t, contains: [] }, n);return i.contains.push(v), i.contains.push({ className: "doctag",
      begin: "(?:TODO|FIXME|NOTE|BUG|OPTIMIZE|HACK|XXX):", relevance: 0 }), i;
  },
      y = w("//", "$"),
      N = w("/\\*", "\\*/"),
      R = w("#", "$");var _ = Object.freeze({
    __proto__: null, MATCH_NOTHING_RE: /\b\B/, IDENT_RE: h, UNDERSCORE_IDENT_RE: d,
    NUMBER_RE: f, C_NUMBER_RE: p, BINARY_NUMBER_RE: m,
    RE_STARTERS_RE: "!|!=|!==|%|%=|&|&&|&=|\\*|\\*=|\\+|\\+=|,|-|-=|/=|/|:|;|<<|<<=|<=|<|===|==|=|>>>=|>>=|>=|>>>|>>|>|\\?|\\[|\\{|\\(|\\^|\\^=|\\||\\|=|\\|\\||~",
    SHEBANG: function (e = {}) {
      var t = /^#![ ]*\//;return e.binary && (e.begin = function (...e) {
        return e.map(function (e) {
          return g(e);
        }).join("");
      }(t, /.*\b/, e.binary, /\b.*/)), a({ className: "meta", begin: t, end: /$/, relevance: 0, "on:begin": function (e, t) {
          0 !== e.index && t.ignoreMatch();
        } }, e);
    }, BACKSLASH_ESCAPE: b, APOS_STRING_MODE: E,
    QUOTE_STRING_MODE: x, PHRASAL_WORDS_MODE: v, COMMENT: w, C_LINE_COMMENT_MODE: y,
    C_BLOCK_COMMENT_MODE: N, HASH_COMMENT_MODE: R, NUMBER_MODE: { className: "number",
      begin: f, relevance: 0 }, C_NUMBER_MODE: { className: "number", begin: p, relevance: 0 },
    BINARY_NUMBER_MODE: { className: "number", begin: m, relevance: 0 }, CSS_NUMBER_MODE: {
      className: "number",
      begin: f + "(%|em|ex|ch|rem|vw|vh|vmin|vmax|cm|mm|in|pt|pc|px|deg|grad|rad|turn|s|ms|Hz|kHz|dpi|dpcm|dppx)?",
      relevance: 0 }, REGEXP_MODE: { begin: /(?=\/[^/\n]*\/)/, contains: [{ className: "regexp",
        begin: /\//, end: /\/[gimuy]*/, illegal: /\n/, contains: [b, { begin: /\[/, end: /\]/,
          relevance: 0, contains: [b] }] }] }, TITLE_MODE: { className: "title", begin: h, relevance: 0
    }, UNDERSCORE_TITLE_MODE: { className: "title", begin: d, relevance: 0 }, METHOD_GUARD: {
      begin: "\\.\\s*[a-zA-Z_]\\w*", relevance: 0 }, END_SAME_AS_BEGIN: function (e) {
      return Object.assign(e, {
        "on:begin": function (e, t) {
          t.data._beginMatch = e[1];
        }, "on:end": function (e, t) {
          t.data._beginMatch !== e[1] && t.ignoreMatch();
        } });
    } });function k(e, t) {
    "." === e.input[e.index - 1] && t.ignoreMatch();
  }function M(e, t) {
    t && e.beginKeywords && (e.begin = "\\b(" + e.beginKeywords.split(" ").join("|") + ")(?!\\.)(?=\\b|\\s)", e.__beforeBegin = k, e.keywords = e.keywords || e.beginKeywords, delete e.beginKeywords, void 0 === e.relevance && (e.relevance = 0));
  }function O(e, t) {
    Array.isArray(e.illegal) && (e.illegal = function (...e) {
      return "(" + e.map(function (e) {
        return g(e);
      }).join("|") + ")";
    }(...e.illegal));
  }function A(e, t) {
    if (e.match) {
      if (e.begin || e.end) throw Error("begin & end are not supported with match");e.begin = e.match, delete e.match;
    }
  }function L(e, t) {
    void 0 === e.relevance && (e.relevance = 1);
  }
  var I = ["of", "and", "for", "in", "not", "or", "if", "then", "parent", "list", "value"];function j(e, t, n = "keyword") {
    var i = {};return "string" == typeof e ? s(n, e.split(" ")) : Array.isArray(e) ? s(n, e) : Object.keys(e).forEach(function (n) {
      Object.assign(i, j(e[n], t, n));
    }), i;function s(e, n) {
      t && (n = n.map(function (e) {
        return e.toLowerCase();
      })), n.forEach(function (t) {
        var n = t.split("|");i[n[0]] = [e, B(n[0], n[1])];
      });
    }
  }function B(e, t) {
    return t ? Number(t) : function (e) {
      return I.includes(e.toLowerCase());
    }(e) ? 0 : 1;
  }
  function T(e, { plugins: t }) {
    function n(t, n) {
      return RegExp(g(t), "m" + (e.case_insensitive ? "i" : "") + (n ? "g" : ""));
    }
    var i = function () {
      function i() {
        _classCallCheck(this, i);

        this.matchIndexes = {}, this.regexes = [], this.matchAt = 1, this.position = 0;
      }

      _createClass(i, [{
        key: "addRule",
        value: function addRule(e, t) {
          t.position = this.position++, this.matchIndexes[this.matchAt] = t, this.regexes.push([t, e]), this.matchAt += function (e) {
            return RegExp(e.toString() + "|").exec("").length - 1;
          }(e) + 1;
        }
      }, {
        key: "compile",
        value: function compile() {
          0 === this.regexes.length && (this.exec = function () {
            return null;
          });var e = this.regexes.map(function (e) {
            return e[1];
          });this.matcherRe = n(function (e, t = "|") {
            var n = 0;return e.map(function (e) {
              n += 1;var t = n;var i = g(e),
                  s = "";for (; i.length > 0;) {
                var _e = u.exec(i);if (!_e) {
                  s += i;break;
                }
                s += i.substring(0, _e.index), i = i.substring(_e.index + _e[0].length), "\\" === _e[0][0] && _e[1] ? s += "\\" + (Number(_e[1]) + t) : (s += _e[0], "(" === _e[0] && n++);
              }return s;
            }).map(function (e) {
              return "(" + e + ")";
            }).join(t);
          }(e), !0), this.lastIndex = 0;
        }
      }, {
        key: "exec",
        value: function exec(e) {
          this.matcherRe.lastIndex = this.lastIndex;var t = this.matcherRe.exec(e);if (!t) return null;var n = t.findIndex(function (e, t) {
            return t > 0 && void 0 !== e;
          }),
              i = this.matchIndexes[n];return t.splice(0, n), Object.assign(t, i);
        }
      }]);

      return i;
    }();

    var s = function () {
      function s() {
        _classCallCheck(this, s);

        this.rules = [], this.multiRegexes = [], this.count = 0, this.lastIndex = 0, this.regexIndex = 0;
      }

      _createClass(s, [{
        key: "getMatcher",
        value: function getMatcher(e) {
          if (this.multiRegexes[e]) return this.multiRegexes[e];var t = new i();return this.rules.slice(e).forEach(function ([e, n]) {
            return t.addRule(e, n);
          }), t.compile(), this.multiRegexes[e] = t, t;
        }
      }, {
        key: "resumingScanAtSamePosition",
        value: function resumingScanAtSamePosition() {
          return 0 !== this.regexIndex;
        }
      }, {
        key: "considerAll",
        value: function considerAll() {
          this.regexIndex = 0;
        }
      }, {
        key: "addRule",
        value: function addRule(e, t) {
          this.rules.push([e, t]), "begin" === t.type && this.count++;
        }
      }, {
        key: "exec",
        value: function exec(e) {
          var t = this.getMatcher(this.regexIndex);t.lastIndex = this.lastIndex;var n = t.exec(e);if (this.resumingScanAtSamePosition()) if (n && n.index === this.lastIndex) ;else {
            var _t3 = this.getMatcher(0);_t3.lastIndex = this.lastIndex + 1, n = _t3.exec(e);
          }
          return n && (this.regexIndex += n.position + 1, this.regexIndex === this.count && this.considerAll()), n;
        }
      }]);

      return s;
    }();

    if (e.compilerExtensions || (e.compilerExtensions = []), e.contains && e.contains.includes("self")) throw Error("ERR: contains `self` is not supported at the top-level of a language.  See documentation.");return e.classNameAliases = a(e.classNameAliases || {}), function t(i, r) {
      var l = i;if (i.isCompiled) return l;[A].forEach(function (e) {
        return e(i, r);
      }), e.compilerExtensions.forEach(function (e) {
        return e(i, r);
      }), i.__beforeBegin = null, [M, O, L].forEach(function (e) {
        return e(i, r);
      }), i.isCompiled = !0;var o = null;if ("object" == typeof i.keywords && (o = i.keywords.$pattern, delete i.keywords.$pattern), i.keywords && (i.keywords = j(i.keywords, e.case_insensitive)), i.lexemes && o) throw Error("ERR: Prefer `keywords.$pattern` to `mode.lexemes`, BOTH are not allowed. (see mode reference) ");return o = o || i.lexemes || /\w+/, l.keywordPatternRe = n(o, !0), r && (i.begin || (i.begin = /\B|\b/), l.beginRe = n(i.begin), i.endSameAsBegin && (i.end = i.begin), i.end || i.endsWithParent || (i.end = /\B|\b/), i.end && (l.endRe = n(i.end)), l.terminatorEnd = g(i.end) || "", i.endsWithParent && r.terminatorEnd && (l.terminatorEnd += (i.end ? "|" : "") + r.terminatorEnd)), i.illegal && (l.illegalRe = n(i.illegal)), i.contains || (i.contains = []), i.contains = [].concat(...i.contains.map(function (e) {
        return function (e) {
          return e.variants && !e.cachedVariants && (e.cachedVariants = e.variants.map(function (t) {
            return a(e, {
              variants: null }, t);
          })), e.cachedVariants ? e.cachedVariants : S(e) ? a(e, {
            starts: e.starts ? a(e.starts) : null
          }) : Object.isFrozen(e) ? a(e) : e;
        }("self" === e ? i : e);
      })), i.contains.forEach(function (e) {
        t(e, l);
      }), i.starts && t(i.starts, r), l.matcher = function (e) {
        var t = new s();return e.contains.forEach(function (e) {
          return t.addRule(e.begin, { rule: e, type: "begin"
          });
        }), e.terminatorEnd && t.addRule(e.terminatorEnd, { type: "end"
        }), e.illegal && t.addRule(e.illegal, { type: "illegal" }), t;
      }(l), l;
    }(e);
  }function S(e) {
    return !!e && (e.endsWithParent || S(e.starts));
  }function P(e) {
    var t = {
      props: ["language", "code", "autodetect"], data: function () {
        return { detectedLanguage: "",
          unknownLanguage: !1 };
      }, computed: { className() {
          return this.unknownLanguage ? "" : "hljs " + this.detectedLanguage;
        }, highlighted() {
          if (!this.autoDetect && !e.getLanguage(this.language)) return console.warn("The language \"" + this.language + "\" you specified could not be found."), this.unknownLanguage = !0, s(this.code);var t = {};return this.autoDetect ? (t = e.highlightAuto(this.code), this.detectedLanguage = t.language) : (t = e.highlight(this.language, this.code, this.ignoreIllegals), this.detectedLanguage = this.language), t.value;
        }, autoDetect() {
          return !(this.language && (e = this.autodetect, !e && "" !== e));var e;
        },
        ignoreIllegals: function () {
          return !0;
        } }, render(e) {
        return e("pre", {}, [e("code", {
          class: this.className, domProps: { innerHTML: this.highlighted } })]);
      } };return {
      Component: t, VuePlugin: { install(e) {
          e.component("highlightjs", t);
        } } };
  }var D = {
    "after:highlightElement": function ({ el: e, result: t, text: n }) {
      var i = H(e);if (!i.length) return;var a = document.createElement("div");a.innerHTML = t.value, t.value = function (e, t, n) {
        var i = 0,
            a = "";var r = [];function l() {
          return e.length && t.length ? e[0].offset !== t[0].offset ? e[0].offset < t[0].offset ? e : t : "start" === t[0].event ? e : t : e.length ? e : t;
        }function o(e) {
          a += "<" + C(e) + [].map.call(e.attributes, function (e) {
            return " " + e.nodeName + '="' + s(e.value) + '"';
          }).join("") + ">";
        }function c(e) {
          a += "</" + C(e) + ">";
        }function g(e) {
          ("start" === e.event ? o : c)(e.node);
        }
        for (; e.length || t.length;) {
          var _t4 = l();if (a += s(n.substring(i, _t4[0].offset)), i = _t4[0].offset, _t4 === e) {
            r.reverse().forEach(c);do {
              g(_t4.splice(0, 1)[0]), _t4 = l();
            } while (_t4 === e && _t4.length && _t4[0].offset === i);r.reverse().forEach(o);
          } else "start" === _t4[0].event ? r.push(_t4[0].node) : r.pop(), g(_t4.splice(0, 1)[0]);
        }
        return a + s(n.substr(i));
      }(i, H(a), n);
    } };function C(e) {
    return e.nodeName.toLowerCase();
  }function H(e) {
    var t = [];return function e(n, i) {
      for (var _s = n.firstChild; _s; _s = _s.nextSibling) {
        3 === _s.nodeType ? i += _s.nodeValue.length : 1 === _s.nodeType && (t.push({
          event: "start", offset: i, node: _s }), i = e(_s, i), C(_s).match(/br|hr|img|input/) || t.push({
          event: "stop", offset: i, node: _s }));
      }return i;
    }(e, 0), t;
  }var $ = {},
      U = function (e) {
    console.error(e);
  },
      z = function (e, ...t) {
    console.log("WARN: " + e, ...t);
  },
      K = function (e, t) {
    $[e + "/" + t] || (console.log("Deprecated as of " + e + ". " + t), $[e + "/" + t] = !0);
  },
      G = s,
      V = a,
      W = Symbol("nomatch");return function (e) {
    var n = Object.create(null),
        s = Object.create(null),
        a = [];var r = !0;var l = /(^(<[^>]+>|\t|)+|\n)/gm,
        o = "Could not find the language '{}', did you forget to load/include a language module?",
        g = {
      disableAutodetect: !0, name: "Plain text", contains: [] };var u = {
      noHighlightRe: /^(no-?highlight)$/i,
      languageDetectRe: /\blang(?:uage)?-([\w-]+)\b/i, classPrefix: "hljs-",
      tabReplace: null, useBR: !1, languages: null, __emitter: c };function h(e) {
      return u.noHighlightRe.test(e);
    }function d(e, t, n, i) {
      var s = "",
          a = "";"object" == typeof t ? (s = e, n = t.ignoreIllegals, a = t.language, i = void 0) : (K("10.7.0", "highlight(lang, code, ...args) has been deprecated."), K("10.7.0", "Please use highlight(code, options) instead.\nhttps://github.com/highlightjs/highlight.js/issues/2277"), a = e, s = t);var r = { code: s, language: a };M("before:highlight", r);var l = r.result ? r.result : f(r.language, r.code, n, i);return l.code = r.code, M("after:highlight", l), l;
    }function f(e, t, s, l) {
      function c(e, t) {
        var n = v.case_insensitive ? t[0].toLowerCase() : t[0];return Object.prototype.hasOwnProperty.call(e.keywords, n) && e.keywords[n];
      }
      function g() {
        null != R.subLanguage ? function () {
          if ("" === M) return;var e = null;if ("string" == typeof R.subLanguage) {
            if (!n[R.subLanguage]) return void k.addText(M);e = f(R.subLanguage, M, !0, _[R.subLanguage]), _[R.subLanguage] = e.top;
          } else e = p(M, R.subLanguage.length ? R.subLanguage : null);R.relevance > 0 && (O += e.relevance), k.addSublanguage(e.emitter, e.language);
        }() : function () {
          if (!R.keywords) return void k.addText(M);var e = 0;R.keywordPatternRe.lastIndex = 0;var t = R.keywordPatternRe.exec(M),
              n = "";for (; t;) {
            n += M.substring(e, t.index);var _i = c(R, t);if (_i) {
              var [_e2, _s2] = _i;if (k.addText(n), n = "", O += _s2, _e2.startsWith("_")) n += t[0];else {
                var _n = v.classNameAliases[_e2] || _e2;k.addKeyword(t[0], _n);
              }
            } else n += t[0];e = R.keywordPatternRe.lastIndex, t = R.keywordPatternRe.exec(M);
          }
          n += M.substr(e), k.addText(n);
        }(), M = "";
      }function h(e) {
        return e.className && k.openNode(v.classNameAliases[e.className] || e.className), R = Object.create(e, { parent: { value: R } }), R;
      }function d(e, t, n) {
        var s = function (e, t) {
          var n = e && e.exec(t);return n && 0 === n.index;
        }(e.endRe, n);if (s) {
          if (e["on:end"]) {
            var _n2 = new i(e);e["on:end"](t, _n2), _n2.isMatchIgnored && (s = !1);
          }if (s) {
            for (; e.endsParent && e.parent;) {
              e = e.parent;
            }return e;
          }
        }
        if (e.endsWithParent) return d(e.parent, t, n);
      }function m(e) {
        return 0 === R.matcher.regexIndex ? (M += e[0], 1) : (I = !0, 0);
      }function b(e) {
        var n = e[0],
            i = t.substr(e.index),
            s = d(R, e, i);if (!s) return W;var a = R;a.skip ? M += n : (a.returnEnd || a.excludeEnd || (M += n), g(), a.excludeEnd && (M = n));do {
          R.className && k.closeNode(), R.skip || R.subLanguage || (O += R.relevance), R = R.parent;
        } while (R !== s.parent);return s.starts && (s.endSameAsBegin && (s.starts.endRe = s.endRe), h(s.starts)), a.returnEnd ? 0 : n.length;
      }var E = {};function x(n, a) {
        var l = a && a[0];if (M += n, null == l) return g(), 0;if ("begin" === E.type && "end" === a.type && E.index === a.index && "" === l) {
          if (M += t.slice(a.index, a.index + 1), !r) {
            var _t5 = Error("0 width match regex");throw _t5.languageName = e, _t5.badRule = E.rule, _t5;
          }return 1;
        }
        if (E = a, "begin" === a.type) return function (e) {
          var t = e[0],
              n = e.rule,
              s = new i(n),
              a = [n.__beforeBegin, n["on:begin"]];for (var _n3 of a) {
            if (_n3 && (_n3(e, s), s.isMatchIgnored)) return m(t);
          }return n && n.endSameAsBegin && (n.endRe = RegExp(t.replace(/[-/\\^$*+?.()|[\]{}]/g, "\\$&"), "m")), n.skip ? M += t : (n.excludeBegin && (M += t), g(), n.returnBegin || n.excludeBegin || (M = t)), h(n), n.returnBegin ? 0 : t.length;
        }(a);if ("illegal" === a.type && !s) {
          var _e3 = Error('Illegal lexeme "' + l + '" for mode "' + (R.className || "<unnamed>") + '"');throw _e3.mode = R, _e3;
        }if ("end" === a.type) {
          var _e4 = b(a);if (_e4 !== W) return _e4;
        }
        if ("illegal" === a.type && "" === l) return 1;if (L > 1e5 && L > 3 * a.index) throw Error("potential infinite loop, way more iterations than matches");return M += l, l.length;
      }var v = N(e);if (!v) throw U(o.replace("{}", e)), Error('Unknown language: "' + e + '"');var w = T(v, { plugins: a });var y = "",
          R = l || w;var _ = {},
          k = new u.__emitter(u);(function () {
        var e = [];for (var _t6 = R; _t6 !== v; _t6 = _t6.parent) {
          _t6.className && e.unshift(_t6.className);
        }e.forEach(function (e) {
          return k.openNode(e);
        });
      })();var M = "",
          O = 0,
          A = 0,
          L = 0,
          I = !1;try {
        for (R.matcher.considerAll();;) {
          L++, I ? I = !1 : R.matcher.considerAll(), R.matcher.lastIndex = A;var _e5 = R.matcher.exec(t);if (!_e5) break;var _n4 = x(t.substring(A, _e5.index), _e5);A = _e5.index + _n4;
        }return x(t.substr(A)), k.closeAllNodes(), k.finalize(), y = k.toHTML(), {
          relevance: Math.floor(O), value: y, language: e, illegal: !1, emitter: k, top: R };
      } catch (n) {
        if (n.message && n.message.includes("Illegal")) return { illegal: !0, illegalBy: {
            msg: n.message, context: t.slice(A - 100, A + 100), mode: n.mode }, sofar: y, relevance: 0,
          value: G(t), emitter: k };if (r) return { illegal: !1, relevance: 0, value: G(t), emitter: k,
          language: e, top: R, errorRaised: n };throw n;
      }
    }function p(e, t) {
      t = t || u.languages || Object.keys(n);var i = function (e) {
        var t = { relevance: 0,
          emitter: new u.__emitter(u), value: G(e), illegal: !1, top: g };return t.emitter.addText(e), t;
      }(e),
          s = t.filter(N).filter(k).map(function (t) {
        return f(t, e, !1);
      });s.unshift(i);var a = s.sort(function (e, t) {
        if (e.relevance !== t.relevance) return t.relevance - e.relevance;if (e.language && t.language) {
          if (N(e.language).supersetOf === t.language) return 1;if (N(t.language).supersetOf === e.language) return -1;
        }return 0;
      }),
          [r, l] = a,
          o = r;return o.second_best = l, o;
    }var m = { "before:highlightElement": function ({ el: e }) {
        u.useBR && (e.innerHTML = e.innerHTML.replace(/\n/g, "").replace(/<br[ /]*>/g, "\n"));
      }, "after:highlightElement": function ({ result: e }) {
        u.useBR && (e.value = e.value.replace(/\n/g, "<br>"));
      } },
        b = /^(<[^>]+>|\t)+/gm,
        E = {
      "after:highlightElement": function ({ result: e }) {
        u.tabReplace && (e.value = e.value.replace(b, function (e) {
          return e.replace(/\t/g, u.tabReplace);
        }));
      } };function x(e) {
      var t = null;var n = function (e) {
        var t = e.className + " ";t += e.parentNode ? e.parentNode.className : "";var n = u.languageDetectRe.exec(t);if (n) {
          var _t7 = N(n[1]);return _t7 || (z(o.replace("{}", n[1])), z("Falling back to no-highlight mode for this block.", e)), _t7 ? n[1] : "no-highlight";
        }return t.split(/\s+/).find(function (e) {
          return h(e) || N(e);
        });
      }(e);if (h(n)) return;M("before:highlightElement", { el: e, language: n }), t = e;var i = t.textContent,
          a = n ? d(i, { language: n, ignoreIllegals: !0 }) : p(i);M("after:highlightElement", { el: e, result: a, text: i
      }), e.innerHTML = a.value, function (e, t, n) {
        var i = t ? s[t] : n;e.classList.add("hljs"), i && e.classList.add(i);
      }(e, n, a.language), e.result = {
        language: a.language, re: a.relevance, relavance: a.relevance
      }, a.second_best && (e.second_best = { language: a.second_best.language,
        re: a.second_best.relevance, relavance: a.second_best.relevance });
    }var v = function () {
      v.called || (v.called = !0, K("10.6.0", "initHighlighting() is deprecated.  Use highlightAll() instead."), document.querySelectorAll("pre code").forEach(x));
    };var w = !1;function y() {
      "loading" !== document.readyState ? document.querySelectorAll("pre code").forEach(x) : w = !0;
    }function N(e) {
      return e = (e || "").toLowerCase(), n[e] || n[s[e]];
    }
    function R(e, { languageName: t }) {
      "string" == typeof e && (e = [e]), e.forEach(function (e) {
        s[e.toLowerCase()] = t;
      });
    }function k(e) {
      var t = N(e);return t && !t.disableAutodetect;
    }function M(e, t) {
      var n = e;a.forEach(function (e) {
        e[n] && e[n](t);
      });
    }
    "undefined" != typeof window && window.addEventListener && window.addEventListener("DOMContentLoaded", function () {
      w && y();
    }, !1), Object.assign(e, { highlight: d, highlightAuto: p, highlightAll: y,
      fixMarkup: function (e) {
        return K("10.2.0", "fixMarkup will be removed entirely in v11.0"), K("10.2.0", "Please see https://github.com/highlightjs/highlight.js/issues/2534"), t = e, u.tabReplace || u.useBR ? t.replace(l, function (e) {
          return "\n" === e ? u.useBR ? "<br>" : e : u.tabReplace ? e.replace(/\t/g, u.tabReplace) : e;
        }) : t;var t;
      }, highlightElement: x,
      highlightBlock: function (e) {
        return K("10.7.0", "highlightBlock will be removed entirely in v12.0"), K("10.7.0", "Please use highlightElement now."), x(e);
      }, configure: function (e) {
        e.useBR && (K("10.3.0", "'useBR' will be removed entirely in v11.0"), K("10.3.0", "Please see https://github.com/highlightjs/highlight.js/issues/2559")), u = V(u, e);
      }, initHighlighting: v, initHighlightingOnLoad: function () {
        K("10.6.0", "initHighlightingOnLoad() is deprecated.  Use highlightAll() instead."), w = !0;
      }, registerLanguage: function (t, i) {
        var s = null;try {
          s = i(e);
        } catch (e) {
          if (U("Language definition for '{}' could not be registered.".replace("{}", t)), !r) throw e;U(e), s = g;
        }
        s.name || (s.name = t), n[t] = s, s.rawDefinition = i.bind(null, e), s.aliases && R(s.aliases, {
          languageName: t });
      }, unregisterLanguage: function (e) {
        delete n[e];for (var _t8 of Object.keys(s)) {
          s[_t8] === e && delete s[_t8];
        }
      },
      listLanguages: function () {
        return Object.keys(n);
      }, getLanguage: N, registerAliases: R,
      requireLanguage: function (e) {
        K("10.4.0", "requireLanguage will be removed entirely in v11."), K("10.4.0", "Please see https://github.com/highlightjs/highlight.js/pull/2844");var t = N(e);if (t) return t;throw Error("The '{}' language is required, but not loaded.".replace("{}", e));
      },
      autoDetection: k, inherit: V, addPlugin: function (e) {
        (function (e) {
          e["before:highlightBlock"] && !e["before:highlightElement"] && (e["before:highlightElement"] = function (t) {
            e["before:highlightBlock"](Object.assign({ block: t.el }, t));
          }), e["after:highlightBlock"] && !e["after:highlightElement"] && (e["after:highlightElement"] = function (t) {
            e["after:highlightBlock"](Object.assign({ block: t.el }, t));
          });
        })(e), a.push(e);
      },
      vuePlugin: P(e).VuePlugin }), e.debugMode = function () {
      r = !1;
    }, e.safeMode = function () {
      r = !0;
    }, e.versionString = "10.7.2";for (var _e6 in _) {
      "object" == typeof _[_e6] && t(_[_e6]);
    }return Object.assign(e, _), e.addPlugin(m), e.addPlugin(D), e.addPlugin(E), e;
  }({});
}();"object" == typeof exports && "undefined" != typeof module && (module.exports = hljs);hljs.registerLanguage("plaintext", function () {
  "use strict";
  return function (t) {
    return {
      name: "Plain text", aliases: ["text", "txt"], disableAutodetect: !0 };
  };
}());hljs.registerLanguage("stylus", function () {
  "use strict";
  var e = ["a", "abbr", "address", "article", "aside", "audio", "b", "blockquote", "body", "button", "canvas", "caption", "cite", "code", "dd", "del", "details", "dfn", "div", "dl", "dt", "em", "fieldset", "figcaption", "figure", "footer", "form", "h1", "h2", "h3", "h4", "h5", "h6", "header", "hgroup", "html", "i", "iframe", "img", "input", "ins", "kbd", "label", "legend", "li", "main", "mark", "menu", "nav", "object", "ol", "p", "q", "quote", "samp", "section", "span", "strong", "summary", "sup", "table", "tbody", "td", "textarea", "tfoot", "th", "thead", "time", "tr", "ul", "var", "video"],
      t = ["any-hover", "any-pointer", "aspect-ratio", "color", "color-gamut", "color-index", "device-aspect-ratio", "device-height", "device-width", "display-mode", "forced-colors", "grid", "height", "hover", "inverted-colors", "monochrome", "orientation", "overflow-block", "overflow-inline", "pointer", "prefers-color-scheme", "prefers-contrast", "prefers-reduced-motion", "prefers-reduced-transparency", "resolution", "scan", "scripting", "update", "width", "min-width", "max-width", "min-height", "max-height"],
      o = ["active", "any-link", "blank", "checked", "current", "default", "defined", "dir", "disabled", "drop", "empty", "enabled", "first", "first-child", "first-of-type", "fullscreen", "future", "focus", "focus-visible", "focus-within", "has", "host", "host-context", "hover", "indeterminate", "in-range", "invalid", "is", "lang", "last-child", "last-of-type", "left", "link", "local-link", "not", "nth-child", "nth-col", "nth-last-child", "nth-last-col", "nth-last-of-type", "nth-of-type", "only-child", "only-of-type", "optional", "out-of-range", "past", "placeholder-shown", "read-only", "read-write", "required", "right", "root", "scope", "target", "target-within", "user-invalid", "valid", "visited", "where"],
      i = ["after", "backdrop", "before", "cue", "cue-region", "first-letter", "first-line", "grammar-error", "marker", "part", "placeholder", "selection", "slotted", "spelling-error"],
      r = ["align-content", "align-items", "align-self", "animation", "animation-delay", "animation-direction", "animation-duration", "animation-fill-mode", "animation-iteration-count", "animation-name", "animation-play-state", "animation-timing-function", "auto", "backface-visibility", "background", "background-attachment", "background-clip", "background-color", "background-image", "background-origin", "background-position", "background-repeat", "background-size", "border", "border-bottom", "border-bottom-color", "border-bottom-left-radius", "border-bottom-right-radius", "border-bottom-style", "border-bottom-width", "border-collapse", "border-color", "border-image", "border-image-outset", "border-image-repeat", "border-image-slice", "border-image-source", "border-image-width", "border-left", "border-left-color", "border-left-style", "border-left-width", "border-radius", "border-right", "border-right-color", "border-right-style", "border-right-width", "border-spacing", "border-style", "border-top", "border-top-color", "border-top-left-radius", "border-top-right-radius", "border-top-style", "border-top-width", "border-width", "bottom", "box-decoration-break", "box-shadow", "box-sizing", "break-after", "break-before", "break-inside", "caption-side", "clear", "clip", "clip-path", "color", "column-count", "column-fill", "column-gap", "column-rule", "column-rule-color", "column-rule-style", "column-rule-width", "column-span", "column-width", "columns", "content", "counter-increment", "counter-reset", "cursor", "direction", "display", "empty-cells", "filter", "flex", "flex-basis", "flex-direction", "flex-flow", "flex-grow", "flex-shrink", "flex-wrap", "float", "font", "font-display", "font-family", "font-feature-settings", "font-kerning", "font-language-override", "font-size", "font-size-adjust", "font-smoothing", "font-stretch", "font-style", "font-variant", "font-variant-ligatures", "font-variation-settings", "font-weight", "height", "hyphens", "icon", "image-orientation", "image-rendering", "image-resolution", "ime-mode", "inherit", "initial", "justify-content", "left", "letter-spacing", "line-height", "list-style", "list-style-image", "list-style-position", "list-style-type", "margin", "margin-bottom", "margin-left", "margin-right", "margin-top", "marks", "mask", "max-height", "max-width", "min-height", "min-width", "nav-down", "nav-index", "nav-left", "nav-right", "nav-up", "none", "normal", "object-fit", "object-position", "opacity", "order", "orphans", "outline", "outline-color", "outline-offset", "outline-style", "outline-width", "overflow", "overflow-wrap", "overflow-x", "overflow-y", "padding", "padding-bottom", "padding-left", "padding-right", "padding-top", "page-break-after", "page-break-before", "page-break-inside", "perspective", "perspective-origin", "pointer-events", "position", "quotes", "resize", "right", "src", "tab-size", "table-layout", "text-align", "text-align-last", "text-decoration", "text-decoration-color", "text-decoration-line", "text-decoration-style", "text-indent", "text-overflow", "text-rendering", "text-shadow", "text-transform", "text-underline-position", "top", "transform", "transform-origin", "transform-style", "transition", "transition-delay", "transition-duration", "transition-property", "transition-timing-function", "unicode-bidi", "vertical-align", "visibility", "white-space", "widows", "width", "word-break", "word-spacing", "word-wrap", "z-index"].reverse();return function (n) {
    var a = function (e) {
      return { IMPORTANT: { className: "meta", begin: "!important" },
        HEXCOLOR: { className: "number", begin: "#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})" },
        ATTRIBUTE_SELECTOR_MODE: { className: "selector-attr", begin: /\[/, end: /\]/,
          illegal: "$", contains: [e.APOS_STRING_MODE, e.QUOTE_STRING_MODE] } };
    }(n),
        s = {
      className: "variable", begin: "\\$" + n.IDENT_RE },
        l = "(?=[.\\s\\n[:,(])";return {
      name: "Stylus", aliases: ["styl"], case_insensitive: !1, keywords: "if else for in",
      illegal: "(\\?|(\\bReturn\\b)|(\\bEnd\\b)|(\\bend\\b)|(\\bdef\\b)|;|#\\s|\\*\\s|===\\s|\\||%)",
      contains: [n.QUOTE_STRING_MODE, n.APOS_STRING_MODE, n.C_LINE_COMMENT_MODE, n.C_BLOCK_COMMENT_MODE, a.HEXCOLOR, {
        begin: "\\.[a-zA-Z][a-zA-Z0-9_-]*(?=[.\\s\\n[:,(])", className: "selector-class" }, {
        begin: "#[a-zA-Z][a-zA-Z0-9_-]*(?=[.\\s\\n[:,(])", className: "selector-id" }, {
        begin: "\\b(" + e.join("|") + ")" + l, className: "selector-tag" }, {
        className: "selector-pseudo", begin: "&?:(" + o.join("|") + ")" + l }, {
        className: "selector-pseudo", begin: "&?::(" + i.join("|") + ")" + l
      }, a.ATTRIBUTE_SELECTOR_MODE, { className: "keyword", begin: /@media/, starts: {
          end: /[{;}]/, keywords: { $pattern: /[a-z-]+/, keyword: "and or not only",
            attribute: t.join(" ") }, contains: [n.CSS_NUMBER_MODE] } }, { className: "keyword",
        begin: "@((-(o|moz|ms|webkit)-)?(charset|css|debug|extend|font-face|for|import|include|keyframes|media|mixin|page|warn|while))\\b"
      }, s, n.CSS_NUMBER_MODE, { className: "function",
        begin: "^[a-zA-Z][a-zA-Z0-9_-]*\\(.*\\)", illegal: "[\\n]", returnBegin: !0,
        contains: [{ className: "title", begin: "\\b[a-zA-Z][a-zA-Z0-9_-]*" }, {
          className: "params", begin: /\(/, end: /\)/,
          contains: [a.HEXCOLOR, s, n.APOS_STRING_MODE, n.CSS_NUMBER_MODE, n.QUOTE_STRING_MODE]
        }] }, { className: "attribute", begin: "\\b(" + r.join("|") + ")\\b", starts: { end: /;|$/,
          contains: [a.HEXCOLOR, s, n.APOS_STRING_MODE, n.QUOTE_STRING_MODE, n.CSS_NUMBER_MODE, n.C_BLOCK_COMMENT_MODE, a.IMPORTANT],
          illegal: /\./, relevance: 0 } }] };
  };
}());hljs.registerLanguage("properties", function () {
  "use strict";
  return function (e) {
    var n = "[ \\t\\f]*",
        a = n + "[:=]" + n,
        t = "(" + a + "|[ \\t\\f]+)",
        r = "([^\\\\\\W:= \\t\\f\\n]|\\\\.)+",
        s = "([^\\\\:= \\t\\f\\n]|\\\\.)+",
        i = {
      end: t, relevance: 0, starts: { className: "string", end: /$/, relevance: 0, contains: [{
          begin: "\\\\\\\\" }, { begin: "\\\\\\n" }] } };return { name: ".properties",
      case_insensitive: !0, illegal: /\S/, contains: [e.COMMENT("^\\s*[!#]", "$"), {
        returnBegin: !0, variants: [{ begin: r + a, relevance: 1 }, { begin: r + "[ \\t\\f]+",
          relevance: 0 }], contains: [{ className: "attr", begin: r, endsParent: !0, relevance: 0 }],
        starts: i }, { begin: s + t, returnBegin: !0, relevance: 0, contains: [{ className: "meta",
          begin: s, endsParent: !0, relevance: 0 }], starts: i }, { className: "attr", relevance: 0,
        begin: s + n + "$" }] };
  };
}());hljs.registerLanguage("css", function () {
  "use strict";
  var e = ["a", "abbr", "address", "article", "aside", "audio", "b", "blockquote", "body", "button", "canvas", "caption", "cite", "code", "dd", "del", "details", "dfn", "div", "dl", "dt", "em", "fieldset", "figcaption", "figure", "footer", "form", "h1", "h2", "h3", "h4", "h5", "h6", "header", "hgroup", "html", "i", "iframe", "img", "input", "ins", "kbd", "label", "legend", "li", "main", "mark", "menu", "nav", "object", "ol", "p", "q", "quote", "samp", "section", "span", "strong", "summary", "sup", "table", "tbody", "td", "textarea", "tfoot", "th", "thead", "time", "tr", "ul", "var", "video"],
      t = ["any-hover", "any-pointer", "aspect-ratio", "color", "color-gamut", "color-index", "device-aspect-ratio", "device-height", "device-width", "display-mode", "forced-colors", "grid", "height", "hover", "inverted-colors", "monochrome", "orientation", "overflow-block", "overflow-inline", "pointer", "prefers-color-scheme", "prefers-contrast", "prefers-reduced-motion", "prefers-reduced-transparency", "resolution", "scan", "scripting", "update", "width", "min-width", "max-width", "min-height", "max-height"],
      i = ["active", "any-link", "blank", "checked", "current", "default", "defined", "dir", "disabled", "drop", "empty", "enabled", "first", "first-child", "first-of-type", "fullscreen", "future", "focus", "focus-visible", "focus-within", "has", "host", "host-context", "hover", "indeterminate", "in-range", "invalid", "is", "lang", "last-child", "last-of-type", "left", "link", "local-link", "not", "nth-child", "nth-col", "nth-last-child", "nth-last-col", "nth-last-of-type", "nth-of-type", "only-child", "only-of-type", "optional", "out-of-range", "past", "placeholder-shown", "read-only", "read-write", "required", "right", "root", "scope", "target", "target-within", "user-invalid", "valid", "visited", "where"],
      o = ["after", "backdrop", "before", "cue", "cue-region", "first-letter", "first-line", "grammar-error", "marker", "part", "placeholder", "selection", "slotted", "spelling-error"],
      r = ["align-content", "align-items", "align-self", "animation", "animation-delay", "animation-direction", "animation-duration", "animation-fill-mode", "animation-iteration-count", "animation-name", "animation-play-state", "animation-timing-function", "auto", "backface-visibility", "background", "background-attachment", "background-clip", "background-color", "background-image", "background-origin", "background-position", "background-repeat", "background-size", "border", "border-bottom", "border-bottom-color", "border-bottom-left-radius", "border-bottom-right-radius", "border-bottom-style", "border-bottom-width", "border-collapse", "border-color", "border-image", "border-image-outset", "border-image-repeat", "border-image-slice", "border-image-source", "border-image-width", "border-left", "border-left-color", "border-left-style", "border-left-width", "border-radius", "border-right", "border-right-color", "border-right-style", "border-right-width", "border-spacing", "border-style", "border-top", "border-top-color", "border-top-left-radius", "border-top-right-radius", "border-top-style", "border-top-width", "border-width", "bottom", "box-decoration-break", "box-shadow", "box-sizing", "break-after", "break-before", "break-inside", "caption-side", "clear", "clip", "clip-path", "color", "column-count", "column-fill", "column-gap", "column-rule", "column-rule-color", "column-rule-style", "column-rule-width", "column-span", "column-width", "columns", "content", "counter-increment", "counter-reset", "cursor", "direction", "display", "empty-cells", "filter", "flex", "flex-basis", "flex-direction", "flex-flow", "flex-grow", "flex-shrink", "flex-wrap", "float", "font", "font-display", "font-family", "font-feature-settings", "font-kerning", "font-language-override", "font-size", "font-size-adjust", "font-smoothing", "font-stretch", "font-style", "font-variant", "font-variant-ligatures", "font-variation-settings", "font-weight", "height", "hyphens", "icon", "image-orientation", "image-rendering", "image-resolution", "ime-mode", "inherit", "initial", "justify-content", "left", "letter-spacing", "line-height", "list-style", "list-style-image", "list-style-position", "list-style-type", "margin", "margin-bottom", "margin-left", "margin-right", "margin-top", "marks", "mask", "max-height", "max-width", "min-height", "min-width", "nav-down", "nav-index", "nav-left", "nav-right", "nav-up", "none", "normal", "object-fit", "object-position", "opacity", "order", "orphans", "outline", "outline-color", "outline-offset", "outline-style", "outline-width", "overflow", "overflow-wrap", "overflow-x", "overflow-y", "padding", "padding-bottom", "padding-left", "padding-right", "padding-top", "page-break-after", "page-break-before", "page-break-inside", "perspective", "perspective-origin", "pointer-events", "position", "quotes", "resize", "right", "src", "tab-size", "table-layout", "text-align", "text-align-last", "text-decoration", "text-decoration-color", "text-decoration-line", "text-decoration-style", "text-indent", "text-overflow", "text-rendering", "text-shadow", "text-transform", "text-underline-position", "top", "transform", "transform-origin", "transform-style", "transition", "transition-delay", "transition-duration", "transition-property", "transition-timing-function", "unicode-bidi", "vertical-align", "visibility", "white-space", "widows", "width", "word-break", "word-spacing", "word-wrap", "z-index"].reverse();return function (n) {
    var a = function (e) {
      return { IMPORTANT: { className: "meta", begin: "!important" },
        HEXCOLOR: { className: "number", begin: "#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})" },
        ATTRIBUTE_SELECTOR_MODE: { className: "selector-attr", begin: /\[/, end: /\]/,
          illegal: "$", contains: [e.APOS_STRING_MODE, e.QUOTE_STRING_MODE] }
      };
    }(n),
        l = [n.APOS_STRING_MODE, n.QUOTE_STRING_MODE];return { name: "CSS",
      case_insensitive: !0, illegal: /[=|'\$]/, keywords: { keyframePosition: "from to" },
      classNameAliases: { keyframePosition: "selector-tag" },
      contains: [n.C_BLOCK_COMMENT_MODE, { begin: /-(webkit|moz|ms|o)-(?=[a-z])/
      }, n.CSS_NUMBER_MODE, { className: "selector-id", begin: /#[A-Za-z0-9_-]+/, relevance: 0
      }, { className: "selector-class", begin: "\\.[a-zA-Z-][a-zA-Z0-9_-]*", relevance: 0
      }, a.ATTRIBUTE_SELECTOR_MODE, { className: "selector-pseudo", variants: [{
          begin: ":(" + i.join("|") + ")" }, { begin: "::(" + o.join("|") + ")" }] }, {
        className: "attribute", begin: "\\b(" + r.join("|") + ")\\b" }, { begin: ":", end: "[;}]",
        contains: [a.HEXCOLOR, a.IMPORTANT, n.CSS_NUMBER_MODE, ...l, {
          begin: /(url|data-uri)\(/, end: /\)/, relevance: 0, keywords: { built_in: "url data-uri"
          }, contains: [{ className: "string", begin: /[^)]/, endsWithParent: !0, excludeEnd: !0 }]
        }, { className: "built_in", begin: /[\w-]+(?=\()/ }] }, {
        begin: (s = /@/, function (...e) {
          return e.map(function (e) {
            return function (e) {
              return e ? "string" == typeof e ? e : e.source : null;
            }(e);
          }).join("");
        }("(?=", s, ")")),
        end: "[{;]", relevance: 0, illegal: /:/, contains: [{ className: "keyword",
          begin: /@-?\w[\w]*(-\w+)*/ }, { begin: /\s/, endsWithParent: !0, excludeEnd: !0,
          relevance: 0, keywords: { $pattern: /[a-z-]+/, keyword: "and or not only",
            attribute: t.join(" ") }, contains: [{ begin: /[a-z-]+(?=:)/, className: "attribute"
          }, ...l, n.CSS_NUMBER_MODE] }] }, { className: "selector-tag",
        begin: "\\b(" + e.join("|") + ")\\b" }] };var s;
  };
}());hljs.registerLanguage("json", function () {
  "use strict";
  return function (n) {
    var e = {
      literal: "true false null"
    },
        i = [n.C_LINE_COMMENT_MODE, n.C_BLOCK_COMMENT_MODE],
        a = [n.QUOTE_STRING_MODE, n.C_NUMBER_MODE],
        l = {
      end: ",", endsWithParent: !0, excludeEnd: !0, contains: a, keywords: e },
        t = { begin: /\{/,
      end: /\}/, contains: [{ className: "attr", begin: /"/, end: /"/,
        contains: [n.BACKSLASH_ESCAPE], illegal: "\\n" }, n.inherit(l, { begin: /:/
      })].concat(i), illegal: "\\S" },
        s = { begin: "\\[", end: "\\]", contains: [n.inherit(l)],
      illegal: "\\S" };return a.push(t, s), i.forEach(function (n) {
      a.push(n);
    }), { name: "JSON",
      contains: a, keywords: e, illegal: "\\S" };
  };
}());hljs.registerLanguage("xml", function () {
  "use strict";
  function e(e) {
    return e ? "string" == typeof e ? e : e.source : null;
  }function n(e) {
    return a("(?=", e, ")");
  }
  function a(...n) {
    return n.map(function (n) {
      return e(n);
    }).join("");
  }function s(...n) {
    return "(" + n.map(function (n) {
      return e(n);
    }).join("|") + ")";
  }return function (e) {
    var t = a(/[A-Z_]/, a("(", /[A-Z0-9_.-]*:/, ")?"), /[A-Z0-9_.-]*/),
        i = {
      className: "symbol", begin: /&[a-z]+;|&#[0-9]+;|&#x[a-f0-9]+;/ },
        r = { begin: /\s/,
      contains: [{ className: "meta-keyword", begin: /#?[a-z_][a-z1-9_-]+/, illegal: /\n/ }]
    },
        c = e.inherit(r, { begin: /\(/, end: /\)/ }),
        l = e.inherit(e.APOS_STRING_MODE, {
      className: "meta-string" }),
        g = e.inherit(e.QUOTE_STRING_MODE, {
      className: "meta-string" }),
        m = { endsWithParent: !0, illegal: /</, relevance: 0,
      contains: [{ className: "attr", begin: /[A-Za-z0-9._:-]+/, relevance: 0 }, { begin: /=\s*/,
        relevance: 0, contains: [{ className: "string", endsParent: !0, variants: [{ begin: /"/,
            end: /"/, contains: [i] }, { begin: /'/, end: /'/, contains: [i] }, { begin: /[^\s"'=<>`]+/ }] }]
      }] };return { name: "HTML, XML",
      aliases: ["html", "xhtml", "rss", "atom", "xjb", "xsd", "xsl", "plist", "wsf", "svg"],
      case_insensitive: !0, contains: [{ className: "meta", begin: /<![a-z]/, end: />/,
        relevance: 10, contains: [r, g, l, c, { begin: /\[/, end: /\]/, contains: [{ className: "meta",
            begin: /<![a-z]/, end: />/, contains: [r, c, g, l] }] }] }, e.COMMENT(/<!--/, /-->/, {
        relevance: 10 }), { begin: /<!\[CDATA\[/, end: /\]\]>/, relevance: 10 }, i, {
        className: "meta", begin: /<\?xml/, end: /\?>/, relevance: 10 }, { className: "tag",
        begin: /<style(?=\s|>)/, end: />/, keywords: { name: "style" }, contains: [m], starts: {
          end: /<\/style>/, returnEnd: !0, subLanguage: ["css", "xml"] } }, { className: "tag",
        begin: /<script(?=\s|>)/, end: />/, keywords: { name: "script" }, contains: [m], starts: {
          end: /<\/script>/, returnEnd: !0, subLanguage: ["javascript", "handlebars", "xml"] } }, {
        className: "tag", begin: /<>|<\/>/ }, { className: "tag",
        begin: a(/</, n(a(t, s(/\/>/, />/, /\s/)))), end: /\/?>/, contains: [{ className: "name",
          begin: t, relevance: 0, starts: m }] }, { className: "tag", begin: a(/<\//, n(a(t, />/))),
        contains: [{ className: "name", begin: t, relevance: 0 }, { begin: />/, relevance: 0,
          endsParent: !0 }] }] };
  };
}());hljs.registerLanguage("javascript", function () {
  "use strict";
  var e = "[A-Za-z$_][0-9A-Za-z$_]*",
      n = ["as", "in", "of", "if", "for", "while", "finally", "var", "new", "function", "do", "return", "void", "else", "break", "catch", "instanceof", "with", "throw", "case", "default", "try", "switch", "continue", "typeof", "delete", "let", "yield", "const", "class", "debugger", "async", "await", "static", "import", "from", "export", "extends"],
      a = ["true", "false", "null", "undefined", "NaN", "Infinity"],
      s = [].concat(["setInterval", "setTimeout", "clearInterval", "clearTimeout", "require", "exports", "eval", "isFinite", "isNaN", "parseFloat", "parseInt", "decodeURI", "decodeURIComponent", "encodeURI", "encodeURIComponent", "escape", "unescape"], ["arguments", "this", "super", "console", "window", "document", "localStorage", "module", "global"], ["Intl", "DataView", "Number", "Math", "Date", "String", "RegExp", "Object", "Function", "Boolean", "Error", "Symbol", "Set", "Map", "WeakSet", "WeakMap", "Proxy", "Reflect", "JSON", "Promise", "Float64Array", "Int16Array", "Int32Array", "Int8Array", "Uint16Array", "Uint32Array", "Float32Array", "Array", "Uint8Array", "Uint8ClampedArray", "ArrayBuffer", "BigInt64Array", "BigUint64Array", "BigInt"], ["EvalError", "InternalError", "RangeError", "ReferenceError", "SyntaxError", "TypeError", "URIError"]);function r(e) {
    return t("(?=", e, ")");
  }function t(...e) {
    return e.map(function (e) {
      return (n = e) ? "string" == typeof n ? n : n.source : null;var n;
    }).join("");
  }return function (i) {
    var c = e,
        o = { begin: /<[A-Za-z0-9\\._:-]+/, end: /\/[A-Za-z0-9\\._:-]+>|\/>/,
      isTrulyOpeningTag: function (e, n) {
        var a = e[0].length + e.index,
            s = e.input[a];"<" !== s ? ">" === s && (function (e, { after: n }) {
          var a = "</" + e[0].slice(1);return -1 !== e.input.indexOf(a, n);
        }(e, { after: a
        }) || n.ignoreMatch()) : n.ignoreMatch();
      } },
        l = { $pattern: e, keyword: n, literal: a,
      built_in: s },
        g = "\\.([0-9](_?[0-9])*)",
        b = "0|[1-9](_?[0-9])*|0[0-7]*[89][0-9]*",
        d = {
      className: "number", variants: [{
        begin: "(\\b(" + b + ")((" + g + ")|\\.)?|(" + g + "))[eE][+-]?([0-9](_?[0-9])*)\\b" }, {
        begin: "\\b(" + b + ")\\b((" + g + ")\\b|\\.)?|(" + g + ")\\b" }, {
        begin: "\\b(0|[1-9](_?[0-9])*)n\\b" }, {
        begin: "\\b0[xX][0-9a-fA-F](_?[0-9a-fA-F])*n?\\b" }, {
        begin: "\\b0[bB][0-1](_?[0-1])*n?\\b" }, { begin: "\\b0[oO][0-7](_?[0-7])*n?\\b" }, {
        begin: "\\b0[0-7]+n?\\b" }], relevance: 0 },
        E = { className: "subst", begin: "\\$\\{",
      end: "\\}", keywords: l, contains: [] },
        u = { begin: "html`", end: "", starts: { end: "`",
        returnEnd: !1, contains: [i.BACKSLASH_ESCAPE, E], subLanguage: "xml" } },
        _ = {
      begin: "css`", end: "", starts: { end: "`", returnEnd: !1,
        contains: [i.BACKSLASH_ESCAPE, E], subLanguage: "css" } },
        m = { className: "string",
      begin: "`", end: "`", contains: [i.BACKSLASH_ESCAPE, E] },
        y = { className: "comment",
      variants: [i.COMMENT(/\/\*\*(?!\/)/, "\\*/", { relevance: 0, contains: [{
          className: "doctag", begin: "@[A-Za-z]+", contains: [{ className: "type", begin: "\\{",
            end: "\\}", relevance: 0 }, { className: "variable", begin: c + "(?=\\s*(-)|$)",
            endsParent: !0, relevance: 0 }, { begin: /(?=[^\n])\s/, relevance: 0 }] }]
      }), i.C_BLOCK_COMMENT_MODE, i.C_LINE_COMMENT_MODE]
    },
        N = [i.APOS_STRING_MODE, i.QUOTE_STRING_MODE, u, _, m, d, i.REGEXP_MODE];E.contains = N.concat({ begin: /\{/, end: /\}/, keywords: l, contains: ["self"].concat(N)
    });var A = [].concat(y, E.contains),
        f = A.concat([{ begin: /\(/, end: /\)/, keywords: l,
      contains: ["self"].concat(A) }]),
        p = { className: "params", begin: /\(/, end: /\)/,
      excludeBegin: !0, excludeEnd: !0, keywords: l, contains: f };return { name: "Javascript",
      aliases: ["js", "jsx", "mjs", "cjs"], keywords: l, exports: { PARAMS_CONTAINS: f },
      illegal: /#(?![$_A-z])/, contains: [i.SHEBANG({ label: "shebang", binary: "node",
        relevance: 5 }), { label: "use_strict", className: "meta", relevance: 10,
        begin: /^\s*['"]use (strict|asm)['"]/
      }, i.APOS_STRING_MODE, i.QUOTE_STRING_MODE, u, _, m, y, d, {
        begin: t(/[{,\n]\s*/, r(t(/(((\/\/.*$)|(\/\*(\*[^/]|[^*])*\*\/))\s*)*/, c + "\\s*:"))),
        relevance: 0, contains: [{ className: "attr", begin: c + r("\\s*:"), relevance: 0 }] }, {
        begin: "(" + i.RE_STARTERS_RE + "|\\b(case|return|throw)\\b)\\s*",
        keywords: "return throw case", contains: [y, i.REGEXP_MODE, { className: "function",
          begin: "(\\([^()]*(\\([^()]*(\\([^()]*\\)[^()]*)*\\)[^()]*)*\\)|" + i.UNDERSCORE_IDENT_RE + ")\\s*=>",
          returnBegin: !0, end: "\\s*=>", contains: [{ className: "params", variants: [{
              begin: i.UNDERSCORE_IDENT_RE, relevance: 0 }, { className: null, begin: /\(\s*\)/, skip: !0
            }, { begin: /\(/, end: /\)/, excludeBegin: !0, excludeEnd: !0, keywords: l, contains: f }] }]
        }, { begin: /,/, relevance: 0 }, { className: "", begin: /\s/, end: /\s*/, skip: !0 }, {
          variants: [{ begin: "<>", end: "</>" }, { begin: o.begin, "on:begin": o.isTrulyOpeningTag,
            end: o.end }], subLanguage: "xml", contains: [{ begin: o.begin, end: o.end, skip: !0,
            contains: ["self"] }] }], relevance: 0 }, { className: "function",
        beginKeywords: "function", end: /[{;]/, excludeEnd: !0, keywords: l,
        contains: ["self", i.inherit(i.TITLE_MODE, { begin: c }), p], illegal: /%/ }, {
        beginKeywords: "while if switch catch for" }, { className: "function",
        begin: i.UNDERSCORE_IDENT_RE + "\\([^()]*(\\([^()]*(\\([^()]*\\)[^()]*)*\\)[^()]*)*\\)\\s*\\{",
        returnBegin: !0, contains: [p, i.inherit(i.TITLE_MODE, { begin: c })] }, { variants: [{
          begin: "\\." + c }, { begin: "\\$" + c }], relevance: 0 }, { className: "class",
        beginKeywords: "class", end: /[{;=]/, excludeEnd: !0, illegal: /[:"[\]]/, contains: [{
          beginKeywords: "extends" }, i.UNDERSCORE_TITLE_MODE] }, { begin: /\b(?=constructor)/,
        end: /[{;]/, excludeEnd: !0, contains: [i.inherit(i.TITLE_MODE, { begin: c }), "self", p]
      }, { begin: "(get|set)\\s+(?=" + c + "\\()", end: /\{/, keywords: "get set",
        contains: [i.inherit(i.TITLE_MODE, { begin: c }), { begin: /\(\)/ }, p] }, { begin: /\$[(.]/ }]
    };
  };
}());hljs.registerLanguage("markdown", function () {
  "use strict";
  function n(...n) {
    return n.map(function (n) {
      return (e = n) ? "string" == typeof e ? e : e.source : null;var e;
    }).join("");
  }return function (e) {
    var a = { begin: /<\/?[A-Za-z_]/, end: ">",
      subLanguage: "xml", relevance: 0 },
        i = { variants: [{ begin: /\[.+?\]\[.*?\]/, relevance: 0
      }, { begin: /\[.+?\]\(((data|javascript|mailto):|(?:http|ftp)s?:\/\/).*?\)/,
        relevance: 2 }, { begin: n(/\[.+?\]\(/, /[A-Za-z][A-Za-z0-9+.-]*/, /:\/\/.*?\)/),
        relevance: 2 }, { begin: /\[.+?\]\([./?&#].*?\)/, relevance: 1 }, {
        begin: /\[.+?\]\(.*?\)/, relevance: 0 }], returnBegin: !0, contains: [{
        className: "string", relevance: 0, begin: "\\[", end: "\\]", excludeBegin: !0,
        returnEnd: !0 }, { className: "link", relevance: 0, begin: "\\]\\(", end: "\\)",
        excludeBegin: !0, excludeEnd: !0 }, { className: "symbol", relevance: 0, begin: "\\]\\[",
        end: "\\]", excludeBegin: !0, excludeEnd: !0 }] },
        s = { className: "strong", contains: [],
      variants: [{ begin: /_{2}/, end: /_{2}/ }, { begin: /\*{2}/, end: /\*{2}/ }] },
        c = {
      className: "emphasis", contains: [], variants: [{ begin: /\*(?!\*)/, end: /\*/ }, {
        begin: /_(?!_)/, end: /_/, relevance: 0 }] };s.contains.push(c), c.contains.push(s);var t = [a, i];return s.contains = s.contains.concat(t), c.contains = c.contains.concat(t), t = t.concat(s, c), { name: "Markdown", aliases: ["md", "mkdown", "mkd"], contains: [{
        className: "section", variants: [{ begin: "^#{1,6}", end: "$", contains: t }, {
          begin: "(?=^.+?\\n[=-]{2,}$)", contains: [{ begin: "^[=-]*$" }, { begin: "^", end: "\\n",
            contains: t }] }] }, a, { className: "bullet", begin: "^[ \t]*([*+-]|(\\d+\\.))(?=\\s+)",
        end: "\\s+", excludeEnd: !0 }, s, c, { className: "quote", begin: "^>\\s+", contains: t,
        end: "$" }, { className: "code", variants: [{ begin: "(`{3,})[^`](.|\\n)*?\\1`*[ ]*" }, {
          begin: "(~{3,})[^~](.|\\n)*?\\1~*[ ]*" }, { begin: "```", end: "```+[ ]*$" }, {
          begin: "~~~", end: "~~~+[ ]*$" }, { begin: "`.+?`" }, { begin: "(?=^( {4}|\\t))",
          contains: [{ begin: "^( {4}|\\t)", end: "(\\n)$" }], relevance: 0 }] }, {
        begin: "^[-\\*]{3,}", end: "$" }, i, { begin: /^\[[^\n]+\]:/, returnBegin: !0, contains: [{
          className: "symbol", begin: /\[/, end: /\]/, excludeBegin: !0, excludeEnd: !0 }, {
          className: "link", begin: /:\s*/, end: /$/, excludeBegin: !0 }] }] };
  };
}());