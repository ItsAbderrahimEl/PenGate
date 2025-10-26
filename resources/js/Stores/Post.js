import { route } from 'ziggy-js'
import { defineStore } from 'pinia'
import { useForm } from '@inertiajs/vue3'
import { useConfirm } from '../Composables/useConfirm.js'

export const usePostStore = defineStore('postStore', () => {

  //Variables
  let post = ref(null)
  let search_text = ref('')
  let { confirmation } = useConfirm()
  let form = useForm({
    'title': '',
    'body': '',
    'topic_id': null
  })

  //Functions
  async function destroy () {
    if (await confirmation('Are you sure you want to delete this post?')) {
      useForm({}).delete(route('posts.destroy', post.value.id))
    }
  }

  function store () {
    form.post(route('posts.store'), {
      preserveScroll: true,
      onSuccess: () => form.reset()
    })
  }

  return {
    //Variables
    post, form, search_text,

    //Functions
    store, destroy
  }
})