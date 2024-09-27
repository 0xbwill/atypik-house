<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
  <meta charset="utf-8">
  <meta name="x-apple-disable-message-reformatting">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="format-detection" content="telephone=no, date=no, address=no, email=no, url=no">
  <meta name="color-scheme" content="light dark">
  <meta name="supported-color-schemes" content="light dark">
  <!--[if mso]>
  <noscript>
    <xml>
      <o:OfficeDocumentSettings xmlns:o="urn:schemas-microsoft-com:office:office">
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
  </noscript>
  <style>
    td,th,div,p,a,h1,h2,h3,h4,h5,h6 {font-family: "Segoe UI", sans-serif; mso-line-height-rule: exactly;}
  </style>
  <![endif]-->
  <title>Reservation Cancellation - Client</title>
  <style>
    img {
      max-width: 100%;
      vertical-align: middle
    }
  </style>
</head>
<body style="margin: 0; width: 100%; padding: 0; -webkit-font-smoothing: antialiased; word-break: break-word">
  <div role="article" aria-roledescription="email" aria-label="Reservation Cancellation - Client" lang="en">
    <h1>Annulation de votre réservation</h1>
    <p>Bonjour {{{ $reservation->user->name }}},</p>
    <p>Nous vous confirmons que votre réservation pour le logement <strong>{{{ $reservation->logement->title
            }}}</strong> a bien été annulée.</p>
    <h2>Détails de l'annulation :</h2>
    <ul>
      <li>Logement : <strong>{{{ $reservation->logement->title }}}</strong></li>
      <li>Date de début : <strong>{{{ \Carbon\Carbon::parse($reservation->debut_resa)->format('d/m/Y') }}}</strong>
      </li>
      <li>Date de fin : <strong>{{{ \Carbon\Carbon::parse($reservation->fin_resa)->format('d/m/Y') }}}</strong></li>
      <li>Montant total : <strong>{{{ number_format($totalPrice, 2) }}} €</strong></li>
    </ul>
    <p>Vous recevrez un remboursement de <strong> {{{ number_format($totalPrice, 2) }}} €</strong> sous 7 jours ouvrés.</p>
    <p>Si vous avez des questions ou des préoccupations, n'hésitez pas à nous contacter.</p>
  </div>
</body>
</html>