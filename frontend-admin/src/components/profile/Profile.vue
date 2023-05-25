<script lang="ts" setup>
import TitleCommon from '@/components/common/TitleCommon.vue'
import CONST, { DEFAULT, AppConstant } from '@/const/'
import Popup from '@/components/PopupConfirm.vue'
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import { useI18n } from 'vue-i18n'
import * as yup from 'yup'
import { Field, ErrorMessage, useForm } from 'vee-validate'
import { useUserStore } from '@/stores/user'
import PAGE_ROUTE from '@/const/pageRoute'
import { useToast } from 'primevue/usetoast'
import { useRouter } from 'vue-router'
import { useProfileStore } from '@/stores/profile'
const storeProfile = useProfileStore()
const storeUser = useUserStore()
const modal = ref<InstanceType<typeof Popup> | null>(null)
const { t } = useI18n()
const toast = useToast()
const router = useRouter()
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
    .matches(CONST.REGEX_EMAIL, t('message.emailInvalid'))
    .max(100, t('message.maxLength100')),
})
const { errors, validate } = useForm({
  validationSchema: schema
})
const updateProfile = async () => {
  try {
    closeModal()
    const res = await storeProfile.updateProfile(storeUser.getProfile)
    toast.add({
      group: 'message',
      severity: 'success',
      summary: res.data.message,
      life: CONST.TIME_DELAY,
      closable: false
    })
    await storeProfile.updateProfile(storeUser.getProfile)
    router.push({ path: PAGE_ROUTE.USER_LIST })
  } catch (e: any) {
    closeModal()
  }
}
onMounted(() => {
  storeUser.getProfileDetail()
})
const closeModal = () => {
  modal.value?.close()
}
</script>
<template>
  <diV>
    <TitleCommon :title="t('page.updateProfile')" />
    <div class="p-4 bg-white border-round-2xl grid mx-0">
      <div class="col-10">
        <div class="grid mt-3">
          <div class="title-card col-4">
            <label class="title-field mt-2 required">{{ t('user.familyName') }}</label>
          </div>
          <div class="col-4">
            <label class="d-block mb-1 font-weight-bold">{{ t('user.firstName') }}</label>
            <Field
              :class="{ 'is-invalid': errors.first_name }"
              name="first_name"
              v-slot="{ field, value }"
              v-model="storeUser.getProfile.first_name"
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
              v-model="storeUser.getProfile.last_name"
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
            <label class="title-field inline-block mt-2 required">{{
              t('user.emailAdress')
            }}</label>
          </div>
          <div class="col-8">
            <Field
              :class="{ 'is-invalid': errors.email }"
              name="email"
              v-slot="{ field, value }"
              v-model="storeUser.getProfile.email"
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
            <label class="title-field">権限設定</label>
          </div>
          <div class="col-8">
            <div class="grid">
              <div class="col-12 pl-0" v-for="(ele, i) in DEFAULT.USER_ROLE" :key="i">
                <div class="field-radiobutton mb-1">
                  <Field name="role" v-slot="{ field, value }" v-model="storeUser.getProfile.role">
                    <label class="cursor-pointer flex align-items-center">
                      <RadioButton v-bind="field" :value="ele.value" :modelValue="value" />
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
              <div class="col-12 pl-0" v-for="(ele, i) in DEFAULT.USER_STATUS" :key="i">
                <div class="field-radiobutton mb-1">
                  <Field
                    name="status"
                    v-slot="{ field, value }"
                    v-model="storeUser.getProfile.status"
                  >
                    <label class="cursor-pointer flex align-items-center">
                      <RadioButton v-bind="field" :value="ele.value" :modelValue="value" />
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
    <Popup
      ref="modal"
      :labelCancel="t('common.no')"
      :labelOk="t('common.yes')"
      :header="t('common.confirm')"
      :content="t('common.popupConfirmSaveContent')"
      :ok="updateProfile"
      :cancel="closeModal"
    ></Popup>
  </diV>
</template>
<style scoped>
.layout-wrapper .p-error {
  padding: 0.75rem 0rem;
}
</style>