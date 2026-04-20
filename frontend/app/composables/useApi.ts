export const useApi = () => {
  const config = useRuntimeConfig()
  const token  = useCookie('auth_token')

  // Use internal Docker network address on server-side, public address on client-side
  const baseURL = import.meta.server 
    ? 'http://nginx/api' 
    : config.public.apiBase

  const $api = $fetch.create({
    baseURL: baseURL as string,
    headers: {
      Accept: 'application/json',
      ...(token.value ? { Authorization: `Bearer ${token.value}` } : {}),
    },
    onResponseError({ response }) {
      if (response.status === 401) {
        useCookie('auth_token').value = null
        navigateTo('/login')
      }
    },
  })

  return { $api }
}
