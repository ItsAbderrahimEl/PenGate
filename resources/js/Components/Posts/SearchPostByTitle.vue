<script setup>
    import TextInput from '../Form/TextInput.vue'
    import { usePostStore } from '../../Stores/Post.js'

    //Variables
    let posts_store = usePostStore()
    let search = ref(posts_store.search_text)
</script>

<template>
    <TextInput
        v-model="search"
        @keyup.enter="posts_store.search_text = search"
        placeholder="Searching for a post, Start typing..."
        class="inline-block mb-10 w-[30rem] rounded-lg py-2.5 px-3 text-slate-100 bg-gray-500 placeholder-slate-300"
    />
</template>