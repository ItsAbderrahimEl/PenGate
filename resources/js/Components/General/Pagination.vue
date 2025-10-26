<script setup>
    import { router } from '@inertiajs/vue3'

    const props = defineProps({
        meta: {
            type: Object,
            required: true
        },
        links: {
            type: Object,
            required: true
        },
        only: {
            type: Array,
            default: []
        },
        preserveState: {
            type: Boolean,
            default: false
        }
    })

    watch(() => props.meta.from, newValue => {
        if (newValue === null) {
            router.visit(props.links.prev ?? props.meta.path, {
                preserveScroll: true,
                preserveState: true
            })
        }
    })

    let classes = 'transition-colors duration-300 first-of-type:rounded-l-md last-of-type:rounded-r-md px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-900'
</script>

<template>
    <div v-if="meta.total > 0">
        <!-- Mobile -->
        <div class="sm:hidden flex items-center bg-gray-400 p-2 m-5 w-fit rounded-md">
            <div class="text-emerald-900 p-2 mr-3">
                {{ meta.current_page }}
            </div>
            <Link
                :preserve-state="preserveState"
                :href="links.prev ?? '#'"
                :class="classes"
                :only="only"
                v-text="'Previous'"
                prefetch
            />
            <Link
                :preserve-state="preserveState"
                :href="links.next ?? '#'"
                prefetch
                :class="classes"
                :only="only"
                v-text="'Next'"
            />
        </div>

        <!-- PC -->
        <div class="hidden w-fit sm:block self-end mt-5 divide-x divide-gray-300 rounded-md">
            <Link
                :preserve-state="preserveState"
                prefetch
                :only="only"
                v-text="link.label"
                :href="link.url ?? '#'"
                v-for="link in meta.links"
                :class="[ classes, { 'bg-green-300 hover:bg-green-300 ': link.active}]"
            />
        </div>
    </div>
</template>
