/*
 * passwordStrength
 * Version: 1.2.1
 *
 * A simple plugin that can test the strength of password
 *
 * https://github.com/HenriettaSu/passwordStrength
 *
 * License: MIT
 *
 * Released on: November 22, 2016
 * Update on: September 09, 2020
 */

$.fn.passwordStrength = function (option) {
    var ele = $(this);
    settings = $.extend($.tester.defaultSettings, option);
    tester = new $.tester(ele, settings);
    return tester;
}

$.tester = function (ele, settings) {
    this.selector = ele;
    this.init(ele, settings);
}

$.extend($.tester, {
    defaultRules: {
        number: {
            rule: /\d+/,
            method: true
        },
        lowercase: {
            rule: /[a-z]+/,
            method: true
        },
        uppercase: {
            rule: /[A-Z]+/,
            method: true
        },
        speChar: {
            rule: /[#@!~_\-%^&*()\\\/]/,
            method: true
        },
        len: {
            rule: /\S{12,}/,
            method: true
        },
        same: {
            rule: /^(.)\1{2,}$/,
            method: false
        }
    },
    defaultSettings: {
        gradeClass: {
            verybad: 'bg-danger',
            bad: 'bg-warning',
            pass: 'bg-orange',
            good: 'bg-green',
            best: 'bg-success'
        }
    },
    prototype: {
        init: function (ele, settings) {
            var eleName = ele.attr('name'),
                rules = $.tester.defaultRules,
                progress = '<div class="row mb-4"><div class="col-md-4"><small style="font-size: 12px">Nivel de segurança</small></div><div class="col-md-8"><div class="password-progress"><div data-name="' + eleName + '" class="progress-bar" style="width: 0%;"></div></div><span style="font-size: 11px" id="i-message-progress"></span></div></div>',
                $progress;
            $('.pass-strong').html(progress); // or after div
            $progress = $('.progress-bar[data-name="' + eleName + '"]');
            ele.on('keyup.passwordStrength', function () {
                var $this = $(this),
                    val = $this.val(),
                    strength = 0,
                    scroe,
                    per,
                    colorClass,
                    i,
                    rule,
                    method,
                    ruleLength = 0;
                for (i in rules) {
                    rule = rules[i].rule;
                    method = rules[i].method;
                    if (val.match(rule)) {
                        strength += (method === true) ? 1 : (method === false) ? -1 : 0;
                    }
                    ruleLength += (method === true) ? 1 : 0;
                }
                scroe = 100 / ruleLength;
                per = strength * scroe;
                colorClass = (per < 30) ? settings.gradeClass.verybad : (per < 45) ? settings.gradeClass.bad : (per < 65) ? settings.gradeClass.pass : (per > 70 && per < 90) ? settings.gradeClass.good : settings.gradeClass.best;
                messageClass = (per < 30) ? 'Muito fraco' : (per < 45) ? 'Fraco' : (per < 65) ? 'Médio' : (per > 70 && per < 90) ? 'Forte' : 'Muito forte';
                $progress.css('width', per + '%');
                $progress.attr('class', 'progress-bar ' + colorClass);
                $('#i-message-progress').html(messageClass);
            });
        },
        reset: function () {
            var selector = this.selector,
                eleName = $(selector[0]).attr('name'),
                $progress = $('.progress-bar[data-name="' + eleName + '"]');
            selector.val('');
            $progress.css('width', '0');
            $progress.attr('class', 'progress-bar');
            $('#i-message-progress').html('');
        },
        destroy: function () {
            var selector = this.selector,
                eleName = $(selector[0]).attr('name'),
                $progress = $('.progress-bar[data-name="' + eleName + '"]').parent();
            $progress.remove();
            $('#i-message-progress').html('');
            selector.off('keyup.passwordStrength');
            delete this.selector;
        }
    },
    addRules: function (rules) {
        $.extend($.tester.defaultRules, rules);
    }
});
