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
  <title>Email de bienvenue</title>
  <style>
    img {
      max-width: 100%;
      vertical-align: middle
    }
    .hover-bg-blue-600:hover {
      background-color: #2563eb !important
    }
    .focus-outline-none:focus {
      outline: 2px solid transparent !important;
      outline-offset: 2px !important
    }
    .focus-ring-2:focus {
      --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color) !important;
      --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color) !important;
      box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000) !important
    }
    .focus-ring-blue-500:focus {
      --tw-ring-opacity: 1 !important;
      --tw-ring-color: rgb(59 130 246 / var(--tw-ring-opacity)) !important
    }
  </style>
</head>
<body style="margin: 0; width: 100%; padding: 0; -webkit-font-smoothing: antialiased; word-break: break-word">
  <div role="article" aria-roledescription="email" aria-label="Email de bienvenue" lang="en">
    <div style="margin-left: auto; margin-right: auto; max-width: 384px; border-radius: 8px; background-color: #fff; padding: 24px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1)">
      <h1 style="margin-bottom: 16px; font-size: 30px; font-weight: 700; color: #111827">
        Bienvenue {{{ $user->name }}} !
      </h1>
      <p style="margin-bottom: 16px; font-size: 18px; color: #374151">
        Merci de vous être inscrit sur Atypik House. Nous sommes ravis de vous accueillir dans notre communauté.
      </p>
      <p style="margin-bottom: 24px; font-size: 18px; color: #374151">
        Nous avons hâte de vous aider à trouver le logement idéal. Si vous avez des questions ou avez besoin d'aide, n'hésitez pas à nous contacter.
      </p>
      <a aria-label="visiter" href="{{{ route('home.index') }}}" class="hover-bg-blue-600 focus-outline-none focus-ring-2 focus-ring-blue-500" style="display: inline-block; border-radius: 8px; background-color: #3b82f6; padding: 12px 24px; font-weight: 600; color: #fff; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1)">
        Visitez notre site
      </a>
    </div>
  </div>
</body>
</html>