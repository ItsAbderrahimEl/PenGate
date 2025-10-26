<script setup>
    import Label from '../Form/Label.vue'
    import Modal from '../General/Modal.vue'
    import TextInput from '../Form/TextInput.vue'
    import ErrorInput from '../Form/ErrorInput.vue'
    import { usePostStore } from '../../Stores/Post.js'
    import TipTapEditor from '../General/TipTapEditor.vue'
    import Select from '../General/Select.vue'

    let store = usePostStore()

    let props = defineProps({
        topics: {
            type: Object
        }
    })
</script>

<template>
    <Modal title="Create a Post" needs_auth>
        <template #trigger>
            <button
                class="transition-all flex items-center justify-center w-48 h-14 font-bold text-lg text-white duration-300 rounded-2xl self-start bg-gradient-to-r hover:outline-2 hover:shadow-md from-purple-600 to-purple-700 ">
                Post your Idea
            </button>
        </template>

        <template #content>
            <div class="flex items-center justify-center">
                <form class="p-5" @submit.prevent="store.store()">
                    <div class="mb-10">
                        <Label class="text-gray-500" for="Topic">Topic</Label>
                        <Select
                            required
                            id="Topic"
                            :elements="topics"
                            class="bg-gray-800"
                            v-model="store.form.topic_id"
                        />
                        <ErrorInput :error="store.form.errors.topic_id"/>
                    </div>

                    <div class="mb-10">
                        <Label class="text-gray-500" for="title">Title</Label>
                        <TextInput id="title" v-model="store.form.title" class="bg-gray-300" name="title"
                                   required/>
                        <ErrorInput :error="store.form.errors.title"/>
                    </div>

                    <div>
                        <Label class="text-gray-500" for="body">Description</Label>
                        <TipTapEditor count-style="text-gray-800" v-model="store.form.body" example="Post"/>
                        <ErrorInput :error="store.form.errors.body"/>
                    </div>

                    <button
                        class="w-full text-white font-bold bg-gray-700 p-4 rounded  transition-colors
                         duration-300 hover:bg-gray-800 disabled:cursor-wait mt-10"
                        :disabled="store.form.processing"
                    >
                        Post
                    </button>
                </form>
            </div>
        </template>
    </Modal>
</template>
