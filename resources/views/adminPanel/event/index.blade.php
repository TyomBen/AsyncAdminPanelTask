@extends('layouts.admin')
@include('auth.modal.createEventModal')
@include('auth.modal.userInformationModal')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
@section('content')
    <div id="title-container"></div>
    <div id="text-container"></div>
    <div id="participants-conteiner"></div>
    <p class="text-lg pt-5" id="event-info">Event details will be here...</p>
    <h4 style="margin-top: 200px;">Participants</h4>
@endsection

<script>
    $(document).ready(function() {
        $(document).on("click", ".event-button", function() {
            $("#delete-event").hide();
            let eventId = $(this).data("event_id");
            let participantsName = $(this).data("event_participant_name");
            let participantsFisrtame = $(this).data("event_participant_lastname");
            let eventTitle = $(this).data("title");
            let eventText = $(this).data("text");
            let eventCreated_at = $(this).data("created_at");
            console.log(eventTitle, eventText, eventCreated_at);
            let joinButtonId = `join_${eventId}`;
            let leaveButtonId = `leave_${eventId}`;
            let participantsContainerId = `${eventId}_participants_container`;

            let currentEventParticipants = $(this).data("text");

            let joinButton = $("<button>", {
                type: "submit",
                id: joinButtonId,
                "data-event_id": eventId,
                class: "btn text-primary btn-secondary join-button mt-5",
                text: "Join The Group",
                style: "display: none; width:200px",
            });

            let leaveButton = $("<button>", {
                type: "submit",
                id: leaveButtonId,
                "data-event_id": eventId,
                class: "btn leave-button btn-secondary text-primary mt-5",
                text: "Leave The Group",
                style: "display: none; width:200px;",
            });

            let participantsContainer = $("<div>", {
                id: participantsContainerId,
                class: "participants-container",
            });

            $(".join-button, .leave-button, .participants-container").remove();

            $("#event-buttons").append(joinButton);
            $("#event-buttons").append(leaveButton);
            $("#user-info").append(participantsContainer);

            const eventDetail = [`Event${eventId}`, eventTitle, eventText, eventCreated_at];

            $("#event-info").html(eventDetail.join("<br>"));

            //получаем информацию об участниках ивента
            function updateParticipants() {
                $.ajax({
                    type: "POST",
                    url: `send/eventId/${eventId}`,
                    data: {
                        event_id: eventId,
                    },
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function(response) {
                        if (response.isParticipant === true) {
                            $(`#${joinButtonId}`).hide();
                            $(`#${leaveButtonId}`).show();
                        } else {
                            $(`#${leaveButtonId}`).hide();
                            $(`#${joinButtonId}`).show();
                        }

                        let participantsContainer = $(`#${participantsContainerId}`);
                        participantsContainer.empty();

                        response.participants.participants.forEach((participant, index) => {
                            if (participant !== null) {
                                let participantId =
                                    `${eventId}_participant_${index}`;
                                let participantLink = $("<a>", {
                                    id: participantId,
                                    class: "text-primary participant-link d-block text-lg detail-user-info",
                                    text: `${participant.name} ${participant.last_name}`,
                                    "data-participant-info": JSON.stringify(
                                        participant),
                                });

                                participantsContainer.append(participantLink);
                            }
                        });

                        if (participantsContainer.is(":empty")) {
                            let noParticipantsLink = $("<a>", {
                                class: "text-primary participant-link d-block text-lg detail-user-info",
                                text: "No Participants...",
                            });

                            participantsContainer.append(noParticipantsLink);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    },
                });
            }
            $(document).ready(function() {
                updateParticipants();
                setInterval(() => {
                    updateParticipants();
                }, 3000);
            });

            $(document).on("click", ".participant-link", function() {
                let participantInfo = $(this).data("participant-info");
                showUserInfo(participantInfo.name, participantInfo.last_name, participantInfo
                    .email);
            });
        });
    });

    $(document)
        .off("click", ".join-button")
        .on("click", ".join-button", function() {
            let eventId = $(this).data("event_id");
            sendDataToController(eventId, "join");
            $(".join-button").hide();
        });

    $(document)
        .off("click", ".leave-button")
        .on("click", ".leave-button", function() {
            let eventId = $(this).data("event_id");
            sendDataToController(eventId, "leave");
            $(".leave-button").hide();
        });

    // присоединение к группе
    function sendDataToController(eventId, action) {
        $.ajax({
            type: "POST",
            url: `take/part/${eventId}`,
            data: {
                eventId: eventId,
                action: action,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function(response) {},
            error: function(error) {
                console.log(error);
            },
        });
    }
</script>

<script>
    $(document).ready(function() {
        // Открытие модального окна
        $("#open-modal").on("click", function() {
            showEventModal();
        });

        // Удаление данных
        $(document).on("click", "#my_event", function() {
            let myEventId = $(this).data("my_event");
            $("#delete-event").text(`Delete Event -${myEventId}`).show();
            if (myEventId) {
                $("#delete-event")
                    .off("click")
                    .on("click", function() {
                        $.ajax({
                            type: "DELETE",
                            url: `delete/Event/id/${myEventId}`,
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                    "content"),
                            },
                            success: function() {
                                $("#delete-event").hide();
                            },
                            error: function(error) {
                                console.log(error);
                            },
                        });
                    });
            }
        });

        // Создание ивента
        $("#create-event").on("click", function() {
            let title = $("#title").val();
            let text = $("#text").val();
            if (title !== "" && text !== "") {
                $.ajax({
                    type: "POST",
                    url: `create/event`,
                    data: {
                        title,
                        text,
                    },
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function(response) {
                        $("#event-modal").modal("hide");
                        $("#title").val("");
                        $("#text").val("");
                    },
                    error: function(error) {
                        console.log(error);
                    },
                });
            }
        });
    });
</script>
