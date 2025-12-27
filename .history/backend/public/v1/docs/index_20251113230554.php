<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shoe Shop API Docs</title>
  <link rel="stylesheet" type="text/css" href="swagger-ui.css"/>
  <style>
    body { margin: 0; background: #fafafa; }
  </style>
</head>
<body>

<div id="swagger-ui"></div>

<script src="swagger-ui-bundle.js"></script>
<script src="swagger-ui-standalone-preset.js"></script>

<script>
window.onload = function () {
  SwaggerUIBundle({
    url: "swagger.php",   // <-- OVO OSTAJE OVAKO!!!
    dom_id: "#swagger-ui",
    presets: [
      SwaggerUIBundle.presets.apis,
      SwaggerUIStandalonePreset
    ],
    layout: "BaseLayout"
  });
};
</script>

</body>
</html>
