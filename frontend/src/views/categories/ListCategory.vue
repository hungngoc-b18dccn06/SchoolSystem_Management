<script setup lang="ts">
    import ListUser from "@/components/category/List.vue";
</script>

<template>
    <ListUser>
        <template #main>
            <router-view />
        </template>
    </ListUser>
</template>
<style lang="scss"></style>
