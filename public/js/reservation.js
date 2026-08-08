document.addEventListener("DOMContentLoaded", () => {

    flatpickr("#rendez_vous_dateHeure", {

    locale: "fr",

    enableTime: true,

    time_24hr: true,

    minDate: "today",

    minuteIncrement: 30,

    dateFormat: "d/m/Y H:i",

    minTime: "09:00",

    maxTime: "19:00",

    disable: [
    function(date) {
        return date.getDay() === 0;
    }
],

});

});