<template>
  <div>
  <Sidebar />
  <div class="login-screen">
        <div class="flex flex-column align-items-center">
            <form @submit.prevent="handleSubmitForm" autocomplete="off">
            <div class="login-form">
                <div class="mt-2">
                    <div class="flex w-full my-2 justify-content-center font-bold text-2xl">
                     {{ t("user.title") }}
                    </div>
                    <div class="field field-input my-5">
                        <Field name="email">
                            <div class="p-inputgroup">
                            <span class="p-inputgroup-addon">
                                <i class="pi pi-envelope"></i>
                            </span>
                            <InputText
                                type="text"
                                :placeholder="t('user.emailAdress')"
                                autocomplete="off"
                            />
                            </div>
                        </Field>
                    </div>
                    <div class="field-input custom-password my-5 pb-1">
                        <Field name="password">
                            <div class="p-inputgroup">
                            <span class="p-inputgroup-addon">
                                <i class="pi pi-lock"></i>
                            </span>
                            <span class="p-input-icon-right w-full">
                                <InputText
                                v-bind="field"
                                class="w-full"
                                aria-describedby="password-help"
                                autocomplete="current-password"
                                :class="{'p-invalid': errorMessage && !metaField.valid && metaField.touched}"
                                :placeholder="t('user.password')"
                                :type="showPass ? 'text' : 'password'"
                                @keydown.enter.prevent="handleSubmitForm"
                                />
                                <i
                                class="pi"
                                :class="{'pi-eye': showPass, 'pi-eye-slash': !showPass}"
                                @click="showPass = !showPass"
                                />
                            </span>
                            </div>
                            <div class="absolute line-height-1 pt-2">
                            <small v-if="errorMessage && !metaField.valid && metaField.touched" class="p-error">{{ errorMessage }}</small>
                            </div>
                        </Field>
                    </div>
                </div>
                <div class="flex flex-column align-items-center gap-2 footer mt-2 pb-1">
            <Button
              :disabled="state.loading"
              :label="t('user.login')"
              class="btn-submit w-full mb-2 p-0"
              type="submit"
            />
            <router-link
              :to="PAGE_ROUTE.FORGOT_PASSWORD"
              class="text-color underline font-semibold mt-4"
              >{{ t("user.forgot") }}</router-link
            >
            <!-- <router-link :to="PAGE_ROUTE.REGISTER" class="">{{
              t("user.register")
            }}</router-link> -->
          </div>
            </div>
            </form>
        </div>
  </div>
  </div>
</template>

<script setup lang='ts'>
import Popup from "@/components/PopupConfirm.vue";
import Sidebar from "@/layout/AuthSidebar.vue";
import { onMounted, reactive, ref } from "vue";
import { useI18n } from "vue-i18n";
import { useRouter } from "vue-router";
import PAGE_ROUTE from "@/const/pageRoute";
import { Field, useForm } from "vee-validate";
import * as yup from "yup";
const showPass = ref(false);
const { t } = useI18n();
const router = useRouter();
const state = reactive({
  loading:false,
});
</script>

<style lang="scss" scoped>
.p-inputtext {
  width: 100% !important;
  border-top-left-radius: 0 !important;
  border-bottom-left-radius: 0 !important;
}
.login-screen {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
  min-height: 700px;
}

.login-form {
  min-width: 500px;
  border-radius: 8px;
  background-color: white;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 40px 100px;
  box-shadow: 0px 1px 6px rgba(0, 0, 0, 0.102);
  border-radius: 10px;
}

.register {
  font-size: 16px;

  a {
    color: var(--vt-c-dark-red);
    text-decoration: none;
    font-weight: 400;
    line-height: 22px;
    margin-bottom: 10px;
  }
}

.field-input {
  min-width: 240px;
  width: 375px;
}
:deep( .p-inputtext ) {
  width: var(--width-input);
  height: var(--height-input);
}
.footer {
  width: 375px;
  font-size: 16px;
  font-weight: 700;
}
:deep( .p-button .p-button-label ) {
  font-size: 16px;
  font-weight: 700;
}
.footer a {
  text-decoration: none;
  color: var(--vt-c-dark-red);
}
:deep( .p-divider .p-divider-content ) {
  font-size: 14px;
  color: #a3bac8;
  font-weight: 400;
  line-height: 22px;
}
:deep( .p-inputgroup #password:focus ) {
  z-index: 0;
}

.custom-password :deep( .p-inputgroup > .p-inputwrapper > .p-inputtext:focus ) {
  z-index: unset;
}
.btn-submit,
.btn-submit:focus {
  width: 200px;
  border: none;
  border-radius: 10px;
  box-shadow: none;
  font-size: 18px;
  font-weight: 700;
  background-color: #2b9dca !important;
}
:deep(.btn-submit) {
  background-color: #2b9dca;
  p {
    font-size: 16px;
    font-weight: 700;
  }
}
.text-color {
  color: #2b9dca !important;
}
.p-invalid-icon {
  color: red;
}
:deep(.login-screen){
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    min-height: 700px;
}
</style>
