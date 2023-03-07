<script setup lang="ts">
    import UpdateUser from "@/components/user/Update.vue";
</script>

<template>
    <UpdateUser>
        <template #main>
            <router-view />
        </template>
    </UpdateUser>
</template>
<style lang="scss"></style>
