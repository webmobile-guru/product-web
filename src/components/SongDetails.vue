<template>
    <div style="margin: -16px">
        <youtube :video-id="woa.media_video_youtube_code" width="100%" height="600" ref="youtube" ></youtube>
        <div class="textContent">
          <h1 class="text-center">{{ woa.name }}</h1>
          <h2 class="text-center">
          {{ woa.location_txt_locality }}<span v-if="woa.location_txt_county"> ({{ woa.location_txt_county }})</span>
          </h2>

          <v-container>
            <v-row>
                <v-col sm=4><h2>{{ $t('lyrics') }}</h2></v-col>
                <v-col sm=8 class="lyrics">{{ woa.lyrics }}</v-col>
            </v-row>
          </v-container>

          <div style="padding: 0 20px;">
            <WavePlaylist 
              :tracks ="tracks" 
              :startTime ="startTime" 
              :trackWidth ="trackWidth"
              :trackHeight="trackHeight"
              :waveOutlineColor="waveOutlineColor"
            >
            </WavePlaylist>
          </div>

          <v-container v-if="woa.sources.length">
            <v-row>
                <v-col sm=4><h2>{{ $t('performers') }}</h2></v-col>
                <v-col sm=8>
                  <span v-for="(source, index) in woa.sources">
                    {{ source.name }}<br/>
                  </span>                
                </v-col>
            </v-row>
          </v-container>

          <v-container>
            <v-row>
                <v-col sm=4><h2>{{ $t('participants') }}</h2></v-col>
                <v-col sm=8>
                  <div v-if="woa.collectors.length" class="mb-5">
                    <h3>{{ $t('collectors') }}</h3>
                    <span v-for="(collector, index) in woa.collectors">
                      {{ collector.name }}<br/>
                    </span>     
                  </div>

                  <div v-if="woa.descriptors.length" class="mb-5">
                    <h3>{{ $t('descriptors') }}</h3>
                    <span v-for="(descriptor, index) in woa.descriptors">
                      {{ descriptor.name }}<br/>
                    </span>     
                  </div>

                  <div v-if="woa.date_of_collecting" class="mb-5">
                    <h3>{{ $t('date_of_collecting') }}</h3>
                    {{ woa.date_of_collecting }}
                  </div>
                </v-col>
            </v-row>
          </v-container>
        </div>

    </div>
</template>


<script>
  import WavePlaylist from '../components/WavePlaylist'
  
  export default {
    data () {
      return {
        tracks_test: [
          {
            mp3: '/media/audio/track1.mp3',
            // img: '/media/img/track1.jpg',
            name: 'Vocals1'
          },
          {
            mp3: '/media/audio/track2.mp3',
            // img: '/media/img/track2.jpg',
            name: 'Vocals2'
          },
          {
            mp3: '/media/audio/track2.mp3',
            // img: '/media/img/track2.jpg',
            name: 'Vocals2'
          }
        ],
        trackHeight: 120,
        waveOutlineColor: '#eee',
        startTime: 0, // 2
        trackWidth: 5000 // 6857 - 171 * 2
      }
    },
    computed: {
      tracks () {
        var ret = []
        if (process.env.NODE_ENV === 'development') {
          return this.tracks_test
        } else if (this.woa.audio_tracks) {
          // console.log(this.woa.audio_tracks)
          var obj = JSON.parse(this.woa.audio_tracks)
          for (var track in obj) {
            ret.push({mp3: 'https://media.polyphonyproject.com/media' + obj[track].filename, name: obj[track].name})
          }
          // console.log(ret)
        }
        return ret
      }
    },
    name: 'SongDetails',
    components: {
      WavePlaylist
    },
    props: ['woa', 'lang']
  }
</script>

<style scoped>
.lyrics {
  white-space: pre;
}
.textContent {
    background: url(/static/images/top_bg.png) top right no-repeat,url(/static/images/bottom_bg.png) bottom left no-repeat;
    padding-top: 120px;
    padding-bottom: 150px;
}
</style>
