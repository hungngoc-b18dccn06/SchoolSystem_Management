<template>
  <div>
    <div class="grid mx-0 p-2 mt-4">
      <div class="col-11">Category List</div>
      <div class="col-11">
        <Card id="custom" class="border-none pb-5">
          <template #content>
            <DataTable
              :value="categoryStore.getCategoryList"
              :reorderableColumns="true"
              @rowReorder="handleReorder"
              responsiveLayout="scroll"
            >
              <Column
                :rowReorder="true"
                style="width: 3rem"
                class="text-center"
                :reorderableColumn="false"
              />
              <Column
                v-for="col of columns"
                :field="col.field"
                :key="col.field"
              >
                <template #body="slotProps">
                  <div class="flex justify-content-between align-items-center">
                    <InputText
                      type="text"
                      v-model="slotProps.data.name"
                      class="w-full"
                    />
                    <div class="flex align-items-center">
                      <InputSwitch
                        class="ml-5 mr-3"
                        v-model="slotProps.data.is_valid"
                        :trueValue="1"
                        :falseValue="0"
                      />
                      <Button
                        icon="pi pi-trash"
                        class="
                          p-button-sm
                          p-button-rounded
                          p-button-danger
                          p-button-text
                        "
                        @click="handleDelete(slotProps.index)"
                      />
                    </div>
                  </div>
                </template>
              </Column>
            </DataTable>
            <Button
              class="p-button-sm mt-3 ml-3"
              label="追加"
              icon="pi pi-plus"
              iconPos="left"
              @click="handleAdd()"
            />
          </template>
        </Card>
        <Toast />
      </div>
    </div>
    <FooterCommon
      labelSubmit="登録する"
      labelCancel="キャンセル"
      :submit="handleSubmit"
      :cancel="handleBack"
    />
    <Popup
      ref="modal"
      :labelCancel="'いいえ'"
      :labelOk="'はい'"
      :confirm="'Confirm'"
      content="Confirm?"
      :ok="confirmSubmit"
      :cancel="closeModal"
    ></Popup>
  </div>
</template>
<script setup lang="ts">
import { useCategoryStore, type CategoryDetail } from "@/stores/category";
import { useToast } from "primevue/usetoast";
import CONST from "@/const";
import { onMounted, ref, reactive } from "vue";
import Popup from "@/components/PopupConfirm.vue";
import FooterCommon from "@/components/common/FooterCommon.vue";

const toast = useToast();
const modal = ref<InstanceType<typeof Popup> | null>(null);
const columns = [{ field: "name" }];

const categoryStore = useCategoryStore();

const handleReorder = (event: any) => {
  // Swap
  const temp = categoryStore.getCategoryList[event.dragIndex];
  categoryStore.getCategoryList[event.dragIndex] = categoryStore.getCategoryList[event.dropIndex]
  categoryStore.getCategoryList[event.dropIndex] = temp;

  categoryStore.getCategoryList.map( (e, index: number) => ({
    ...e,
    display_order: index + 1
  }));
};
const handleAdd = (index) => {
  const data = {
    display_order: categoryStore.getCategoryList.length + 1,
    category: "家族",
    name: "",
    is_valid: 1,
  }
  categoryStore.getCategoryList.push(data);
};
const handleDelete = (index) => {
  categoryStore.getCategoryList = categoryStore.getCategoryList.splice(index, 1);
};

const handleBack = () => {
  alert("Back");
  // router.push(`${PAGE_ROUTE.HOME}`);
};

const handleSubmit = () => {
  modal.value?.open();
};
const confirmSubmit = async () => {
  const data: CategoryDetail = {
    corners: [...categoryStore.getCategoryList]
  };
  try {
    await categoryStore.apiUpdateCategories(data);
    toast.add({severity: "success", summary: "Success", life: CONST.TIME_DELAY});
  } catch (e) {
    toast.add({severity: "error", summary: "Error", life: CONST.TIME_DELAY});
  }
  modal.value?.close();
};

onMounted(async () => {
  await categoryStore.apiGetCategories();
});
</script>

<style lang="scss" scoped>
::v-deep .p-card {
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

// ::v-deep .p-inputswitch {
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

::v-deep #custom {
  padding: 8px 30px 8px 21px;
}

::v-deep .p-datatable .p-datatable-thead {
  display: none;
}

::v-deep .p-datatable .p-datatable-tbody > tr > td {
  padding: 13px 3px 13px 0px;
}

::v-deep .p-datatable .p-datatable-tbody tr:last-child td {
  border-bottom: none;
}

::v-deep .p-datatable .p-datatable-tbody span:hover {
  cursor: pointer;
}

.p-button.p-button-text {
  background-color: #0085ff;
  color: #fff;
  margin: auto;
}
</style>