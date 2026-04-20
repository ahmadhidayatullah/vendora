export default defineNuxtPlugin(async (nuxtApp) => {
  const auth = useAuthStore()
  const token = useCookie('auth_token')

  // Only fetch user if we have a token and we're not already fetching it
  if (token.value && !auth.user) {
    await auth.fetchUser()
  }
})
