import Echo from "laravel-echo";
import Pusher from "pusher-js"; // Add this line

const baseURL = "https://mms-api.algoskech.co.ke";

window.Pusher = Pusher;

window.Echo = new Echo({
  broadcaster: "pusher",
  key: "qyjszpgrbpixurrm",
  cluster: "mt1",
  wsHost: "mms-api.algoskech.co.ke",
  wsPort: 2053,
  wssPort: 2053,
  forceTLS: true,
  // disabledStats: true,
  enabledTransports: ["ws", "wss"],
  auth: {
    headers: {
      Authorization: "Bearer " + localStorage.getItem("token"),
      Accept: "application/json",
    },
  },
  authEndpoint: `${baseURL}/api/broadcasting/auth`,
});
