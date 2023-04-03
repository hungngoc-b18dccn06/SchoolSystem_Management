<script lang="ts" setup>
import CONST, { DEFAULT, AppConstant } from "@/const/";
import { onMounted, reactive } from "vue";
import { useRoute } from "vue-router";
import { useI18n } from "vue-i18n";
import * as yup from "yup";
import { Field, ErrorMessage, useForm } from "vee-validate";
import { useUserStore } from "@/stores/user";
import { useTeacherStore } from "@/stores/teacher";
import FooterCommon from "@/components/common/FooterCommon.vue";
import Calendar from 'primevue/calendar';
const storeTeacher = useTeacherStore();
const storeUser = useUserStore();
const { t } = useI18n();
const currentRoute = useRoute();
const emit = defineEmits(["submit", "cancel"]);
const isCreate = currentRoute.path.search("create") >= 0;
const schema = yup.object({
  first_name: yup
    .string()
    .trim()
    .required(t('message.required'))
    .max(100, t('message.maxLength100')),
  last_name: yup
    .string()
    .trim()
    .required(t('message.required'))
    .max(100, t('message.maxLength100')),
  email: yup
    .string()
    .trim()
    .required(t('message.required'))
    .matches(CONST.REGEX_EMAIL,t('message.emailInvalid'))
    .max(100, t('message.maxLength100')),

  password: yup.lazy((value) => {
    if (isCreate) {
      return yup
        .string()
        .required(t('message.required'))
        .matches(CONST.REGEX_PASSWORD, t('message.passwordInvalid'));
    }
    return yup.mixed().notRequired();
  }),
});

const {resetForm, values, errors, validate } = useForm({
  validationSchema: schema,
});

const handleResetForm = () => {
  resetForm({
    values: {
        first_name: '',
        last_name: '',
        email: '',
        status: DEFAULT.USER_STATUS[0].value,
        role: DEFAULT.USER_ROLE[0].value,
        password:'',
      },
  });
};

const handleSubmit = async () => {
  if ((await validate()).valid) {
    emit("submit");
  };
};
const handleBack = async () => {
  emit("cancel");
};

defineExpose({
  handleResetForm,
});

</script>
<template>
  <div class="p-4 bg-white border-round-2xl grid mx-0">
    <div class="col-10">
      <div class="grid mt-3">
        <div class="title-card col-4">
          <label class="title-field mt-2 required">{{t('user.familyName')}}</label>
        </div>
        <div class="col-4">
          <label class="d-block mb-1 font-weight-bold">{{t('user.firstName')}}</label>
          <Field
            :class="{ 'is-invalid': errors.first_name }"
            name="first_name"
            v-slot="{ field, value }"
            v-model="storeTeacher.getFormTeacher.first_name"
          >
            <div class="p-inputgroup">
              <InputText
                class="w-full"
                :placeholder="t('user.firstName')"
                v-bind="field"
                :modelValue="value"
              />
            </div>
            <ErrorMessage class="subtext p-error absolute pt-1" name="first_name" />
          </Field>
        </div>
        <div class="col-4">
          <label class="d-block mb-1 font-weight-bold">{{ t('user.lastName') }}</label>
          <Field
            :class="{ 'is-invalid': errors.last_name }"
            name="last_name"
            v-slot="{ field, value }"
            v-model="storeTeacher.getFormTeacher.last_name"
          >
            <div class="p-inputgroup">
              <InputText
                class="w-full"
                :placeholder="t('user.lastName')"
                v-bind="field"
                :modelValue="value"
              />
            </div>
            <ErrorMessage class="subtext p-error absolute pt-1" name="last_name" />
          </Field>
        </div>
      </div>
      <div class="grid mt-6">
        <div class="title-card col-4">
          <label class="title-field inline-block mt-2 required">{{ t('user.emailAdress') }}</label>
        </div>
        <div class="col-8">
          <Field
            :class="{ 'is-invalid': errors.email }"
            name="email"
            v-slot="{ field, value }"
            v-model="storeTeacher.getFormTeacher.email"
          >
            <div class="p-inputgroup">
              <InputText
                class="w-full"
                :placeholder="t('user.emailAdress')"
                v-bind="field"
                :modelValue="value"
              />
            </div>
            <ErrorMessage class="subtext p-error absolute pt-1" name="email" />
          </Field>
        </div>
      </div>
      <div class="grid mt-6">
        <div class="title-card col-4">
          <label class="title-field inline-block mt-2 required">{{ t('user.phone') }}</label>
        </div>
        <div class="col-8">
          <Field
            :class="{ 'is-invalid': errors.phone }"
            name="phone"
            v-slot="{ field, value }"
            v-model="storeTeacher.getFormTeacher.phone"
          >
            <div class="p-inputgroup">
              <InputText
                class="w-full"
                :placeholder="t('user.phone')"
                v-bind="field"
                :modelValue="value"
              />
            </div>
            <ErrorMessage class="subtext p-error absolute pt-1" name="email" />
          </Field>
        </div>
      </div>
      <div class="grid mt-6">
        <div class="title-card col-4">
          <label class="title-field inline-block mt-2 required">{{ t('user.currentAddress') }}</label>
        </div>
        <div class="col-8">
          <Field
            :class="{ 'is-invalid': errors.current_address }"
            name="current_address"
            v-slot="{ field, value }"
            v-model="storeTeacher.getFormTeacher.current_address"
          >
            <div class="p-inputgroup">
              <InputText
                class="w-full"
                :placeholder="t('user.currentAddress')"
                v-bind="field"
                :modelValue="value"
              />
            </div>
            <ErrorMessage class="subtext p-error absolute pt-1" name="current_address" />
          </Field>
        </div>
      </div>
      <div class="grid mt-6">
        <div class="title-card col-4">
          <label class="title-field inline-block mt-2 required">{{ t('user.permanentAddress') }}</label>
        </div>
        <div class="col-8">
          <Field
            :class="{ 'is-invalid': errors.permanentAddress }"
            name="permanent_address"
            v-slot="{ field, value }"
            v-model="storeTeacher.getFormTeacher.permanent_address"
          >
            <div class="p-inputgroup">
              <InputText
                class="w-full"
                :placeholder="t('user.permanentAddress')"
                v-bind="field"
                :modelValue="value"
              />
            </div>
            <ErrorMessage class="subtext p-error absolute pt-1" name="permanent_address" />
          </Field>
        </div>
      </div>
      <div class="grid mt-6" v-if="isCreate">
        <div class="title-card col-4">
          <label class="title-field required">{{t('user.password')}}</label>
        </div>
            <div class="col-8">
              <Field
                :class="{ 'is-invalid': errors.password }"
                name="password"
                v-slot="{ field, value }"
                v-model="storeTeacher.getFormTeacher.password">
                <div class="p-inputgroup">
                  <Password
                    v-bind="field"
                    inputClass="w-full"
                    :placeholder="t('user.password')"
                    hideIcon="pi pi-eye"
                    showIcon="pi pi-eye-slash"
                    :feedback="false"
                    aria-describedby="password-error"
                    autocomplete="new-password"
                    :maxlength="AppConstant.MAX_LENGTH_PASSWORD"
                    :modelValue="value"
                    toggleMask
                  />
                </div>
                <ErrorMessage class="subtext p-error absolute pt-1" name="password" />
              </Field>
        </div>
      </div>
      <div class="grid mt-6">
        <div class="title-card col-4">
          <label class="title-field inline-block mt-2 required">{{ t('user.dateofbirth') }}</label>
        </div>
        <div class="col-8">
          <Field
            :class="{ 'is-invalid': errors.email }"
            name="phone"
            v-slot="{ field, value }"
            
          >
            <div class="p-inputgroup">
                <div class="card flex justify-content-center">
                    <Calendar v-model="storeTeacher.getFormTeacher.dateofbirth" :placeholder="t('user.dateofbirth')"  />
                </div>
            </div>
            <ErrorMessage class="subtext p-error absolute pt-1" name="phone" />
          </Field>
        </div>
      </div>
      <div class="grid mt-6">
        <div class="title-card col-4">
          <label class="title-field">権限設定</label>
        </div>
        <div class="col-8">
          <div class="grid">
            <div
              class="col-12 pl-0"
              v-for="(ele, i) in DEFAULT.GENDER"
              :key="i"
            >
              <div class="field-radiobutton mb-1">
                <Field
                  name="role"
                  v-slot="{ field, value }"
                  v-model="storeTeacher.getFormTeacher.gender"
                >
                  <label class="cursor-pointer flex align-items-center">
                    <RadioButton
                      v-bind="field"
                      :value="ele.value"
                      :modelValue="value"
                    />
                    <span class="px-2">{{ ele.label }}</span>
                  </label>
                </Field>
              </div>
            </div>
            <ErrorMessage class="subtext p-error absolute pt-1" name="is_valid" />
          </div>
        </div>
      </div>
      <div class="grid mt-5">
        <div class="title-card col-4">
          <label class="title-field">状態</label>
        </div>
        <div class="col-8">
          <div class="grid">
            <div
              class="col-12 pl-0"
              v-for="(ele, i) in DEFAULT.USER_STATUS"
              :key="i"
            >
              <div class="field-radiobutton mb-1">
                <Field
                  name="status"
                  v-slot="{ field, value }"
                  v-model="storeTeacher.getFormTeacher.status"
                >
                  <label class="cursor-pointer flex align-items-center">
                    <RadioButton
                      v-bind="field"
                      :value="ele.value"
                      :modelValue="value"
                    />
                    <span class="px-2">{{ ele.label }}</span>
                  </label>
                </Field>
              </div>
            </div>
            <ErrorMessage class="subtext p-error absolute pt-1" name="type" />
          </div>
        </div>
      </div>
    </div>
  </div>
  <FooterCommon
    :labelSubmit="t('common.register')"
    :labelCancel="t('common.back')"
    :submit="handleSubmit"
    :cancel="handleBack"
  />
</template>
<style scoped>
  .layout-wrapper .p-error{
    padding: 0.75rem 0rem;
  }
</style>