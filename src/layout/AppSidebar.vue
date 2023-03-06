<template>
  <ul v-if="items">
    <template v-for="(item, i) of items">
      <li
        v-if="visible(item) && !item.separator"
        :key="item.label || i"
        :class="[
          {
            'layout-menuitem-category': root,
            'active-menuitem':
              (activeIndex === i && !item.to && !item.disabled) ||
              showMenu(item, i),
          },
        ]"
        role="none"
      >
        <template v-if="root">
          <div class="layout-menuitem-root-text" :aria-label="item.label">
            {{ item.label }}
          </div>
          <app-sub-menu
            :items="visible(item) && item.items"
            @menuitem-click="emit('menuitem-click', $event)"
          ></app-sub-menu>
        </template>
        <template v-else>
          <router-link
            v-if="item.to"
            :to="item.to"
            :class="[
              item.class,
              'p-ripple',
              { 'p-disabled': item.disabled },
              { 'custom-select': router.path === item.to },
            ]"
            :style="item.style"
            @click="onMenuItemClick($event, item, i)"
            :target="item.target"
            :aria-label="item.label"
            exact
            role="menuitem"
            v-ripple
          >
            <i :class="item.icon"></i>
            <span>{{ item.label }}</span>
            <i
              v-if="item.items"
              class="pi pi-fw pi-angle-down menuitem-toggle-icon"
            ></i>
            <p-badge v-if="item.badge" :value="item.badge"></p-badge>
          </router-link>
          <a
            v-if="!item.to"
            :href="item.url || '#'"
            :style="item.style"
            :class="[item.class, 'p-ripple', { 'p-disabled': item.disabled }]"
            @click="onMenuItemClick($event, item, i)"
            :target="item.target"
            :aria-label="item.label"
            role="menuitem"
            v-ripple
          >
            <i :class="item.icon"></i>
            <span>{{ item.label }}</span>
            <i
              v-if="item.items"
              class="pi pi-fw pi-angle-down menuitem-toggle-icon"
            ></i>
            <p-badge v-if="item.badge" :value="item.badge"></p-badge>
          </a>
          <Transition name="layout-submenu-wrapper">
            <app-sub-menu
              v-show="activeIndex === i || showMenu(item, i)"
              :items="visible(item) && item.items"
              @menuitem-click="emit('menuitem-click', $event)"
            ></app-sub-menu>
          </Transition>
        </template>
      </li>
      <li
        class="p-menu-separator"
        :style="item.style"
        v-if="visible(item) && item.separator"
        :key="'separator' + i"
        role="separator"
      ></li>
    </template>
  </ul>
</template>

<script lang="ts">
export default {
  name: "app-sub-menu",
};
</script>
<script setup lang="ts">
import { ref } from "vue";
import { useRoute } from "vue-router";
import type { MenuItem } from "primevue/menuitem";
defineProps<{
  items?: MenuItem;
  root?: boolean;
}>();
const activeIndex = ref<keyof MenuItem | null>(null);
const emit = defineEmits(["menuitem-click"]);
const loadPage = ref<boolean>(true);
const router = useRoute();
const onMenuItemClick = (
  event: Event,
  item: MenuItem,
  index: keyof MenuItem
) => {
  if (item.disabled) {
    event.preventDefault();
    return;
  }
  if (!item.to && !item.url) {
    event.preventDefault();
  }
  //execute command
  if (item.command) {
    item.command({ originalEvent: event, item: item });
  }
  activeIndex.value = index === activeIndex.value ? null : index;
  emit("menuitem-click", {
    originalEvent: event,
    item: item,
  });
  loadPage.value = false;
};
const visible = (item: MenuItem) => {
  return typeof item.visible === "function"
    ? item.visible()
    : item.visible !== false;
};
const showMenu = (item: MenuItem, index: keyof MenuItem): boolean => {
  if (!loadPage.value) return false;
  let result = true;
  if (item?.to === router.path) {
    return true;
  } else if (item?.items !== undefined) {
    for (let i of item.items) {
      result = result && !showMenu(i, index);
    }
  }
  if (!result) {
    activeIndex.value = index;
    return true;
  } else {
    return false;
  }
};
</script>
<style lang="scss">
.custom-select {
  outline: 0 none;
  outline-offset: 0;
  background-color: var(--vt-c-text-dark-2);
}
</style>