import { route } from 'ziggy-js'
import { usePostStore } from './Post.js'
import { router } from '@inertiajs/vue3'
import { useTopicStore } from './Topic.js'
import { defineStore } from 'pinia'

export const useSearchStore = defineStore('searchStore', () => {
  //Variables
  let topic_store = useTopicStore()
  let post_store = usePostStore()

  //Watchers
  watch(() => topic_store.current_topic, () => {
    search()
  })

  watch(() => post_store.search_text, () => {
    search()
  })

  //Function
  function search () {
    let query = {}

    //Include the post-search text if it's not empty
    if (post_store.search_text.length > 0) {
      query.title = post_store.search_text
    }

    //Include the current topic if it's not the default topic
    if (topic_store.current_topic !== topic_store.default_topic) {
      query.topic = topic_store.current_topic
    }

    router.get(route('posts.index'), query, {
      preserveState: true,
      preserveScroll: true,
      only: ['posts']
    })
  }
})