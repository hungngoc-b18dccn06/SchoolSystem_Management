<template>
  <div>
    <Dialog
      class="dialog-entry"
      :draggable="false"
      :modal="true"
      v-model:visible="display"
      :style="{ width: width ?? '420px' }"
    >
      <template #header>
        <div
          class="header-dialog w-full flex justify-content-center text-xl font-semibold ml-4"
        >
          {{ header }}
        </div>
      </template>
      <p v-if="confirm" class="confirm">{{ confirm }}</p>
      <p class="content text-base" v-html="$t(content)"></p>

      <template #footer v-if="labelCancel && labelOk">
        <div class="flex justify-content-center">
          <Button
            v-if="labelCancel"
            :label="labelCancel"
            @click="close"
            class="btn-cancel p-button-secondary mx-3"
            icon="pi pi-times"
          />
          <Button
            v-if="labelOk"
            :label="labelOk"
            @click="ok"
            class="mx-3 btn-confirm"
            icon="pi pi-check"
          />
        </div>
      </template>
    </Dialog>
  </div>
</template>

<script lang="ts" setup>
import { ref } from "vue";

const props = defineProps<{
  header?: string;
  confirm?: string;
  content: string;
  labelOk?: string;
  labelCancel?: string;
  width?: string;
  ok?: () => void;
  cancel?: () => void;
}>();

const display = ref(false);
const open = () => {
  display.value = true;
};
const close = () => {
  display.value = false;
};

defineExpose({
  open,
  close,
});
</script>

<style lang="scss" scoped>
.content {
  text-align: center;
  margin-top: 10px;
}
.confirm {
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
  font-weight: 700;
}
:deep(.p-button .p-button-label) {
  width: 200px !important;
}
.p-button {
  border-color: transparent !important;
}
.btn-cancel {
  background-color: #475569 !important;
  color: black;
}
.btn-confirm {
  background-color: #2b9dca !important;
  color: white;
}
:deep(span.pi.pi-check.p-button-icon.p-button-icon-left){
  padding-left: 25px;
}
:deep(.p-button .p-button-label){
  display: flex !important;
}
:deep(button.p-button.p-component.btn-cancel.mx-3){
  padding-left: 30px !important;
}
</style>
