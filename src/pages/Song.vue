<template>

    <song-details
      :woa="woa"
      :lang="this.$i18n.locale"
      v-if="woa"
     >
     </song-details>

</template>

<script>
  import SongDetails from '@/components/SongDetails'
  import { WOA_QUERY } from '@/constants/graphql'

  export default {
    name: 'Keyword',
    data () {
      return {
        woa: null,
        lang: this.$i18n.locale,
        id: this.$route.params.id
      }
    },
    components: {
      SongDetails
    },
    apollo: {
      woa: {
        query: WOA_QUERY,
        variables () {
          return {
            item_id: this.$route.params.item_id,
            lang: this.$i18n.locale
          }
        }
      }
    }
  }
</script>
