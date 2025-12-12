<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shoe Shop API Docs</title>

  <!-- FIXED PATHS -->
  <link rel="stylesheet" type="text/css" href="/v1/docs/swagger-ui.css"/>

  <style>
    body { margin: 0; background: #fafafa; }
  </style>
</head>
<body>

<div id="swagger-ui"></div>

<!-- FIXED PATHS -->
<script src="/v1/docs/swagger-ui-bundle.js"></script>
<script src="/v1/docs/swagger-ui-standalone-preset.js"></script>

<script>
window.onload = function () {
  SwaggerUIBundle({
    url: "/v1/docs/swagger.php",
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
