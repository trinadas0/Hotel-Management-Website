document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById("my-form");

    async function handleSubmit(event) {
        event.preventDefault();
        var status = document.getElementById("my-form-status");
        var data = new FormData(event.target);

        fetch(event.target.action, {
            method: form.method,
            body: data,
            headers: {
                'Accept': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                status.innerHTML = "Thanks for your submission!";
                form.reset();
            } else {
                response.json().then(data => {
                    if (Object.hasOwn(data, 'errors')) {
                        status.innerHTML = data["errors"].map(error => error["message"]).join(", ");
                    } else {
                        status.innerHTML = "There was an issue while submitting your form";
                    }
                });
                
            }
        }).catch(error => {
            status.innerHTML = "There was an issue while submitting your form";
        });
    }

    form.addEventListener("submit", handleSubmit);
});


document.addEventListener('DOMContentLoaded', function() {
    var searchForm = document.getElementById("searchForm");

    async function handleSearch(event) {
        event.preventDefault();
        var formData = new FormData(searchForm);
        var params = new URLSearchParams(formData);

        fetch('search.php?' + params.toString())
            .then(response => response.text())
            .then(data => {
                document.getElementById('rooms').innerHTML = data;
                addBookingListeners();
            })
            .catch(error => console.error('Error:', error));
    }

    function addBookingListeners() {
        document.querySelectorAll('.book-btn').forEach(button => {
            button.addEventListener('click', handleBooking);
        });
    }

    async function handleBooking(event) {
        var roomId = event.target.dataset.roomId;
        var arrival = document.getElementById('arrival').value;
        var departure = document.getElementById('departure').value;

        var bookingData = new URLSearchParams({ room_id: roomId, arrival: arrival, departure: departure });

        fetch('book.php', {
            method: 'POST',
            body: bookingData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Room booked successfully!');
                document.querySelector(`.room[data-room-id="${roomId}"]`).remove();
            } else {
                alert('Failed to book room: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    searchForm.addEventListener("submit", handleSearch);
});


document.addEventListener('DOMContentLoaded', function() {
    const bookButtons = document.querySelectorAll('.book-btn');

    bookButtons.forEach(button => {
        button.addEventListener('click', function() {
            const roomId = this.getAttribute('data-room-id');
            const arrival = document.getElementById('arrival').value;
            const departure = document.getElementById('departure').value;

            fetch('book.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    room_id: roomId,
                    arrival: arrival,
                    departure: departure
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Booking successful!');
                } else {
                    alert('Booking failed: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
