import { defineStore } from 'pinia'
import { when } from '../Helpers.js'

export const useTopicStore = defineStore('topicStore', () => {

  //Variables
  let default_topic = 'All Topics'
  let current_topic = ref(default_topic)

  //Computed
  let is_selected = name => computed(() => current_topic.value === name)

  //Functions
  function addDefaultTopicTo (topics) {
    when(!contains_the_default(topics), topics.unshift({ id: 0, name: default_topic }))
  }

  function contains_the_default (topics) {
    return topics.some(topic => topic.name === default_topic)
  }

  function reset_to_default () {
    current_topic.value = default_topic
  }

  return {
    //Variables
    current_topic,
    default_topic,

    //Function
    is_selected,
    addDefaultTopicTo,
    reset_to_default
  }
})