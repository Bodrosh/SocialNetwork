<template>
    <div
        v-if="data"
        class="p-4 mt-4 mb-4 border-2 border-gray-100 rounded-2xl flex justify-between text-center gap-2"
    >
        <div class="bg-amber-50 p-4 rounded-2xl w-1/4">
            Подписчики<br>
            {{ data.subscribers_count }}
        </div>
        <div class="bg-blue-50 p-4 rounded-2xl w-1/4">
            Лайки<br>
            {{ data.likes_count }}
        </div>
        <div class="bg-emerald-50 p-4 rounded-2xl w-1/4">
            Посты<br>
            {{ data.posts_count }}
        </div>
        <div class="bg-fuchsia-50 p-4 rounded-2xl w-1/4">
            Подписки<br>
            {{ data.followings_count }}
        </div>
    </div>
</template>

<script setup>
defineProps({
    data: {
        default: null
    }
})
</script>

<style scoped>

</style>
