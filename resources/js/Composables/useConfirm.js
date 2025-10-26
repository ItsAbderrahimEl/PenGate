let globalState = reactive({
    show: false,
    title: '',
    message: '',
    resolver: null
})

let state = readonly(globalState)

let confirmation = (message, title = 'Please Confirm') => {
    globalState.show = true
    globalState.title = title
    globalState.message = message

    return new Promise((resolve) => {
        globalState.resolver = (result) => {
            resolve(result)
            globalState.resolver = null
            resetModel()
        }
    })
}

let confirm = () => globalState.resolver?.(true)

let cancel = () => globalState.resolver?.(false)

let resetModel = () => Object.assign(globalState, {
    show: false,
    title: '',
    message: '',
    resolver: null
})

export let useConfirm = () => ({ state, confirmation, cancel, confirm })
