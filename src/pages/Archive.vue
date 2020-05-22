<template>
  <div>

    <h1 class="mb-5">{{ $t('pages.archive') }}</h1>

    <woa-list-e-s type="dance" :lang="this.$i18n.locale" :app="app" :credentials="credentials"></woa-list-e-s>

  </div>
</template>

<script>
import WoaListES from '@/components/WoaListES'

export default {
  name: 'Archive',
  components: {
    WoaListES
  },
  computed: {
    app () {
      if (this.$i18n.locale === 'hu') {
        return 'hu-index-name'
      } else if (this.$i18n.locale === 'uk') {
        return 'puk-index-name'
      } else {
        return 'en-index-name'
      }
    },
    credentials () {
      return 'username:passowrd'
    }
  }
}
</script>
