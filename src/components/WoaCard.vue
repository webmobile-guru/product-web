<template>
  <div>
      <v-card
        class="mx-auto"
      >

        <v-card-title>
          <template v-if="item.media_video_youtube_code">
            <woa-video-dialog
            :item="item"
            v-bind:lang="lang"
            width="100%"
            ></woa-video-dialog>
          </template>

          <div class="mt-2 itemName">
            <router-link :to="$i18nRoute({ name: 'song', params: { item_id: item.item_id } })">
              {{ item.name }}
            </router-link>
          </div>

        </v-card-title>

        <v-card-text>
          {{ item.location_txt_locality }}<span v-if="item.location_txt_county"> ({{ item.location_txt_county }})</span>
        </v-card-text>

      </v-card>
  </div>
</template>


<script>
  import { WOA_TYPES } from '@/constants/pcd'
  import WoaVideoDialog from '@/components/WoaVideoDialog'

  export default {
    data () {
      return {
        image_webroot: process.env.VUE_APP_MEDIA_WEBROOT,
        show: false,
        dialog: false
      }
    },
    components: {
      WoaVideoDialog
    },
    computed: {
      yt_thumbnail () {
        var ret = 'https://img.youtube.com/vi/' + this.item.media_video_youtube_code + '/0.jpg'
        // console.log(ret)
        return ret
      },
      media_files () {
        var mediaFiles = []
        // console.log(this.item)
        if (this.item.media_files !== null) {
          if (this.item.media_files.length) {
            mediaFiles = JSON.parse(this.item.media_files)
          }
        }
        return mediaFiles
      },
      my_dance_notations () {
        var woas = []
        if (this.item.woas.length) {
          for (let woa of this.item.woas) {
            if (woa.type === WOA_TYPES['dancenotation']) woas.push(woa)
          }
        }
        return woas
      },
      my_dances () {
        var woas = []
        if (this.item.woas.length) {
          for (let woa of this.item.woas) {
            if (woa.type === WOA_TYPES['dance']) woas.push(woa)
          }
        }
        if (woas.length === 0) woas = false
        return woas
      },
      taxonomies () {
        var taxonomies = {}
        /*
        var i, j, tempName
        if (this.item.hasOwnProperty('taxonomies')) {
          // console.log(this.item.taxonomies)

          for (let taxonomy of this.item.taxonomies) {
            // console.log('taxonomy', taxonomy)

            for (i = 0; i < taxonomy.parents.length; i++) {
              var actParent = taxonomy.parents[i]
              // console.log('actParent', actParent)
              if (i === 0) {
                if (!(actParent.name in taxonomies)) {
                  taxonomies[actParent.name] = []
                }
                tempName = []
                for (j = 1; j < taxonomy.parents.length; j++) {
                  tempName.push(taxonomy.parents[j].name)
                }
                tempName.push(taxonomy.name)
                taxonomies[actParent.name].push(tempName.join(' / '))
              }
            }
          }
        }
        // console.log(taxonomies)
        */
        return taxonomies
      }
    },
    name: 'WoaCard',
    props: ['item', 'lang', 'active']
  }
</script>

<style scoped>
.v-card__title {
  word-break: normal;
}
.itemName {
  min-height: 50px;
}
</style>
