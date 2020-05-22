<template>
  <v-dialog
        v-model="dialog"
        width="80%"
        @input="whenClosed()"
      >
        <template v-slot:activator="{ on }">
          <v-img
            :src="yt_thumbnail"
            class="yt_thumbnail"
            :width="width"
            v-on="on"
          ></v-img>
        </template>

        <v-card>
          <v-card-title
            class="headline grey lighten-2"
            primary-title
          >
            {{ item.name }}

          </v-card-title>

          <v-card-text class="pt-3">
              <v-container>
                <v-row>
                  <v-col cols="12" sm="6">
                    <div :id="youtubeWrapId">
                      <youtube  :video-id="item.media_video_youtube_code" width="100%" ref="youtube" ></youtube>
                    </div>
                  </v-col>
                  <v-col cols="12" sm="6">
                    {{ item.location_txt_locality }}<span v-if="item.location_txt_archaic"> - {{ item.location_txt_archaic }}</span><span v-if="item.location_txt_county"> ({{ item.location_txt_county }})</span>

                    <div v-if="my_dance_notations.length">
                      {{ $t('dancenotation') }}:
                      <span v-for="(dance_notation, index) in my_dance_notations">
                        <router-link :to="$i18nRoute({ name: 'dance-notation', params: { id: dance_notation.id } })">
                          {{ dance_notation.item_id }}
                        </router-link>
                        <span v-if="index < (my_dance_notations.length - 1)">,</span>
                      </span>
                    </div>
                    <div v-if="my_dances.length">
                      {{ $t('dance') }}:
                      <span v-for="(dance, index) in my_dances">
                        <router-link :to="$i18nRoute({ name: 'dance', params: { id: dance.id } })">
                          {{ dance.item_id }}
                        </router-link>
                        <span v-if="index < (my_dances.length - 1)">,</span>
                      </span>
                    </div>

                    <div v-if="item.dance_measures">
                      <b>{{ $t('dance_measures') }}</b>: {{ item.dance_measures }}
                    </div>

                    <div v-if="item.collectors.length">
                      <b v-if="item.type === 500">{{ $t('collectors') }}:</b>
                      <b v-if="item.type === 600">{{ $t('notated_by') }}:</b>

                      <span v-for="(collector, index) in item.collectors">
                        {{ collector.name }}<span v-if="index < (item.collectors.length - 1)">, </span>
                      </span><span v-if="item.date_of_collecting_text">, {{ item.date_of_collecting_text }}</span>
                    </div>

                    <div v-if="item.sources.length">
                      <b>{{ $t('performers') }}:</b>

                      <span v-for="(source, index) in item.sources">
                        {{ source.name }}<span v-if="index < (item.sources.length - 1)">,</span>
                      </span>
                    </div>

                    <div v-if="item.logbook_txt && item.logbook_txt.length">
                      <b>{{ $t('logbook_txt') }}</b>: {{ item.logbook_txt }}
                    </div>

                    <div v-if="item.tape_no_txt && item.tape_no_txt.length">
                      <b>{{ $t('tape_no_txt') }}</b>: {{ item.tape_no_txt }}
                    </div>

                    <div v-if="item.lp_no_txt && item.lp_no_txt.length">
                      <b>{{ $t('lp_no_txt') }}</b>: {{ item.lp_no_txt }}
                    </div>

                    <div v-if="item.collector_comment">
                      <b>{{ $t('comment') }}</b>: {{ item.collector_comment }}
                    </div>

                    <div v-if="item.published_txt">
                      <b>{{ $t('published_txt') }}</b>: {{ item.published_txt }}
                    </div>

                  </v-col>
                </v-row>
              </v-container>
          </v-card-text>

          <v-divider></v-divider>

          <v-card-actions>
            <div class="flex-grow-1"></div>
            <v-btn
              color="primary"
              text
              @click="dialog = false; whenClosed()"
            >
              {{ $t('close') }}
            </v-btn>
          </v-card-actions>

        </v-card>
      </v-dialog>
</template>

<script>
  import { WOA_TYPES } from '@/constants/pcd'

  export default {
    data () {
      return {
        dialog: false
      }
    },
    computed: {
      yt_thumbnail () {
        if (this.item.media_image_file) {
          var ret = process.env.VUE_APP_IMAGES_WEBROOT + this.item.media_image_file
          if (parseInt(process.env.VUE_APP_USE_WESERV) === 1) ret += '&w=600'
          return ret
        } else {
          return 'https://img.youtube.com/vi/' + this.item.media_video_youtube_code + '/0.jpg'
        }
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
      youtubeWrapId () {
        return 'youtube_wrap_' + this.item.id
      }
    },
    methods: {
      whenClosed () {
        // stop yputube playback when dialog is closed
        var el = document.querySelector('div#youtube_wrap_' + this.item.id + ' iframe')
        if (typeof el !== 'undefined' && !this.dialog) {
          el.src = el.src
        }
      }
    },
    name: 'WoaVideoDialog',
    props: ['item', 'lang', 'width']
  }
</script>

<style>
.yt_thumbnail :hover {
  cursor: pointer;
}
</style>
