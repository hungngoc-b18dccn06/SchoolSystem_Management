import {ACCESS_TOKEN} from "@/const";

export const getAccessToken = () => {
  const token = sessionStorage.getItem(ACCESS_TOKEN);
  return token ?? localStorage.getItem(ACCESS_TOKEN);
};
