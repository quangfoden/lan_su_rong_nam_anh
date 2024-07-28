const setcookie = {
    set(name, value, options) {
        options = options || {};
        var expires = options.expires;
        if (typeof expires === 'number' && expires) {
            var expirationDate = new Date();
            expirationDate.setTime(expirationDate.getTime() + expires * 24 * 60 * 60 * 1000);
            expires = options.expires = expirationDate;
        }
        document.cookie = [
            encodeURIComponent(name) + '=' + encodeURIComponent(value),
            expires ? 'expires=' + expires.toUTCString() : '',
            options.path ? 'path=' + options.path : '',
            options.domain ? 'domain=' + options.domain : '',
            options.secure ? 'secure' : ''
        ].filter(Boolean).join('; ');
    }
};
export default { setcookie }