<template>
    <div>
        <div class="dowload-file-admin">
            <Button class="p-button-sm white-space-nowrap download mr-2" icon="pi pi-download"
                @click="downloadCSV(DEFAULT.EXPORT_TYPE.CSV, 'CSV出力', 'csv')" label="CSV出力"></Button>
            <Button class="p-button-sm white-space-nowrap download mr-2" icon="pi pi-download"
                @click="downloadCSV(DEFAULT.EXPORT_TYPE.EXCEL_TOTAL, '集計出力', 'xlsx')" label="集計出力"></Button>
        </div>
        <TitleCommon :title="t('page.userCreate')" />
        <div class="lighten-4 rounded">
            <div class="p-4 border-search pb-3">
                <div class="key_search">
                    <span class="text-field-search">キーワード検索</span>
                    <div class="p-inputgroup flex-1">
                        <InputText class="w-full" v-model="storeUser.getParamSearch.search_text" placeholder="入力してください" />
                        <ButtonClearCommon v-if="storeUser.getParamSearch.search_text" :clearInput="() => clearInput('storeUser.getParamSearch.search_text')
                            " />
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-field-search">項目指定（数字項目）</span>
                    <div class="grid align-items-center">
                        <div class="col-3">
                            <div class="p-inputgroup">
                                <Dropdown v-model="selectedNumbericType" :options="DEFAULT.NUMBERIC_ITEM"
                                    placeholder="選択してください" optionLabel="label" class="w-full md:w-14rem"
                                    @change="handelSearchType" />
                                <ButtonClearCommon v-if="selectedNumbericType"
                                    :clearInput="() => clearInput('selectedNumbericType')" />
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="p-inputgroup">
                                <Field :class="{ 'is-invalid': errors.start_number }" name="start_number"
                                    v-slot="{ field, value }" v-model="storeUser.getParamSearch.start_number">
                                    <InputText class="w-full" :disabled="!selectedNumbericType" :modelValue="value"
                                        v-bind="field" @update:model-value="field" v-on:keyup="async () => {
                                                await validate();
                                            }
                                            " v-on:keypress="checkNumeric" />
                                    <ErrorMessage v-if="errors.start_number"
                                        class="subtext p-error absolute pt-6 p-invalid white-space-nowrap"
                                        name="start_number" />
                                    
                                </Field>
                                <ButtonClearCommon v-if="storeUser.getParamSearch.start_number" :clearInput="() => clearInput('storeUser.getParamSearch.start_number')
                                    " />
                            </div>
                        </div>
                        <span class="mx-1">~</span>
                        <div class="col-3">
                            <div class="p-inputgroup">
                                <Field :class="{ 'is-invalid': errors.start_number }" name="end_number"
                                    v-slot="{ field, value }" v-model="storeUser.getParamSearch.end_number">
                                    <InputText class="w-full" :disabled="!selectedNumbericType" :modelValue="value"
                                        v-bind="field" @update:model-value="field" v-on:keyup="async () => {
                                                await validate();
                                            }
                                            " v-on:keypress="checkNumeric" />
                                            <ErrorMessage v-if="errors.end_number"
                                        class="subtext p-error absolute pt-6 p-invalid white-space-nowrap"
                                        name="end_number" />
                                </Field>
                                <ButtonClearCommon v-if="storeUser.getParamSearch.end_number" :clearInput="() => clearInput('storeUser.getParamSearch.end_number') " />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="text-field-search">項目指定（日付項目）</span>
                    <div class="grid align-items-center">
                        <div class="col-3">
                            <div class="p-inputgroup">
                                <div class="p-inputgroup flex-1">
                                    <Dropdown v-model="selectedDate" :options="DEFAULT.DATE_ITEM" placeholder="選択してください"
                                        optionLabel="label" class="w-full md:w-14rem" @change="handelSearchType" />
                                    <ButtonClearCommon v-if="selectedDate" :clearInput="() => clearInput('selectedDate')" />
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="p-inputgroup">
                                <Calendar v-model="startMonth" view="date" dateFormat="yy/mm/dd" class="calendar_search"
                                    showIcon :manualInput="false" :max-date="endMonth" @date-select="handleChangeToStart"
                                    :disabled="!selectedDate" @update:model-value="startMonth = $event" />
                                <ButtonClearCommon v-if="startMonth" :clearInput="() => clearInput('start_date')" />
                            </div>
                        </div>
                        <span class="mx-1">~</span>
                        <div class="col-3">
                            <div class="p-inputgroup">
                                <Calendar v-model="endMonth" view="date" dateFormat="yy/mm/dd" class="calendar_search"
                                    showIcon :manualInput="false" :min-date="startMonth" @date-select="handleChangeToEnd"
                                    :disabled="!selectedDate" @update:model-value="endMonth = $event" />
                                <ButtonClearCommon v-if="endMonth" :clearInput="() => clearInput('end_date')" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="text-field-search">項目指定（フラグ項目）</span>
                    <div class="grid align-items-center">
                        <div class="col-3">
                            <div class="p-inputgroup">
                                <Dropdown v-model="selectedFlag" :options="DEFAULT.FLAG_ITEM" placeholder="選択してください"
                                    optionLabel="label" class="w-full md:w-14rem" @change="handelSearchType" />
                                <ButtonClearCommon v-if="selectedFlag" :clearInput="() => clearInput('selectedFlag')" />
                            </div>
                        </div>
                        <div class="col-3 flex align-items-center">
                            <div class="px-4">
                                <RadioButton v-model="flagValue" inputId="ingredient1" name="有り" :disabled="!selectedFlag"
                                    value="1" @change="handelChangeFlag" />
                                <label for="ingredient1" class="ml-2 white-space-nowrap">有り</label>
                            </div>
                            <div class="px-4">
                                <RadioButton v-model="flagValue" inputId="ingredient2" name="有り" :disabled="!selectedFlag"
                                    value="0" @change="handelChangeFlag" />
                                <label for="ingredient2" class="ml-2 white-space-nowrap">無し</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="text-field-search">役職で探す</span>
                    <div class="grid align-items-center">
                        <div class="col-3">
                            <div class="p-inputgroup">
                                <Dropdown v-model="selectedFlag" :options="DEFAULT.ROLE_ITEM" placeholder="選択してください"
                                    optionLabel="label" class="w-full md:w-14rem" @change="handelSearchType" />
                                <ButtonClearCommon v-if="selectedFlag" :clearInput="() => clearInput('selectedFlag')" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="reset_search flex justify-content-center align-items-center mt-2">
                    <Button class="p-button-sm white-space-nowrap refresh" icon="pi pi-refresh" @click="reloadSearch()"
                        label="クリア"></Button>
                </div>
            </div>
            </div>
            <DataTable :value="storeUser.getUsers" class="p-datatable-sm" ref="dt" tableStyle="min-width: 75rem"
                @row-click="gotToDetail($event)" :rowHover="true" responsive-layout="scroll">
                <Column style="padding-left:2rem; margin:auto" v-for="col in columns" :key="col.field" :field="col.field"
                    :header="col.header" :sortable="true"></Column>
                <Column headerStyle=" text-align: center" bodyStyle="text-align: center; overflow: visible">
                    <template #body="slotProps">
                        <Button class="p-button-danger p-button-sm white-space-nowrap" icon="pi pi-trash"
                            v-if="slotProps.data.email !== storeUser.getProfile.email"
                            @click="deleteUser(slotProps.data.id)" :label="t('common.delete')"></Button>
                    </template>
                </Column>
                <template #empty>
                    <div class="text-center">{{ $t('user.userNotFound') }}</div>
                </template>
                <template #loading>
                    {{ $t('user.userLoading') }}
                </template>
                <template #header>
                    <div class="flex justify-content-between align-items-center">
                        <span class="p-input-icon-left w-5">
                            <i class="pi pi-search"></i>
                            <InputText class="w-full" :placeholder="$t('common.search')" />
                        </span>
                        <div>
                            <Button class="white-space-nowrap" @click="gotToCreate" icon="pi pi-plus"
                                :label="t('user.userRegister')"></Button>
                        </div>
                    </div>
                </template>
                <template #footer>
                    <Paginator v-if="storeUser.getPagination.total > 0"
                        :first="(storeUser.getPagination.currentPage - 1) * storeUser.getPagination.perPage"
                        :rows="storeUser.getPagination.perPage" :totalRecords="storeUser.getPagination.total"
                        template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                        :currentPageReportTemplate="AppConstant.CURRENT_PAGE_REPORT_TEMPLATE" @page="changePage">
                    </Paginator>
                </template>
            </DataTable>
        
        <Popup ref="modal" :labelCancel="t('common.no')" :labelOk="t('common.yes')" :header="t('common.confirm')"
            :content="t('common.popupDeleteContent')" :ok="confirm" :cancel="cancel"></Popup>
    </div>
</template>
<script setup lang="ts">
import { PrimeIcons, FilterMatchMode, FilterOperator } from 'primevue/api';
import Paginator from 'primevue/paginator';
import TitleCommon from "@/components/common/TitleCommon.vue"
import Popup from "@/components/PopupConfirm.vue";
import ButtonClearCommon from "@/components/common/ButtonClearCommon.vue";
import { useUserStore } from "@/stores/user";
import FooterCommon from "@/components/common/FooterCommon.vue";
import { ref, onMounted, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import CONST, { AppConstant, DEFAULT } from "@/const";
import { Field, ErrorMessage, useForm } from "vee-validate";
import { useToast } from "primevue/usetoast";
import { useI18n } from "vue-i18n";
import * as yup from "yup";
import { number } from "yup";
import { format } from "date-fns";
const router = useRouter();
const storeUser = useUserStore();
const totalRecords = ref();
const idUser = ref(0);
const toast = useToast();
const { t } = useI18n();
const selectedNumbericType = ref();
const selectedDate = ref();
const startMonth = ref();
const endMonth = ref();
const selectedFlag = ref();
const flagValue = ref();
const columns = [
    { field: 'id', header: 'ID' },
    { field: 'name', header: '氏名' },
    { field: 'email', header: 'メールアドレス' },
    { field: 'role', header: '権限設定' },
    { field: 'created_at', header: '登録日' },
    { field: 'status', header: '状態' },
];

const schema = yup.object({
    start_number: yup
        .number()
        .transform((value, origin) => (value === "" || origin === "" ? 0 : value))
        .typeError(t("message.requiredNumber"))
        .nullable()
        .test("name", t("message.validateStartNumber"), (value, ctx) => {
            return value && ctx.parent.end_number
                ? value < ctx.parent.end_number
                : true;
        }),
    end_number: yup
        .number()
        .transform((value, origin) => (value === "" || origin === "" ? 0 : value))
        .typeError(t("message.requiredNumber"))
        .nullable(),
});
const { values, errors, validate } = useForm({
    validationSchema: schema,
});
function gotToDetail(event: any) {
    router.push(`/user/${event.data.id}/update`);
}
const gotToCreate = () => {
    router.push(`/user/create`);
}
const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});
const modal = ref<InstanceType<typeof Popup> | null>(null);
const openModal = () => {
    modal.value?.open();
};
const closeModal = () => {
    modal.value?.close();
};
const deleteUser = (event: any) => {
    idUser.value = event;
    modal.value?.open();
};
const changePage = async (event: any) => {
    storeUser.getListUser(event.page + 1);
};
const confirm = async () => {
    try {
        closeModal();
        const res = await storeUser.deleteUser(idUser.value);
        toast.add({ group: "message", severity: "success", summary: res.data.message, life: CONST.TIME_DELAY, closable: false });
    } catch (e) {
        console.log(e);
        closeModal();
    }
}
const cancel = () => {
    closeModal();
}
const downloadCSV = async (type: number, name: string, ext: string) => {
    console.log(1)
};

const checkNumeric = (event: any) => {
  const keyCode = event.keyCode;
  if (keyCode < 48 || keyCode > 57) {
    event.preventDefault();
  }
};
const handelSearchType = async () => {
  if (selectedNumbericType.value) {
    storeUser.getParamSearch.numberic_type =
      selectedNumbericType.value.value;
  } else if (selectedDate.value) {
    storeUser.getParamSearch.date_type = selectedDate.value.value;
  } else if (selectedFlag.value) {
    storeUser.getParamSearch.flag_type = selectedFlag.value.value;
  }
};
const handelChangeFlag = async () => {
  storeUser.getParamSearch.flag_type = selectedFlag.value.value;
  storeUser.getParamSearch.flag_value = flagValue.value;
  storeUser.getListUser();
};
watch(
  () => storeUser.getParamSearch.start_number,
  (value) => {
    setTimeout(function () {
      if (
        value === storeUser.getParamSearch.start_number &&
        !errors.value.start_number
      ) {
        storeUser.getListUser();
      }
    }, 1000);
  }
);
watch(
  () => storeUser.getParamSearch.end_number,
  (value) => {
    setTimeout(function () {
      if (
        value === storeUser.getParamSearch.end_number &&
        !errors.value.end_number
      ) {
        storeUser.getListUser();
      }
    }, 1000);
  }
);
watch(
  () => storeUser.getParamSearch.search_text,
  (value) => {
    setTimeout(function () {
      if (value === storeUser.getParamSearch.search_text) {
        storeUser.getListUser();
      }
    }, 1000);
  }
);

const handleChangeToStart = async () => {
    storeUser.getParamSearch.start_date = format(
      new Date(startMonth.value),
      CONST.FORMAT_DATE
    );
    storeUser.getListUser();
  
};
const handleChangeToEnd = async () => {
    storeUser.getParamSearch.end_date = format(
      new Date(endMonth.value),
      CONST.FORMAT_DATE
    );
    storeUser.getListUser();
};
const reloadSearch = () => {
  const { getParamSearch }: any = storeUser;
  Object.keys(getParamSearch).forEach(
    (key) => (getParamSearch[key] = undefined)
  );
  [
    startMonth,
    endMonth,
    selectedDate,
    selectedNumbericType,
    selectedFlag,
    flagValue,
  ].forEach((input) => (input.value = null));
  storeUser.getListUser();
};
const clearInput = (inputName: any) => {
  if (inputName === "start_date") {
    startMonth.value = "";
    storeUser.getParamSearch.start_date = null;
    storeUser.getListUser();
  } else if (inputName === "end_date") {
    storeUser.getParamSearch.end_date = null;
    endMonth.value = "";
    storeUser.getListUser();
  } else if (inputName === "selectedNumbericType") {
    selectedNumbericType.value = "";
    storeUser.getParamSearch.numberic_type = undefined;
    storeUser.getParamSearch.start_number = undefined;
    storeUser.getParamSearch.end_number = undefined;
    storeUser.getListUser();
  } else if (inputName === "selectedDate") {
    selectedDate.value = "";
    storeUser.getParamSearch.date_type = undefined;
    storeUser.getParamSearch.start_date = undefined;
    storeUser.getParamSearch.end_date = undefined;
    startMonth.value = "";
    endMonth.value = "";
    storeUser.getListUser();
  } else if (inputName === "storeUser.getParamSearch.search_text") {
    storeUser.getParamSearch.search_text = "";
    storeUser.getListUser();
  } else if (inputName === "selectedFlag") {
    storeUser.getParamSearch.flag_type = undefined;
    storeUser.getParamSearch.flag_value = undefined;
    flagValue.value = null;
    selectedFlag.value = "";
    storeUser.getListUser();
  } else if (inputName === "storeUser.getParamSearch.start_number") {
    storeUser.getParamSearch.start_number = undefined;
    storeUser.getListUser();
  } else if (inputName === "storeUser.getParamSearch.end_number") {
    storeUser.getParamSearch.end_number = undefined;
    storeUser.getListUser();
  }
};
onMounted(
    () => {
        storeUser.getListUser();
        storeUser.getProfileDetail();
    }
)
</script>
<style scoped>
.table-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.product-image {
    width: 50px;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
}

span.text-field-search {
    font-weight: bold;
}

h5.m-0 {
    font-size: 26px;
    font-weight: 600;
}

.dowload-file-admin {
    display: flex;
    justify-content: end;
}
.lighten-4.rounded{
    border: grey;
    border-radius: 0.5rem;
    box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.02), 0px 0px 2px rgba(0, 0, 0, 0.05), 0px 1px 4px rgba(0, 0, 0, 0.08);
    margin-bottom: 30px;
}
</style>
