<script setup>
    import { route } from 'ziggy-js'
    import Example from './SVGs/Example.vue'
    import { Link } from '@tiptap/extension-link'
    import { StarterKit } from '@tiptap/starter-kit'
    import Underline from '@tiptap/extension-underline'
    import TextAlign from '@tiptap/extension-text-align'
    import { Highlight } from '@tiptap/extension-highlight'
    import { CharacterCount } from '@tiptap/extension-character-count'
    import { BubbleMenu, EditorContent, useEditor } from '@tiptap/vue-3'

    //Variables
    let CharacterLimit = 4000
    let menuItems = [
        {
            title: 'Bold',
            isActive: (editor) => editor.isActive('bold'),
            action: (editor) => editor.chain().focus().toggleBold().run(),
            icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="size-6">
                    <path stroke-linejoin="round"
                          d="M6.75 3.744h-.753v8.25h7.125a4.125 4.125 0 0 0 0-8.25H6.75Zm0 0v.38m0 16.122h6.747a4.5 4.5 0 0 0 0-9.001h-7.5v9h.753Zm0 0v-.37m0-15.751h6a3.75 3.75 0 1 1 0 7.5h-6m0-7.5v7.5m0 0v8.25m0-8.25h6.375a4.125 4.125 0 0 1 0 8.25H6.75m.747-15.38h4.875a3.375 3.375 0 0 1 0 6.75H7.497v-6.75Zm0 7.5h5.25a3.75 3.75 0 0 1 0 7.5h-5.25v-7.5Z"/>
                </svg>`
        },
        {
            title: 'Italic',
            isActive: (editor) => editor.isActive('italic'),
            action: (editor) => editor.chain().focus().toggleItalic().run(),
            icon: ` <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5.248 20.246H9.05m0 0h3.696m-3.696 0 5.893-16.502m0 0h-3.697m3.697 0h3.803"/>
                </svg>`
        },
        {
            title: 'Strike Through',
            isActive: (editor) => editor.isActive('strike'),
            action: (editor) => editor.chain().focus().toggleStrike().run(),
            icon: ` <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 12a8.912 8.912 0 0 1-.318-.079c-1.585-.424-2.904-1.247-3.76-2.236-.873-1.009-1.265-2.19-.968-3.301.59-2.2 3.663-3.29 6.863-2.432A8.186 8.186 0 0 1 16.5 5.21M6.42 17.81c.857.99 2.176 1.812 3.761 2.237 3.2.858 6.274-.23 6.863-2.431.233-.868.044-1.779-.465-2.617M3.75 12h16.5"/>
                </svg>`
        },
        {
            title: 'Unordered List',
            isActive: (editor) => editor.isActive('bulletList'),
            action: (editor) => editor.chain().focus().toggleBulletList().run(),
            icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                </svg>`
        },
        {
            title: 'Ordered List',
            isActive: (editor) => editor.isActive('orderedList'),
            action: (editor) => editor.chain().focus().toggleOrderedList().run(),
            icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M8.242 5.992h12m-12 6.003H20.24m-12 5.999h12M4.117 7.495v-3.75H2.99m1.125 3.75H2.99m1.125 0H5.24m-1.92 2.577a1.125 1.125 0 1 1 1.591 1.59l-1.83 1.83h2.16M2.99 15.745h1.125a1.125 1.125 0 0 1 0 2.25H3.74m0-.002h.375a1.125 1.125 0 0 1 0 2.25H2.99"/>
                </svg>`
        },
        {
            title: 'Blockquotes',
            isActive: (editor) => editor.isActive('blockquote'),
            action: (editor) => editor.chain().focus().toggleBlockquote().run(),
            icon: `<svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="rgba(0,0,0,1)"><path d="M4.58341 17.3211C3.55316 16.2274 3 15 3 13.0103C3 9.51086 5.45651 6.37366 9.03059 4.82318L9.92328 6.20079C6.58804 8.00539 5.93618 10.346 5.67564 11.822C6.21263 11.5443 6.91558 11.4466 7.60471 11.5105C9.40908 11.6778 10.8312 13.159 10.8312 15C10.8312 16.933 9.26416 18.5 7.33116 18.5C6.2581 18.5 5.23196 18.0095 4.58341 17.3211ZM14.5834 17.3211C13.5532 16.2274 13 15 13 13.0103C13 9.51086 15.4565 6.37366 19.0306 4.82318L19.9233 6.20079C16.588 8.00539 15.9362 10.346 15.6756 11.822C16.2126 11.5443 16.9156 11.4466 17.6047 11.5105C19.4091 11.6778 20.8312 13.159 20.8312 15C20.8312 16.933 19.2642 18.5 17.3312 18.5C16.2581 18.5 15.232 18.0095 14.5834 17.3211Z"></path></svg>
`
        },
        {
            title: 'Link',
            isActive: (editor) => editor.isActive('link'),
            action: () => manageLink(),
            icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
</svg>
`
        },
        {
            title: 'Unset Link',
            isActive: (editor) => editor.isActive('link'),
            action: (editor) => editor.chain().unsetLink().run(),
            disabled: (editor) => !editor.isActive('link'),
            icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M13.181 8.68a4.503 4.503 0 0 1 1.903 6.405m-9.768-2.782L3.56 14.06a4.5 4.5 0 0 0 6.364 6.365l3.129-3.129m5.614-5.615 1.757-1.757a4.5 4.5 0 0 0-6.364-6.365l-4.5 4.5c-.258.26-.479.541-.661.84m1.903 6.405a4.495 4.495 0 0 1-1.242-.88 4.483 4.483 0 0 1-1.062-1.683m6.587 2.345 5.907 5.907m-5.907-5.907L8.898 8.898M2.991 2.99 8.898 8.9" />
</svg>

`
        },
        {
            title: 'Heading 1',
            isActive: (editor) => editor.isActive('heading', { level: 2 }),
            action: (editor) => editor.chain().focus().toggleHeading({ level: 2 }).run(),
            icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.243 4.493v7.5m0 0v7.502m0-7.501h10.5m0-7.5v7.5m0 0v7.501m4.501-8.627 2.25-1.5v10.126m0 0h-2.25m2.25 0h2.25"/>
                </svg>`
        },
        {
            title: 'Heading 2',
            isActive: (editor) => editor.isActive('heading', { level: 3 }),
            action: (editor) => editor.chain().focus().toggleHeading({ level: 3 }).run(),
            icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21.75 19.5H16.5v-1.609a2.25 2.25 0 0 1 1.244-2.012l2.89-1.445c.651-.326 1.116-.955 1.116-1.683 0-.498-.04-.987-.118-1.463-.135-.825-.835-1.422-1.668-1.489a15.202 15.202 0 0 0-3.464.12M2.243 4.492v7.5m0 0v7.502m0-7.501h10.5m0-7.5v7.5m0 0v7.501"/>
                </svg>`
        },
        {
            title: 'Heading 3',
            isActive: (editor) => editor.isActive('heading', { level: 4 }),
            action: (editor) => editor.chain().focus().toggleHeading({ level: 4 }).run(),
            icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M20.905 14.626a4.52 4.52 0 0 1 .738 3.603c-.154.695-.794 1.143-1.504 1.208a15.194 15.194 0 0 1-3.639-.104m4.405-4.707a4.52 4.52 0 0 0 .738-3.603c-.154-.696-.794-1.144-1.504-1.209a15.19 15.19 0 0 0-3.639.104m4.405 4.708H18M2.243 4.493v7.5m0 0v7.502m0-7.501h10.5m0-7.5v7.5m0 0v7.501"/>
                </svg>`
        },
        {
            title: 'Highlight',
            isActive: (editor) => editor.isActive('highlight'),
            action: (editor) => editor.chain().focus().toggleHighlight().run(),
            icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
</svg>
`
        },
        {
            title: 'Unset Highlight',
            isActive: (editor) => editor.isActive('highlight'),
            disabled: (editor) => !editor.isActive('highlight'),
            action: (editor) => editor.chain().focus().unsetHighlight().run(),
            icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M11.412 15.655 9.75 21.75l3.745-4.012M9.257 13.5H3.75l2.659-2.849m2.048-2.194L14.25 2.25 12 10.5h8.25l-4.707 5.043M8.457 8.457 3 3m5.457 5.457 7.086 7.086m0 0L21 21" />
</svg>
`
        },
        {
            title: 'Align Left',
            isActive: (editor) => editor.isActive({ textAlign: 'left' }),
            action: (editor) => {
                if (editor.isActive({ textAlign: 'left' })) {
                    return editor.chain().focus().unsetTextAlign().run()
                }

                return editor.chain().focus().setTextAlign('left').run()
            },
            icon: `<svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="rgba(0,0,0,1)"><path d="M3 4H21V6H3V4ZM3 19H17V21H3V19ZM3 14H21V16H3V14ZM3 9H17V11H3V9Z"></path></svg>
`
        },
        {
            title: 'Align Center',
            isActive: (editor) => editor.isActive({ textAlign: 'center' }),
            action: (editor) => {
                if (editor.isActive({ textAlign: 'center' })) {
                    return editor.chain().focus().unsetTextAlign().run()
                }

                return editor.chain().focus().setTextAlign('center').run()
            },
            icon: `<svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="currentColor"><path d="M3 4H21V6H3V4ZM5 19H19V21H5V19ZM3 14H21V16H3V14ZM5 9H19V11H5V9Z"></path></svg>
`
        },
        {
            title: 'Align Right',
            isActive: (editor) => editor.isActive({ textAlign: 'right' }),
            action: (editor) => {
                if (editor.isActive({ textAlign: 'right' })) {
                    return editor.chain().focus().unsetTextAlign().run()
                }

                return editor.chain().focus().setTextAlign('right').run()
            },
            icon: `<svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="rgba(0,0,0,1)"><path d="M3 4H21V6H3V4ZM7 19H21V21H7V19ZM3 14H21V16H3V14ZM7 9H21V11H7V9Z"></path></svg>
`
        },
        {
            title: 'Align Justify',
            isActive: (editor) => editor.isActive({ textAlign: 'justify' }),
            action: (editor) => {
                if (editor.isActive({ textAlign: 'justify' })) {
                    return editor.chain().focus().unsetTextAlign().run()
                }

                return editor.chain().focus().setTextAlign('justify').run()
            },
            icon: `<svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="rgba(0,0,0,1)"><path d="M3 4H21V6H3V4ZM3 19H21V21H3V19ZM3 14H21V16H3V14ZM3 9H21V11H3V9Z"></path></svg>
`
        },
        {
            title: 'Underline',
            isActive: (editor) => editor.isActive('underline'),
            action: (editor) => {
                if (editor.isActive('underline')) {
                    return editor.chain().focus().unsetMark('underline').run()
                }

                return editor.chain().focus().setUnderline().run()
            },
            icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M17.995 3.744v7.5a6 6 0 1 1-12 0v-7.5m-2.25 16.502h16.5" />
</svg>
`
        },
        {
            title: 'Undo',
            disabled: (editor) => !editor.can().undo(),
            action: (editor) => editor.chain().focus().undo().run(),
            icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
</svg>

`
        },
        {
            title: 'Redo',
            disabled: (editor) => !editor.can().redo(),
            action: (editor) => editor.chain().focus().redo().run(),
            icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
</svg>
`
        }

    ]
    let bubbleMenuItems = [
        {
            title: 'Bold',
            isActive: (editor) => editor.isActive('bold'),
            action: (editor) => editor.chain().focus().toggleBold().run(),
            icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="size-6">
                    <path stroke-linejoin="round"
                          d="M6.75 3.744h-.753v8.25h7.125a4.125 4.125 0 0 0 0-8.25H6.75Zm0 0v.38m0 16.122h6.747a4.5 4.5 0 0 0 0-9.001h-7.5v9h.753Zm0 0v-.37m0-15.751h6a3.75 3.75 0 1 1 0 7.5h-6m0-7.5v7.5m0 0v8.25m0-8.25h6.375a4.125 4.125 0 0 1 0 8.25H6.75m.747-15.38h4.875a3.375 3.375 0 0 1 0 6.75H7.497v-6.75Zm0 7.5h5.25a3.75 3.75 0 0 1 0 7.5h-5.25v-7.5Z"/>
                </svg>`
        },
        {
            title: 'Italic',
            isActive: (editor) => editor.isActive('italic'),
            action: (editor) => editor.chain().focus().toggleItalic().run(),
            icon: ` <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5.248 20.246H9.05m0 0h3.696m-3.696 0 5.893-16.502m0 0h-3.697m3.697 0h3.803"/>
                </svg>`
        },
        {
            title: 'Strike Through',
            isActive: (editor) => editor.isActive('strike'),
            action: (editor) => editor.chain().focus().toggleStrike().run(),
            icon: ` <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 12a8.912 8.912 0 0 1-.318-.079c-1.585-.424-2.904-1.247-3.76-2.236-.873-1.009-1.265-2.19-.968-3.301.59-2.2 3.663-3.29 6.863-2.432A8.186 8.186 0 0 1 16.5 5.21M6.42 17.81c.857.99 2.176 1.812 3.761 2.237 3.2.858 6.274-.23 6.863-2.431.233-.868.044-1.779-.465-2.617M3.75 12h16.5"/>
                </svg>`
        },
        {
            title: 'Underline',
            isActive: (editor) => editor.isActive('underline'),
            action: (editor) => {
                if (editor.isActive('underline')) {
                    return editor.chain().focus().unsetMark('underline').run()
                }

                return editor.chain().focus().setUnderline().run()
            },
            icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M17.995 3.744v7.5a6 6 0 1 1-12 0v-7.5m-2.25 16.502h16.5" />
</svg>
`
        }
    ]
    let editor = useEditor({
        extensions: [
            Link,
            Underline,
            Highlight.configure({
                HTMLAttributes: {
                    class: 'bg-gray-500 text-gray-50 py-0.5 px-1 rounded selection:text-white selection:bg-gray-400 '
                }
            }),
            TextAlign.configure({
                types: ['heading', 'paragraph']
            }),
            StarterKit.configure({
                heading: {
                    levels: [2, 3, 4]
                }
            }),
            CharacterCount.configure({
                limit: CharacterLimit
            })
        ],
        editorProps: {
            attributes: {
                class: 'prose prose-md bg-gray-200 min-w-full h-[25rem] overflow-scroll mb-5 px-2 py-1.5 outline-none text-gray-900 rounded-b-md bg-gray-300 pt-5 pr-5'
            }
        },
        onUpdate: () => emit('update:modelValue', editor.value.getHTML())
    })

    //Hooks
    defineExpose({
        focus: () => editor.value.commands.focus(),
        reset: () => editor.value.commands.setContent(''),
        setContent: content => editor.value.commands.setContent(content)
    })
    let emit = defineEmits(['update:modelValue'])
    let props = defineProps({
        modelValue: String,
        example: {
            type: String,
            default: null
        },
        menuStyle: {
            type: String,
            default: ''
        },
        countStyle: {
            type: String,
            default: ''
        }
    })

    //Watchers
    watch(() => props.modelValue, val => {
        if (editor.value.getHTML() !== props.modelValue) {
            editor.value.commands.setContent(val)
        }
    })

    //Functions
    let manageLink = () => {
        let editorInstance = editor.value

        if (editorInstance.isActive('link')) {
            return editorInstance
                .chain()
                .focus()
                .unsetMark('link')
                .run()
        }

        let url = prompt('Where do you to link to? ')

        if (url !== null) {
            return editorInstance
                .chain()
                .focus()
                .setLink({ href: url, target: '_blank' })
                .run()
        }

        return editorInstance.chain().focus().run()
    }
    let getExample = async () => {
        await axios.get(route('example', props.example))
            .then(res => editor.value.commands.setContent(res.data))
    }
</script>

<template>
    <div v-if="editor" class="bg-transparent">
        <menu :class="`border-b border-gray-400 ${menuStyle}`">
            <button
                :key="index"
                type="button"
                v-html="item.icon"
                :title="item.title"
                v-for="(item, index) in menuItems"
                @click.prevent="item.action(editor)"
                :disabled="item.disabled?.(editor) ?? false"
                :class="item?.isActive?.(editor) ? 'bg-purple-400' : 'hover:bg-gray-400'"
                class="px-2 py-1.5 bg-gray-300 text-black first:rounded-tl-lg last:rounded-tr-lg disabled:cursor-not-allowed"
            ></button>
        </menu>

        <BubbleMenu
            :editor="editor"
            :tippy-options="{ duration: 100 }"
            class="absolute flex p-1  bg-gray-100 rounded-lg shadow-lg top-12"
        >
            <button
                :key="index"
                v-html="item.icon"
                class="px-2 py-1 rounded-lg text-black"
                @click.prevent="item.action(editor)"
                v-for="(item, index) in bubbleMenuItems"
                :class="item.isActive(editor) ? 'bg-purple-300' : 'hover:bg-gray-300'"
            ></button>
        </BubbleMenu>

        <div class="relative">
            <EditorContent :editor="editor"/>
            <button
                v-if="example"
                title="Get an example"
                @click.prevent="getExample"
                class="absolute top-3 right-3"
            >
                <Example class="size-6 text-gray-900"/>
            </button>
        </div>

        <div
            class=""
            :class="[ `text-right ${countStyle}`,
                {
                    'character-count': true,
                    'character-count--warning': editor.storage.characterCount.characters() === CharacterLimit
                }]"
        >
            {{ editor.storage.characterCount.characters() }} / {{ CharacterLimit }} characters
            |
            {{ editor.storage.characterCount.words() }} words
        </div>
    </div>
</template>
