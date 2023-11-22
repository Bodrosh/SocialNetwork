<template>
    <button
        :class="[
            'inline-flex items-center px-4 py-2 border border-transparent rounded-full font-semibold text-xs uppercase tracking-widest active:bg-gray-900 focus:outline-none transition ease-in-out duration-150',
            isLight ? 'bg-white border-gray-800 text-gray-800 hover:bg-gray-50' : 'bg-gray-800 text-white hover:bg-gray-700'
        ]"
    >
        <slot />
    </button>
</template>
<script setup>
    defineProps({
        isLight: {
            default: false,
            type: Boolean
        }
    })
</script>
