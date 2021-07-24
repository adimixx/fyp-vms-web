Vue.filter("currency", function(val) {
    const format = val / 100;
    return format.toFixed(2);
});

Vue.filter("currencyWithRM", function(val) {
    const format = val / 100;
    if (format == 0) return "-";

    return "RM " + format.toFixed(2);
});

Vue.filter("currencyToDB", function(val) {
    const format = val * 100;
    return format;
});

Vue.filter("dateOnly", function(val) {
    return moment(val).format("L");
});

Vue.filter("uppercase", function(val) {
    return val.toUpperCase();
});

Vue.filter("nullString", function(val) {
    if (val == null || val == "") {
        return '-';
    }
    return val;
});
