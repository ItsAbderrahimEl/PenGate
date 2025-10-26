import './bootstrap'
import '@css/app.css'
import Layout from './Layouts/Layout.vue'
import { createPinia } from 'pinia'
import { createInertiaApp, Head, Link, usePage } from '@inertiajs/vue3'

let pinia = createPinia()
let page = usePage()

createInertiaApp({
  title: title => title ? `${page.props.app.name} - ${title}` : page.props.app.name,

  resolve: (name) => {
    const pages = import.meta.glob('./Pages/**/*.vue')

    return pages[`./Pages/${name}.vue`]().then(page => {
      if (page.default.layout === undefined) {
        page.default.layout = Layout
      }
      return page.default
    })
  },

  setup ({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .component('Link', Link)
      .component('Head', Head)
      .use(pinia)
      .mount(el)
  }
})
