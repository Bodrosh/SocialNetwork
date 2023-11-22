<template>
    <div v-if="posts.length > 0">
        <div v-for="post of posts" class="p-4 mt-4 mb-4 border-2 border-gray-100 rounded-2xl">
            <PostListItem :post="post" />
        </div>
    </div>
    <div
        v-else
        class="p-4 mt-4 mb-4 border-2 border-gray-100 rounded-2xl"
    >
        Посты не найдены
    </div>
</template>

<script setup>
import PostListItem from "@/Components/Post/PostListItem.vue";

defineProps({
    posts: {
        required: true,
        type: Array
    }
})
</script>

<style scoped>

</style>
