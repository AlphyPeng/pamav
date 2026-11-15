import axios from "axios";

axios.defaults.baseURL = window.location.origin;
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

export default axios;
