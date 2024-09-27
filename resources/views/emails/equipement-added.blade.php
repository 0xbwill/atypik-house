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
  <title>Equipement ajouté</title>
  <style>
    img {
      max-width: 100%;
      vertical-align: middle
    }
  </style>
</head>
<body style="margin: 0; width: 100%; padding: 0; -webkit-font-smoothing: antialiased; word-break: break-word">
  <div role="article" aria-roledescription="email" aria-label="Equipement ajouté" lang="en">
    <div style="width: 100%">
      <div style="margin-left: auto; margin-right: auto; max-width: 336px; border-radius: 8px; background-color: #fff; padding: 24px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1)">
        <h1 style="font-size: 30px; font-weight: 700; color: #1f2937">Bonjour,</h1>
        <p style="margin-top: 16px; font-size: 18px">Un nouvel équipement a été ajouté à une catégorie :</p>
        <div style="margin-top: 16px; border-radius: 4px; border-width: 1px; border-color: #d1d5db; background-color: #f3f4f6; padding: 16px">
          <h2 style="font-size: 24px; font-weight: 600">{{{ $equipement->name }}}</h2>
          <p style="margin-top: 8px">Catégorie : {{{ $category->name }}}</p>
        </div>
        <p style="margin-top: 16px;">Vous pouvez le consulter dans le tableau de bord.</p>
        <p style="margin-top: 16px;">Merci, <br> L'équipe de réservation</p>
      </div>
    </div>
  </div>
</body>
</html>