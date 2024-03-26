var calendar;
var Calendar = FullCalendar.Calendar;
var events = [];

$(function() {
    // Function to initialize the calendar
    function initializeCalendar() {
        if (!!scheds) {
            Object.keys(scheds).map(k => {
                var row = scheds[k];
                var backgroundColor, textColor;
                
                switch (row.title.toLowerCase()) {
                    case 'present':
                        backgroundColor = '#6E9107'; // Green color for present
                        textColor = '#FFFFFF'; // White text color
                        break;
                    case 'absent':
                        backgroundColor = '#F24141'; // Red color for absent
                        textColor = '#FFFFFF'; // White text color
                        break;
                    case 'holiday':
                        backgroundColor = '#0368A5'; // blue color for holiday
                        textColor = '#FFFFFF'; // White text color
                        break;
                    case 'leave':
                        backgroundColor = '#EB7D00'; // orange color for weekend
                        textColor = '#FFFFFF'; // white text color
                        break;
                    case 'weekend':
                        backgroundColor = '#7944AB'; // Purple color for leave
                        textColor = '#FFFFFF'; // White text color
                        break;
                    default:
                        backgroundColor = '#09aff4'; // Default color
                        textColor = '#FFFFFF'; // Default text color
                }
                
                events.push({ 
                    id: row.id, 
                    title: row.title, 
                    start: row.start_datetime, 
                    end: row.end_datetime, 
                    backgroundColor: backgroundColor, 
                    textColor: textColor ,
                    editable: false
                });
            });
        }

        calendar = new Calendar(document.getElementById('calendar'), {
            headerToolbar: {
                left: 'prev,next today',
                right: 'dayGridMonth,dayGridWeek,list',
                center: 'title',
            },
            selectable: true,
            themeSystem: 'bootstrap',
            firstDay: 1,
            //Random default events
            events: events,
            eventClick: function(info) {
                var _details = $('#event-details-modal');
                var id = info.event.id;
                if (!!scheds[id]) {
                    _details.find('#title').text(scheds[id].title + " " + scheds[id].start_datetime);
                    _details.find('#clock_in').text("Clock In : " + scheds[id].clockin);
                    _details.find('#clock_out').text("Clock Out : " + scheds[id].clockout);
                    var count = scheds[id].breakcount;
                    for (let k = 0; k < count; k++) {
                        _details.find('#break_in'+k).text("Break In : " + scheds[id]['breakin' + k]);
                        _details.find('#break_out'+k).text("Break Out : " + scheds[id]['breakout' + k]);
                    }
                    if(count==0)
                    {
                        for (let m = 0; m < 10; m++) {
                            _details.find('#break_in'+m).text("");
                            _details.find('#break_out'+m).text("");
                        }
                    }
                    if(count==1)
                    {
                        for (let n = 1; n < 10; n++) {
                            _details.find('#break_in'+n).text("");
                            _details.find('#break_out'+n).text("");
                        }
                    }
                   
                    _details.modal('show'); // Open the modal
                } else {
                    alert("Event is undefined");
                }
            },
            eventDidMount: function(info) {
                // Do Something after events mounted
            },
            editable: true
        });

        calendar.render();
    }

    // Initialize the calendar
    initializeCalendar();
});
