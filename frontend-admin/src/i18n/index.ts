/* eslint-disable @typescript-eslint/ban-types */
import {createI18n} from "vue-i18n";
import messages from "./locales";

export default createI18n({
  legacy: false,
  globalInjection: true,
  locale: "ja",
  fallbackLocale: "ja",
  messages: messages,
});
