import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const token = useCookie('auth_token', {
    maxAge: 60 * 60 * 24 * 7, // 7 days
    sameSite: 'lax',
  })

  const isAuthenticated = computed(() => !!token.value)
  const isVendor = computed(() => user.value?.roles?.includes('vendor') || !!user.value?.vendor_id)

  const { $api } = useApi()

  async function fetchUser() {
    if (!token.value) return
    try {
      const data = await $api('/me')
      user.value = data
    } catch (e) {
      token.value = null
      user.value = null
    }
  }

  async function login(credentials: any) {
    const data = await $api('/login', {
      method: 'POST',
      body: credentials,
    })
    token.value = data.token
    user.value = data.user
    return data
  }

  async function register(payload: any) {
    const data = await $api('/register', {
      method: 'POST',
      body: payload,
    })
    token.value = data.token
    user.value = data.user
    return data
  }

  function logout() {
    // We don't necessarily need to wait for the backend to confirm logout
    // to clear the local state, but we should notify it.
    $api('/logout', { method: 'POST' }).catch(() => {})
    token.value = null
    user.value = null
    navigateTo('/login')
  }

  return {
    user,
    token,
    isAuthenticated,
    isVendor,
    fetchUser,
    login,
    register,
    logout,
  }
})
