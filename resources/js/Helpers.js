import { router, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

export const when = (condition, callback) => condition &&
typeof callback === 'function' ? callback() : callback

export const unless = (condition, callback) => !condition &&
typeof callback === 'function' ? callback() : callback

export const goBack = () => window.history.back()

export const extractObjects = (elements) => elements.map(el => ({ ...el }))

export const redirect_to_login = () => router.get(route('login.create'))

export const require_authentication = () => {
  if (!usePage().props.auth) {
    redirect_to_login()
    return true
  }
  return false
}