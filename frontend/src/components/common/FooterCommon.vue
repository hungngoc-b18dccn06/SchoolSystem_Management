<template>
  <div class="layout-footer p-2 shadow-1">
    <Button
      class="p-button-secondary btn-action-back mr-3"
      :label="labelCancel"
      icon="pi pi-arrow-left"
      iconPos="left"
      @click="cancel"
    />
    <Button
      class="btn-action-save"
      :label="labelSubmit"
      icon="pi pi-save"
      iconPos="left"
      @click="submit"
    />
  </div>
</template>

<script lang="ts" setup>
const props = defineProps<{
  labelSubmit?: string;
  labelCancel?: string;
  submit?: () => void;
  cancel?: () => void;
}>();
</script>

<style scoped>
.layout-footer {
  position: fixed;
  display: flex;
  justify-content: center;
  background: #fff;
  width: calc(100% - var(--sidebar-width));
  bottom: 0;
  left: var(--sidebar-width);
  z-index: 10;
}
.btn-action-save {
}
.btn-action-back {
}
</style>
