<!-- resources/views/end_payment.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement Finalisé</title>
</head>
<body>
    <h1>Paiement finalisé</h1>
    <p>Votre paiement a été traité. La fenêtre se fermera automatiquement dans 3 secondes.</p>
    <script>
        setTimeout(function() {
            window.close();
        }, 3000);
    </script>
</body>
</html>