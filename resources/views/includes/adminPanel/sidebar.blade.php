<script>
    // функция отображение событий
    function updateEvents() {
        $.ajax({
            type: 'GET',
            url: 'data/events',
            dataType: 'json',
            success: function(response) {
                $('.all-events').empty();
                $('.my-events').empty();
                response.allEvents.forEach(event => {
                    console.log(event);
                    let events = $('<button>', {
                        type: 'submit',
                        text: `Event ${event.id}`,
                        'data-text': event.text,
                        'data-event_id': event.id,
                        'data-title': event.title,
                        'data-created_at': event.created_at,
                        'data-event_creator_id': event.creator_id,
                        class: 'btn btn-block border border-dark text-primary event-button',

                    });
                    event.participants.forEach(participant => {
                        let participantNameKey = `data-event_participant_name`;
                        let participantFirstnameKey = `data-event_participant_lastname`;
                        events.attr(participantNameKey, participant.name);
                        events.attr(participantFirstnameKey, participant.last_name);
                    });

                    $('.all-events').append(events);
                });
                // отображение данных своих событий
                response.myEvents.forEach(event => {
                    let myEvents = $('<button>', {
                        type: 'button',
                        id: `my_event`,
                        'data-my_event': event.id,
                        text: `Event ${event.id}`,
                        class: 'btn btn-block border border-dark text-primary',
                    });
                    $('.my-events').append(myEvents);
                });

            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    $(document).ready(function() {
        updateEvents();
        setInterval(function() {
            updateEvents();
        }, 30000);
    });
</script>
