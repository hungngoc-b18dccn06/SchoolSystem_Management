<script setup lang="ts">
import CommonLayout from "@/layout/CommonLayout.vue";
import { RouterView } from "vue-router";

</script>

<template>
  <CommonLayout>
    <template #main>
      <router-view />
    </template>
  </CommonLayout>
</template>
