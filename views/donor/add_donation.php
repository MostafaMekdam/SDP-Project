<h1>Add Donation</h1>
<form method="POST" action="index.php?controller=donor&action=addDonation">
    <input type="hidden" name="event_id" value="<?= htmlspecialchars($_GET['eventId'] ?? '') ?>">

    <label>Type:</label>
    <select name="type" required onchange="togglePaymentFields(this.value)">
        <option value="">Select Type</option>
        <option value="money">Money</option>
        <option value="blood">Blood</option>
    </select><br>

    <!-- Payment Fields -->
    <div id="payment-fields" style="display: none;">
        <label>Payment Method:</label>
        <select name="payment_method" onchange="toggleSpecificPaymentFields(this.value)" required>
            <option value="">Select Method</option>
            <option value="ewallet">EWallet</option>
            <option value="bankcard">Bank Card</option>
        </select><br>

        <!-- EWallet Fields -->
        <div id="ewallet-fields" style="display: none;">
            <label>Email:</label>
            <input type="email" name="email"><br>
            <label>Password:</label>
            <input type="password" name="password"><br>
        </div>

        <!-- Bank Card Fields -->
        <div id="bankcard-fields" style="display: none;">
            <label>Card Number:</label>
            <input type="text" name="card_number"><br>
            <label>CVV:</label>
            <input type="text" name="cvv"><br>
            <label>Expiry Date:</label>
            <input type="date" name="expiry_date"><br>
        </div>

        <label>Amount:</label>
        <input type="number" name="amount" step="0.01"><br>
    </div>

    <button type="submit">Donate</button>
</form>

<script>
function togglePaymentFields(type) {
    document.getElementById('payment-fields').style.display = type === 'money' ? 'block' : 'none';
}
function toggleSpecificPaymentFields(method) {
    document.getElementById('ewallet-fields').style.display = method === 'ewallet' ? 'block' : 'none';
    document.getElementById('bankcard-fields').style.display = method === 'bankcard' ? 'block' : 'none';
}
</script>
