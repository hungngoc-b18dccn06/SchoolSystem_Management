<template>
  <div class="layout-wrapper layout-overlay" :class="openSidebar ? '' : 'close-sidebar'">
    <div class="layout-sidebar pa-1 shadow-2">
      <div class="layout-title flex justify-content-center align-items-center">
        <Image :src="logo" class="logo" @click="clickToHome()" style="cursor:pointer"></Image>
      </div>
      <app-side-bar :items="menu" :root="true" class="layout-menu" :index="1"/>
    </div>
    <div class="layout-main-container">
      <app-top-bar @toggleSidebar="toggleSidebar"/>
      <div class="layout-main">
        <div class="p-4 pb-8">
          <slot name="main"> </slot>
        </div>
      </div>
    </div>
</div>
</template>

<script setup lang="ts">
import logo from '@/assets/logo.png'
import {ref, onMounted} from "vue";
import {useRoute, useRouter} from "vue-router";
import AppTopBar from "@/layout/AppTopbar.vue";
import AppSideBar from "@/layout/AppSidebar.vue";
import AppFooter from "@/layout/AppFooter.vue";
import Menu from "@/const/menu.const";


const menu = Menu;
const route = useRoute();
const router = useRouter();
const openSidebar = ref(true);

const toggleSidebar = () => {
  openSidebar.value = !openSidebar.value;
}
const clickToHome = () => {
  router.push(`/`);
};
onMounted(async () => {
});

</script>

<style lang="scss">
.layout-wrapper {
  &.layout-overlay {
    &.close-sidebar { 
      --sidebar-width: 0px;
      .layout-sidebar * {
        display: none;
      }
    }
    .layout-main-container {
      width: 100%;
      display: flex;
      flex-direction: column;
      height: 100vh;
      max-height: 100vh;
      transition: margin-left 0.2s;
      background: #f7f9fb !important;

      .layout-main {
        width: auto;
        padding-top: var(--topbar-height);
        padding-left: var(--sidebar-width);
        background: var(--main-bg);
        min-height: 100vh;
      }
    }

    .layout-sidebar {
      position: fixed;
      width: var(--sidebar-width);
      flex: 0 0 var(--sidebar-width);
      height: calc(100vh);
      z-index: 999;
      overflow-y: auto;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      top: 0;
      left: 0;
      transition: transform 0.2s, left 0.2s, width .2s;
      background-color: var(--sidebar-bg);
      box-shadow: 0px 3px 5px rgb(0 0 0 / 2%), 0px 0px 2px rgb(0 0 0 / 5%),
        0px 1px 4px rgb(0 0 0 / 8%);

      .layout-title {
        display: flex;
        align-items: center;
        justify-content: center;
        height: var(--topbar-height);
        padding: 5px 0;

        .logo {
          height: 100%;
        }
      }
    }
  }

  .layout-mask {
    display: none;
  }

  @mixin focused-inset() {
    outline: 0 none;
    outline-offset: 0;
    background-color: var(--vt-c-text-dark-2);
  }

  .layout-menu {
    margin: 0;
    padding: 10px;
    width: var(--sidebar-width);

    ul {
      list-style-type: none;
    }

    li {
      &.layout-menuitem-category {
        margin-top: 0.2rem;

        &:first-child {
          margin-top: 0;
        }
      }

      .layout-menuitem-root-text {
        text-transform: uppercase;
        color: var(--surface-900);
        font-weight: 900;
        margin-bottom: 0.2rem;
        font-size: 0.875rem;
      }

      a {
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        color: var(--sidebar-color);
        transition: color 0.2s;
        font-weight: 900;
        font-size: var(--sidebar-fs);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: background-color 0.15s;
        
        .pi {
          font-weight: 700;
          font-size: 1.2rem;
        }

        span {
          font-weight: 700;
          margin-left: 0.5rem;
          margin-top: .2em;
        }

        .menuitem-toggle-icon {
          margin-left: auto;
        }

        &:focus {
          @include focused-inset();
        }

        &:hover {
          transition: box-shadow 0.2s;
          box-shadow: vinset var(--focus-ring);
          background: var(--sidebar-item-hover);
        }

        &.router-link-exact-active {
          font-weight: 900;
          font-size: 20px;
          color: var(--sidebar-color);
          background-color: var(--sidebar-item-active);
        }

        .p-badge {
          margin-left: auto;
        }
      }

      &.active-menuitem {
        >a {
          .menuitem-toggle-icon {
            &:before {
              content: "\e933";
            }
          }
        }
      }

      ul {
        list-style-type: none;
        margin: 0;
        padding: 0;

        .layout-submenu-wrapper-enter-from,
        .layout-submenu-wrapper-leave-to {
          max-height: 0;
        }

        .layout-submenu-wrapper-enter-to,
        .layout-submenu-wrapper-leave-from {
          max-height: 1000px;
        }

        .layout-submenu-wrapper-leave-active {
          overflow: hidden;
          transition: max-height 0.45s cubic-bezier(0, 1, 0, 1);
        }

        .layout-submenu-wrapper-enter-active {
          overflow: hidden;
          transition: max-height 1s ease-in-out;
        }

        ul {
          padding-left: 1rem;
        }
      }
    }
  }

  .p-card {
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
    padding: .25em .75em;
  }
}

.required:after {
    content: "必須";
    background-color: red;
    padding: 3px;
    margin-left: 0.5em;
    font-size: 10px;
    border-radius: 5px;
    color: #fff;
    font-weight: 600;
    white-space: nowrap;
}
</style>