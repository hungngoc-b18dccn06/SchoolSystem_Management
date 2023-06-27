<template>
  <div class="p-inputgroup-addon">
    <div class="input-wrapper">
      <Button
        v-if="true"
        icon="pi pi-times"
        class="p-button-rounded p-button-text"
        :placeholder="placeholder"
        :inputValue="inputValue"
        @click="clearInput"
      />
    </div>
  </div>
</template>

<script lang="ts" setup>
import InputText from 'primevue/inputtext';
import { ref } from "vue";
const props = defineProps<{
  inputValue?: string;
  placeholder?: string;
  clearInput?: () => void;
}>();
</script>

<style lang="scss" scoped>
.p-inputgroup-addon {
  position: absolute;
  top: 1px;
  right: 1px;
  z-index: 1;
  border: #fff;
  background: #fff;
  padding: 0px;
  margin: 0;
  height: calc(100% - 3px) !important;
}

.p-inputgroup-addon:last-child {
  border-right: 0;
}

.input-wrapper {
  height: 100%;
}

:deep .p-button.p-button-icon-only.p-button-rounded{
  height: 100%;
  padding: 0;
}
button:hover {
  background-color: none;
}
button.p-button.p-component.p-button-icon-only.p-button-rounded.p-button-text:hover {
    background: none;
}

</style>