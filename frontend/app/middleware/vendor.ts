export default defineNuxtRouteMiddleware((to, from) => {
  const auth = useAuthStore()

  if (!auth.isVendor) {
    return navigateTo('/')
  }
})
