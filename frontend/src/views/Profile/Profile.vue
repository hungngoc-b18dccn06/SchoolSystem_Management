<script setup lang="ts">
    import Profile from "@/components/profile/Profile.vue";
</script>

<template>
    <ListUser>
        <template #main>
            <router-view />
        </template>
    </ListUser>
</template>
<style lang="scss"></style>
