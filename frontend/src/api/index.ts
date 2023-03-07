import {ApiConstant} from "@/const";
import PAGE_ROUTE from "@/const/pageRoute";
import router from "@/router";
import {useRequestStore} from "@/stores/request";
import {getAccessToken} from "@/utils/timeOut";
import axios, {AxiosError} from "axios";

const RESPONSE_TIMEOUT = 30000;

const api = axios.create({
  baseURL: 'http://127.0.0.1:8000',
  headers: {
    "Content-Type": "application/json",
  },
  timeout: RESPONSE_TIMEOUT,
});

api.interceptors.request.use(
  function (config) {
    useRequestStore().insert();
    console.log("log request", config.data);
    if (config.headers) {
      const token = getAccessToken();
      config.headers["Authorization"] = `Bearer ${token ?? ""}`;
    }
    return config;
  },
  function (error) {
    return Promise.reject(error);
  },
);

api.interceptors.response.use(
  function (response) {
    setTimeout(() => useRequestStore().remove(), 50);
    return response;
  },
  function (error) {
    if (error) {
      useRequestStore().setError(error);
      useRequestStore().remove();
      if (
        axios.isAxiosError(error) &&
        (error as AxiosError).response?.status === 401 &&
        ApiConstant.LOGIN !== error?.config?.url
      ) {
        router.push(`${PAGE_ROUTE.LOGIN}`);
      }
    }
    return Promise.reject(error);
  },
);

export default api;
