<template>
  <div>
    <div class="title-page flex justify-content-between align-center mt-1 mb-4">
      <p class="content" style="font-weight: bold !important">{{ title }}</p>
      <Button
        v-if="props.buttonLabel"
        class="white-space-nowrap"
        @click="handleClick"
        :icon="props.buttonIcon"
        :label="props.buttonLabel"
      ></Button>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { ref } from "vue";
const props = defineProps<{
  title?: string;
  buttonLabel?: string;
  buttonIcon?: string;
  buttonClick?: () => void;
}>();

const handleClick = () => {
  if (props.buttonClick) {
    props.buttonClick();
  }
};
</script>

<style lang="scss" scoped>
.content {
  font-size: 25px;
  font-weight: bold;
  color: black;
}
</style>
