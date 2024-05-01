!function (t, e) {
    "object" == typeof exports && "undefined" != typeof module ? module.exports = e() : "function" == typeof define && define.amd ? define(e) : (t = "undefined" != typeof globalThis ? globalThis : t || self).i18next = e()
}(this, (function () {
    "use strict";
    const t = {
        type: "logger", log(t) {
            this.output("log", t)
        }, warn(t) {
            this.output("warn", t)
        }, error(t) {
            this.output("error", t)
        }, output(t, e) {
            console && console[t] && console[t].apply(console, e)
        }
    };

    class e {
        constructor(t) {
            let e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
            this.init(t, e)
        }

        init(e) {
            let s = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
            this.prefix = s.prefix || "i18next:", this.logger = e || t, this.options = s, this.debug = s.debug
        }

        log() {
            for (var t = arguments.length, e = new Array(t), s = 0; s < t; s++) e[s] = arguments[s];
            return this.forward(e, "log", "", !0)
        }

        warn() {
            for (var t = arguments.length, e = new Array(t), s = 0; s < t; s++) e[s] = arguments[s];
            return this.forward(e, "warn", "", !0)
        }

        error() {
            for (var t = arguments.length, e = new Array(t), s = 0; s < t; s++) e[s] = arguments[s];
            return this.forward(e, "error", "")
        }

        deprecate() {
            for (var t = arguments.length, e = new Array(t), s = 0; s < t; s++) e[s] = arguments[s];
            return this.forward(e, "warn", "WARNING DEPRECATED: ", !0)
        }

        forward(t, e, s, i) {
            return i && !this.debug ? null : ("string" == typeof t[0] && (t[0] = `${s}${this.prefix} ${t[0]}`), this.logger[e](t))
        }

        create(t) {
            return new e(this.logger, {prefix: `${this.prefix}:${t}:`, ...this.options})
        }

        clone(t) {
            return (t = t || this.options).prefix = t.prefix || this.prefix, new e(this.logger, t)
        }
    }

    var s = new e;

    class i {
        constructor() {
            this.observers = {}
        }

        on(t, e) {
            return t.split(" ").forEach((t => {
                this.observers[t] || (this.observers[t] = new Map);
                const s = this.observers[t].get(e) || 0;
                this.observers[t].set(e, s + 1)
            })), this
        }

        off(t, e) {
            this.observers[t] && (e ? this.observers[t].delete(e) : delete this.observers[t])
        }

        emit(t) {
            for (var e = arguments.length, s = new Array(e > 1 ? e - 1 : 0), i = 1; i < e; i++) s[i - 1] = arguments[i];
            if (this.observers[t]) {
                Array.from(this.observers[t].entries()).forEach((t => {
                    let [e, i] = t;
                    for (let t = 0; t < i; t++) e(...s)
                }))
            }
            if (this.observers["*"]) {
                Array.from(this.observers["*"].entries()).forEach((e => {
                    let [i, n] = e;
                    for (let e = 0; e < n; e++) i.apply(i, [t, ...s])
                }))
            }
        }
    }

    function n() {
        let t, e;
        const s = new Promise(((s, i) => {
            t = s, e = i
        }));
        return s.resolve = t, s.reject = e, s
    }

    function o(t) {
        return null == t ? "" : "" + t
    }

    const r = /###/g;

    function a(t, e, s) {
        function i(t) {
            return t && t.indexOf("###") > -1 ? t.replace(r, ".") : t
        }

        function n() {
            return !t || "string" == typeof t
        }

        const o = "string" != typeof e ? e : e.split(".");
        let a = 0;
        for (; a < o.length - 1;) {
            if (n()) return {};
            const e = i(o[a]);
            !t[e] && s && (t[e] = new s), t = Object.prototype.hasOwnProperty.call(t, e) ? t[e] : {}, ++a
        }
        return n() ? {} : {obj: t, k: i(o[a])}
    }

    function l(t, e, s) {
        const {obj: i, k: n} = a(t, e, Object);
        if (void 0 !== i || 1 === e.length) return void (i[n] = s);
        let o = e[e.length - 1], r = e.slice(0, e.length - 1), l = a(t, r, Object);
        for (; void 0 === l.obj && r.length;) o = `${r[r.length - 1]}.${o}`, r = r.slice(0, r.length - 1), l = a(t, r, Object), l && l.obj && void 0 !== l.obj[`${l.k}.${o}`] && (l.obj = void 0);
        l.obj[`${l.k}.${o}`] = s
    }

    function u(t, e) {
        const {obj: s, k: i} = a(t, e);
        if (s) return s[i]
    }

    function h(t, e, s) {
        for (const i in e) "__proto__" !== i && "constructor" !== i && (i in t ? "string" == typeof t[i] || t[i] instanceof String || "string" == typeof e[i] || e[i] instanceof String ? s && (t[i] = e[i]) : h(t[i], e[i], s) : t[i] = e[i]);
        return t
    }

    function p(t) {
        return t.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&")
    }

    var c = {"&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;", "/": "&#x2F;"};

    function g(t) {
        return "string" == typeof t ? t.replace(/[&<>"'\/]/g, (t => c[t])) : t
    }

    const d = [" ", ",", "?", "!", ";"], f = new class {
        constructor(t) {
            this.capacity = t, this.regExpMap = new Map, this.regExpQueue = []
        }

        getRegExp(t) {
            const e = this.regExpMap.get(t);
            if (void 0 !== e) return e;
            const s = new RegExp(t);
            return this.regExpQueue.length === this.capacity && this.regExpMap.delete(this.regExpQueue.shift()), this.regExpMap.set(t, s), this.regExpQueue.push(t), s
        }
    }(20);

    function m(t, e) {
        let s = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : ".";
        if (!t) return;
        if (t[e]) return t[e];
        const i = e.split(s);
        let n = t;
        for (let t = 0; t < i.length;) {
            if (!n || "object" != typeof n) return;
            let e, o = "";
            for (let r = t; r < i.length; ++r) if (r !== t && (o += s), o += i[r], e = n[o], void 0 !== e) {
                if (["string", "number", "boolean"].indexOf(typeof e) > -1 && r < i.length - 1) continue;
                t += r - t + 1;
                break
            }
            n = e
        }
        return n
    }

    function y(t) {
        return t && t.indexOf("_") > 0 ? t.replace("_", "-") : t
    }

    class v extends i {
        constructor(t) {
            let e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {
                ns: ["translation"],
                defaultNS: "translation"
            };
            super(), this.data = t || {}, this.options = e, void 0 === this.options.keySeparator && (this.options.keySeparator = "."), void 0 === this.options.ignoreJSONStructure && (this.options.ignoreJSONStructure = !0)
        }

        addNamespaces(t) {
            this.options.ns.indexOf(t) < 0 && this.options.ns.push(t)
        }

        removeNamespaces(t) {
            const e = this.options.ns.indexOf(t);
            e > -1 && this.options.ns.splice(e, 1)
        }

        getResource(t, e, s) {
            let i = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : {};
            const n = void 0 !== i.keySeparator ? i.keySeparator : this.options.keySeparator,
                o = void 0 !== i.ignoreJSONStructure ? i.ignoreJSONStructure : this.options.ignoreJSONStructure;
            let r;
            t.indexOf(".") > -1 ? r = t.split(".") : (r = [t, e], s && (Array.isArray(s) ? r.push(...s) : "string" == typeof s && n ? r.push(...s.split(n)) : r.push(s)));
            const a = u(this.data, r);
            return !a && !e && !s && t.indexOf(".") > -1 && (t = r[0], e = r[1], s = r.slice(2).join(".")), a || !o || "string" != typeof s ? a : m(this.data && this.data[t] && this.data[t][e], s, n)
        }

        addResource(t, e, s, i) {
            let n = arguments.length > 4 && void 0 !== arguments[4] ? arguments[4] : {silent: !1};
            const o = void 0 !== n.keySeparator ? n.keySeparator : this.options.keySeparator;
            let r = [t, e];
            s && (r = r.concat(o ? s.split(o) : s)), t.indexOf(".") > -1 && (r = t.split("."), i = e, e = r[1]), this.addNamespaces(e), l(this.data, r, i), n.silent || this.emit("added", t, e, s, i)
        }

        addResources(t, e, s) {
            let i = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : {silent: !1};
            for (const i in s) "string" != typeof s[i] && "[object Array]" !== Object.prototype.toString.apply(s[i]) || this.addResource(t, e, i, s[i], {silent: !0});
            i.silent || this.emit("added", t, e, s)
        }

        addResourceBundle(t, e, s, i, n) {
            let o = arguments.length > 5 && void 0 !== arguments[5] ? arguments[5] : {silent: !1, skipCopy: !1},
                r = [t, e];
            t.indexOf(".") > -1 && (r = t.split("."), i = s, s = e, e = r[1]), this.addNamespaces(e);
            let a = u(this.data, r) || {};
            o.skipCopy || (s = JSON.parse(JSON.stringify(s))), i ? h(a, s, n) : a = {...a, ...s}, l(this.data, r, a), o.silent || this.emit("added", t, e, s)
        }

        removeResourceBundle(t, e) {
            this.hasResourceBundle(t, e) && delete this.data[t][e], this.removeNamespaces(e), this.emit("removed", t, e)
        }

        hasResourceBundle(t, e) {
            return void 0 !== this.getResource(t, e)
        }

        getResourceBundle(t, e) {
            return e || (e = this.options.defaultNS), "v1" === this.options.compatibilityAPI ? {...this.getResource(t, e)} : this.getResource(t, e)
        }

        getDataByLanguage(t) {
            return this.data[t]
        }

        hasLanguageSomeTranslations(t) {
            const e = this.getDataByLanguage(t);
            return !!(e && Object.keys(e) || []).find((t => e[t] && Object.keys(e[t]).length > 0))
        }

        toJSON() {
            return this.data
        }
    }

    var b = {
        processors: {}, addPostProcessor(t) {
            this.processors[t.name] = t
        }, handle(t, e, s, i, n) {
            return t.forEach((t => {
                this.processors[t] && (e = this.processors[t].process(e, s, i, n))
            })), e
        }
    };
    const x = {};

    class S extends i {
        constructor(t) {
            let e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
            var i, n;
            super(), i = t, n = this, ["resourceStore", "languageUtils", "pluralResolver", "interpolator", "backendConnector", "i18nFormat", "utils"].forEach((t => {
                i[t] && (n[t] = i[t])
            })), this.options = e, void 0 === this.options.keySeparator && (this.options.keySeparator = "."), this.logger = s.create("translator")
        }

        changeLanguage(t) {
            t && (this.language = t)
        }

        exists(t) {
            let e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {interpolation: {}};
            if (null == t) return !1;
            const s = this.resolve(t, e);
            return s && void 0 !== s.res
        }

        extractFromKey(t, e) {
            let s = void 0 !== e.nsSeparator ? e.nsSeparator : this.options.nsSeparator;
            void 0 === s && (s = ":");
            const i = void 0 !== e.keySeparator ? e.keySeparator : this.options.keySeparator;
            let n = e.ns || this.options.defaultNS || [];
            const o = s && t.indexOf(s) > -1,
                r = !(this.options.userDefinedKeySeparator || e.keySeparator || this.options.userDefinedNsSeparator || e.nsSeparator || function (t, e, s) {
                    e = e || "", s = s || "";
                    const i = d.filter((t => e.indexOf(t) < 0 && s.indexOf(t) < 0));
                    if (0 === i.length) return !0;
                    const n = f.getRegExp(`(${i.map((t => "?" === t ? "\\?" : t)).join("|")})`);
                    let o = !n.test(t);
                    if (!o) {
                        const e = t.indexOf(s);
                        e > 0 && !n.test(t.substring(0, e)) && (o = !0)
                    }
                    return o
                }(t, s, i));
            if (o && !r) {
                const e = t.match(this.interpolator.nestingRegexp);
                if (e && e.length > 0) return {key: t, namespaces: n};
                const o = t.split(s);
                (s !== i || s === i && this.options.ns.indexOf(o[0]) > -1) && (n = o.shift()), t = o.join(i)
            }
            return "string" == typeof n && (n = [n]), {key: t, namespaces: n}
        }

        translate(t, e, s) {
            if ("object" != typeof e && this.options.overloadTranslationOptionHandler && (e = this.options.overloadTranslationOptionHandler(arguments)), "object" == typeof e && (e = {...e}), e || (e = {}), null == t) return "";
            Array.isArray(t) || (t = [String(t)]);
            const i = void 0 !== e.returnDetails ? e.returnDetails : this.options.returnDetails,
                n = void 0 !== e.keySeparator ? e.keySeparator : this.options.keySeparator, {
                    key: o,
                    namespaces: r
                } = this.extractFromKey(t[t.length - 1], e), a = r[r.length - 1], l = e.lng || this.language,
                u = e.appendNamespaceToCIMode || this.options.appendNamespaceToCIMode;
            if (l && "cimode" === l.toLowerCase()) {
                if (u) {
                    const t = e.nsSeparator || this.options.nsSeparator;
                    return i ? {
                        res: `${a}${t}${o}`,
                        usedKey: o,
                        exactUsedKey: o,
                        usedLng: l,
                        usedNS: a,
                        usedParams: this.getUsedParamsDetails(e)
                    } : `${a}${t}${o}`
                }
                return i ? {
                    res: o,
                    usedKey: o,
                    exactUsedKey: o,
                    usedLng: l,
                    usedNS: a,
                    usedParams: this.getUsedParamsDetails(e)
                } : o
            }
            const h = this.resolve(t, e);
            let p = h && h.res;
            const c = h && h.usedKey || o, g = h && h.exactUsedKey || o, d = Object.prototype.toString.apply(p),
                f = void 0 !== e.joinArrays ? e.joinArrays : this.options.joinArrays,
                m = !this.i18nFormat || this.i18nFormat.handleAsObject;
            if (m && p && ("string" != typeof p && "boolean" != typeof p && "number" != typeof p) && ["[object Number]", "[object Function]", "[object RegExp]"].indexOf(d) < 0 && ("string" != typeof f || "[object Array]" !== d)) {
                if (!e.returnObjects && !this.options.returnObjects) {
                    this.options.returnedObjectHandler || this.logger.warn("accessing an object - but returnObjects options is not enabled!");
                    const t = this.options.returnedObjectHandler ? this.options.returnedObjectHandler(c, p, {
                        ...e,
                        ns: r
                    }) : `key '${o} (${this.language})' returned an object instead of string.`;
                    return i ? (h.res = t, h.usedParams = this.getUsedParamsDetails(e), h) : t
                }
                if (n) {
                    const t = "[object Array]" === d, s = t ? [] : {}, i = t ? g : c;
                    for (const t in p) if (Object.prototype.hasOwnProperty.call(p, t)) {
                        const o = `${i}${n}${t}`;
                        s[t] = this.translate(o, {...e, joinArrays: !1, ns: r}), s[t] === o && (s[t] = p[t])
                    }
                    p = s
                }
            } else if (m && "string" == typeof f && "[object Array]" === d) p = p.join(f), p && (p = this.extendTranslation(p, t, e, s)); else {
                let i = !1, r = !1;
                const u = void 0 !== e.count && "string" != typeof e.count, c = S.hasDefaultValue(e),
                    g = u ? this.pluralResolver.getSuffix(l, e.count, e) : "",
                    d = e.ordinal && u ? this.pluralResolver.getSuffix(l, e.count, {ordinal: !1}) : "",
                    f = u && !e.ordinal && 0 === e.count && this.pluralResolver.shouldUseIntlApi(),
                    m = f && e[`defaultValue${this.options.pluralSeparator}zero`] || e[`defaultValue${g}`] || e[`defaultValue${d}`] || e.defaultValue;
                !this.isValidLookup(p) && c && (i = !0, p = m), this.isValidLookup(p) || (r = !0, p = o);
                const y = (e.missingKeyNoValueFallbackToKey || this.options.missingKeyNoValueFallbackToKey) && r ? void 0 : p,
                    v = c && m !== p && this.options.updateMissing;
                if (r || i || v) {
                    if (this.logger.log(v ? "updateKey" : "missingKey", l, a, o, v ? m : p), n) {
                        const t = this.resolve(o, {...e, keySeparator: !1});
                        t && t.res && this.logger.warn("Seems the loaded translations were in flat JSON format instead of nested. Either set keySeparator: false on init or make sure your translations are published in nested format.")
                    }
                    let t = [];
                    const s = this.languageUtils.getFallbackCodes(this.options.fallbackLng, e.lng || this.language);
                    if ("fallback" === this.options.saveMissingTo && s && s[0]) for (let e = 0; e < s.length; e++) t.push(s[e]); else "all" === this.options.saveMissingTo ? t = this.languageUtils.toResolveHierarchy(e.lng || this.language) : t.push(e.lng || this.language);
                    const i = (t, s, i) => {
                        const n = c && i !== p ? i : y;
                        this.options.missingKeyHandler ? this.options.missingKeyHandler(t, a, s, n, v, e) : this.backendConnector && this.backendConnector.saveMissing && this.backendConnector.saveMissing(t, a, s, n, v, e), this.emit("missingKey", t, a, s, p)
                    };
                    this.options.saveMissing && (this.options.saveMissingPlurals && u ? t.forEach((t => {
                        const s = this.pluralResolver.getSuffixes(t, e);
                        f && e[`defaultValue${this.options.pluralSeparator}zero`] && s.indexOf(`${this.options.pluralSeparator}zero`) < 0 && s.push(`${this.options.pluralSeparator}zero`), s.forEach((s => {
                            i([t], o + s, e[`defaultValue${s}`] || m)
                        }))
                    })) : i(t, o, m))
                }
                p = this.extendTranslation(p, t, e, h, s), r && p === o && this.options.appendNamespaceToMissingKey && (p = `${a}:${o}`), (r || i) && this.options.parseMissingKeyHandler && (p = "v1" !== this.options.compatibilityAPI ? this.options.parseMissingKeyHandler(this.options.appendNamespaceToMissingKey ? `${a}:${o}` : o, i ? p : void 0) : this.options.parseMissingKeyHandler(p))
            }
            return i ? (h.res = p, h.usedParams = this.getUsedParamsDetails(e), h) : p
        }

        extendTranslation(t, e, s, i, n) {
            var o = this;
            if (this.i18nFormat && this.i18nFormat.parse) t = this.i18nFormat.parse(t, {...this.options.interpolation.defaultVariables, ...s}, s.lng || this.language || i.usedLng, i.usedNS, i.usedKey, {resolved: i}); else if (!s.skipInterpolation) {
                s.interpolation && this.interpolator.init({
                    ...s,
                    interpolation: {...this.options.interpolation, ...s.interpolation}
                });
                const r = "string" == typeof t && (s && s.interpolation && void 0 !== s.interpolation.skipOnVariables ? s.interpolation.skipOnVariables : this.options.interpolation.skipOnVariables);
                let a;
                if (r) {
                    const e = t.match(this.interpolator.nestingRegexp);
                    a = e && e.length
                }
                let l = s.replace && "string" != typeof s.replace ? s.replace : s;
                if (this.options.interpolation.defaultVariables && (l = {...this.options.interpolation.defaultVariables, ...l}), t = this.interpolator.interpolate(t, l, s.lng || this.language, s), r) {
                    const e = t.match(this.interpolator.nestingRegexp);
                    a < (e && e.length) && (s.nest = !1)
                }
                !s.lng && "v1" !== this.options.compatibilityAPI && i && i.res && (s.lng = i.usedLng), !1 !== s.nest && (t = this.interpolator.nest(t, (function () {
                    for (var t = arguments.length, i = new Array(t), r = 0; r < t; r++) i[r] = arguments[r];
                    return n && n[0] === i[0] && !s.context ? (o.logger.warn(`It seems you are nesting recursively key: ${i[0]} in key: ${e[0]}`), null) : o.translate(...i, e)
                }), s)), s.interpolation && this.interpolator.reset()
            }
            const r = s.postProcess || this.options.postProcess, a = "string" == typeof r ? [r] : r;
            return null != t && a && a.length && !1 !== s.applyPostProcessor && (t = b.handle(a, t, e, this.options && this.options.postProcessPassResolved ? {
                i18nResolved: {
                    ...i,
                    usedParams: this.getUsedParamsDetails(s)
                }, ...s
            } : s, this)), t
        }

        resolve(t) {
            let e, s, i, n, o, r = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
            return "string" == typeof t && (t = [t]), t.forEach((t => {
                if (this.isValidLookup(e)) return;
                const a = this.extractFromKey(t, r), l = a.key;
                s = l;
                let u = a.namespaces;
                this.options.fallbackNS && (u = u.concat(this.options.fallbackNS));
                const h = void 0 !== r.count && "string" != typeof r.count,
                    p = h && !r.ordinal && 0 === r.count && this.pluralResolver.shouldUseIntlApi(),
                    c = void 0 !== r.context && ("string" == typeof r.context || "number" == typeof r.context) && "" !== r.context,
                    g = r.lngs ? r.lngs : this.languageUtils.toResolveHierarchy(r.lng || this.language, r.fallbackLng);
                u.forEach((t => {
                    this.isValidLookup(e) || (o = t, !x[`${g[0]}-${t}`] && this.utils && this.utils.hasLoadedNamespace && !this.utils.hasLoadedNamespace(o) && (x[`${g[0]}-${t}`] = !0, this.logger.warn(`key "${s}" for languages "${g.join(", ")}" won't get resolved as namespace "${o}" was not yet loaded`, "This means something IS WRONG in your setup. You access the t function before i18next.init / i18next.loadNamespace / i18next.changeLanguage was done. Wait for the callback or Promise to resolve before accessing it!!!")), g.forEach((s => {
                        if (this.isValidLookup(e)) return;
                        n = s;
                        const o = [l];
                        if (this.i18nFormat && this.i18nFormat.addLookupKeys) this.i18nFormat.addLookupKeys(o, l, s, t, r); else {
                            let t;
                            h && (t = this.pluralResolver.getSuffix(s, r.count, r));
                            const e = `${this.options.pluralSeparator}zero`,
                                i = `${this.options.pluralSeparator}ordinal${this.options.pluralSeparator}`;
                            if (h && (o.push(l + t), r.ordinal && 0 === t.indexOf(i) && o.push(l + t.replace(i, this.options.pluralSeparator)), p && o.push(l + e)), c) {
                                const s = `${l}${this.options.contextSeparator}${r.context}`;
                                o.push(s), h && (o.push(s + t), r.ordinal && 0 === t.indexOf(i) && o.push(s + t.replace(i, this.options.pluralSeparator)), p && o.push(s + e))
                            }
                        }
                        let a;
                        for (; a = o.pop();) this.isValidLookup(e) || (i = a, e = this.getResource(s, t, a, r))
                    })))
                }))
            })), {res: e, usedKey: s, exactUsedKey: i, usedLng: n, usedNS: o}
        }

        isValidLookup(t) {
            return !(void 0 === t || !this.options.returnNull && null === t || !this.options.returnEmptyString && "" === t)
        }

        getResource(t, e, s) {
            let i = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : {};
            return this.i18nFormat && this.i18nFormat.getResource ? this.i18nFormat.getResource(t, e, s, i) : this.resourceStore.getResource(t, e, s, i)
        }

        getUsedParamsDetails() {
            let t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {};
            const e = ["defaultValue", "ordinal", "context", "replace", "lng", "lngs", "fallbackLng", "ns", "keySeparator", "nsSeparator", "returnObjects", "returnDetails", "joinArrays", "postProcess", "interpolation"],
                s = t.replace && "string" != typeof t.replace;
            let i = s ? t.replace : t;
            if (s && void 0 !== t.count && (i.count = t.count), this.options.interpolation.defaultVariables && (i = {...this.options.interpolation.defaultVariables, ...i}), !s) {
                i = {...i};
                for (const t of e) delete i[t]
            }
            return i
        }

        static hasDefaultValue(t) {
            const e = "defaultValue";
            for (const s in t) if (Object.prototype.hasOwnProperty.call(t, s) && e === s.substring(0, 12) && void 0 !== t[s]) return !0;
            return !1
        }
    }

    function k(t) {
        return t.charAt(0).toUpperCase() + t.slice(1)
    }

    class O {
        constructor(t) {
            this.options = t, this.supportedLngs = this.options.supportedLngs || !1, this.logger = s.create("languageUtils")
        }

        getScriptPartFromCode(t) {
            if (!(t = y(t)) || t.indexOf("-") < 0) return null;
            const e = t.split("-");
            return 2 === e.length ? null : (e.pop(), "x" === e[e.length - 1].toLowerCase() ? null : this.formatLanguageCode(e.join("-")))
        }

        getLanguagePartFromCode(t) {
            if (!(t = y(t)) || t.indexOf("-") < 0) return t;
            const e = t.split("-");
            return this.formatLanguageCode(e[0])
        }

        formatLanguageCode(t) {
            if ("string" == typeof t && t.indexOf("-") > -1) {
                const e = ["hans", "hant", "latn", "cyrl", "cans", "mong", "arab"];
                let s = t.split("-");
                return this.options.lowerCaseLng ? s = s.map((t => t.toLowerCase())) : 2 === s.length ? (s[0] = s[0].toLowerCase(), s[1] = s[1].toUpperCase(), e.indexOf(s[1].toLowerCase()) > -1 && (s[1] = k(s[1].toLowerCase()))) : 3 === s.length && (s[0] = s[0].toLowerCase(), 2 === s[1].length && (s[1] = s[1].toUpperCase()), "sgn" !== s[0] && 2 === s[2].length && (s[2] = s[2].toUpperCase()), e.indexOf(s[1].toLowerCase()) > -1 && (s[1] = k(s[1].toLowerCase())), e.indexOf(s[2].toLowerCase()) > -1 && (s[2] = k(s[2].toLowerCase()))), s.join("-")
            }
            return this.options.cleanCode || this.options.lowerCaseLng ? t.toLowerCase() : t
        }

        isSupportedCode(t) {
            return ("languageOnly" === this.options.load || this.options.nonExplicitSupportedLngs) && (t = this.getLanguagePartFromCode(t)), !this.supportedLngs || !this.supportedLngs.length || this.supportedLngs.indexOf(t) > -1
        }

        getBestMatchFromCodes(t) {
            if (!t) return null;
            let e;
            return t.forEach((t => {
                if (e) return;
                const s = this.formatLanguageCode(t);
                this.options.supportedLngs && !this.isSupportedCode(s) || (e = s)
            })), !e && this.options.supportedLngs && t.forEach((t => {
                if (e) return;
                const s = this.getLanguagePartFromCode(t);
                if (this.isSupportedCode(s)) return e = s;
                e = this.options.supportedLngs.find((t => t === s ? t : t.indexOf("-") < 0 && s.indexOf("-") < 0 ? void 0 : t.indexOf("-") > 0 && s.indexOf("-") < 0 && t.substring(0, t.indexOf("-")) === s || 0 === t.indexOf(s) && s.length > 1 ? t : void 0))
            })), e || (e = this.getFallbackCodes(this.options.fallbackLng)[0]), e
        }

        getFallbackCodes(t, e) {
            if (!t) return [];
            if ("function" == typeof t && (t = t(e)), "string" == typeof t && (t = [t]), "[object Array]" === Object.prototype.toString.apply(t)) return t;
            if (!e) return t.default || [];
            let s = t[e];
            return s || (s = t[this.getScriptPartFromCode(e)]), s || (s = t[this.formatLanguageCode(e)]), s || (s = t[this.getLanguagePartFromCode(e)]), s || (s = t.default), s || []
        }

        toResolveHierarchy(t, e) {
            const s = this.getFallbackCodes(e || this.options.fallbackLng || [], t), i = [], n = t => {
                t && (this.isSupportedCode(t) ? i.push(t) : this.logger.warn(`rejecting language code not found in supportedLngs: ${t}`))
            };
            return "string" == typeof t && (t.indexOf("-") > -1 || t.indexOf("_") > -1) ? ("languageOnly" !== this.options.load && n(this.formatLanguageCode(t)), "languageOnly" !== this.options.load && "currentOnly" !== this.options.load && n(this.getScriptPartFromCode(t)), "currentOnly" !== this.options.load && n(this.getLanguagePartFromCode(t))) : "string" == typeof t && n(this.formatLanguageCode(t)), s.forEach((t => {
                i.indexOf(t) < 0 && n(this.formatLanguageCode(t))
            })), i
        }
    }

    let L = [{
        lngs: ["ach", "ak", "am", "arn", "br", "fil", "gun", "ln", "mfe", "mg", "mi", "oc", "pt", "pt-BR", "tg", "tl", "ti", "tr", "uz", "wa"],
        nr: [1, 2],
        fc: 1
    }, {
        lngs: ["af", "an", "ast", "az", "bg", "bn", "ca", "da", "de", "dev", "el", "en", "eo", "es", "et", "eu", "fi", "fo", "fur", "fy", "gl", "gu", "ha", "hi", "hu", "hy", "ia", "it", "kk", "kn", "ku", "lb", "mai", "ml", "mn", "mr", "nah", "nap", "nb", "ne", "nl", "nn", "no", "nso", "pa", "pap", "pms", "ps", "pt-PT", "rm", "sco", "se", "si", "so", "son", "sq", "sv", "sw", "ta", "te", "tk", "ur", "yo"],
        nr: [1, 2],
        fc: 2
    }, {
        lngs: ["ay", "bo", "cgg", "fa", "ht", "id", "ja", "jbo", "ka", "km", "ko", "ky", "lo", "ms", "sah", "su", "th", "tt", "ug", "vi", "wo", "zh"],
        nr: [1],
        fc: 3
    }, {lngs: ["be", "bs", "cnr", "dz", "hr", "ru", "sr", "uk"], nr: [1, 2, 5], fc: 4}, {
        lngs: ["ar"],
        nr: [0, 1, 2, 3, 11, 100],
        fc: 5
    }, {lngs: ["cs", "sk"], nr: [1, 2, 5], fc: 6}, {lngs: ["csb", "pl"], nr: [1, 2, 5], fc: 7}, {
        lngs: ["cy"],
        nr: [1, 2, 3, 8],
        fc: 8
    }, {lngs: ["fr"], nr: [1, 2], fc: 9}, {lngs: ["ga"], nr: [1, 2, 3, 7, 11], fc: 10}, {
        lngs: ["gd"],
        nr: [1, 2, 3, 20],
        fc: 11
    }, {lngs: ["is"], nr: [1, 2], fc: 12}, {lngs: ["jv"], nr: [0, 1], fc: 13}, {
        lngs: ["kw"],
        nr: [1, 2, 3, 4],
        fc: 14
    }, {lngs: ["lt"], nr: [1, 2, 10], fc: 15}, {lngs: ["lv"], nr: [1, 2, 0], fc: 16}, {
        lngs: ["mk"],
        nr: [1, 2],
        fc: 17
    }, {lngs: ["mnk"], nr: [0, 1, 2], fc: 18}, {lngs: ["mt"], nr: [1, 2, 11, 20], fc: 19}, {
        lngs: ["or"],
        nr: [2, 1],
        fc: 2
    }, {lngs: ["ro"], nr: [1, 2, 20], fc: 20}, {lngs: ["sl"], nr: [5, 1, 2, 3], fc: 21}, {
        lngs: ["he", "iw"],
        nr: [1, 2, 20, 21],
        fc: 22
    }], w = {
        1: function (t) {
            return Number(t > 1)
        }, 2: function (t) {
            return Number(1 != t)
        }, 3: function (t) {
            return 0
        }, 4: function (t) {
            return Number(t % 10 == 1 && t % 100 != 11 ? 0 : t % 10 >= 2 && t % 10 <= 4 && (t % 100 < 10 || t % 100 >= 20) ? 1 : 2)
        }, 5: function (t) {
            return Number(0 == t ? 0 : 1 == t ? 1 : 2 == t ? 2 : t % 100 >= 3 && t % 100 <= 10 ? 3 : t % 100 >= 11 ? 4 : 5)
        }, 6: function (t) {
            return Number(1 == t ? 0 : t >= 2 && t <= 4 ? 1 : 2)
        }, 7: function (t) {
            return Number(1 == t ? 0 : t % 10 >= 2 && t % 10 <= 4 && (t % 100 < 10 || t % 100 >= 20) ? 1 : 2)
        }, 8: function (t) {
            return Number(1 == t ? 0 : 2 == t ? 1 : 8 != t && 11 != t ? 2 : 3)
        }, 9: function (t) {
            return Number(t >= 2)
        }, 10: function (t) {
            return Number(1 == t ? 0 : 2 == t ? 1 : t < 7 ? 2 : t < 11 ? 3 : 4)
        }, 11: function (t) {
            return Number(1 == t || 11 == t ? 0 : 2 == t || 12 == t ? 1 : t > 2 && t < 20 ? 2 : 3)
        }, 12: function (t) {
            return Number(t % 10 != 1 || t % 100 == 11)
        }, 13: function (t) {
            return Number(0 !== t)
        }, 14: function (t) {
            return Number(1 == t ? 0 : 2 == t ? 1 : 3 == t ? 2 : 3)
        }, 15: function (t) {
            return Number(t % 10 == 1 && t % 100 != 11 ? 0 : t % 10 >= 2 && (t % 100 < 10 || t % 100 >= 20) ? 1 : 2)
        }, 16: function (t) {
            return Number(t % 10 == 1 && t % 100 != 11 ? 0 : 0 !== t ? 1 : 2)
        }, 17: function (t) {
            return Number(1 == t || t % 10 == 1 && t % 100 != 11 ? 0 : 1)
        }, 18: function (t) {
            return Number(0 == t ? 0 : 1 == t ? 1 : 2)
        }, 19: function (t) {
            return Number(1 == t ? 0 : 0 == t || t % 100 > 1 && t % 100 < 11 ? 1 : t % 100 > 10 && t % 100 < 20 ? 2 : 3)
        }, 20: function (t) {
            return Number(1 == t ? 0 : 0 == t || t % 100 > 0 && t % 100 < 20 ? 1 : 2)
        }, 21: function (t) {
            return Number(t % 100 == 1 ? 1 : t % 100 == 2 ? 2 : t % 100 == 3 || t % 100 == 4 ? 3 : 0)
        }, 22: function (t) {
            return Number(1 == t ? 0 : 2 == t ? 1 : (t < 0 || t > 10) && t % 10 == 0 ? 2 : 3)
        }
    };
    const N = ["v1", "v2", "v3"], $ = ["v4"], R = {zero: 0, one: 1, two: 2, few: 3, many: 4, other: 5};

    class C {
        constructor(t) {
            let e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
            this.languageUtils = t, this.options = e, this.logger = s.create("pluralResolver"), this.options.compatibilityJSON && !$.includes(this.options.compatibilityJSON) || "undefined" != typeof Intl && Intl.PluralRules || (this.options.compatibilityJSON = "v3", this.logger.error("Your environment seems not to be Intl API compatible, use an Intl.PluralRules polyfill. Will fallback to the compatibilityJSON v3 format handling.")), this.rules = function () {
                const t = {};
                return L.forEach((e => {
                    e.lngs.forEach((s => {
                        t[s] = {numbers: e.nr, plurals: w[e.fc]}
                    }))
                })), t
            }()
        }

        addRule(t, e) {
            this.rules[t] = e
        }

        getRule(t) {
            let e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
            if (this.shouldUseIntlApi()) try {
                return new Intl.PluralRules(y("dev" === t ? "en" : t), {type: e.ordinal ? "ordinal" : "cardinal"})
            } catch (t) {
                return
            }
            return this.rules[t] || this.rules[this.languageUtils.getLanguagePartFromCode(t)]
        }

        needsPlural(t) {
            let e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
            const s = this.getRule(t, e);
            return this.shouldUseIntlApi() ? s && s.resolvedOptions().pluralCategories.length > 1 : s && s.numbers.length > 1
        }

        getPluralFormsOfKey(t, e) {
            let s = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : {};
            return this.getSuffixes(t, s).map((t => `${e}${t}`))
        }

        getSuffixes(t) {
            let e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
            const s = this.getRule(t, e);
            return s ? this.shouldUseIntlApi() ? s.resolvedOptions().pluralCategories.sort(((t, e) => R[t] - R[e])).map((t => `${this.options.prepend}${e.ordinal ? `ordinal${this.options.prepend}` : ""}${t}`)) : s.numbers.map((s => this.getSuffix(t, s, e))) : []
        }

        getSuffix(t, e) {
            let s = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : {};
            const i = this.getRule(t, s);
            return i ? this.shouldUseIntlApi() ? `${this.options.prepend}${s.ordinal ? `ordinal${this.options.prepend}` : ""}${i.select(e)}` : this.getSuffixRetroCompatible(i, e) : (this.logger.warn(`no plural rule found for: ${t}`), "")
        }

        getSuffixRetroCompatible(t, e) {
            const s = t.noAbs ? t.plurals(e) : t.plurals(Math.abs(e));
            let i = t.numbers[s];
            this.options.simplifyPluralSuffix && 2 === t.numbers.length && 1 === t.numbers[0] && (2 === i ? i = "plural" : 1 === i && (i = ""));
            const n = () => this.options.prepend && i.toString() ? this.options.prepend + i.toString() : i.toString();
            return "v1" === this.options.compatibilityJSON ? 1 === i ? "" : "number" == typeof i ? `_plural_${i.toString()}` : n() : "v2" === this.options.compatibilityJSON || this.options.simplifyPluralSuffix && 2 === t.numbers.length && 1 === t.numbers[0] ? n() : this.options.prepend && s.toString() ? this.options.prepend + s.toString() : s.toString()
        }

        shouldUseIntlApi() {
            return !N.includes(this.options.compatibilityJSON)
        }
    }

    function P(t, e, s) {
        let i = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : ".",
            n = !(arguments.length > 4 && void 0 !== arguments[4]) || arguments[4], o = function (t, e, s) {
                const i = u(t, s);
                return void 0 !== i ? i : u(e, s)
            }(t, e, s);
        return !o && n && "string" == typeof s && (o = m(t, s, i), void 0 === o && (o = m(e, s, i))), o
    }

    class j {
        constructor() {
            let t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {};
            this.logger = s.create("interpolator"), this.options = t, this.format = t.interpolation && t.interpolation.format || (t => t), this.init(t)
        }

        init() {
            let t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {};
            t.interpolation || (t.interpolation = {escapeValue: !0});
            const e = t.interpolation;
            this.escape = void 0 !== e.escape ? e.escape : g, this.escapeValue = void 0 === e.escapeValue || e.escapeValue, this.useRawValueToEscape = void 0 !== e.useRawValueToEscape && e.useRawValueToEscape, this.prefix = e.prefix ? p(e.prefix) : e.prefixEscaped || "{{", this.suffix = e.suffix ? p(e.suffix) : e.suffixEscaped || "}}", this.formatSeparator = e.formatSeparator ? e.formatSeparator : e.formatSeparator || ",", this.unescapePrefix = e.unescapeSuffix ? "" : e.unescapePrefix || "-", this.unescapeSuffix = this.unescapePrefix ? "" : e.unescapeSuffix || "", this.nestingPrefix = e.nestingPrefix ? p(e.nestingPrefix) : e.nestingPrefixEscaped || p("$t("), this.nestingSuffix = e.nestingSuffix ? p(e.nestingSuffix) : e.nestingSuffixEscaped || p(")"), this.nestingOptionsSeparator = e.nestingOptionsSeparator ? e.nestingOptionsSeparator : e.nestingOptionsSeparator || ",", this.maxReplaces = e.maxReplaces ? e.maxReplaces : 1e3, this.alwaysFormat = void 0 !== e.alwaysFormat && e.alwaysFormat, this.resetRegExp()
        }

        reset() {
            this.options && this.init(this.options)
        }

        resetRegExp() {
            const t = (t, e) => t && t.source === e ? (t.lastIndex = 0, t) : new RegExp(e, "g");
            this.regexp = t(this.regexp, `${this.prefix}(.+?)${this.suffix}`), this.regexpUnescape = t(this.regexpUnescape, `${this.prefix}${this.unescapePrefix}(.+?)${this.unescapeSuffix}${this.suffix}`), this.nestingRegexp = t(this.nestingRegexp, `${this.nestingPrefix}(.+?)${this.nestingSuffix}`)
        }

        interpolate(t, e, s, i) {
            let n, r, a;
            const l = this.options && this.options.interpolation && this.options.interpolation.defaultVariables || {};

            function u(t) {
                return t.replace(/\$/g, "$$$$")
            }

            const h = t => {
                if (t.indexOf(this.formatSeparator) < 0) {
                    const n = P(e, l, t, this.options.keySeparator, this.options.ignoreJSONStructure);
                    return this.alwaysFormat ? this.format(n, void 0, s, {...i, ...e, interpolationkey: t}) : n
                }
                const n = t.split(this.formatSeparator), o = n.shift().trim(), r = n.join(this.formatSeparator).trim();
                return this.format(P(e, l, o, this.options.keySeparator, this.options.ignoreJSONStructure), r, s, {
                    ...i, ...e,
                    interpolationkey: o
                })
            };
            this.resetRegExp();
            const p = i && i.missingInterpolationHandler || this.options.missingInterpolationHandler,
                c = i && i.interpolation && void 0 !== i.interpolation.skipOnVariables ? i.interpolation.skipOnVariables : this.options.interpolation.skipOnVariables;
            return [{regex: this.regexpUnescape, safeValue: t => u(t)}, {
                regex: this.regexp,
                safeValue: t => this.escapeValue ? u(this.escape(t)) : u(t)
            }].forEach((e => {
                for (a = 0; n = e.regex.exec(t);) {
                    const s = n[1].trim();
                    if (r = h(s), void 0 === r) if ("function" == typeof p) {
                        const e = p(t, n, i);
                        r = "string" == typeof e ? e : ""
                    } else if (i && Object.prototype.hasOwnProperty.call(i, s)) r = ""; else {
                        if (c) {
                            r = n[0];
                            continue
                        }
                        this.logger.warn(`missed to pass in variable ${s} for interpolating ${t}`), r = ""
                    } else "string" == typeof r || this.useRawValueToEscape || (r = o(r));
                    const l = e.safeValue(r);
                    if (t = t.replace(n[0], l), c ? (e.regex.lastIndex += r.length, e.regex.lastIndex -= n[0].length) : e.regex.lastIndex = 0, a++, a >= this.maxReplaces) break
                }
            })), t
        }

        nest(t, e) {
            let s, i, n, r = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : {};

            function a(t, e) {
                const s = this.nestingOptionsSeparator;
                if (t.indexOf(s) < 0) return t;
                const i = t.split(new RegExp(`${s}[ ]*{`));
                let o = `{${i[1]}`;
                t = i[0], o = this.interpolate(o, n);
                const r = o.match(/'/g), a = o.match(/"/g);
                (r && r.length % 2 == 0 && !a || a.length % 2 != 0) && (o = o.replace(/'/g, '"'));
                try {
                    n = JSON.parse(o), e && (n = {...e, ...n})
                } catch (e) {
                    return this.logger.warn(`failed parsing options string in nesting for key ${t}`, e), `${t}${s}${o}`
                }
                return delete n.defaultValue, t
            }

            for (; s = this.nestingRegexp.exec(t);) {
                let l = [];
                n = {...r}, n = n.replace && "string" != typeof n.replace ? n.replace : n, n.applyPostProcessor = !1, delete n.defaultValue;
                let u = !1;
                if (-1 !== s[0].indexOf(this.formatSeparator) && !/{.*}/.test(s[1])) {
                    const t = s[1].split(this.formatSeparator).map((t => t.trim()));
                    s[1] = t.shift(), l = t, u = !0
                }
                if (i = e(a.call(this, s[1].trim(), n), n), i && s[0] === t && "string" != typeof i) return i;
                "string" != typeof i && (i = o(i)), i || (this.logger.warn(`missed to resolve ${s[1]} for nesting ${t}`), i = ""), u && (i = l.reduce(((t, e) => this.format(t, e, r.lng, {
                    ...r,
                    interpolationkey: s[1].trim()
                })), i.trim())), t = t.replace(s[0], i), this.regexp.lastIndex = 0
            }
            return t
        }
    }

    function E(t) {
        const e = {};
        return function (s, i, n) {
            const o = i + JSON.stringify(n);
            let r = e[o];
            return r || (r = t(y(i), n), e[o] = r), r(s)
        }
    }

    class I {
        constructor() {
            let t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {};
            this.logger = s.create("formatter"), this.options = t, this.formats = {
                number: E(((t, e) => {
                    const s = new Intl.NumberFormat(t, {...e});
                    return t => s.format(t)
                })), currency: E(((t, e) => {
                    const s = new Intl.NumberFormat(t, {...e, style: "currency"});
                    return t => s.format(t)
                })), datetime: E(((t, e) => {
                    const s = new Intl.DateTimeFormat(t, {...e});
                    return t => s.format(t)
                })), relativetime: E(((t, e) => {
                    const s = new Intl.RelativeTimeFormat(t, {...e});
                    return t => s.format(t, e.range || "day")
                })), list: E(((t, e) => {
                    const s = new Intl.ListFormat(t, {...e});
                    return t => s.format(t)
                }))
            }, this.init(t)
        }

        init(t) {
            const e = (arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {interpolation: {}}).interpolation;
            this.formatSeparator = e.formatSeparator ? e.formatSeparator : e.formatSeparator || ","
        }

        add(t, e) {
            this.formats[t.toLowerCase().trim()] = e
        }

        addCached(t, e) {
            this.formats[t.toLowerCase().trim()] = E(e)
        }

        format(t, e, s) {
            let i = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : {};
            return e.split(this.formatSeparator).reduce(((t, e) => {
                const {formatName: n, formatOptions: o} = function (t) {
                    let e = t.toLowerCase().trim();
                    const s = {};
                    if (t.indexOf("(") > -1) {
                        const i = t.split("(");
                        e = i[0].toLowerCase().trim();
                        const n = i[1].substring(0, i[1].length - 1);
                        "currency" === e && n.indexOf(":") < 0 ? s.currency || (s.currency = n.trim()) : "relativetime" === e && n.indexOf(":") < 0 ? s.range || (s.range = n.trim()) : n.split(";").forEach((t => {
                            if (!t) return;
                            const [e, ...i] = t.split(":"), n = i.join(":").trim().replace(/^'+|'+$/g, "");
                            s[e.trim()] || (s[e.trim()] = n), "false" === n && (s[e.trim()] = !1), "true" === n && (s[e.trim()] = !0), isNaN(n) || (s[e.trim()] = parseInt(n, 10))
                        }))
                    }
                    return {formatName: e, formatOptions: s}
                }(e);
                if (this.formats[n]) {
                    let e = t;
                    try {
                        const r = i && i.formatParams && i.formatParams[i.interpolationkey] || {},
                            a = r.locale || r.lng || i.locale || i.lng || s;
                        e = this.formats[n](t, a, {...o, ...i, ...r})
                    } catch (t) {
                        this.logger.warn(t)
                    }
                    return e
                }
                return this.logger.warn(`there was no format function for ${n}`), t
            }), t)
        }
    }

    class F extends i {
        constructor(t, e, i) {
            let n = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : {};
            super(), this.backend = t, this.store = e, this.services = i, this.languageUtils = i.languageUtils, this.options = n, this.logger = s.create("backendConnector"), this.waitingReads = [], this.maxParallelReads = n.maxParallelReads || 10, this.readingCalls = 0, this.maxRetries = n.maxRetries >= 0 ? n.maxRetries : 5, this.retryTimeout = n.retryTimeout >= 1 ? n.retryTimeout : 350, this.state = {}, this.queue = [], this.backend && this.backend.init && this.backend.init(i, n.backend, n)
        }

        queueLoad(t, e, s, i) {
            const n = {}, o = {}, r = {}, a = {};
            return t.forEach((t => {
                let i = !0;
                e.forEach((e => {
                    const r = `${t}|${e}`;
                    !s.reload && this.store.hasResourceBundle(t, e) ? this.state[r] = 2 : this.state[r] < 0 || (1 === this.state[r] ? void 0 === o[r] && (o[r] = !0) : (this.state[r] = 1, i = !1, void 0 === o[r] && (o[r] = !0), void 0 === n[r] && (n[r] = !0), void 0 === a[e] && (a[e] = !0)))
                })), i || (r[t] = !0)
            })), (Object.keys(n).length || Object.keys(o).length) && this.queue.push({
                pending: o,
                pendingCount: Object.keys(o).length,
                loaded: {},
                errors: [],
                callback: i
            }), {
                toLoad: Object.keys(n),
                pending: Object.keys(o),
                toLoadLanguages: Object.keys(r),
                toLoadNamespaces: Object.keys(a)
            }
        }

        loaded(t, e, s) {
            const i = t.split("|"), n = i[0], o = i[1];
            e && this.emit("failedLoading", n, o, e), s && this.store.addResourceBundle(n, o, s, void 0, void 0, {skipCopy: !0}), this.state[t] = e ? -1 : 2;
            const r = {};
            this.queue.forEach((s => {
                !function (t, e, s, i) {
                    const {obj: n, k: o} = a(t, e, Object);
                    n[o] = n[o] || [], i && (n[o] = n[o].concat(s)), i || n[o].push(s)
                }(s.loaded, [n], o), function (t, e) {
                    void 0 !== t.pending[e] && (delete t.pending[e], t.pendingCount--)
                }(s, t), e && s.errors.push(e), 0 !== s.pendingCount || s.done || (Object.keys(s.loaded).forEach((t => {
                    r[t] || (r[t] = {});
                    const e = s.loaded[t];
                    e.length && e.forEach((e => {
                        void 0 === r[t][e] && (r[t][e] = !0)
                    }))
                })), s.done = !0, s.errors.length ? s.callback(s.errors) : s.callback())
            })), this.emit("loaded", r), this.queue = this.queue.filter((t => !t.done))
        }

        read(t, e, s) {
            let i = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : 0,
                n = arguments.length > 4 && void 0 !== arguments[4] ? arguments[4] : this.retryTimeout,
                o = arguments.length > 5 ? arguments[5] : void 0;
            if (!t.length) return o(null, {});
            if (this.readingCalls >= this.maxParallelReads) return void this.waitingReads.push({
                lng: t,
                ns: e,
                fcName: s,
                tried: i,
                wait: n,
                callback: o
            });
            this.readingCalls++;
            const r = (r, a) => {
                if (this.readingCalls--, this.waitingReads.length > 0) {
                    const t = this.waitingReads.shift();
                    this.read(t.lng, t.ns, t.fcName, t.tried, t.wait, t.callback)
                }
                r && a && i < this.maxRetries ? setTimeout((() => {
                    this.read.call(this, t, e, s, i + 1, 2 * n, o)
                }), n) : o(r, a)
            }, a = this.backend[s].bind(this.backend);
            if (2 !== a.length) return a(t, e, r);
            try {
                const s = a(t, e);
                s && "function" == typeof s.then ? s.then((t => r(null, t))).catch(r) : r(null, s)
            } catch (t) {
                r(t)
            }
        }

        prepareLoading(t, e) {
            let s = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : {},
                i = arguments.length > 3 ? arguments[3] : void 0;
            if (!this.backend) return this.logger.warn("No backend was added via i18next.use. Will not load resources."), i && i();
            "string" == typeof t && (t = this.languageUtils.toResolveHierarchy(t)), "string" == typeof e && (e = [e]);
            const n = this.queueLoad(t, e, s, i);
            if (!n.toLoad.length) return n.pending.length || i(), null;
            n.toLoad.forEach((t => {
                this.loadOne(t)
            }))
        }

        load(t, e, s) {
            this.prepareLoading(t, e, {}, s)
        }

        reload(t, e, s) {
            this.prepareLoading(t, e, {reload: !0}, s)
        }

        loadOne(t) {
            let e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : "";
            const s = t.split("|"), i = s[0], n = s[1];
            this.read(i, n, "read", void 0, void 0, ((s, o) => {
                s && this.logger.warn(`${e}loading namespace ${n} for language ${i} failed`, s), !s && o && this.logger.log(`${e}loaded namespace ${n} for language ${i}`, o), this.loaded(t, s, o)
            }))
        }

        saveMissing(t, e, s, i, n) {
            let o = arguments.length > 5 && void 0 !== arguments[5] ? arguments[5] : {},
                r = arguments.length > 6 && void 0 !== arguments[6] ? arguments[6] : () => {
                };
            if (this.services.utils && this.services.utils.hasLoadedNamespace && !this.services.utils.hasLoadedNamespace(e)) this.logger.warn(`did not save key "${s}" as the namespace "${e}" was not yet loaded`, "This means something IS WRONG in your setup. You access the t function before i18next.init / i18next.loadNamespace / i18next.changeLanguage was done. Wait for the callback or Promise to resolve before accessing it!!!"); else if (null != s && "" !== s) {
                if (this.backend && this.backend.create) {
                    const a = {...o, isUpdate: n}, l = this.backend.create.bind(this.backend);
                    if (l.length < 6) try {
                        let n;
                        n = 5 === l.length ? l(t, e, s, i, a) : l(t, e, s, i), n && "function" == typeof n.then ? n.then((t => r(null, t))).catch(r) : r(null, n)
                    } catch (t) {
                        r(t)
                    } else l(t, e, s, i, r, a)
                }
                t && t[0] && this.store.addResource(t[0], e, s, i)
            }
        }
    }

    function V() {
        return {
            debug: !1,
            initImmediate: !0,
            ns: ["translation"],
            defaultNS: ["translation"],
            fallbackLng: ["dev"],
            fallbackNS: !1,
            supportedLngs: !1,
            nonExplicitSupportedLngs: !1,
            load: "all",
            preload: !1,
            simplifyPluralSuffix: !0,
            keySeparator: ".",
            nsSeparator: ":",
            pluralSeparator: "_",
            contextSeparator: "_",
            partialBundledLanguages: !1,
            saveMissing: !1,
            updateMissing: !1,
            saveMissingTo: "fallback",
            saveMissingPlurals: !0,
            missingKeyHandler: !1,
            missingInterpolationHandler: !1,
            postProcess: !1,
            postProcessPassResolved: !1,
            returnNull: !1,
            returnEmptyString: !0,
            returnObjects: !1,
            joinArrays: !1,
            returnedObjectHandler: !1,
            parseMissingKeyHandler: !1,
            appendNamespaceToMissingKey: !1,
            appendNamespaceToCIMode: !1,
            overloadTranslationOptionHandler: function (t) {
                let e = {};
                if ("object" == typeof t[1] && (e = t[1]), "string" == typeof t[1] && (e.defaultValue = t[1]), "string" == typeof t[2] && (e.tDescription = t[2]), "object" == typeof t[2] || "object" == typeof t[3]) {
                    const s = t[3] || t[2];
                    Object.keys(s).forEach((t => {
                        e[t] = s[t]
                    }))
                }
                return e
            },
            interpolation: {
                escapeValue: !0,
                format: t => t,
                prefix: "{{",
                suffix: "}}",
                formatSeparator: ",",
                unescapePrefix: "-",
                nestingPrefix: "$t(",
                nestingSuffix: ")",
                nestingOptionsSeparator: ",",
                maxReplaces: 1e3,
                skipOnVariables: !0
            }
        }
    }

    function A(t) {
        return "string" == typeof t.ns && (t.ns = [t.ns]), "string" == typeof t.fallbackLng && (t.fallbackLng = [t.fallbackLng]), "string" == typeof t.fallbackNS && (t.fallbackNS = [t.fallbackNS]), t.supportedLngs && t.supportedLngs.indexOf("cimode") < 0 && (t.supportedLngs = t.supportedLngs.concat(["cimode"])), t
    }

    function D() {
    }

    class U extends i {
        constructor() {
            let t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {},
                e = arguments.length > 1 ? arguments[1] : void 0;
            var i;
            if (super(), this.options = A(t), this.services = {}, this.logger = s, this.modules = {external: []}, i = this, Object.getOwnPropertyNames(Object.getPrototypeOf(i)).forEach((t => {
                "function" == typeof i[t] && (i[t] = i[t].bind(i))
            })), e && !this.isInitialized && !t.isClone) {
                if (!this.options.initImmediate) return this.init(t, e), this;
                setTimeout((() => {
                    this.init(t, e)
                }), 0)
            }
        }

        init() {
            var t = this;
            let e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {},
                i = arguments.length > 1 ? arguments[1] : void 0;
            this.isInitializing = !0, "function" == typeof e && (i = e, e = {}), !e.defaultNS && !1 !== e.defaultNS && e.ns && ("string" == typeof e.ns ? e.defaultNS = e.ns : e.ns.indexOf("translation") < 0 && (e.defaultNS = e.ns[0]));
            const o = V();

            function r(t) {
                return t ? "function" == typeof t ? new t : t : null
            }

            if (this.options = {...o, ...this.options, ...A(e)}, "v1" !== this.options.compatibilityAPI && (this.options.interpolation = {...o.interpolation, ...this.options.interpolation}), void 0 !== e.keySeparator && (this.options.userDefinedKeySeparator = e.keySeparator), void 0 !== e.nsSeparator && (this.options.userDefinedNsSeparator = e.nsSeparator), !this.options.isClone) {
                let e;
                this.modules.logger ? s.init(r(this.modules.logger), this.options) : s.init(null, this.options), this.modules.formatter ? e = this.modules.formatter : "undefined" != typeof Intl && (e = I);
                const i = new O(this.options);
                this.store = new v(this.options.resources, this.options);
                const n = this.services;
                n.logger = s, n.resourceStore = this.store, n.languageUtils = i, n.pluralResolver = new C(i, {
                    prepend: this.options.pluralSeparator,
                    compatibilityJSON: this.options.compatibilityJSON,
                    simplifyPluralSuffix: this.options.simplifyPluralSuffix
                }), !e || this.options.interpolation.format && this.options.interpolation.format !== o.interpolation.format || (n.formatter = r(e), n.formatter.init(n, this.options), this.options.interpolation.format = n.formatter.format.bind(n.formatter)), n.interpolator = new j(this.options), n.utils = {hasLoadedNamespace: this.hasLoadedNamespace.bind(this)}, n.backendConnector = new F(r(this.modules.backend), n.resourceStore, n, this.options), n.backendConnector.on("*", (function (e) {
                    for (var s = arguments.length, i = new Array(s > 1 ? s - 1 : 0), n = 1; n < s; n++) i[n - 1] = arguments[n];
                    t.emit(e, ...i)
                })), this.modules.languageDetector && (n.languageDetector = r(this.modules.languageDetector), n.languageDetector.init && n.languageDetector.init(n, this.options.detection, this.options)), this.modules.i18nFormat && (n.i18nFormat = r(this.modules.i18nFormat), n.i18nFormat.init && n.i18nFormat.init(this)), this.translator = new S(this.services, this.options), this.translator.on("*", (function (e) {
                    for (var s = arguments.length, i = new Array(s > 1 ? s - 1 : 0), n = 1; n < s; n++) i[n - 1] = arguments[n];
                    t.emit(e, ...i)
                })), this.modules.external.forEach((t => {
                    t.init && t.init(this)
                }))
            }
            if (this.format = this.options.interpolation.format, i || (i = D), this.options.fallbackLng && !this.services.languageDetector && !this.options.lng) {
                const t = this.services.languageUtils.getFallbackCodes(this.options.fallbackLng);
                t.length > 0 && "dev" !== t[0] && (this.options.lng = t[0])
            }
            this.services.languageDetector || this.options.lng || this.logger.warn("init: no languageDetector is used and no lng is defined");
            ["getResource", "hasResourceBundle", "getResourceBundle", "getDataByLanguage"].forEach((e => {
                this[e] = function () {
                    return t.store[e](...arguments)
                }
            }));
            ["addResource", "addResources", "addResourceBundle", "removeResourceBundle"].forEach((e => {
                this[e] = function () {
                    return t.store[e](...arguments), t
                }
            }));
            const a = n(), l = () => {
                const t = (t, e) => {
                    this.isInitializing = !1, this.isInitialized && !this.initializedStoreOnce && this.logger.warn("init: i18next is already initialized. You should call init just once!"), this.isInitialized = !0, this.options.isClone || this.logger.log("initialized", this.options), this.emit("initialized", this.options), a.resolve(e), i(t, e)
                };
                if (this.languages && "v1" !== this.options.compatibilityAPI && !this.isInitialized) return t(null, this.t.bind(this));
                this.changeLanguage(this.options.lng, t)
            };
            return this.options.resources || !this.options.initImmediate ? l() : setTimeout(l, 0), a
        }

        loadResources(t) {
            let e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : D;
            const s = "string" == typeof t ? t : this.language;
            if ("function" == typeof t && (e = t), !this.options.resources || this.options.partialBundledLanguages) {
                if (s && "cimode" === s.toLowerCase() && (!this.options.preload || 0 === this.options.preload.length)) return e();
                const t = [], i = e => {
                    if (!e) return;
                    if ("cimode" === e) return;
                    this.services.languageUtils.toResolveHierarchy(e).forEach((e => {
                        "cimode" !== e && t.indexOf(e) < 0 && t.push(e)
                    }))
                };
                if (s) i(s); else {
                    this.services.languageUtils.getFallbackCodes(this.options.fallbackLng).forEach((t => i(t)))
                }
                this.options.preload && this.options.preload.forEach((t => i(t))), this.services.backendConnector.load(t, this.options.ns, (t => {
                    t || this.resolvedLanguage || !this.language || this.setResolvedLanguage(this.language), e(t)
                }))
            } else e(null)
        }

        reloadResources(t, e, s) {
            const i = n();
            return t || (t = this.languages), e || (e = this.options.ns), s || (s = D), this.services.backendConnector.reload(t, e, (t => {
                i.resolve(), s(t)
            })), i
        }

        use(t) {
            if (!t) throw new Error("You are passing an undefined module! Please check the object you are passing to i18next.use()");
            if (!t.type) throw new Error("You are passing a wrong module! Please check the object you are passing to i18next.use()");
            return "backend" === t.type && (this.modules.backend = t), ("logger" === t.type || t.log && t.warn && t.error) && (this.modules.logger = t), "languageDetector" === t.type && (this.modules.languageDetector = t), "i18nFormat" === t.type && (this.modules.i18nFormat = t), "postProcessor" === t.type && b.addPostProcessor(t), "formatter" === t.type && (this.modules.formatter = t), "3rdParty" === t.type && this.modules.external.push(t), this
        }

        setResolvedLanguage(t) {
            if (t && this.languages && !(["cimode", "dev"].indexOf(t) > -1)) for (let t = 0; t < this.languages.length; t++) {
                const e = this.languages[t];
                if (!(["cimode", "dev"].indexOf(e) > -1) && this.store.hasLanguageSomeTranslations(e)) {
                    this.resolvedLanguage = e;
                    break
                }
            }
        }

        changeLanguage(t, e) {
            var s = this;
            this.isLanguageChangingTo = t;
            const i = n();
            this.emit("languageChanging", t);
            const o = t => {
                this.language = t, this.languages = this.services.languageUtils.toResolveHierarchy(t), this.resolvedLanguage = void 0, this.setResolvedLanguage(t)
            }, r = (t, n) => {
                n ? (o(n), this.translator.changeLanguage(n), this.isLanguageChangingTo = void 0, this.emit("languageChanged", n), this.logger.log("languageChanged", n)) : this.isLanguageChangingTo = void 0, i.resolve((function () {
                    return s.t(...arguments)
                })), e && e(t, (function () {
                    return s.t(...arguments)
                }))
            }, a = e => {
                t || e || !this.services.languageDetector || (e = []);
                const s = "string" == typeof e ? e : this.services.languageUtils.getBestMatchFromCodes(e);
                s && (this.language || o(s), this.translator.language || this.translator.changeLanguage(s), this.services.languageDetector && this.services.languageDetector.cacheUserLanguage && this.services.languageDetector.cacheUserLanguage(s)), this.loadResources(s, (t => {
                    r(t, s)
                }))
            };
            return t || !this.services.languageDetector || this.services.languageDetector.async ? !t && this.services.languageDetector && this.services.languageDetector.async ? 0 === this.services.languageDetector.detect.length ? this.services.languageDetector.detect().then(a) : this.services.languageDetector.detect(a) : a(t) : a(this.services.languageDetector.detect()), i
        }

        getFixedT(t, e, s) {
            var i = this;
            const n = function (t, e) {
                let o;
                if ("object" != typeof e) {
                    for (var r = arguments.length, a = new Array(r > 2 ? r - 2 : 0), l = 2; l < r; l++) a[l - 2] = arguments[l];
                    o = i.options.overloadTranslationOptionHandler([t, e].concat(a))
                } else o = {...e};
                o.lng = o.lng || n.lng, o.lngs = o.lngs || n.lngs, o.ns = o.ns || n.ns, o.keyPrefix = o.keyPrefix || s || n.keyPrefix;
                const u = i.options.keySeparator || ".";
                let h;
                return h = o.keyPrefix && Array.isArray(t) ? t.map((t => `${o.keyPrefix}${u}${t}`)) : o.keyPrefix ? `${o.keyPrefix}${u}${t}` : t, i.t(h, o)
            };
            return "string" == typeof t ? n.lng = t : n.lngs = t, n.ns = e, n.keyPrefix = s, n
        }

        t() {
            return this.translator && this.translator.translate(...arguments)
        }

        exists() {
            return this.translator && this.translator.exists(...arguments)
        }

        setDefaultNamespace(t) {
            this.options.defaultNS = t
        }

        hasLoadedNamespace(t) {
            let e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
            if (!this.isInitialized) return this.logger.warn("hasLoadedNamespace: i18next was not initialized", this.languages), !1;
            if (!this.languages || !this.languages.length) return this.logger.warn("hasLoadedNamespace: i18n.languages were undefined or empty", this.languages), !1;
            const s = e.lng || this.resolvedLanguage || this.languages[0],
                i = !!this.options && this.options.fallbackLng, n = this.languages[this.languages.length - 1];
            if ("cimode" === s.toLowerCase()) return !0;
            const o = (t, e) => {
                const s = this.services.backendConnector.state[`${t}|${e}`];
                return -1 === s || 2 === s
            };
            if (e.precheck) {
                const t = e.precheck(this, o);
                if (void 0 !== t) return t
            }
            return !!this.hasResourceBundle(s, t) || (!(this.services.backendConnector.backend && (!this.options.resources || this.options.partialBundledLanguages)) || !(!o(s, t) || i && !o(n, t)))
        }

        loadNamespaces(t, e) {
            const s = n();
            return this.options.ns ? ("string" == typeof t && (t = [t]), t.forEach((t => {
                this.options.ns.indexOf(t) < 0 && this.options.ns.push(t)
            })), this.loadResources((t => {
                s.resolve(), e && e(t)
            })), s) : (e && e(), Promise.resolve())
        }

        loadLanguages(t, e) {
            const s = n();
            "string" == typeof t && (t = [t]);
            const i = this.options.preload || [], o = t.filter((t => i.indexOf(t) < 0));
            return o.length ? (this.options.preload = i.concat(o), this.loadResources((t => {
                s.resolve(), e && e(t)
            })), s) : (e && e(), Promise.resolve())
        }

        dir(t) {
            if (t || (t = this.resolvedLanguage || (this.languages && this.languages.length > 0 ? this.languages[0] : this.language)), !t) return "rtl";
            const e = this.services && this.services.languageUtils || new O(V());
            return ["ar", "shu", "sqr", "ssh", "xaa", "yhd", "yud", "aao", "abh", "abv", "acm", "acq", "acw", "acx", "acy", "adf", "ads", "aeb", "aec", "afb", "ajp", "apc", "apd", "arb", "arq", "ars", "ary", "arz", "auz", "avl", "ayh", "ayl", "ayn", "ayp", "bbz", "pga", "he", "iw", "ps", "pbt", "pbu", "pst", "prp", "prd", "ug", "ur", "ydd", "yds", "yih", "ji", "yi", "hbo", "men", "xmn", "fa", "jpr", "peo", "pes", "prs", "dv", "sam", "ckb"].indexOf(e.getLanguagePartFromCode(t)) > -1 || t.toLowerCase().indexOf("-arab") > 1 ? "rtl" : "ltr"
        }

        static createInstance() {
            return new U(arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {}, arguments.length > 1 ? arguments[1] : void 0)
        }

        cloneInstance() {
            let t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {},
                e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : D;
            const s = t.forkResourceStore;
            s && delete t.forkResourceStore;
            const i = {...this.options, ...t, isClone: !0}, n = new U(i);
            void 0 === t.debug && void 0 === t.prefix || (n.logger = n.logger.clone(t));
            return ["store", "services", "language"].forEach((t => {
                n[t] = this[t]
            })), n.services = {...this.services}, n.services.utils = {hasLoadedNamespace: n.hasLoadedNamespace.bind(n)}, s && (n.store = new v(this.store.data, i), n.services.resourceStore = n.store), n.translator = new S(n.services, i), n.translator.on("*", (function (t) {
                for (var e = arguments.length, s = new Array(e > 1 ? e - 1 : 0), i = 1; i < e; i++) s[i - 1] = arguments[i];
                n.emit(t, ...s)
            })), n.init(i, e), n.translator.options = i, n.translator.backendConnector.services.utils = {hasLoadedNamespace: n.hasLoadedNamespace.bind(n)}, n
        }

        toJSON() {
            return {
                options: this.options,
                store: this.store,
                language: this.language,
                languages: this.languages,
                resolvedLanguage: this.resolvedLanguage
            }
        }
    }

    const T = U.createInstance();
    return T.createInstance = U.createInstance, T
}));