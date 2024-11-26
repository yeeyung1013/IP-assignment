document.addEventListener('DOMContentLoaded', () => {
    // URL of the PHP API
    const apiUrl = 'http://localhost/villain_sf/assets/api/paymentReportApi.php';

    // Fetch the XML data from the PHP API
    fetch(apiUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text();
        })
        .then(data => {
            // Parse the XML data
            const parser = new DOMParser();
            const xmlDoc = parser.parseFromString(data, "application/xml");

            // Check for parsing errors
            const parserError = xmlDoc.querySelector('parsererror');
            if (parserError) {
                throw new Error('Error parsing XML: ' + parserError.textContent);
            }

            // Extract payment details
            const payments = xmlDoc.getElementsByTagName('payment');
            if (payments.length === 0) {
                document.getElementById('report').innerHTML = '<p>No payment records found.</p>';
                return;
            }

            // Calculate total amount and total quantity
            let totalAmount = 0;
            let totalQuantity = 0;

            for (let i = 0; i < payments.length; i++) {
                const amount = parseFloat(payments[i].getElementsByTagName('amount')[0]?.textContent || '0');
                const quantity = parseInt(payments[i].getElementsByTagName('quantity')[0]?.textContent || '0', 10);
                totalAmount += amount;
                totalQuantity += quantity;
            }

            totalAmount = totalAmount.toFixed(2);
            const currentDate = new Date().toLocaleDateString();

            // Table
            let output = `
                <div class="summary">
                    <h2>Report Summary</h2>
                    <p>Total Amount: $${totalAmount}</p>
                    <p>Total Quantity: ${totalQuantity}</p>
                    <p>Date: ${currentDate}</p>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Payment ID</th>
                            <th>Customer ID</th>
                            <th>Amount</th>
                            <th>Quantity</th>
                            <th>Payment Method</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            for (let i = 0; i < payments.length; i++) {
                const payment_id = payments[i].getElementsByTagName('paymentID')[0]?.textContent || 'N/A';
                const amount = payments[i].getElementsByTagName('amount')[0]?.textContent || 'N/A';
                const payment_method = payments[i].getElementsByTagName('paymentMethod')[0]?.textContent || 'N/A';
                const date = payments[i].getElementsByTagName('paymentDate')[0]?.textContent || 'N/A';
                const quantity = payments[i].getElementsByTagName('quantity')[0]?.textContent || 'N/A';
                const cust_id = payments[i].getElementsByTagName('custID')[0]?.textContent || 'N/A';

                output += `
                    <tr>
                        <td>${payment_id}</td>
                        <td>${cust_id}</td>
                        <td>${amount}</td>
                        <td>${quantity}</td>
                        <td>${payment_method}</td>
                        <td>${date}</td>
                    </tr>
                `;
            }

            output += `
                    </tbody>
                </table>
            `;
            document.getElementById('report').innerHTML = output;
        })
        .catch(error => {
            console.error('Error fetching payment report:', error);
            document.getElementById('report').innerHTML = '<p class="error">Failed to load payment report. ' + error.message + '</p>';
        });
});
