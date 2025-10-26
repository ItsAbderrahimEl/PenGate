<script setup>
    import Pagination from '../General/Pagination.vue'
    import ShowPost from './ShowPost.vue'

    defineProps({
        posts: Object
    })
</script>

<template>
    <div class="w-2/3 ">
        <div v-if="posts.data.length === 0">
            There is no post with that title
        </div>
      <div class="space-y-5" v-else>
          <template
              :key="post.id"
              v-for="post in posts.data"
          >
              <show-post :post/>
          </template>

          <Pagination
              class="flex justify-end"
              :links="posts.links"
              :meta="posts.meta"
              :only="['posts']"
              preserve-state
          />
      </div>
    </div>
</template>