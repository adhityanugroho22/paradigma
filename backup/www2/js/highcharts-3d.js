/*
 Highcharts JS v5.0.5 (2016-11-29)

 3D features for Highcharts JS

 @license: www.highcharts.com/license
*/
(function(E) {
    "object" === typeof module && module.exports ? module.exports = E : E(Highcharts)
})(function(E) {
    (function(a) {
        var r = a.deg2rad,
            h = a.pick;
        a.perspective = function(p, m, w) {
            var q = m.options.chart.options3d,
                g = w ? m.inverted : !1,
                n = m.plotWidth / 2,
                f = m.plotHeight / 2,
                l = q.depth / 2,
                d = h(q.depth, 1) * h(q.viewDistance, 0),
                e = m.scale3d || 1,
                b = r * q.beta * (g ? -1 : 1),
                q = r * q.alpha * (g ? -1 : 1),
                c = Math.cos(q),
                u = Math.cos(-b),
                x = Math.sin(q),
                y = Math.sin(-b);
            w || (n += m.plotLeft, f += m.plotTop);
            return a.map(p, function(b) {
                var a, q;
                q = (g ? b.y : b.x) - n;
                var m = (g ?
                        b.x : b.y) - f,
                    p = (b.z || 0) - l;
                a = u * q - y * p;
                b = -x * y * q + c * m - u * x * p;
                q = c * y * q + x * m + c * u * p;
                m = 0 < d && d < Number.POSITIVE_INFINITY ? d / (q + l + d) : 1;
                a = a * m * e + n;
                b = b * m * e + f;
                return {
                    x: g ? b : a,
                    y: g ? a : b,
                    z: q * e + l
                }
            })
        };
        a.pointCameraDistance = function(a, m) {
            var p = m.options.chart.options3d,
                q = m.plotWidth / 2;
            m = m.plotHeight / 2;
            p = h(p.depth, 1) * h(p.viewDistance, 0) + p.depth;
            return Math.sqrt(Math.pow(q - a.plotX, 2) + Math.pow(m - a.plotY, 2) + Math.pow(p - a.plotZ, 2))
        }
    })(E);
    (function(a) {
        function r(b) {
            var a = 0,
                k, c;
            for (k = 0; k < b.length; k++) c = (k + 1) % b.length, a += b[k].x * b[c].y -
                b[c].x * b[k].y;
            return a / 2
        }

        function h(b) {
            var a = 0,
                k;
            for (k = 0; k < b.length; k++) a += b[k].z;
            return b.length ? a / b.length : 0
        }

        function p(b, a, k, c, e, d, f, g) {
            var C = [],
                H = d - e;
            return d > e && d - e > Math.PI / 2 + .0001 ? (C = C.concat(p(b, a, k, c, e, e + Math.PI / 2, f, g)), C = C.concat(p(b, a, k, c, e + Math.PI / 2, d, f, g))) : d < e && e - d > Math.PI / 2 + .0001 ? (C = C.concat(p(b, a, k, c, e, e - Math.PI / 2, f, g)), C = C.concat(p(b, a, k, c, e - Math.PI / 2, d, f, g))) : ["C", b + k * Math.cos(e) - k * t * H * Math.sin(e) + f, a + c * Math.sin(e) + c * t * H * Math.cos(e) + g, b + k * Math.cos(d) + k * t * H * Math.sin(d) + f, a + c * Math.sin(d) -
                c * t * H * Math.cos(d) + g, b + k * Math.cos(d) + f, a + c * Math.sin(d) + g
            ]
        }
        var m = Math.cos,
            w = Math.PI,
            q = Math.sin,
            g = a.animObject,
            n = a.charts,
            f = a.color,
            l = a.defined,
            d = a.deg2rad,
            e = a.each,
            b = a.extend,
            c = a.inArray,
            u = a.map,
            x = a.merge,
            y = a.perspective,
            F = a.pick,
            A = a.SVGElement,
            G = a.SVGRenderer,
            B = a.wrap,
            t = 4 * (Math.sqrt(2) - 1) / 3 / (w / 2);
        G.prototype.toLinePath = function(b, a) {
            var k = [];
            e(b, function(b) {
                k.push("L", b.x, b.y)
            });
            b.length && (k[0] = "M", a && k.push("Z"));
            return k
        };
        G.prototype.cuboid = function(b) {
            var c = this.g();
            b = this.cuboidPath(b);
            c.attr({
                "stroke-linejoin": "round"
            });
            c.front = this.path(b[0]).attr({
                "class": "highcharts-3d-front",
                zIndex: b[3]
            }).add(c);
            c.top = this.path(b[1]).attr({
                "class": "highcharts-3d-top",
                zIndex: b[4]
            }).add(c);
            c.side = this.path(b[2]).attr({
                "class": "highcharts-3d-side",
                zIndex: b[5]
            }).add(c);
            c.fillSetter = function(b) {
                this.front.attr({
                    fill: b
                });
                this.top.attr({
                    fill: f(b).brighten(.1).get()
                });
                this.side.attr({
                    fill: f(b).brighten(-.1).get()
                });
                this.color = b;
                return this
            };
            c.opacitySetter = function(b) {
                this.front.attr({
                    opacity: b
                });
                this.top.attr({
                    opacity: b
                });
                this.side.attr({
                    opacity: b
                });
                return this
            };
            c.attr = function(b) {
                if (b.shapeArgs || l(b.x)) b = this.renderer.cuboidPath(b.shapeArgs || b), this.front.attr({
                    d: b[0],
                    zIndex: b[3]
                }), this.top.attr({
                    d: b[1],
                    zIndex: b[4]
                }), this.side.attr({
                    d: b[2],
                    zIndex: b[5]
                });
                else return a.SVGElement.prototype.attr.call(this, b);
                return this
            };
            c.animate = function(b, c, a) {
                l(b.x) && l(b.y) ? (b = this.renderer.cuboidPath(b), this.front.attr({
                        zIndex: b[3]
                    }).animate({
                        d: b[0]
                    }, c, a), this.top.attr({
                        zIndex: b[4]
                    }).animate({
                        d: b[1]
                    }, c, a), this.side.attr({
                        zIndex: b[5]
                    }).animate({
                        d: b[2]
                    }, c, a),
                    this.attr({
                        zIndex: -b[6]
                    })) : b.opacity ? (this.front.animate(b, c, a), this.top.animate(b, c, a), this.side.animate(b, c, a)) : A.prototype.animate.call(this, b, c, a);
                return this
            };
            c.destroy = function() {
                this.front.destroy();
                this.top.destroy();
                this.side.destroy();
                return null
            };
            c.attr({
                zIndex: -b[6]
            });
            return c
        };
        G.prototype.cuboidPath = function(b) {
            function c(b) {
                return l[b]
            }
            var a = b.x,
                e = b.y,
                d = b.z,
                f = b.height,
                C = b.width,
                g = b.depth,
                l = [{
                    x: a,
                    y: e,
                    z: d
                }, {
                    x: a + C,
                    y: e,
                    z: d
                }, {
                    x: a + C,
                    y: e + f,
                    z: d
                }, {
                    x: a,
                    y: e + f,
                    z: d
                }, {
                    x: a,
                    y: e + f,
                    z: d + g
                }, {
                    x: a + C,
                    y: e +
                        f,
                    z: d + g
                }, {
                    x: a + C,
                    y: e,
                    z: d + g
                }, {
                    x: a,
                    y: e,
                    z: d + g
                }],
                l = y(l, n[this.chartIndex], b.insidePlotArea),
                d = function(b, a) {
                    var e = [];
                    b = u(b, c);
                    a = u(a, c);
                    0 > r(b) ? e = b : 0 > r(a) && (e = a);
                    return e
                };
            b = d([3, 2, 1, 0], [7, 6, 5, 4]);
            a = [4, 5, 2, 3];
            e = d([1, 6, 7, 0], a);
            d = d([1, 2, 5, 6], [0, 7, 4, 3]);
            return [this.toLinePath(b, !0), this.toLinePath(e, !0), this.toLinePath(d, !0), h(b), h(e), h(d), 9E9 * h(u(a, c))]
        };
        a.SVGRenderer.prototype.arc3d = function(a) {
            function l(b) {
                var a = !1,
                    e = {},
                    d;
                for (d in b) - 1 !== c(d, u) && (e[d] = b[d], delete b[d], a = !0);
                return a ? e : !1
            }
            var k = this.g(),
                q = k.renderer,
                u = "x y r innerR start end".split(" ");
            a = x(a);
            a.alpha *= d;
            a.beta *= d;
            k.top = q.path();
            k.side1 = q.path();
            k.side2 = q.path();
            k.inn = q.path();
            k.out = q.path();
            k.onAdd = function() {
                var b = k.parentGroup,
                    a = k.attr("class");
                k.top.add(k);
                e(["out", "inn", "side1", "side2"], function(c) {
                    k[c].addClass(a + " highcharts-3d-side").add(b)
                })
            };
            k.setPaths = function(b) {
                var a = k.renderer.arc3dPath(b),
                    c = 100 * a.zTop;
                k.attribs = b;
                k.top.attr({
                    d: a.top,
                    zIndex: a.zTop
                });
                k.inn.attr({
                    d: a.inn,
                    zIndex: a.zInn
                });
                k.out.attr({
                    d: a.out,
                    zIndex: a.zOut
                });
                k.side1.attr({
                    d: a.side1,
                    zIndex: a.zSide1
                });
                k.side2.attr({
                    d: a.side2,
                    zIndex: a.zSide2
                });
                k.zIndex = c;
                k.attr({
                    zIndex: c
                });
                b.center && (k.top.setRadialReference(b.center), delete b.center)
            };
            k.setPaths(a);
            k.fillSetter = function(b) {
                var a = f(b).brighten(-.1).get();
                this.fill = b;
                this.side1.attr({
                    fill: a
                });
                this.side2.attr({
                    fill: a
                });
                this.inn.attr({
                    fill: a
                });
                this.out.attr({
                    fill: a
                });
                this.top.attr({
                    fill: b
                });
                return this
            };
            e(["opacity", "translateX", "translateY", "visibility"], function(b) {
                k[b + "Setter"] = function(b, a) {
                    k[a] = b;
                    e(["out",
                        "inn", "side1", "side2", "top"
                    ], function(c) {
                        k[c].attr(a, b)
                    })
                }
            });
            B(k, "attr", function(a, c, e) {
                var d;
                "object" === typeof c && (d = l(c)) && (b(k.attribs, d), k.setPaths(k.attribs));
                return a.call(this, c, e)
            });
            B(k, "animate", function(b, a, c, e) {
                var d, k = this.attribs,
                    f;
                delete a.center;
                delete a.z;
                delete a.depth;
                delete a.alpha;
                delete a.beta;
                f = g(F(c, this.renderer.globalAnimation));
                f.duration && (a = x(a), d = l(a), a.dummy = 1, d && (f.step = function(b, a) {
                    function c(b) {
                        return k[b] + (F(d[b], k[b]) - k[b]) * a.pos
                    }
                    "dummy" === a.prop && a.elem.setPaths(x(k, {
                        x: c("x"),
                        y: c("y"),
                        r: c("r"),
                        innerR: c("innerR"),
                        start: c("start"),
                        end: c("end")
                    }))
                }), c = f);
                return b.call(this, a, c, e)
            });
            k.destroy = function() {
                this.top.destroy();
                this.out.destroy();
                this.inn.destroy();
                this.side1.destroy();
                this.side2.destroy();
                A.prototype.destroy.call(this)
            };
            k.hide = function() {
                this.top.hide();
                this.out.hide();
                this.inn.hide();
                this.side1.hide();
                this.side2.hide()
            };
            k.show = function() {
                this.top.show();
                this.out.show();
                this.inn.show();
                this.side1.show();
                this.side2.show()
            };
            return k
        };
        G.prototype.arc3dPath =
            function(b) {
                function a(b) {
                    b %= 2 * Math.PI;
                    b > Math.PI && (b = 2 * Math.PI - b);
                    return b
                }
                var c = b.x,
                    e = b.y,
                    d = b.start,
                    f = b.end - .00001,
                    g = b.r,
                    l = b.innerR,
                    u = b.depth,
                    h = b.alpha,
                    n = b.beta,
                    x = Math.cos(d),
                    r = Math.sin(d);
                b = Math.cos(f);
                var y = Math.sin(f),
                    v = g * Math.cos(n),
                    g = g * Math.cos(h),
                    t = l * Math.cos(n),
                    B = l * Math.cos(h),
                    l = u * Math.sin(n),
                    z = u * Math.sin(h),
                    u = ["M", c + v * x, e + g * r],
                    u = u.concat(p(c, e, v, g, d, f, 0, 0)),
                    u = u.concat(["L", c + t * b, e + B * y]),
                    u = u.concat(p(c, e, t, B, f, d, 0, 0)),
                    u = u.concat(["Z"]),
                    F = 0 < n ? Math.PI / 2 : 0,
                    n = 0 < h ? 0 : Math.PI / 2,
                    F = d > -F ? d : f > -F ? -F :
                    d,
                    D = f < w - n ? f : d < w - n ? w - n : f,
                    A = 2 * w - n,
                    h = ["M", c + v * m(F), e + g * q(F)],
                    h = h.concat(p(c, e, v, g, F, D, 0, 0));
                f > A && d < A ? (h = h.concat(["L", c + v * m(D) + l, e + g * q(D) + z]), h = h.concat(p(c, e, v, g, D, A, l, z)), h = h.concat(["L", c + v * m(A), e + g * q(A)]), h = h.concat(p(c, e, v, g, A, f, 0, 0)), h = h.concat(["L", c + v * m(f) + l, e + g * q(f) + z]), h = h.concat(p(c, e, v, g, f, A, l, z)), h = h.concat(["L", c + v * m(A), e + g * q(A)]), h = h.concat(p(c, e, v, g, A, D, 0, 0))) : f > w - n && d < w - n && (h = h.concat(["L", c + v * Math.cos(D) + l, e + g * Math.sin(D) + z]), h = h.concat(p(c, e, v, g, D, f, l, z)), h = h.concat(["L", c + v * Math.cos(f),
                    e + g * Math.sin(f)
                ]), h = h.concat(p(c, e, v, g, f, D, 0, 0)));
                h = h.concat(["L", c + v * Math.cos(D) + l, e + g * Math.sin(D) + z]);
                h = h.concat(p(c, e, v, g, D, F, l, z));
                h = h.concat(["Z"]);
                n = ["M", c + t * x, e + B * r];
                n = n.concat(p(c, e, t, B, d, f, 0, 0));
                n = n.concat(["L", c + t * Math.cos(f) + l, e + B * Math.sin(f) + z]);
                n = n.concat(p(c, e, t, B, f, d, l, z));
                n = n.concat(["Z"]);
                x = ["M", c + v * x, e + g * r, "L", c + v * x + l, e + g * r + z, "L", c + t * x + l, e + B * r + z, "L", c + t * x, e + B * r, "Z"];
                c = ["M", c + v * b, e + g * y, "L", c + v * b + l, e + g * y + z, "L", c + t * b + l, e + B * y + z, "L", c + t * b, e + B * y, "Z"];
                y = Math.atan2(z, -l);
                e = Math.abs(f + y);
                b = Math.abs(d + y);
                d = Math.abs((d + f) / 2 + y);
                e = a(e);
                b = a(b);
                d = a(d);
                d *= 1E5;
                f = 1E5 * b;
                e *= 1E5;
                return {
                    top: u,
                    zTop: 1E5 * Math.PI + 1,
                    out: h,
                    zOut: Math.max(d, f, e),
                    inn: n,
                    zInn: Math.max(d, f, e),
                    side1: x,
                    zSide1: .99 * e,
                    side2: c,
                    zSide2: .99 * f
                }
            }
    })(E);
    (function(a) {
        function r(a, g) {
            var d = a.plotLeft,
                e = a.plotWidth + d,
                b = a.plotTop,
                c = a.plotHeight + b,
                f = d + a.plotWidth / 2,
                l = b + a.plotHeight / 2,
                h = Number.MAX_VALUE,
                q = -Number.MAX_VALUE,
                n = Number.MAX_VALUE,
                m = -Number.MAX_VALUE,
                r, t = 1;
            r = [{
                x: d,
                y: b,
                z: 0
            }, {
                x: d,
                y: b,
                z: g
            }];
            p([0, 1], function(b) {
                r.push({
                    x: e,
                    y: r[b].y,
                    z: r[b].z
                })
            });
            p([0, 1, 2, 3], function(b) {
                r.push({
                    x: r[b].x,
                    y: c,
                    z: r[b].z
                })
            });
            r = w(r, a, !1);
            p(r, function(b) {
                h = Math.min(h, b.x);
                q = Math.max(q, b.x);
                n = Math.min(n, b.y);
                m = Math.max(m, b.y)
            });
            d > h && (t = Math.min(t, 1 - Math.abs((d + f) / (h + f)) % 1));
            e < q && (t = Math.min(t, (e - f) / (q - f)));
            b > n && (t = 0 > n ? Math.min(t, (b + l) / (-n + b + l)) : Math.min(t, 1 - (b + l) / (n + l) % 1));
            c < m && (t = Math.min(t, Math.abs((c - l) / (m - l))));
            return t
        }
        var h = a.Chart,
            p = a.each,
            m = a.merge,
            w = a.perspective,
            q = a.pick,
            g = a.wrap;
        h.prototype.is3d = function() {
            return this.options.chart.options3d &&
                this.options.chart.options3d.enabled
        };
        h.prototype.propsRequireDirtyBox.push("chart.options3d");
        h.prototype.propsRequireUpdateSeries.push("chart.options3d");
        a.wrap(a.Chart.prototype, "isInsidePlot", function(a) {
            return this.is3d() || a.apply(this, [].slice.call(arguments, 1))
        });
        var n = a.getOptions();
        m(!0, n, {
            chart: {
                options3d: {
                    enabled: !1,
                    alpha: 0,
                    beta: 0,
                    depth: 100,
                    fitToPlot: !0,
                    viewDistance: 25,
                    frame: {
                        bottom: {
                            size: 1
                        },
                        side: {
                            size: 1
                        },
                        back: {
                            size: 1
                        }
                    }
                }
            }
        });
        g(h.prototype, "setClassName", function(a) {
            a.apply(this, [].slice.call(arguments,
                1));
            this.is3d() && (this.container.className += " highcharts-3d-chart")
        });
        a.wrap(a.Chart.prototype, "setChartSize", function(a) {
            var f = this.options.chart.options3d;
            a.apply(this, [].slice.call(arguments, 1));
            if (this.is3d()) {
                var d = this.inverted,
                    e = this.clipBox,
                    b = this.margin;
                e[d ? "y" : "x"] = -(b[3] || 0);
                e[d ? "x" : "y"] = -(b[0] || 0);
                e[d ? "height" : "width"] = this.chartWidth + (b[3] || 0) + (b[1] || 0);
                e[d ? "width" : "height"] = this.chartHeight + (b[0] || 0) + (b[2] || 0);
                this.scale3d = 1;
                !0 === f.fitToPlot && (this.scale3d = r(this, f.depth))
            }
        });
        g(h.prototype,
            "redraw",
            function(a) {
                this.is3d() && (this.isDirtyBox = !0);
                a.apply(this, [].slice.call(arguments, 1))
            });
        g(h.prototype, "renderSeries", function(a) {
            var f = this.series.length;
            if (this.is3d())
                for (; f--;) a = this.series[f], a.translate(), a.render();
            else a.call(this)
        });
        h.prototype.retrieveStacks = function(a) {
            var f = this.series,
                d = {},
                e, b = 1;
            p(this.series, function(c) {
                e = q(c.options.stack, a ? 0 : f.length - 1 - c.index);
                d[e] ? d[e].series.push(c) : (d[e] = {
                    series: [c],
                    position: b
                }, b++)
            });
            d.totalStacks = b + 1;
            return d
        }
    })(E);
    (function(a) {
        var r,
            h = a.Axis,
            p = a.Chart,
            m = a.each,
            w = a.extend,
            q = a.merge,
            g = a.perspective,
            n = a.pick,
            f = a.splat,
            l = a.Tick,
            d = a.wrap;
        d(h.prototype, "setOptions", function(a, b) {
            a.call(this, b);
            this.chart.is3d() && (a = this.options, a.tickWidth = n(a.tickWidth, 0), a.gridLineWidth = n(a.gridLineWidth, 1))
        });
        d(h.prototype, "render", function(a) {
            a.apply(this, [].slice.call(arguments, 1));
            if (this.chart.is3d()) {
                var b = this.chart,
                    c = b.renderer,
                    e = b.options.chart.options3d,
                    d = e.frame,
                    f = d.bottom,
                    g = d.back,
                    d = d.side,
                    h = e.depth,
                    l = this.height,
                    q = this.width,
                    n = this.left,
                    m = this.top;
                this.isZAxis || (this.horiz ? (g = {
                    x: n,
                    y: m + (b.xAxis[0].opposite ? -f.size : l),
                    z: 0,
                    width: q,
                    height: f.size,
                    depth: h,
                    insidePlotArea: !1
                }, this.bottomFrame ? this.bottomFrame.animate(g) : (this.bottomFrame = c.cuboid(g).attr({
                    "class": "highcharts-3d-frame highcharts-3d-frame-bottom",
                    zIndex: b.yAxis[0].reversed && 0 < e.alpha ? 4 : -1
                }).add(), this.bottomFrame.attr({
                    fill: f.color || "none",
                    stroke: f.color || "none"
                }))) : (e = {
                    x: n + (b.yAxis[0].opposite ? 0 : -d.size),
                    y: m + (b.xAxis[0].opposite ? -f.size : 0),
                    z: h,
                    width: q + d.size,
                    height: l + f.size,
                    depth: g.size,
                    insidePlotArea: !1
                }, this.backFrame ? this.backFrame.animate(e) : (this.backFrame = c.cuboid(e).attr({
                    "class": "highcharts-3d-frame highcharts-3d-frame-back",
                    zIndex: -3
                }).add(), this.backFrame.attr({
                    fill: g.color || "none",
                    stroke: g.color || "none"
                })), b = {
                    x: n + (b.yAxis[0].opposite ? q : -d.size),
                    y: m + (b.xAxis[0].opposite ? -f.size : 0),
                    z: 0,
                    width: d.size,
                    height: l + f.size,
                    depth: h,
                    insidePlotArea: !1
                }, this.sideFrame ? this.sideFrame.animate(b) : (this.sideFrame = c.cuboid(b).attr({
                    "class": "highcharts-3d-frame highcharts-3d-frame-side",
                    zIndex: -2
                }).add(), this.sideFrame.attr({
                    fill: d.color || "none",
                    stroke: d.color || "none"
                }))))
            }
        });
        d(h.prototype, "getPlotLinePath", function(a) {
            var b = a.apply(this, [].slice.call(arguments, 1));
            if (!this.chart.is3d() || null === b) return b;
            var c = this.chart,
                e = c.options.chart.options3d,
                c = this.isZAxis ? c.plotWidth : e.depth,
                e = this.opposite;
            this.horiz && (e = !e);
            b = [this.swapZ({
                x: b[1],
                y: b[2],
                z: e ? c : 0
            }), this.swapZ({
                x: b[1],
                y: b[2],
                z: c
            }), this.swapZ({
                x: b[4],
                y: b[5],
                z: c
            }), this.swapZ({
                x: b[4],
                y: b[5],
                z: e ? 0 : c
            })];
            b = g(b, this.chart, !1);
            return b =
                this.chart.renderer.toLinePath(b, !1)
        });
        d(h.prototype, "getLinePath", function(a) {
            return this.chart.is3d() ? [] : a.apply(this, [].slice.call(arguments, 1))
        });
        d(h.prototype, "getPlotBandPath", function(a) {
            if (!this.chart.is3d()) return a.apply(this, [].slice.call(arguments, 1));
            var b = arguments,
                c = b[1],
                b = this.getPlotLinePath(b[2]);
            (c = this.getPlotLinePath(c)) && b ? c.push("L", b[10], b[11], "L", b[7], b[8], "L", b[4], b[5], "L", b[1], b[2]) : c = null;
            return c
        });
        d(l.prototype, "getMarkPath", function(a) {
            var b = a.apply(this, [].slice.call(arguments,
                1));
            if (!this.axis.chart.is3d()) return b;
            b = [this.axis.swapZ({
                x: b[1],
                y: b[2],
                z: 0
            }), this.axis.swapZ({
                x: b[4],
                y: b[5],
                z: 0
            })];
            b = g(b, this.axis.chart, !1);
            return b = ["M", b[0].x, b[0].y, "L", b[1].x, b[1].y]
        });
        d(l.prototype, "getLabelPosition", function(a) {
            var b = a.apply(this, [].slice.call(arguments, 1));
            this.axis.chart.is3d() && (b = g([this.axis.swapZ({
                x: b.x,
                y: b.y,
                z: 0
            })], this.axis.chart, !1)[0]);
            return b
        });
        a.wrap(h.prototype, "getTitlePosition", function(a) {
            var b = this.chart.is3d(),
                c, e;
            b && (e = this.axisTitleMargin, this.axisTitleMargin =
                0);
            c = a.apply(this, [].slice.call(arguments, 1));
            b && (c = g([this.swapZ({
                x: c.x,
                y: c.y,
                z: 0
            })], this.chart, !1)[0], c[this.horiz ? "y" : "x"] += (this.horiz ? 1 : -1) * (this.opposite ? -1 : 1) * e, this.axisTitleMargin = e);
            return c
        });
        d(h.prototype, "drawCrosshair", function(a) {
            var b = arguments;
            this.chart.is3d() && b[2] && (b[2] = {
                plotX: b[2].plotXold || b[2].plotX,
                plotY: b[2].plotYold || b[2].plotY
            });
            a.apply(this, [].slice.call(b, 1))
        });
        h.prototype.swapZ = function(a, b) {
            if (this.isZAxis) {
                b = b ? 0 : this.chart.plotLeft;
                var c = this.chart;
                return {
                    x: b + (c.yAxis[0].opposite ?
                        a.z : c.xAxis[0].width - a.z),
                    y: a.y,
                    z: a.x - b
                }
            }
            return a
        };
        r = a.ZAxis = function() {
            this.isZAxis = !0;
            this.init.apply(this, arguments)
        };
        w(r.prototype, h.prototype);
        w(r.prototype, {
            setOptions: function(a) {
                a = q({
                    offset: 0,
                    lineWidth: 0
                }, a);
                h.prototype.setOptions.call(this, a);
                this.coll = "zAxis"
            },
            setAxisSize: function() {
                h.prototype.setAxisSize.call(this);
                this.width = this.len = this.chart.options.chart.options3d.depth;
                this.right = this.chart.chartWidth - this.width - this.left
            },
            getSeriesExtremes: function() {
                var a = this,
                    b = a.chart;
                a.hasVisibleSeries = !1;
                a.dataMin = a.dataMax = a.ignoreMinPadding = a.ignoreMaxPadding = null;
                a.buildStacks && a.buildStacks();
                m(a.series, function(c) {
                    if (c.visible || !b.options.chart.ignoreHiddenSeries) a.hasVisibleSeries = !0, c = c.zData, c.length && (a.dataMin = Math.min(n(a.dataMin, c[0]), Math.min.apply(null, c)), a.dataMax = Math.max(n(a.dataMax, c[0]), Math.max.apply(null, c)))
                })
            }
        });
        d(p.prototype, "getAxes", function(a) {
            var b = this,
                c = this.options,
                c = c.zAxis = f(c.zAxis || {});
            a.call(this);
            b.is3d() && (this.zAxis = [], m(c, function(a, c) {
                a.index = c;
                a.isX = !0;
                (new r(b, a)).setScale()
            }))
        })
    })(E);
    (function(a) {
        function r(a) {
            var f = a.apply(this, [].slice.call(arguments, 1));
            this.chart.is3d() && (f.stroke = this.options.edgeColor || f.fill, f["stroke-width"] = w(this.options.edgeWidth, 1));
            return f
        }

        function h(a) {
            if (this.chart.is3d()) {
                var f = this.chart.options.plotOptions.column.grouping;
                void 0 === f || f || void 0 === this.group.zIndex || this.zIndexSet || (this.group.attr({
                    zIndex: 10 * this.group.zIndex
                }), this.zIndexSet = !0)
            }
            a.apply(this, [].slice.call(arguments, 1))
        }
        var p = a.each,
            m = a.perspective,
            w = a.pick,
            q = a.Series,
            g = a.seriesTypes,
            n = a.svg;
        a = a.wrap;
        a(g.column.prototype, "translate", function(a) {
            a.apply(this, [].slice.call(arguments, 1));
            if (this.chart.is3d()) {
                var f = this.chart,
                    d = this.options,
                    e = d.depth || 25,
                    b = (d.stacking ? d.stack || 0 : this._i) * (e + (d.groupZPadding || 1));
                !1 !== d.grouping && (b = 0);
                b += d.groupZPadding || 1;
                p(this.data, function(a) {
                    if (null !== a.y) {
                        var c = a.shapeArgs,
                            d = a.tooltipPos;
                        a.shapeType = "cuboid";
                        c.z = b;
                        c.depth = e;
                        c.insidePlotArea = !0;
                        d = m([{
                            x: d[0],
                            y: d[1],
                            z: b
                        }], f, !0)[0];
                        a.tooltipPos = [d.x, d.y]
                    }
                });
                this.z = b
            }
        });
        a(g.column.prototype, "animate", function(a) {
            if (this.chart.is3d()) {
                var f = arguments[1],
                    d = this.yAxis,
                    e = this,
                    b = this.yAxis.reversed;
                n && (f ? p(e.data, function(a) {
                    null !== a.y && (a.height = a.shapeArgs.height, a.shapey = a.shapeArgs.y, a.shapeArgs.height = 1, b || (a.shapeArgs.y = a.stackY ? a.plotY + d.translate(a.stackY) : a.plotY + (a.negative ? -a.height : a.height)))
                }) : (p(e.data, function(a) {
                        null !== a.y && (a.shapeArgs.height = a.height, a.shapeArgs.y = a.shapey, a.graphic && a.graphic.animate(a.shapeArgs, e.options.animation))
                    }),
                    this.drawDataLabels(), e.animate = null))
            } else a.apply(this, [].slice.call(arguments, 1))
        });
        a(g.column.prototype, "init", function(a) {
            a.apply(this, [].slice.call(arguments, 1));
            if (this.chart.is3d()) {
                var f = this.options,
                    d = f.grouping,
                    e = f.stacking,
                    b = w(this.yAxis.options.reversedStacks, !0),
                    c = 0;
                if (void 0 === d || d) {
                    d = this.chart.retrieveStacks(e);
                    c = f.stack || 0;
                    for (e = 0; e < d[c].series.length && d[c].series[e] !== this; e++);
                    c = 10 * (d.totalStacks - d[c].position) + (b ? e : -e);
                    this.xAxis.reversed || (c = 10 * d.totalStacks - c)
                }
                f.zIndex = c
            }
        });
        a(g.column.prototype, "pointAttribs", r);
        g.columnrange && a(g.columnrange.prototype, "pointAttribs", r);
        a(q.prototype, "alignDataLabel", function(a) {
            if (this.chart.is3d() && ("column" === this.type || "columnrange" === this.type)) {
                var f = arguments[4],
                    d = {
                        x: f.x,
                        y: f.y,
                        z: this.z
                    },
                    d = m([d], this.chart, !0)[0];
                f.x = d.x;
                f.y = d.y
            }
            a.apply(this, [].slice.call(arguments, 1))
        });
        g.columnrange && a(g.columnrange.prototype, "drawPoints", h);
        a(g.column.prototype, "drawPoints", h)
    })(E);
    (function(a) {
        var r = a.deg2rad,
            h = a.each,
            p = a.pick,
            m = a.seriesTypes,
            w = a.svg;
        a = a.wrap;
        a(m.pie.prototype, "translate", function(a) {
            a.apply(this, [].slice.call(arguments, 1));
            if (this.chart.is3d()) {
                var g = this,
                    n = g.options,
                    f = n.depth || 0,
                    q = g.chart.options.chart.options3d,
                    d = q.alpha,
                    e = q.beta,
                    b = n.stacking ? (n.stack || 0) * f : g._i * f,
                    b = b + f / 2;
                !1 !== n.grouping && (b = 0);
                h(g.data, function(a) {
                    var c = a.shapeArgs;
                    a.shapeType = "arc3d";
                    c.z = b;
                    c.depth = .75 * f;
                    c.alpha = d;
                    c.beta = e;
                    c.center = g.center;
                    c = (c.end + c.start) / 2;
                    a.slicedTranslation = {
                        translateX: Math.round(Math.cos(c) * n.slicedOffset * Math.cos(d * r)),
                        translateY: Math.round(Math.sin(c) *
                            n.slicedOffset * Math.cos(d * r))
                    }
                })
            }
        });
        a(m.pie.prototype.pointClass.prototype, "haloPath", function(a) {
            var g = arguments;
            return this.series.chart.is3d() ? [] : a.call(this, g[1])
        });
        a(m.pie.prototype, "pointAttribs", function(a, g, h) {
            a = a.call(this, g, h);
            h = this.options;
            this.chart.is3d() && (a.stroke = h.edgeColor || g.color || this.color, a["stroke-width"] = p(h.edgeWidth, 1));
            return a
        });
        a(m.pie.prototype, "drawPoints", function(a) {
            a.apply(this, [].slice.call(arguments, 1));
            this.chart.is3d() && h(this.points, function(a) {
                var g = a.graphic;
                if (g) g[a.y && a.visible ? "show" : "hide"]()
            })
        });
        a(m.pie.prototype, "drawDataLabels", function(a) {
            if (this.chart.is3d()) {
                var g = this.chart.options.chart.options3d;
                h(this.data, function(a) {
                    var f = a.shapeArgs,
                        l = f.r,
                        d = (f.start + f.end) / 2,
                        e = a.labelPos,
                        b = -l * (1 - Math.cos((f.alpha || g.alpha) * r)) * Math.sin(d),
                        c = l * (Math.cos((f.beta || g.beta) * r) - 1) * Math.cos(d);
                    h([0, 2, 4], function(a) {
                        e[a] += c;
                        e[a + 1] += b
                    })
                })
            }
            a.apply(this, [].slice.call(arguments, 1))
        });
        a(m.pie.prototype, "addPoint", function(a) {
            a.apply(this, [].slice.call(arguments, 1));
            this.chart.is3d() && this.update(this.userOptions, !0)
        });
        a(m.pie.prototype, "animate", function(a) {
            if (this.chart.is3d()) {
                var g = arguments[1],
                    h = this.options.animation,
                    f = this.center,
                    l = this.group,
                    d = this.markerGroup;
                w && (!0 === h && (h = {}), g ? (l.oldtranslateX = l.translateX, l.oldtranslateY = l.translateY, g = {
                    translateX: f[0],
                    translateY: f[1],
                    scaleX: .001,
                    scaleY: .001
                }, l.attr(g), d && (d.attrSetters = l.attrSetters, d.attr(g))) : (g = {
                    translateX: l.oldtranslateX,
                    translateY: l.oldtranslateY,
                    scaleX: 1,
                    scaleY: 1
                }, l.animate(g, h), d && d.animate(g,
                    h), this.animate = null))
            } else a.apply(this, [].slice.call(arguments, 1))
        })
    })(E);
    (function(a) {
        var r = a.perspective,
            h = a.pick,
            p = a.seriesTypes,
            m = a.wrap;
        m(p.scatter.prototype, "translate", function(a) {
            a.apply(this, [].slice.call(arguments, 1));
            if (this.chart.is3d()) {
                var m = this.chart,
                    g = h(this.zAxis, m.options.zAxis[0]),
                    n = [],
                    f, l, d;
                for (d = 0; d < this.data.length; d++) f = this.data[d], l = g.isLog && g.val2lin ? g.val2lin(f.z) : f.z, f.plotZ = g.translate(l), f.isInside = f.isInside ? l >= g.min && l <= g.max : !1, n.push({
                    x: f.plotX,
                    y: f.plotY,
                    z: f.plotZ
                });
                m = r(n, m, !0);
                for (d = 0; d < this.data.length; d++) f = this.data[d], g = m[d], f.plotXold = f.plotX, f.plotYold = f.plotY, f.plotZold = f.plotZ, f.plotX = g.x, f.plotY = g.y, f.plotZ = g.z
            }
        });
        m(p.scatter.prototype, "init", function(a, h, g) {
            h.is3d() && (this.axisTypes = ["xAxis", "yAxis", "zAxis"], this.pointArrayMap = ["x", "y", "z"], this.parallelArrays = ["x", "y", "z"], this.directTouch = !0);
            a = a.apply(this, [h, g]);
            this.chart.is3d() && (this.tooltipOptions.pointFormat = this.userOptions.tooltip ? this.userOptions.tooltip.pointFormat || "x: \x3cb\x3e{point.x}\x3c/b\x3e\x3cbr/\x3ey: \x3cb\x3e{point.y}\x3c/b\x3e\x3cbr/\x3ez: \x3cb\x3e{point.z}\x3c/b\x3e\x3cbr/\x3e" :
                "x: \x3cb\x3e{point.x}\x3c/b\x3e\x3cbr/\x3ey: \x3cb\x3e{point.y}\x3c/b\x3e\x3cbr/\x3ez: \x3cb\x3e{point.z}\x3c/b\x3e\x3cbr/\x3e");
            return a
        });
        m(p.scatter.prototype, "pointAttribs", function(h, m) {
            var g = h.apply(this, [].slice.call(arguments, 1));
            this.chart.is3d() && m && (g.zIndex = a.pointCameraDistance(m, this.chart));
            return g
        })
    })(E);
    (function(a) {
        var r = a.Axis,
            h = a.SVGRenderer,
            p = a.VMLRenderer;
        p && (a.setOptions({
                animate: !1
            }), p.prototype.cuboid = h.prototype.cuboid, p.prototype.cuboidPath = h.prototype.cuboidPath, p.prototype.toLinePath =
            h.prototype.toLinePath, p.prototype.createElement3D = h.prototype.createElement3D, p.prototype.arc3d = function(a) {
                a = h.prototype.arc3d.call(this, a);
                a.css({
                    zIndex: a.zIndex
                });
                return a
            }, a.VMLRenderer.prototype.arc3dPath = a.SVGRenderer.prototype.arc3dPath, a.wrap(r.prototype, "render", function(a) {
                a.apply(this, [].slice.call(arguments, 1));
                this.sideFrame && (this.sideFrame.css({
                    zIndex: 0
                }), this.sideFrame.front.attr({
                    fill: this.sideFrame.color
                }));
                this.bottomFrame && (this.bottomFrame.css({
                    zIndex: 1
                }), this.bottomFrame.front.attr({
                    fill: this.bottomFrame.color
                }));
                this.backFrame && (this.backFrame.css({
                    zIndex: 0
                }), this.backFrame.front.attr({
                    fill: this.backFrame.color
                }))
            }))
    })(E)
});