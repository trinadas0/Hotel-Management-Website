document.addEventListener('DOMContentLoaded', function() {
    fetchPayments();

    document.getElementById('paymentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        addPayment();
    });
});

function fetchPayments() {
    fetch('php/get_payments.php')
        .then(response => response.json())
        .then(data => {
            const paymentTableBody = document.querySelector('#paymentTable tbody');
            paymentTableBody.innerHTML = '';

            data.forEach(payment => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${payment.card_number}</td>
                    <td>${payment.card_name}</td>
                    <td>${payment.expiry_date}</td>
                    <td>
                        <button onclick="editPayment(${payment.id})">Edit</button>
                        <button onclick="deletePayment(${payment.id})">Delete</button>
                    </td>
                `;
                paymentTableBody.appendChild(row);
            });
        });
}

function addPayment() {
    const formData = new FormData(document.getElementById('paymentForm'));

    fetch('php/add_payment.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        alert(result);
        fetchPayments();
    });
}

function deletePayment(id) {
    if (confirm('Are you sure you want to delete this payment method?')) {
        fetch('php/delete_payment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id=${id}`
        })
        .then(response => response.text())
        .then(result => {
            alert(result);
            fetchPayments();
        });
    }
}

function editPayment(id) {
    const cardNumber = prompt('Enter new card number:');
    const cardName = prompt('Enter new name on card:');
    const expiryDate = prompt('Enter new expiry date (YYYY-MM):');

    fetch('php/update_payment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${id}&cardNumber=${cardNumber}&cardName=${cardName}&expiryDate=${expiryDate}`
    })
    .then(response => response.text())
    .then(result => {
        alert(result);
        fetchPayments();
    });
}
