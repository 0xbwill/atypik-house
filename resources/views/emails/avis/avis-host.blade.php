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
  <title>Avis host</title>
  <style>
    img {
      max-width: 100%;
      vertical-align: middle
    }
  </style>
</head>
<body style="margin: 0; width: 100%; padding: 0; -webkit-font-smoothing: antialiased; word-break: break-word">
  <div role="article" aria-roledescription="email" aria-label="Avis host" lang="en">
    <h1>Un nouveau commentaire a été publié</h1>
    <p>Bonjour {{{ $avis->logement->user->name }}},</p>
    <p>Un client a publié un nouveau commentaire sur votre logement <strong>{{{ $avis->logement->title }}}</strong>.</p>
    <h2>Détails du commentaire :</h2>
    <ul>
      <li>Client : <strong>{{{ $avis->user->name }}}</strong></li>
      <li>Note : <strong>{{{ $avis->rating }}}</strong>/5</li>
      <li>Commentaire : <strong>{{{ $avis->comment }}}</strong></li>
    </ul>
    <p>Vous pouvez consulter tous les commentaires dans la section dédiée de votre compte.</p>
  </div>
</body>
</html>