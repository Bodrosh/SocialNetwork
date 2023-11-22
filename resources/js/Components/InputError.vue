<script setup>
defineProps({
    message: {
        type: [String, Array],
    },
});
</script>

<template>
    <div v-if="message">
        <div v-if="typeof message === 'string'">
            <p class="text-sm text-red-600">
                {{ message }}
            </p>
        </div>
        <div v-else>
            <p v-for="singleMessage of message" class="text-sm text-red-600">
                {{ singleMessage }}
            </p>
        </div>

    </div>
</template>
