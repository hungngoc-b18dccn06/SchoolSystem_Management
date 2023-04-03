
export const HEADER_DEFAULT = {
  Accept: "*/*",
  "Content-Type": "application/json",
  "Access-Control-Allow-Headers": "*",
  "Access-Control-Allow-Origin": "*",
  "Access-Control-Allow-Credentials": "true",
  // "Access-Control-Allow-Methods": "GET,HEAD,OPTIONS,POST,PUT",
};

export const TIMEOUT = 30000;

// HTTP Status
export const STT_OK = 200;
export const STT_CREATED = 201;
export const STT_BAD_REQUEST = 400;
export const STT_UNAUTHORIZED = 401;
export const STT_FORBIDDEN = 403;
export const STT_NOT_FOUND = 404;
export const STT_UNPROCESSABLE_ENTITY = 422;
export const STT_INTERNAL_SERVER = 500;
export const STT_BAD_GATEWAY = 502;
export const STT_NETWORK_PROBLEM = 0;


//headers
export const UPDATE_DATA_FILE_HEADER = {
  headers: {accept: "*/*", "content-type": "application/json; charset=utf-8"},
};
export const UPDATE_USER_HEADER = {
  headers: { accept: "*/*", "content-type": "application/json; charset=utf-8" },
};

export interface ResponseLogin {
  data: {
    access_token: string;
  };
  token_type: string;
  expires_in: number;
  refresh_token: string;
}

//ROUTERS
export const LOGIN = "/api/auth/login";
export const LOGOUT = "/api/auth/logout";
// @ts-ignore
export const CHECK_TOKEN_EXPIRED = (token:any) => `/api/auth/check-token-expired?token=${token}`;
export const SEND_PASSWORD_RESET = `api/auth/password/reset`;
export const REGISTER_PASSWORD = (token: string | string[]) =>
  `/api/v1/UsrReg;token=${token}`;
export const USER_REGISTER = (urlPrefix: string) =>
  `/api/v1/UsrReg?urlPrefix=${encodeURIComponent(
    urlPrefix
  )}&pathSuffix=medipurse`;
export const SEND_MAIL_RESET_PASSWORD = "api/auth/password/email";

// CATEGORY
export const GET_LIST_CATEGORY = "/api/categories";
export const DELETE_CATEGORY = (id: number) => `/api/categories/${id}`;
export const UPDATE_CATEGORY =  "/api/categories";

export const GET_PROFILE =  "/api/auth/profile";
export const UPDATE_PROFILE = "/api/auth/profile"
export const GET_LIST_USER =  "/api/users";
export const GET_DETAIL_USER = (id: number) => `/api/users/${id}`;
export const CREATE_USER = "/api/users";
export const UPDATE_USER = (id: number) => `/api/users/${id}`;
export const DELETE_USER = (id: number) => `/api/users/${id}`;

//TEACHERS

export const GET_TEACHER =  "/api/teachers";
export const CREATE_TEACHER = "/api/teachers";
export const GET_DETAIL_TEACHER = (id: number) => `/api/teachers/${id}`;
export const UPDATE_TEACHER = (id: number) => `/api/teachers/${id}`;