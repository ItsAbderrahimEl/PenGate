<script setup>
    import ShowPost from '../../Components/Posts/ShowPost.vue'
    import Follow from '../../Components/General/Follow.vue'

    //Hooks
    defineProps({
        user: Object,
        liked_posts: Object,
        authored_posts: Object
    })
</script>

<template>
    <div class="">
        <div class="w-2/3 flex mx-auto p-5 ring ring-green-500  rounded-xl gap-x-5">
            <div class="w-1/2 rounded flex flex-col space-y-5">
                <img :src="user.avatar" alt="Avatar">
                <follow :user/>
            </div>
            <div class="space-y-8">
                <div class="text-5xl mt-3 font-bold">
                    {{ user.name }}
                </div>

                <div>
                    <span class="font-bold text-xl">Contact Info</span>
                    <div class="ml-3">
                        <div>
                            {{ user.email }}
                        </div>

                        <div>
                            {{ user.phone }}
                        </div>
                    </div>
                </div>

                <div>
                    <span class="text-xl font-bold">Biography</span>
                    <div class="ml-3">
                        {{ user.bio }}
                    </div>
                </div>
            </div>

        </div>

        <div class="space-y-10 p-10">
            <span class="text-lg font-extrabold ">Liked Posts</span>
            <div class="space-y-5 p-5">
                <template
                    v-for="post in liked_posts"
                    :key="post.id"
                >
                    <show-post :post/>
                </template>
            </div>
        </div>

        <div class="space-y-10 p-10">
            <span class="text-lg font-extrabold">Authored Posts</span>
            <div class="space-y-5 p-5">
                <template
                    :key="post.id"
                    v-for="post in authored_posts"
                >
                    <show-post :post :show-user="false"/>
                </template>
            </div>
        </div>
    </div>
</template>