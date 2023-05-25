<script setup lang="ts">
import { RouterView } from "vue-router";
import { useRequestStore } from "@/stores/request";
import { useToast } from "primevue/usetoast";
import { watch } from "vue";
const toast = useToast();
const requestStore = useRequestStore();
watch(
  () => requestStore.error,
  (newValue) => {
    if (!newValue) {
      return;
    }
    const message: any = newValue?.response?.data;
    toast.add({
      severity: "error",
      summary: message.errors ? message.errors[Object.keys(message.errors)[0]][0] : message.message,
      life: 3000,
      group: "message",
      closable: false,
      contentStyleClass: "py-1",
    });
  }
);
watch(
  () => requestStore.getIsFetcing.length,
  (newValue) => (document.body.style.overflowY = newValue ? "hidden" : ""),
);
</script>
<template>
  <div
    v-if="requestStore.getIsFetcing.length"
    class="absolute w-screen h-screen flex align-items-center justify-content-center"
    style="z-index: 99999999"
  >
    <div
      class="w-screen h-screen"
      style="background-color: black; opacity: 0.15"
    ></div>
    <ProgressSpinner class="absolute z-1" />
  </div>
  <Toast group="message" position="top-center">
      <template #message="slotProps">
        <i v-if="slotProps.message.severity == 'error'" class="p-toast-message-icon pi pi-times"></i>
        <i v-if="slotProps.message.severity == 'success'" class="p-toast-message-icon pi pi-check"></i>
        <div class="p-toast-message-text">
          <span class="p-toast-summary">{{ slotProps.message.summary }}</span>
        </div>
      </template>
    </Toast>
  <RouterView />
</template>
<style scoped>
header {
  line-height: 1.5;
  max-height: 100vh;
}

.logo {
  display: block;
  margin: 0 auto 2rem;
}

nav {
  width: 100%;
  font-size: 12px;
  text-align: center;
  margin-top: 2rem;
}

nav a.router-link-exact-active {
  color: var(--color-text);
}

nav a.router-link-exact-active:hover {
  background-color: transparent;
}

nav a {
  display: inline-block;
  padding: 0 1rem;
  border-left: 1px solid var(--color-border);
}

nav a:first-of-type {
  border: 0;
}
.p-progress-spinner {
  width: 64px;
}
:deep(.p-progress-spinner-circle) {
  stroke: #f4f4f4;
  stroke-width: 4;
  animation: p-progress-spinner-dash 1.5s ease-in-out infinite;
}
.h-screen {
  height: 100vh;
  position: fixed;
}
@media (min-width: 1024px) {
  header {
    display: flex;
    place-items: center;
    padding-right: calc(var(--section-gap) / 2);
  }

  .logo {
    margin: 0 2rem 0 0;
  }

  header .wrapper {
    display: flex;
    place-items: flex-start;
    flex-wrap: wrap;
  }

  nav {
    text-align: left;
    margin-left: -1rem;
    font-size: 1rem;

    padding: 1rem 0;
    margin-top: 1rem;
  }
}
</style>
