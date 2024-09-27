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
  <title>New reservation client</title>
  <style>
    img {
      max-width: 100%;
      vertical-align: middle
    }
  </style>
</head>
<body style="margin: 0; width: 100%; padding: 0; -webkit-font-smoothing: antialiased; word-break: break-word">
  <div role="article" aria-roledescription="email" aria-label="New reservation client" lang="en">
    <div style="margin: 32px auto; max-width: 336px; border-radius: 8px; background-color: #fff; padding: 24px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1)">
      <h1 style="text-align: center; font-size: 24px; font-weight: 700; color: #2563eb">Confirmation de votre réservation</h1>
      <p style="margin-top: 16px; font-size: 18px; color: #374151">Bonjour {{{ $reservation->user->name }}},</p>
      <p style="margin-top: 8px; color: #4b5563">Nous avons bien reçu votre réservation pour le logement <strong>{{{
                $reservation->logement->title }}}</strong>.</p>
      <h2 style="margin-top: 16px; font-size: 18px; font-weight: 600; color: #1f2937">Détails de la réservation :</h2>
      <ul style="margin-top: 8px; list-style-position: inside; list-style-type: disc; color: #4b5563">
        <li>Date de début : <strong>{{{ \Carbon\Carbon::parse($reservation->debut_resa)->format('d/m/Y')
                    }}}</strong></li>
        <li>Date de fin : <strong>{{{ \Carbon\Carbon::parse($reservation->fin_resa)->format('d/m/Y') }}}</strong>
        </li>
        <li>Montant total : <strong>{{{ number_format($totalPrice, 2) }}} €</strong></li>
      </ul>
      <p style="margin-top: 16px; color: #4b5563;">Nous vous remercions pour votre confiance et restons à votre disposition pour
        toute question.</p>
      <p style="margin-top: 16px; color: #4b5563;">Cordialement,</p>
      <p style="font-weight: 600; color: #1f2937;">L'équipe Atypik House</p>
    </div>
  </div>
</body>
</html>