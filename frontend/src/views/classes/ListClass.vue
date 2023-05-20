<script setup lang="ts">
    import ListClass from "@/components/classes/List.vue";
</script>

<template>
    <ListClass>
        <template #main>
            <router-view />
        </template>
    </ListClass>
</template>
<style lang="scss"></style>
