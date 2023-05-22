<script lang="ts" setup>
import CONST, { DEFAULT, AppConstant } from "@/const/";
import { useRoute } from "vue-router";
import { useI18n } from "vue-i18n";
import {onMounted, ref} from "vue";
import * as yup from "yup";
import { Field, ErrorMessage, useForm } from "vee-validate";
import { useTeacherStore } from "@/stores/teacher";
import { useClassStore } from "@/stores/class";
import FooterCommon from "@/components/common/FooterCommon.vue";
import Dropdown from "primevue/dropdown";
const storeTeacher = useTeacherStore();
const storeClass = useClassStore();
const { t } = useI18n();
const currentRoute = useRoute();
const emit = defineEmits(["submit", "cancel"]);
const selectedTeacher = ref();
const isCreate = currentRoute.path.search("create") >= 0;
const schema = yup.object({
  class_numeric: yup
    .number()
    .required(t('message.required'))
    .max(100, t('message.maxLength100')),
  class_name: yup
    .string()
    .trim()
    .required(t('message.required'))
    .max(100, t('message.maxLength100')),
  class_description: yup
    .string()
    .trim()
    .required(t('message.required'))
    .max(100, t('message.maxLength100')),
});

function getNameTeacher() {
    console.log(storeTeacher.getTeachers);
}

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
        gender: DEFAULT.GENDER[0].value,
        password:'',
      },
  });
};

onMounted(async () => {
  storeTeacher.getListTeacher();
  getNameTeacher();
});

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
          <label class="title-field mt-2 required">クラス名</label>
        </div>
        <div class="col-8">
          <label class="d-block mb-1 font-weight-bold">クラス名</label>
          <Field
            :class="{ 'is-invalid': errors.class_name }"
            name="class_name"
            v-slot="{ field, value }"
            v-model="storeClass.getFormClass.class_name"
          >
            <div class="p-inputgroup">
              <InputText
                class="w-full"
                :placeholder="t('user.firstName')"
                v-bind="field"
                :modelValue="value"
              />
            </div>
            <ErrorMessage class="subtext p-error absolute pt-1" name="class_name" />
          </Field>
        </div>
      </div>
      <div class="grid mt-6">
        <div class="title-card col-4">
          <label class="title-field inline-block mt-2 required">クラス数値</label>
        </div>
        <div class="col-8">
          <Field
            :class="{ 'is-invalid': errors.class_numeric }"
            name="class_numeric"
            v-slot="{ field, value }"
            v-model="storeClass.getFormClass.class_numeric"
          >
            <div class="p-inputgroup">
              <InputText
                class="w-full"
                :placeholder="t('user.emailAdress')"
                v-bind="field"
                :modelValue="value"
              />
            </div>
            <ErrorMessage class="subtext p-error absolute pt-1" name="class_numeric" />
          </Field>
        </div>
      </div>
      <div class="grid mt-6">
        <div class="title-card col-4">
          <label class="title-field inline-block mt-2 required">クラスの説明</label>
        </div>
        <div class="col-8">
          <Field
            :class="{ 'is-invalid': errors.class_description }"
            name="class_description"
            v-slot="{ field, value }"
            v-model="storeClass.getFormClass.class_description"
          >
            <div class="p-inputgroup">
              <InputText
                class="w-full"
                placeholder="クラスの説明"
                v-bind="field"
                :modelValue="value"
              />
            </div>
            <ErrorMessage class="subtext p-error absolute pt-1" name="class_description" />
          </Field>
        </div>
      </div>
      <div class="grid mt-6">
        <div class="title-card col-4">
          <label class="title-field inline-block mt-2 required">教師を割り当てる</label>
        </div>
        <div class="col-8">
          <Field
            :class="{ 'is-invalid': errors.permanentAddress }"
            name="permanent_address"
            v-slot="{ field, value }"
            v-model="storeTeacher.getFormTeacher.permanent_address"
          >
            <div class="p-inputgroup">
              <Dropdown v-model="storeClass.getFormClass.teacher_name" :options="storeTeacher.getTeachers" optionLabel="name"/>
            </div>
            <ErrorMessage class="subtext p-error absolute pt-1" name="permanent_address" />
          </Field>
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