var calendar = new FullCalendar.Calendar(document.getElementById("calendar"), {
    contentHeight: 'auto',
    initialView: "dayGridMonth",
    headerToolbar: {
        start: 'title',
        center: '',
        end: 'today prev,next'
    },
    selectable: true,
    editable: true,
    eventDurationEditable: true,
    eventResizableFromStart: true,
    slotEventOverlap: false,
    initialDate: '2020-12-01',
    dateClick: function (info) {
        console.log('Date clicked:', info.dateStr);

        if (typeof Swal === 'undefined') {
            console.error('SweetAlert2 is not loaded');
            return;
        }

        Swal.fire({
            title: '<h4 class="text-dark font-weight-bolder mt-3">Create New Event</h4>',
            html: `
                <div class="px-3">
                    <div class="mb-4">
                        <label class="form-label text-secondary">Event Title</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="fas fa-calendar-alt text-primary"></i>
                            </span>
                            <input type="text" id="eventTitle" required
                                class="form-control form-control-lg ps-2 border-start-0"
                                placeholder="Enter event title">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-4">
                            <label class="form-label text-secondary">Start Date & Time</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="fas fa-hourglass-start text-primary"></i>
                                </span>
                                <input type="datetime-local" id="startDate"
                                    class="form-control form-control-lg ps-2 border-start-0"
                                    value="${info.dateStr}T00:00">
                            </div>
                        </div>

                        <div class="col-12 col-md-6 mb-4">
                            <label class="form-label text-secondary">End Date & Time</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="fas fa-hourglass-end text-primary"></i>
                                </span>
                                <input type="datetime-local" id="endDate"
                                    class="form-control form-control-lg ps-2 border-start-0"
                                    value="${info.dateStr}T23:59">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary">Event Color</label>
                        <div class="d-flex justify-content-around p-2">
                            <div class="form-check">
                                <input class="form-check-input bg-gradient-primary" type="radio" name="eventColor" value="bg-gradient-primary" checked>
                                <label class="form-check-label">Primary</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input bg-gradient-info" type="radio" name="eventColor" value="bg-gradient-info">
                                <label class="form-check-label">Info</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input bg-gradient-success" type="radio" name="eventColor" value="bg-gradient-success">
                                <label class="form-check-label">Success</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input bg-gradient-warning" type="radio" name="eventColor" value="bg-gradient-warning">
                                <label class="form-check-label">Warning</label>
                            </div>
                        </div>
                    </div>
                </div>
            `,
            focusConfirm: false,
            customClass: {
                container: 'custom-container',
                popup: 'card shadow-lg',
                confirmButton: 'btn bg-gradient-primary btn-lg me-3',
                cancelButton: 'btn btn-outline-secondary btn-lg',
                closeButton: 'btn-close'
            },
            showCancelButton: true,
            confirmButtonText: 'Create Event',
            cancelButtonText: 'Cancel',
            buttonsStyling: false,
            width: '42em',
            preConfirm: () => {
                const title = document.getElementById('eventTitle').value;
                if (!title) {
                    Swal.showValidationMessage('Event title is required');
                    return false;
                }

                const startDate = document.getElementById('startDate').value;
                const endDate = document.getElementById('endDate').value;
                if (new Date(endDate) < new Date(startDate)) {
                    Swal.showValidationMessage('End date cannot be before start date');
                    return false;
                }

                const eventColor = document.querySelector('input[name="eventColor"]:checked').value;
                return {
                    title: title,
                    start: startDate,
                    end: endDate,
                    className: eventColor
                }
            }
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                try {
                    calendar.addEvent({
                        title: result.value.title,
                        start: result.value.start,
                        end: result.value.end,
                        className: result.value.className,
                        editable: true,
                        durationEditable: true,
                        resourceEditable: true,
                        startEditable: true,
                        display: 'block',
                        allDay: false
                    });
                    Swal.fire({
                        icon: 'success',
                        title: 'Event Created!',
                        text: 'Your event has been successfully added to the calendar.',
                        customClass: {
                            confirmButton: 'btn bg-gradient-primary btn-lg'
                        },
                        buttonsStyling: false
                    });
                } catch (error) {
                    console.error('Error adding event:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to create event. Please try again.',
                        customClass: {
                            confirmButton: 'btn bg-gradient-primary btn-lg'
                        },
                        buttonsStyling: false
                    });
                }
            }
        });
    },
    select: function (info) {
        // Subtract one day from endStr
        let endDate = new Date(info.endStr);
        endDate.setDate(endDate.getDate() - 1);
        let adjustedEndStr = endDate.toISOString().split('T')[0];

        console.log('Selection made:', info.startStr, 'to', adjustedEndStr);


        if (typeof Swal === 'undefined') {
            console.error('SweetAlert2 is not loaded');
            return;
        }

        Swal.fire({
            title: '<h4 class="text-dark font-weight-bolder mt-3">Create Event for Multiple Days</h4>',
            html: `
                <div class="px-3">
                    <div class="mb-4">
                        <label class="form-label text-secondary">Event Title</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="fas fa-calendar-alt text-primary"></i>
                            </span>
                            <input type="text" id="eventTitle" required
                                class="form-control form-control-lg ps-2 border-start-0"
                                placeholder="Enter event title">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-4">
                            <label class="form-label text-secondary">Start Date & Time</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="fas fa-hourglass-start text-primary"></i>
                                </span>
                                <input type="datetime-local" id="startDate"
                                    class="form-control form-control-lg ps-2 border-start-0"
                                    value="${info.startStr}T00:00">
                            </div>
                        </div>

                        <div class="col-12 col-md-6 mb-4">
                            <label class="form-label text-secondary">End Date & Time</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="fas fa-hourglass-end text-primary"></i>
                                </span>
                                <input type="datetime-local" id="endDate"
                                    class="form-control form-control-lg ps-2 border-start-0"
                                    value="${adjustedEndStr}T23:59">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary">Event Color</label>
                        <div class="d-flex justify-content-around p-2">
                            <div class="form-check">
                                <input class="form-check-input bg-gradient-primary" type="radio" name="eventColor" value="bg-gradient-primary" checked>
                                <label class="form-check-label">Primary</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input bg-gradient-info" type="radio" name="eventColor" value="bg-gradient-info">
                                <label class="form-check-label">Info</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input bg-gradient-success" type="radio" name="eventColor" value="bg-gradient-success">
                                <label class="form-check-label">Success</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input bg-gradient-warning" type="radio" name="eventColor" value="bg-gradient-warning">
                                <label class="form-check-label">Warning</label>
                            </div>
                        </div>
                    </div>
                </div>
            `,
            focusConfirm: false,
            customClass: {
                container: 'custom-container',
                popup: 'card shadow-lg',
                confirmButton: 'btn bg-gradient-primary btn-lg me-3',
                cancelButton: 'btn btn-outline-secondary btn-lg',
                closeButton: 'btn-close'
            },
            showCancelButton: true,
            confirmButtonText: 'Create Event',
            cancelButtonText: 'Cancel',
            buttonsStyling: false,
            width: '42em',
            preConfirm: () => {
                const title = document.getElementById('eventTitle').value;
                if (!title) {
                    Swal.showValidationMessage('Event title is required');
                    return false;
                }

                const startDate = document.getElementById('startDate').value;
                const endDate = document.getElementById('endDate').value;
                if (new Date(endDate) < new Date(startDate)) {
                    Swal.showValidationMessage('End date cannot be before start date');
                    return false;
                }

                const eventColor = document.querySelector('input[name="eventColor"]:checked').value;
                return {
                    title: title,
                    start: startDate,
                    end: endDate,
                    className: eventColor
                }
            }
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                try {
                    calendar.addEvent({
                        title: result.value.title,
                        start: result.value.start,
                        end: result.value.end,
                        className: result.value.className,
                        editable: true,
                        durationEditable: true,
                        resourceEditable: true,
                        startEditable: true,
                        display: 'block',
                        allDay: false
                    });
                    calendar.unselect(); // Clear the selection
                    Swal.fire({
                        icon: 'success',
                        title: 'Event Created!',
                        text: 'Your event has been successfully added to the calendar.',
                        customClass: {
                            confirmButton: 'btn bg-gradient-primary btn-lg'
                        },
                        buttonsStyling: false
                    });
                } catch (error) {
                    console.error('Error adding event:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to create event. Please try again.',
                        customClass: {
                            confirmButton: 'btn bg-gradient-primary btn-lg'
                        },
                        buttonsStyling: false
                    });
                }
            }
        });
    },
    eventClick: function(info) {
        // Get event details
        const event = info.event;

        Swal.fire({
            title: '<h4 class="text-dark font-weight-bolder mt-3">Event Details</h4>',
            html: `
                <div class="px-3">
                    <div class="mb-4">
                        <label class="form-label text-secondary">Event Title</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="fas fa-calendar-alt text-primary"></i>
                            </span>
                            <input type="text" id="eventTitle"
                                class="form-control form-control-lg ps-2 border-start-0"
                                value="${event.title}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-4">
                            <label class="form-label text-secondary">Start Date & Time</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="fas fa-hourglass-start text-primary"></i>
                                </span>
                                <input type="datetime-local" id="startDate"
                                    class="form-control form-control-lg ps-2 border-start-0"
                                    value="${moment(event.start).format('YYYY-MM-DD')}T${moment(event.start).format('HH:mm')}">
                            </div>
                        </div>

                        <div class="col-12 col-md-6 mb-4">
                            <label class="form-label text-secondary">End Date & Time</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="fas fa-hourglass-end text-primary"></i>
                                </span>
                                <input type="datetime-local" id="endDate"
                                    class="form-control form-control-lg ps-2 border-start-0"
                                    value="${moment(event.end || event.start).format('YYYY-MM-DD')}T${moment(event.end || event.start).format('HH:mm')}">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary">Event Color</label>
                        <div class="d-flex justify-content-around p-2">
                            <div class="form-check">
                                <input class="form-check-input bg-gradient-primary" type="radio" name="eventColor" value="bg-gradient-primary" ${event.classNames.includes('bg-gradient-primary') ? 'checked' : ''}>
                                <label class="form-check-label">Primary</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input bg-gradient-info" type="radio" name="eventColor" value="bg-gradient-info" ${event.classNames.includes('bg-gradient-info') ? 'checked' : ''}>
                                <label class="form-check-label">Info</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input bg-gradient-success" type="radio" name="eventColor" value="bg-gradient-success" ${event.classNames.includes('bg-gradient-success') ? 'checked' : ''}>
                                <label class="form-check-label">Success</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input bg-gradient-warning" type="radio" name="eventColor" value="bg-gradient-warning" ${event.classNames.includes('bg-gradient-warning') ? 'checked' : ''}>
                                <label class="form-check-label">Warning</label>
                            </div>
                        </div>
                    </div>
                </div>
            `,
            focusConfirm: false,
            customClass: {
                container: 'custom-container',
                popup: 'card shadow-lg',
                confirmButton: 'btn bg-gradient-primary btn-lg me-3',
                cancelButton: 'btn btn-outline-secondary btn-lg me-3',
                denyButton: 'btn btn-outline-danger btn-lg me-3',
                closeButton: 'btn-close'
            },
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonText: 'Update',
            cancelButtonText: 'Close',
            denyButtonText: 'Delete',
            buttonsStyling: false,
            width: '42em',
            preConfirm: () => {
                const title = document.getElementById('eventTitle').value;
                if (!title) {
                    Swal.showValidationMessage('Event title is required');
                    return false;
                }

                const startDate = document.getElementById('startDate').value;
                const endDate = document.getElementById('endDate').value;
                if (new Date(endDate) < new Date(startDate)) {
                    Swal.showValidationMessage('End date cannot be before start date');
                    return false;
                }

                const eventColor = document.querySelector('input[name="eventColor"]:checked').value;
                return {
                    title: title,
                    start: startDate,
                    end: endDate,
                    className: eventColor
                }
            }
        }).then((result) => {
            if (result.isDenied) {
                // Show delete confirmation first
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    customClass: {
                        confirmButton: 'btn bg-gradient-primary me-3',
                        cancelButton: 'btn bg-gradient-danger'
                    },
                    buttonsStyling: false
                }).then((deleteResult) => {
                    if (deleteResult.isConfirmed) {
                        // Delete event
                        event.remove();
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Your event has been successfully removed.',
                            customClass: {
                                confirmButton: 'btn bg-gradient-primary'
                            },
                            buttonsStyling: false
                        });
                    }
                });
            } else if (result.isConfirmed && result.value) {
                // Update event
                event.setProp('title', result.value.title);
                event.setStart(result.value.start);
                event.setEnd(result.value.end);
                event.setProp('classNames', [result.value.className]);

                Swal.fire({
                    icon: 'success',
                    title: 'Event Updated!',
                    text: 'Your event has been successfully updated.',
                    customClass: {
                        confirmButton: 'btn bg-gradient-primary btn-lg'
                    },
                    buttonsStyling: false
                });
            }
        });
    },
    events: [{
            title: 'Call with Dave',
            start: '2020-11-18',
            end: '2020-11-18',
            className: 'bg-gradient-danger'
        },

        {
            title: 'Lunch meeting',
            start: '2020-11-21',
            end: '2020-11-22',
            className: 'bg-gradient-warning'
        },

        {
            title: 'All day conference',
            start: '2020-11-29',
            end: '2020-11-29',
            className: 'bg-gradient-success'
        },

        {
            title: 'Meeting with Mary',
            start: '2020-12-01',
            end: '2020-12-01',
            className: 'bg-gradient-info'
        },

        {
            title: 'Winter Hackaton',
            start: '2020-12-03',
            end: '2020-12-03',
            className: 'bg-gradient-danger'
        },

        {
            title: 'Digital event',
            start: '2020-12-07',
            end: '2020-12-09',
            className: 'bg-gradient-warning'
        },

        {
            title: 'Marketing event',
            start: '2020-12-10',
            end: '2020-12-10',
            className: 'bg-primary'
        },

        {
            title: 'Dinner with Family',
            start: '2020-12-19',
            end: '2020-12-19',
            className: 'bg-gradient-danger'
        },

        {
            title: 'Black Friday',
            start: '2020-12-23',
            end: '2020-12-23',
            className: 'bg-gradient-info'
        },

        {
            title: 'Cyber Week',
            start: '2020-12-02',
            end: '2020-12-02',
            className: 'bg-gradient-warning'
        },

    ],
    views: {
        month: {
            titleFormat: {
                month: "long",
                year: "numeric"
            }
        },
        agendaWeek: {
            titleFormat: {
                month: "long",
                year: "numeric",
                day: "numeric"
            }
        },
        agendaDay: {
            titleFormat: {
                month: "short",
                year: "numeric",
                day: "numeric"
            }
        }
    },
});

calendar.render();

var ctx1 = document.getElementById("chart-line-1").getContext("2d");

var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

gradientStroke1.addColorStop(1, 'rgba(255,255,255,0.3)');
gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

new Chart(ctx1, {
    type: "line",
    data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
            label: "Visitors",
            tension: 0.5,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#fff",
            borderWidth: 2,
            backgroundColor: gradientStroke1,
            data: [50, 45, 60, 60, 80, 65, 90, 80, 100],
            maxBarThickness: 6,
            fill: true
        }],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false,
            }
        },
        interaction: {
            intersect: false,
            mode: 'index',
        },
        scales: {
            y: {
                display: false,
                ticks: {
                    display: false,
                    drawTicks: false,
                    drawOnChartArea: false,
                    drawBorder: false,
                },
                grid: {
                    display: false,
                }
            },
            x: {
                display: false,
                ticks: {
                    display: false,
                    drawTicks: false,
                    drawOnChartArea: false,
                    drawBorder: false,
                },
                grid: {
                    display: false,
                }
            }
        }
    }
});
