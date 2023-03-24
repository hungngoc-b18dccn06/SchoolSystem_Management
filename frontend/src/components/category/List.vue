<template>
  <div>
    <TitleCommon :title="t('page.categoryList')" />
    <div class="grid mx-0 mt-4" >
      <div class="col-11 px-0">
        <Card id="custom" class="border-none pb-5 m-0">
          <template #content>
            <DataTable
              v-if="categoryStore.getCategoryList.length"
              :value="categoryStore.getCategoryList"
              :reorderableColumns="true"
              @rowReorder="handleReorder"
              item-key="name"
              responsiveLayout="scroll"
            >
              <Column
                :rowReorder="true"
                style="width: 3rem"
                class="text-center vertical-align-top icon-move"
                :reorderableColumn="false"
              />
              <Column
                v-for="col of columns"
                :field="col.field"
                :key="col.field"
              >
                <template #body="slotProps">
                  <div class="flex justify-content-between">
                    <div class="w-full">
                      <Field
                        :class="{
                          'is-invalid':
                            errors[`categories[${slotProps.index}].name`],
                        }"
                        :name="`categories[${slotProps.index}].name`"
                        v-slot="{ field, value }"
                        v-model="slotProps.data.name"
                      >
                        <InputText
                          ref="inputCategory"
                          v-bind="field"
                          :class="{
                            'p-invalid':
                              errors[`categories[${slotProps.index}].name`],
                          }"
                          :value="getName(slotProps.data)"
                          @input="setName(slotProps.data, ($event.target as HTMLInputElement).value)"
                          validate-on-blur
                          type="text"
                          :modelValue="value"
                          class="w-full"
                        />
                        <ErrorMessage
                          class="subtext p-error"
                          :name="`categories[${slotProps.index}].name`"
                        />
                      </Field>
                    </div>
                    <div class="flex">
                      <InputSwitch
                        class="ml-5 mr-3 mt-2"
                        v-model="slotProps.data.status"
                        :trueValue="1"
                        :falseValue="0"
                      />
                      <Button class="p-button-danger p-button-sm white-space-nowrap mt-1" icon="pi pi-trash" @click="handleDelete(slotProps.index)" :label="t('common.delete')"></Button>
                    </div>
                  </div>
                </template>
              </Column>
            </DataTable>
            <Button
              class="mt-3 ml-6"
              label="追加"
              icon="pi pi-plus"
              iconPos="left"
              @click="handleAddButton"
              v-on:keydown.enter.prevent=''
              v-on:keydown.space.prevent=''
            />
          </template>
        </Card>
        <Toast />
      </div>
    </div>
    <FooterCommon
      :labelSubmit="t('common.register')"
      :labelCancel="t('common.back')"
      :submit="handleSubmit"
      :cancel="handleBack"
    />
    <Popup
      ref="modal"
      :labelCancel="t('common.no')"
      :labelOk="t('common.yes')"
      :header="t('common.confirm')"
      :content="contentPopup"
      :ok="confirmSubmit"
      :cancel="closeModal"
    ></Popup>
  </div>
</template>
<script setup lang="ts">
import { useCategoryStore, type CategoryDetail } from "@/stores/category";
import CONST from "@/const";
import { onMounted, ref, reactive, nextTick} from "vue";
import * as yup from "yup";
import { Field, ErrorMessage, useForm } from "vee-validate";
import Popup from "@/components/PopupConfirm.vue";
import TitleCommon from "@/components/common/TitleCommon.vue";
import FooterCommon from "@/components/common/FooterCommon.vue";
import PAGE_ROUTE from "@/const/pageRoute";
import router from "@/router";
import { useI18n } from "vue-i18n";
import {useToast} from "primevue/usetoast";
const modal = ref<InstanceType<typeof Popup> | null>(null);
const columns = [{ field: "name" }];
const { t } = useI18n();

const toast = useToast();
const categoryStore = useCategoryStore();
const indexDelete = ref(-1);
const contentPopup = ref('');
const inputCategory = ref<any>([]);
const getName = (item: CategoryDetail) => {
  return item.name || '';
};

const setName = (item: CategoryDetail, value: string) => {
  item.name = value.trim();
};
const schema = yup.object({
  categories: yup
    .array()
    .of(
      yup.object().shape({
        name: yup
          .string()
          .trim()
          .test('unique-names', t('message.categoryDuplicate'), function(value) {
            return categoryStore.getCategoryList.filter(el => el.name.trim() === (value ?? "").trim()).length <= 1;
          })
          .max(100, t('message.maxLength100'))
          .required(t('message.required')),
      })
    )
    
});

const { resetForm, values, errors, validate } = useForm({
  validationSchema: schema,
});

const closeModal = () => {
  indexDelete.value = -1;
  modal.value?.close();
};

const handleReorder = (event: any) => {
  // Swap
  const temp = categoryStore.getCategoryList[event.dragIndex];
  categoryStore.getCategoryList[event.dragIndex] =
    categoryStore.getCategoryList[event.dropIndex];
  categoryStore.getCategoryList[event.dropIndex] = temp;

  categoryStore.setCategoryList(categoryStore.getCategoryList.map((e, index: number) => ({
    ...e,
    display_order: index + 1,
  })));

};
const handleAddButton = () => {
  categoryStore.getCategoryList.push({
    display_order: categoryStore.getCategoryList.length + 1,
    name: "",
    status: 1,
  });
}
const handleDelete = async (index: number) => {
  indexDelete.value = index;
  contentPopup.value = t('common.popupDeleteContent');
  modal.value?.open();
};

const handleBack = () => {
  router.back();
};

const handleSubmit = async () => {
  const validateValue = await validate();
  if (!validateValue.valid) return;
  indexDelete.value = -1;
  contentPopup.value = t('common.popupConfirmSaveContent');
  modal.value?.open();
};
const confirmSubmit = async () => {
  try {
    modal.value?.close();
    if (indexDelete.value != -1) {
      const id = categoryStore.getCategoryList[indexDelete.value]?.id;
      if (id) {
        const res = await categoryStore.apiDeleteCategories(id);
        toast.add({group: "message", severity: "success", summary: res.data.message, life: CONST.TIME_DELAY,  closable: false});
      }
      categoryStore.getCategoryList.splice(indexDelete.value, 1);
    } else {
      const data: any = {
        categories: [...categoryStore.getCategoryList],
      };
      const res = await categoryStore.apiUpdateCategories(data);
      toast.add({group: "message", severity: "success", summary: res.data.message, life: CONST.TIME_DELAY,  closable: false});
    }
  } catch (e) {
    console.log(e);
  }
};

onMounted(async () => {
  await categoryStore.apiGetCategories();
});
</script>

<style lang="scss" scoped>
:deep(.p-card) {
  border: 0.5px solid rgba(142, 142, 169, 0.8);
  box-shadow: 0px 1px 6px rgba(0, 0, 0, 0.102);
  border-radius: 10px;
  margin-left: 76px;

  .p-card-body {
    padding: 0;

    .p-card-content {
      padding: 0;

      ul {
        padding: 15px 34px 0px 24px;

        li {
          margin: 0;
          padding: 12px 0px 12px 0px;
          border-bottom: 0.5px solid rgba(142, 142, 169, 0.8);

          &:last-child {
            padding-bottom: 22px;
            border: none;

            span {
              font-weight: 400;
              font-size: 16px;
              line-height: 22px;
            }
          }
        }
      }
    }
  }
}
.p-error { 
  position: relative;
}
.label {
  margin-left: 40px;
  margin-bottom: 32px;
  font-size: 18px;
  font-weight: 700px;
}

.label h2 {
  font-size: 18px;
  font-weight: 700px;
}

.label img {
  margin-right: 36px;
}

// :deep( .p-inputswitch ) {
//   width: 37px;
//   height: 19.25px;
//   background: #4662d1;
//   border-radius: 63.5136px;

//   .p-inputswitch-slider {
//     &:before {
//       width: 16px;
//       left: 0px;
//       height: 17px;
//       top: 11px;
//     }
//   }
// }

:deep(#custom) {
  padding: 8px 30px 8px 21px;
}

:deep(.p-datatable) {

  .p-datatable-wrapper {
    box-shadow: none;
  }
  .p-datatable-thead {
    display: none;
  }
  .p-datatable-tbody {
    tr {
      background: #fff !important;
    }
    > tr > td {
      padding: 13px 3px 13px 0px;
    }

    tr:last-child td {
      border-bottom: none;
    }

    span:hover {
      cursor: pointer;
    }
  }
}

.p-button.p-button-text {
  background-color: #0085ff;
  color: #fff;
  margin: auto;
}
:deep(.p-inputtext:focus),
.p-inputtext:hover{
  background-color: transparent !important;
  box-shadow: none;
}
input.p-inputtext.p-component.p-filled.w-full, input.p-inputtext.p-component.p-invalid.w-full,input.p-inputtext.p-component.w-full{
  border-color:#6c757d !important;
  background-color: transparent !important;
  box-shadow: none;

}
::v-deep .icon-move i{
  margin-top: 13px;
}
</style>
