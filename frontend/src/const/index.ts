export * as AppConstant from "./app.const";
export * as ApiConstant from "./api.const";
export * as MenuConstant from "./menu.const";
export * as DEFAULT from "./default.const";

export const ACCESS_TOKEN = "access_token";
export const REMIND = "remind_info";
export const USER_INFO = "user_info";
export const EXPIRY_TIME = "expiry_time";

export default {
  TIME_DELAY: 3000,
  REGEX_PASSWORD: /^[a-zA-Z0-9!@#$%^&*()_]{8,16}$/,
  REGEX_EMAIL:  /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
  FORMAT_DATE: "yyyy/MM/dd",
  DATE_FORMAT:"yyyy-MM-dd",
  DEFAULT_PAGE_SIZE: 10,
}
