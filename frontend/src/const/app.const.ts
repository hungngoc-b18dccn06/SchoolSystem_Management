export const SORT_BY = {
  desc: "DESC",
  asc: "ASC",
};

export const USER_ROLES = {
  anonymous: 0,
  admin: 1,
};

export const DATETIME_TYPE = {
  date: "date",
  datetime: "datetime",
};
export const DATE_FORMAT = "yy/mm/dd";
export const API_DATE_FORMAT = "yyyy-MM-dd";
export const TIME_FORMAT = "HH:mm:ss";
export const DATE_TIME_FORMAT = "yyyy/MM/dd - HH:mm";
export const RECEIPT_DATE_TIME_FORMAT = "yyyy-MM-dd HH:mm";
export const ANTD_DATE_FORMAT = "YYYY/MM/DD";
export const ANTD_DATE_TIME_FORMAT = "YYYY/MM/DD - HH:mm";
export const ANTD_MONTH_FORMAT = "YYYY/MM";
export const DATE_FORMAT_JP = "yyyy年M月d日";
export const DATE_CALENDAR_FORMAT_JP = "M月d日";
export const DATE_FORMAT_JP_V1 = "yyyy年MM月dd日";
export const DATE_FORMAT_JP_V2 = "MM月dd日";
export const DATE_FORMAT_JP_V3 = "dd日";
export const FORMAT_ND = "iii";
export const FORMAT_ND_FULL = "iiii";
export const FORMAT_CHART = "M/dd";
export const DATE_WEATHER_FORMAT = "yyyyMMdd";
export const MONTH_WEATHER_FORMAT = "yyyyMM";
export const FORMAT_DATETIME_CALENDAR_ID = "yyyyMMdd'T'HHmmss'Z'";

export const DATE_TIME_ZONE_FORMAT = "yyyy-MM-dd'T'HH:mm:ss'Z'";
export const DATE_TIME_ZONE_FORMAT2 = "yyyy-MM-dd'T'HH:mm:ss.000'Z'";
export const DATE_TIME_ZONE_VN_FORMAT = "yyyy-MM-dd'T'HH:mm:ss";
export const DATE_TIME_ZONE_FORMAT_CALENDAR = "yyyyMMdd'T'HHmmss'Z'";
export const DATE_TIME_DTSTART = "yyyy-MM-dd HH:mm:ss";

export const DATE_YYYY_MM_DD = "yyyy/MM/dd";
export const TIME_HH_MM_SS = "HH:mm:ss";
export const TIME_HHMMSS = "HHmmss";
export const TIME_HH_MM = "HH:mm";
export const TIME_HH_MM_2 = "hh:mm";
export const TIME_A_HH_MM = "ahh:mm";
export const TIME_A_HH_00 = "ahh:00";
export const TIME_A_HH_30 = "ahh:30";
export const TIME_A = "a";
export const DATE_CALENDAR_API = "yyyyMMdd";
export const DATE_CALENDAR_API_2 = "YYYYMMDD";
export const DATE_CALENDAR_API_3 = "YYYY-MM-DD";

export const DATE_TIME_FORMAT_2 = "yyyy-MM-dd  HH:mm:ss";
export const DATE_FORMAT_3 = "MM/DD/YYYY";
export const CURRENT_PAGE_REPORT_TEMPLATE = "全 {totalRecords}件中、{first}件〜{last}件を表示しています";

export const ROWS_PER_PAGE = 10;

export const ROWS_PER_PAGE_REPORT = 90;

export const DEFAULT_IMAGES_NUMBER_SIZE = 8;

export const DEFAULT_DISPLAYED_PAGE_NUMBER = 6;

export const SNACK_BAR_DURATION = 5000;
export const INPUT_TIMEOUT = 500;
export const LOCAL_LOGIN_KEY = "access_token";
export const TIME_DELAY = 3000;
export enum LOGIN_TYPE {
  BASE = "Email-Password",
  GOOGLE = "Google",
  APPLE = "Apple",
}
export const NUMBER_CHAR = "0123456789";
export const UPCASE_ALPHABET_CHAR = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
export const SPECIAL_CHAR = "!@#$%^&*()";
export const DOWNCASE_ALPHABET_CHAR = "abcdefghijklmnopqrstuvwxyz";
export const DEFAULT_LENGTH_INPUT = 255;
export const MAX_LENGTH_INPUT = 1500;
export const MAX_LENGTH_PASSWORD = 16;
export const MAX_LENGTH_PASSWORD_GEN = 50;
export const MIN_LENGTH_PASSWORD = 8;
export const MAX_LENGTH_30 = 30;
export const MAX_LENGTH_15 = 15;
export const MAX_FRACTION_DIGITS = 1;
export const MAX_FRACTION_DIGITS_4 = 4;
export const LENGTH_CVV = 3;
export const LENGTH_PINCODE = 4;
export const LENGTH_CARDNUMBER = 19;
export const REGEX_PASSWORD = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,16}$/;
export const PLATFORM = "web";
export const DEFAULT_CLIPBOARD_TIME = "30";
export const DEFAULT_LOGOUT_TIME = "60";
export const REGEX_URL =
  /(http(s)?:\/\/.)(www\.)?[-a-zA-Z0-9@:%._+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_+.~#?&//=]*)/g;
export const REGEX_URL_HTTP =
  /(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_+.~#?&//=]*)/g;
export const REGEX_TAGS = /(<([^>]+)>)/gi;
export const REGEX_DATE = /\d{4}-\d{1,2}-\d{1,2}/g;
export const GOOGLE_VALUE = "12";
export const APPLE_VALUE = "11";
export const STORAGE_TYPE_LOGIN = "type_login";
export const SOCIAL_USER_ID = "social_user_id";
export const SOCIAL_USER_EMAIL = "social_user_email";
export const SOURCE_ID = "0";
export const BACKGROUND_COLOR_CHAR = "#42A5F5";
export const MAX_NUMBER_INPUT = 9999;
export const MIN_NUMBER_INPUT = 0;
export const MAX_DECIMAL_PART = 2;

export const REGEX_MAX_NUMBER_3_DECIMAL_2 = /^\d{1,3}(\.\d{0,2})?$/;
export const REGEX_MAX_NUMBER_3 = /^\d{1,3}$/;
export const REGEX_MAX_NUMBER_9 = /^\d{1,9}$/;
export const REGEX_MAX_NUMBER_9_DECIMAL_2 = /^\d{1,9}(\.\d{0,2})?$/;
export const REGEX_MAX_DECIMAL_2 = /^(\.\d{0,2})?$/;
export const REGEX_POSITIVE_INTEGER = /^\+?(0|[1-9]\d*)$/gm;
