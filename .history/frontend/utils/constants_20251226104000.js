let Constants = {
  PROJECT_BASE_URL:
    location.hostname === "localhost"
      ? "http://localhost/kanita-foco/backend/rest"
      : "https://dolphin-app-chiwd.ondigitalocean.app/rest",

  USER_ROLE: "customer",
  ADMIN_ROLE: "admin"
};
