<script setup>
    import { router, usePage } from '@inertiajs/vue3'
    import ThunderUp from './SVGs/ThunderUp.vue'
    import { require_authentication } from '../../Helpers.js'

    //Variables
    let page = usePage()

    //Hooks
    let props = defineProps({
        likeable: {
            type: Object,
            required: true
        },
        likeable_type: {
            type: String,
            required: true
        }
    })

    //Computed
    let hasBeenLiked = computed(() => props.likeable.hasOwnProperty('liked') && props.likeable?.liked !== false)

    //Functions
    let manageClick = () => {
        if (require_authentication()) {
            return
        }

        if (hasBeenLiked.value) {
            router.delete(route('likes.destroy', [props.likeable.liked]), {
                preserveScroll: true
            })
            return
        }

        router.post(route('likes.store', [props.likeable_type, props.likeable.id]), {}, {
            preserveScroll: true
        })
    }
</script>

<template>
    <div class="flex w-fit  rounded-lg items-center">
        <label class="cursor-pointer">
            <input
                type="checkbox"
                class="hidden peer"
                @click="manageClick"
            />
            <thunder-up
                :class="[
                    'size-8 transition-all duration-300 peer-checked:animate-pulse-1s',
                    {
                        '!fill-blue-500 !peer-checked:fill-gray-400': hasBeenLiked,
                        '!fill-gray-400 !peer-checked:fill-blue-500': !hasBeenLiked
                    }
                ]"
            />
        </label>
    </div>
</template>