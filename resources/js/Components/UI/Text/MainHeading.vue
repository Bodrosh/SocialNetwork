<template>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{title}}</h2>
</template>

<script setup>
    defineProps({
        title: {
            type: String,
            required: true
        }
    })
</script>

<style scoped>

</style>
