/*
Copyright (c) 2005 JSON.org

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The Software shall be used for Good, not Evil.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

/*
    The global object JSON contains two methods.

    JSON.stringify(value) takes a JavaScript value and produces a JSON text.
    The value must not be cyclical.

    JSON.parse(text) takes a JSON text and produces a JavaScript value. It will
    return false if there is an error.
*/


    (function (s) {



        // Augment String.prototype. We do this in an immediate anonymous function to

        // avoid defining global variables.



        // m is a table of character substitutions.



        var m = {

            '\b': '\\b',

            '\t': '\\t',

            '\n': '\\n',

            '\f': '\\f',

            '\r': '\\r',

            '"' : '\\"',

            '\\': '\\\\'

        };



        s.parseJSON = function (filter) {



            // Parsing happens in three stages. In the first stage, we run the text against

            // a regular expression which looks for non-JSON characters. We are especially

            // concerned with '()' and 'new' because they can cause invocation, and '='

            // because it can cause mutation. But just to be safe, we will reject all

            // unexpected characters.



            try {

                if (/^("(\\.|[^"\\\n\r])*?"|[,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t])+?$/.

                        test(this)) {



                    // In the second stage we use the eval function to compile the text into a

                    // JavaScript structure. The '{' operator is subject to a syntactic ambiguity

                    // in JavaScript: it can begin a block or an object literal. We wrap the text

                    // in parens to eliminate the ambiguity.



                    var j = eval('(' + this + ')');



                    // In the optional third stage, we recursively walk the new structure, passing

                    // each name/value pair to a filter function for possible transformation.



                    if (typeof filter === 'function') {



                        function walk(k, v) {

                            if (v && typeof v === 'object') {

                                for (var i in v) {

                                    if (v.hasOwnProperty(i)) {

                                        v[i] = walk(i, v[i]);

                                    }

                                }

                            }

                            return filter(k, v);

                        }



                        j = walk('', j);

                    }

                    return j;

                }

            } catch (e) {



            // Fall through if the regexp test fails.



            }

            throw new SyntaxError("parseJSON");

        };



        s.toJSONString = function () {



          // If the string contains no control characters, no quote characters, and no

          // backslash characters, then we can simply slap some quotes around it.

          // Otherwise we must also replace the offending characters with safe

          // sequences.



          // add by weberliu @ 2007-4-2

          var _self = this.replace("&", "%26");



          if (/["\\\x00-\x1f]/.test(this)) {

              return '"' + _self.replace(/([\x00-\x1f\\"])/g, function(a, b) {

                  var c = m[b];

                  if (c) {

                      return c;

                  }

                  c = b.charCodeAt();

                  return '\\u00' +

                      Math.floor(c / 16).toString(16) +

                      (c % 16).toString(16);

              }) + '"';

          }

          return '"' + _self + '"';

        };

    })(String.prototype);




