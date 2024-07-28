<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Methods</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <header>
        <div class="logo">18Hotels</div>
        <nav>
            <a href="index.html">Home</a>
            <a href="rooms.html">Rooms</a>
            <a href="account_settings.html">Account Settings</a>
            <a href="contact.php">Contact Us</a>
        </nav>
    </header>
    <main>
        <div class="payment-methods">
            <h2>Payment Methods</h2>
            <div class="add-payment">
                <h3>Add Payment Method</h3>
                <form id="paymentForm">
                    <label for="cardNumber">Card Number</label>
                    <input type="text" id="cardNumber" name="cardNumber" required>

                    <label for="cardName">Name on Card</label>
                    <input type="text" id="cardName" name="cardName" required>

                    <label for="expiryDate">Expiry Date</label>
                    <input type="month" id="expiryDate" name="expiryDate" required>

                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" required>

                    <button type="submit">Add Payment Method</button>
                </form>
            </div>

            <div class="existing-payments">
                <h3>Existing Payment Methods</h3>
                <table id="paymentTable">
                    <thead>
                        <tr>
                            <th>Card Number</th>
                            <th>Name on Card</th>
                            <th>Expiry Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Payment methods will be dynamically inserted here -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchPayments();

            document.getElementById('paymentForm').addEventListener('submit', function(e) {
                e.preventDefault();
                addPayment();
            });
        });

        function fetchPayments() {
            fetch('get_payments.php')
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
                                <button onclick="deletePayment(${payment.id})">Delete</button>
                                <button onclick="editPayment(${payment.id})">Edit</button>
                            </td>
                        `;
                        paymentTableBody.appendChild(row);
                    });
                });
        }

        function addPayment() {
            const formData = new FormData(document.getElementById('paymentForm'));

            fetch('add_payment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                fetchPayments();
            });
        }

        function deletePayment(id) {
            const formData = new FormData();
            formData.append('id', id);

            fetch('delete_payment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                fetchPayments();
            });
        }

        function editPayment(id) {
            // Implement the logic to edit payment method
            // For now, just a placeholder function
            const cardNumber = prompt('Enter new card number:');
            const cardName = prompt('Enter new name on card:');
            const expiryDate = prompt('Enter new expiry date (YYYY-MM):');

            if (cardNumber && cardName && expiryDate) {
                const formData = new FormData();
                formData.append('id', id);
                formData.append('cardNumber', cardNumber);
                formData.append('cardName', cardName);
                formData.append('expiryDate', expiryDate);

                fetch('update_payment.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    fetchPayments();
                });
            }
        }
    </script>
</body>
</html>