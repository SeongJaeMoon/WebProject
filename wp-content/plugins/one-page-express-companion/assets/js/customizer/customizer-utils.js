(function ($) {
    CP_Customizer.addModule(function (CP_Customizer) {
        CP_Customizer.utils = CP_Customizer.utils || {};
        CP_Customizer.utils.phpTrim = function (str, charlist) {

            var whitespace = [
                ' ',
                '\n',
                '\r',
                '\t',
                '\f',
                '\x0b',
                '\xa0',
                '\u2000',
                '\u2001',
                '\u2002',
                '\u2003',
                '\u2004',
                '\u2005',
                '\u2006',
                '\u2007',
                '\u2008',
                '\u2009',
                '\u200a',
                '\u200b',
                '\u2028',
                '\u2029',
                '\u3000'
            ].join('');

            var l = 0;
            var i = 0;
            str += '';

            if (charlist) {
                whitespace = (charlist + '').replace(/([[\]().?/*{}+$^:])/g, '$1')
            }
            l = str.length
            for (i = 0; i < l; i++) {
                if (whitespace.indexOf(str.charAt(i)) === -1) {
                    str = str.substring(i)
                    break
                }
            }
            l = str.length
            for (i = l - 1; i >= 0; i--) {
                if (whitespace.indexOf(str.charAt(i)) === -1) {
                    str = str.substring(0, i + 1)
                    break
                }
            }
            return whitespace.indexOf(str.charAt(0)) === -1 ? str : ''
        };

        CP_Customizer.utils.normalizeBackgroundImageValue = function (value) {
            value = value.replace(/url\((.*)\)/, "$1");
            return CP_Customizer.utils.phpTrim(value, "\"'");
        };


        CP_Customizer.utils.htmlDecode = function (value) {
            return $('<div/>').html(value).text();
        };

        CP_Customizer.utils.htmlEscape = function (str) {
            return str
                .replace(/&/g, '&amp;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;');
        };


        var htmlEntityMap = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;',
            '/': '&#x2F;',
            '`': '&#x60;',
            '=': '&#x3D;'
        };

        CP_Customizer.utils.htmlUnescape = function (str) {

            for (var item in htmlEntityMap) {
                var regExp = new RegExp(htmlEntityMap[item], 'g');
                str = str.replace(regExp, item);
            }

            return str;
        };


        CP_Customizer.utils.setToPath = function (schema, path, value) {

            if (!schema) {
                return schema;
            }

            var pList = path.split('.');
            var len = pList.length;

            if (len > 1) {
                var first = pList.shift();
                var remainingPath = pList.join('.');
                schema[first] = CP_Customizer.utils.setToPath(schema[first], remainingPath, value);
            } else {
                schema[path] = value;
            }

            return schema;
        };

        CP_Customizer.utils.normalizeShortcodeString = function (shortcode) {
            shortcode = CP_Customizer.utils.htmlDecode(shortcode);

            return '[' + CP_Customizer.utils.phpTrim(shortcode) + ']';
        };

        CP_Customizer.utils.getSpectrumColorFormated = function ($spectrumElement) {
            var value = $spectrumElement.spectrum('get');


            if (!value) {
                return value;
            }

            if (value.getAlpha() < 1) {
                return "rgba(" + value._r + "," + value._g + "," + value._b + "," + value._a + ")";
            } else {
                return value.toHexString();
            }
        };

        CP_Customizer.utils.getValue = function (component) {
            var value = undefined;

            if (component instanceof CP_Customizer.wpApi.Control) {
                value = component.setting.get();
            }

            if (component instanceof CP_Customizer.wpApi.Setting) {
                value = component.get();
            }

            if (_.isString(component)) {
                value = CP_Customizer.wpApi(component).get();
            }

            if (_.isString(value)) {

                try {
                value = decodeURI(value);

                } catch (e) {

                }

                try {
                    value = JSON.parse(value);
                } catch (e) {

                }

            }

            return value;
        };

        CP_Customizer.utils.deepClone = function (toClone) {
            return jQuery.extend(true, {}, toClone);
        };

        CP_Customizer.utils.cssValueNumber = function (value) {
            var matches = value.match(/\d+(.\d+)?/);

            if (!matches || !_.isArray(matches)) {
                return null;
            }

            return matches.shift();
        };

        CP_Customizer.utils.arrayChunk = function (bigArray, perGroup) {
            perGroup = perGroup || 5;
            var result = _.groupBy(bigArray, function (element, index) {
                return Math.floor(index / perGroup);
            });

            return _.toArray(result);
        };

        CP_Customizer.utils.normalizeClassAttr = function (classes, asSelector) {
            classes = classes.split(' ').filter(function (item) {
                return (item.trim().length > 0);
            });

            if (asSelector) {
                return (classes.length ? '.' + classes.join('.') : '');
            } else {
                return classes.join(' ');
            }
        };

        CP_Customizer.utils.getFileInfo = function (url) {
            var filename = url.substring(url.lastIndexOf("/") + 1, url.lastIndexOf("."));
            var parts = url.split("/" + filename)[0];
            var path = parts[0];
            var extension = parts.length > 1 ? parts[1].split('/')[0] : '';

            return {
                path: path,
                file: filename + (extension ? '.' + extension : extension),
                filename: filename,
                extension: extension
            }
        };

        var imageExtensions = ["tif", "tiff", "gif", "jpeg", "jpg", "jif", "jfif", "jp2", "jpx", "j2k", "j2c", "fpx", "pcd", "png", "pdf", "bmp", "ico"];
        CP_Customizer.utils.isImageFile = function (url) {
            var fileInfo = CP_Customizer.utils.getFileInfo(url);

            return (imageExtensions.indexOf(fileInfo.extension) !== -1);

        };

        // https://stackoverflow.com/a/13896633
        // TODO: make work with ?x[a]=2&x[b]=3
        CP_Customizer.utils.parseUrlQuery = function (str) {
            if (typeof str !== "string" || str.length === 0) return {};
            var s = str.split("&");
            var s_length = s.length;
            var bit, query = {}, first, second;
            for (var i = 0; i < s_length; i++) {
                bit = s[i].split("=");
                first = decodeURIComponent(bit[0]);
                if (first.length === 0) continue;
                second = decodeURIComponent(bit[1]);
                if (typeof query[first] === "undefined") query[first] = second;
                else if (query[first] instanceof Array) query[first].push(second);
                else query[first] = [query[first], second];
            }
            return query;
        };


        CP_Customizer.utils.stringifyUrlQuery = function (query) {
            var queryString = "";
            for (var key in query) {

                if (!query.hasOwnProperty(key)) {
                    continue;
                }

                var data = query[key];

                if (!_.isUndefined(data)) {
                    if (_.isString(data)) {
                        queryString += '&' + encodeURIComponent(key) + '=' + encodeURIComponent(data);
                    }

                    if (_.isArray(data)) {
                        for (var i = 0; i < data.length; i++) {
                            queryString += '&' + encodeURIComponent(key) + '[' + i + ']=' + encodeURIComponent(data[i]);
                        }
                    }

                } else {
                    queryString += '&' + encodeURIComponent(key);
                }
            }

            if (queryString.length) {
                queryString = '?' + CP_Customizer.utils.phpTrim(queryString, '&');
            }

            return queryString;
        };

        CP_Customizer.utils.parseURL = function (url) {
            var location = (( url.split('?')[0] || '').split('#')[0] || ''),
                queryString = (url.indexOf('?') !== -1) ? url.split('?').pop().split('#')[0] : '',
                query = CP_Customizer.utils.parseUrlQuery(queryString),
                hash = (url.indexOf('#') !== -1) ? url.replace(/(.*)#/, '').trim() : '';

            return {
                location: location.replace(/\/$/, ''),
                query: query,
                hash: hash.length ? '#' + hash : ''
            }

        };

        CP_Customizer.utils.removeUrlQueryStrings = function (url, strings) {
            var parsedUrl = CP_Customizer.utils.parseURL(url),
                hash = parsedUrl.hash,
                queryKeys = Object.getOwnPropertyNames(parsedUrl.query),
                query = {};

            for (var i = 0; i < queryKeys.length; i++) {
                var key = queryKeys[i];
                if (strings.indexOf(key) === -1) {
                    query[key] = parsedUrl.query[key];
                }
            }

            var queryString = CP_Customizer.utils.stringifyUrlQuery(query);

            if (!queryString.length) {
                queryString = "/";
            }

            return parsedUrl.location + queryString + hash;
        };

        CP_Customizer.utils.nodeMatchingClasses = function (node, classList, firstMatchOnly) {

            if (!$(node).length) {
                if (firstMatchOnly) {
                    return undefined;
                }
                return [];
            }

            result = Array.from($(node)[0].classList).filter(function (_class) {
                return (classList.indexOf(_class) !== -1);
            });

            if (firstMatchOnly) {
                if (result.length) {
                    result = result[0];
                } else {
                    result = undefined;
                }
            }

            return result;
        };

        CP_Customizer.utils.colorInArray = function (colorsArray, color, includeAlpha) {
            var inArray = false;
            color = tinycolor(color);

            for (var i = 0; i < colorsArray.length; i++) {

                var _color = tinycolor(colorsArray[i]);
                inArray = (color._r === _color._r) && (color._g === _color._g) && (color._b === _color._b);

                if (includeAlpha) {
                    inArray = inArray && (color._a === _color._a);
                }

                if (inArray) {
                    break;
                }
            }

            return inArray;

        }
    });
})(jQuery);
