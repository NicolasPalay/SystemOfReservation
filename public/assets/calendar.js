window.onload = () => {
    let calendarEl = document.getElementById('calendar');
    let calendar = new FullCalendar.Calendar(calendarEl, {
        themeSystem: 'journal',
        initialView: 'timeGridWeek',
        timeZone: 'Europe/Paris',
        locale: 'fr',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
        },
        slotMinTime: '09:00',
        slotMaxTime: '19:00',
        dayHeaders: true,
        views: {
            timeGridWeek: {
                type: 'timeGrid',
                duration: { days: 7 },
                buttonText: 'Semaine',
                dayHeaderFormat: { weekday: 'short' },
                hiddenDays: [0, 1]
            }
        },
        businessHours: {
            daysOfWeek: [2, 3, 4, 5, 6], // Mardi à Samedi
            startTime: '09:00', // Heure de début
            endTime: '19:00' // Heure de fin
        },
        events: JSON.parse('{{ data|raw }}')
    });

    calendar.render();
};