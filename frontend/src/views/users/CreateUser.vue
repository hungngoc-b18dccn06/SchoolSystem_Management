<script setup lang="ts">
    import CreateUser from "@/components/user/Create.vue";
</script>

<template>
    <CreateUser>
        <template #main>
            <router-view />
        </template>
    </CreateUser>
</template>
<style lang="scss"></style>
