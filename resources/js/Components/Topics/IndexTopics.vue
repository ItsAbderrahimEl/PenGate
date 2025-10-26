<script setup>
    import { useTopicStore } from '../../Stores/Topic.js'

    //Variables
    let store = useTopicStore()

    //Hooks
    let props = defineProps({
        topics: {
            type: Array,
            required: true
        }
    })

    onBeforeMount(() => {
        store.addDefaultTopicTo(props.topics)
    })
</script>

<template>
    <div class="p-5 w-fit divide-y-2 divide-gray-500">
        <div
            class="p-2"
            :key="topic.id"
            v-for="topic in topics"
        >
            <div
                @click="store.current_topic = topic.name"
                :class="['cursor-pointer', {
                    'text-indigo-300' : store.is_selected(topic.name).value
                }]"
            >
                {{ topic.name }}
            </div>
        </div>
    </div>
</template>