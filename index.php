<?php include 'templates/header.php'; ?>

<div class="container">
    <h1>Cek Bintang</h1>
    <form action="submit.php" method="POST">
        <label for="guestName">Nama Kamu:</label><br>
        <input type="text" id="guestName" name="guestName" required><br><br>

        <label for="birthDate">Tanggal Lahir:</label><br>
        <input type="date" id="birthDate" name="birthDate" required><br><br>

        <button type="submit">Submit</button>
    </form>
</div>

<?php include 'templates/footer.php'; ?>