const enum PAGE_ROUTE {
  HOME = "/",
  LOGIN = "/auth/signin",
  REGISTER = "/register",
  FORGOT_PASSWORD = "/auth/forgot-password",
  REGISTER_SUCCESSFUL = "/register-successful",
  PASSWORD_GENERATE = "/generate-password",
  UPDATE_PROFILE = "/update-profile",
  UPDATE_PASSWORD = "/update-password",
  INITIAL_PROFILE = "/initial-profile",
  NOT_FOUND = "/not-found",
  CHANGE_PASSWORD_RESET = "/reset-password",
  REGISTER_PASSWORD = "/UsrRegInput/medipurse/:id",

  // USER
  USER_LIST = "/users",
  USER_CREATE = "/user/create",
  USER_UPDATE = "/user/:userId/update",

  //Category
  CATEGORY_LIST = "/categories",

  //teacher
  TEACHER_LIST = "/teachers",
}

export const publicPath = [
  "/auth/signin",
  "/register",
  "/UsrRegInput",
  "/auth/forgot-password",
  "/reset-password",
];
export default PAGE_ROUTE;
