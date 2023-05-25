import {ERROR_LIB} from "@/const/error.const";
import {STT_INTERNAL_SERVER, STT_NOT_FOUND, STT_FORBIDDEN, STT_BAD_REQUEST, STT_UNAUTHORIZED} from "@/const/api.const";
import type {AxiosError} from "axios";
interface DataReturn {
  result?: boolean;
  message?: string;
  type?: string;
}
export const handleErrorMessage = (value: AxiosError) => {
  const data: DataReturn = {};
  const statusCode = value?.response?.status;
  if (value.config?.baseURL === ERROR_LIB.medipurse.url) {
    data.type = ERROR_LIB.medipurse.type;
  } else if (value.config?.baseURL === ERROR_LIB.google.url) {
    data.type = ERROR_LIB.google.type;
  }
  if (
    statusCode === STT_INTERNAL_SERVER ||
    statusCode === STT_NOT_FOUND ||
    statusCode === STT_FORBIDDEN ||
    statusCode === STT_BAD_REQUEST
  ) {
    data.message = ERROR_LIB.interalServer;
  } else if (statusCode === STT_UNAUTHORIZED) {
    data.message = ERROR_LIB.authServer;
  } else {
    data.message = ERROR_LIB.connectServer;
  }
  return data;
};
