<template>
    <div class="body" v-show="loaded">
      <div id="top-bar" class="playlist-top-bar shrink">
        <div class="playlist-toolbar">
          <div class="controlPanel">
            <div class="btn-group">
              <span class="btn-pause btn btn-warning" v-on:click="pause">
                <b-icon icon="pause-fill"></b-icon>
              </span>
              <span class="btn-play btn btn-success" v-on:click="start">
                <b-icon icon="play-fill"></b-icon>
              </span>
              <span class="btn-stop btn btn-danger" v-on:click="stop">
                <b-icon icon="stop-fill"></b-icon>
              </span>
            </div>
          </div>
          <div class="progressBar" v-on:click.stop="topBarClick($event)">
            <div class="barItemTitle"
            v-for="topBarInfo in topBarInfos"
            v-bind:key="topBarInfo.title"
            v-bind:style="{ width: topBarInfo.length + '% !important' }"
            >
              {{ topBarInfo.title }}
            </div>
          </div>
        </div>
      </div>
      <div id="playlist"></div>
    </div>
</template>
<script>
  import '../styles/playlist.scss'
  var ee = null
  export default {
    props: ['tracks', 'startTime', 'trackWidth', 'trackHeight', 'waveOutlineColor', 'topBarInfos'],
    name: 'wave-playlist',
    data: function () {
      return {
        // this is time length of audio file
        duration: 0,
        loaded: false
      }
    },
    mounted: async function () {
      window.OfflineAudioContext = window.OfflineAudioContext || window.webkitOfflineAudioContext
      window.AudioContext = window.AudioContext || window.webkitAudioContext
      let audioContext = new window.AudioContext()
      let sampleRate = audioContext.sampleRate

      this.duration = await this.getMp3Secs(this.tracks[0].mp3, this.startTime)
      let duration = this.duration
      let customSamplesPerPixel = Math.round(this.duration * sampleRate / this.trackWidth)

      let WaveformPlaylist = require('waveform-playlist')
      let playlist = WaveformPlaylist.init(
        {
          samplesPerPixel: customSamplesPerPixel,
          ac: audioContext,
          sampleRate: sampleRate,
          mono: true,
          timescale: true,
          waveHeight: this.trackHeight,
          container: document.getElementById('playlist'),
          state: 'cursor',
          colors: {
            waveOutlineColor: this.waveOutlineColor,
            timeColor: 'grey',
            fadeColor: 'black'
          },
          controls: {
            show: true,
            width: 200
          },
          zoomLevels: [512, customSamplesPerPixel],
          seekStyle: 'fill',
          isAutomaticScroll: true,
          isContinuousPlay: true
        }
      )

      ee = playlist.getEventEmitter()
      ee.on('finished', function () {
        // console.log('The cursor has reached the end of the selection !')
      })

      const bar = document.querySelector('.progressBar')
      ee.on('select', function (start, end, track) {
        let percent = 100 * start / duration
        bar.style.background = 'linear-gradient(90deg, #2c6b7b ' + percent + '%, #80a9af ' + percent + '%)'
        // console.log('end: ', this.duration)
        // console.log('track: ', track.endTime)
      })

      ee.on('timeupdate', function (playbackPosition) {
        // console.log('end: ', duration)

        let percent = 100 * playbackPosition / duration
        bar.style.background = 'linear-gradient(90deg, #2c6b7b ' + percent + '%, #80a9af ' + percent + '%)'
        // console.log('playbackPosition: ', playbackPosition)
      })

      let loadTrack = this.tracks.map((track, index) => {
        return {
          src: this.tracks[index].mp3,
          name: this.tracks[index].name,
          selected: {
            start: this.startTime
          },
          start: this.startTime
        }
      })

      playlist
        .load(loadTrack)
        .then(this.loadedCallback)
    },
    beforeDestroy: function () {
      // console.log('this is befroe destroy!')
    },
    methods: {
      pause: () => {
        ee.emit('pause')
      },
      start: () => {
        ee.emit('play')
      },
      stop: () => {
        ee.emit('stop')
      },
      topBarClick: function (e) {
        let xPosition = e.offsetX
        let barLength = e.toElement.offsetWidth
        let audioLength = this.duration
        let startTime = audioLength * xPosition / barLength
        const bar = document.querySelector('.progressBar')
        let percent = 100 * xPosition / barLength
        bar.style.background = 'linear-gradient(90deg, #2c6b7b ' + percent + '%, #80a9af ' + percent + '%)'
        ee.emit('select', startTime)
      },
      getMp3Secs: (mp3file, startTime) => {
        return new Promise((resolve, reject) => {
          let audioContext = new (window.AudioContext || window.webkitAudioContext)()
          let request = new XMLHttpRequest()
          request.open('GET', mp3file, true)
          request.responseType = 'arraybuffer'
          request.onload = function () {
            audioContext.decodeAudioData(request.response, function (buffer) {
              resolve(buffer.duration + startTime)
            })
          }
          request.send()
        })
      },
      loadedCallback: function () {
        const playlistOverplays = document.getElementsByClassName('playlist-overlay')
        Object.keys(playlistOverplays).forEach((key) => {
          if (this.tracks[key].img) {
            playlistOverplays[key].style.backgroundImage = "url('" + this.tracks[key].img + "')"
          }
        })
        this.loaded = true
      }
    }
  }
</script>

<style lang='scss' scoped>
  .playlist-top-bar {
    margin: 0 0 12px 0;
  }
  .progressBar {
    background: #80a9af;
    display: flex;
    height: 22px;
  }

  .barItemTitle {
    padding: 0 6px;
    border: white solid 1px;
    border-width: 0 1px 0 0;
    pointer-events:none;
    color: white;
    // min-inline-size: fit-content;
  }

  .controlPanel {
    display: flex;
    justify-content: center;
    padding: 6px 0;
  }

  span.btn {
    margin: 0 12px;
    padding: 0;
    width: 42px;
    height: 42px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50% !important;
  }

  .btn-pause {
    border: #9da269 5px solid;
  }

  .btn-play {
    border: #b0d6b0 5px solid;
  }

  .btn-stop {
    border: #dc8c82 5px solid;
  }

  #playlist {
    margin:4px, 4px;
    padding:4px;
    height: calc(100vh - 200px);
    overflow-x: auto;
  }

</style>
