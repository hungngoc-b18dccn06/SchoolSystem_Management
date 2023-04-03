<script setup lang="ts">
    import ListTeacher from "@/components/teacher/List.vue";
</script>

<template>
    <ListTeacher>
        <template #main>
            <router-view />
        </template>
    </ListTeacher>
</template>
<style lang="scss"></style>
