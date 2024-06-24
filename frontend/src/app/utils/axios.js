// utils/axios.js

import axios from "axios";

const axiosInstance = axios.create({
  baseURL: "http://127.0.0.1",
  timeout: 5000,
  headers: {
    "Content-Type": "application/json",
    "Cache-Control": "no-cache",
  },
});

export default axiosInstance;
