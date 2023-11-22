<template>
    <div>
        <div>
            <Link :href="route('user.show', {user: post.user.id})">{{post.user.name}}</Link>
        </div>
        <div v-if="post.reposted_post" class="mb-4">
            <div class="flex justify-between bg-amber-100 p-4 rounded-2xl">
                <div class="w-2/3">
                    <h5 class="text-xl font-medium">{{post.reposted_post.title}}</h5>
                    <div>{{post.reposted_post.content}}</div>
                    <small>{{post.reposted_post.date}}</small>
                </div>
                <div class="w-1/3 flex justify-end items-center">
                    <img v-if="post.reposted_post.image_url"
                         :src="post.reposted_post.image_url"
                         alt=""
                    >
                </div>
            </div>
        </div>
        <div class="flex justify-between">
            <div class="w-2/3">
                <div class="flex justify-between">
                    <h5 class="text-xl font-medium">{{post.title}}</h5>
                    <div>
                        <span>{{post.likes_count}}</span>
                        <svg
                            @click="likePost(post)"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            :class="['w-5 h-5 mr-4 ml-1 inline-flex', post.is_liked ? 'fill-red-500' : '']"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                        <span
                            v-if="!isPersonalPage"
                            @click="showShareForm = !showShareForm"
                        >
                            <span>{{post.reposts_count}}</span>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-5 h-5 ml-1 inline-flex"
                            >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z" />
                        </svg>
                        </span>



                    </div>
                </div>
                <div>{{post.content}}</div>
                <small>{{post.date}}</small>
            </div>
            <div class="w-1/3 flex justify-end items-center">
                <img v-if="post.image_url"
                     :src="post.image_url"
                     alt=""
                >
                <div v-else>
                    No image
                </div>
            </div>
        </div>
        <SharePostForm
            v-if="showShareForm"
            :post-id="post.id"
        />

        <PostListItemComments
            @incrCommentsCount="post.comments_count++"
            :post-id="post.id"
            :count="post.comments_count"
        />

    </div>
</template>

<script setup>
import SharePostForm from "@/Components/Post/SharePostForm.vue";
import {computed, ref} from "vue";
import PostListItemComments from "@/Components/Comment/PostListItemComments.vue";
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    post: {
        required: true,
        type: Object
    }
})

const showShareForm = ref(false)
const isPersonalPage = computed(() => route().current('user.personal'))

const likePost = (post) => {
    axios.post(`/api/posts/${post.id}/toggle_like`)
        .then(res => {
            post.is_liked = res.data.is_liked
            post.likes_count = res.data.likes_count
        })
}
</script>

<style scoped>

</style>
