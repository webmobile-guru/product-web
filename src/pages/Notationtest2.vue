<template>
  <div>
    <WavePlaylist
      :tracks ="tracks"
      :startTime ="startTime"
      :trackWidth ="trackWidth"
      :trackHeight="trackHeight"
      :waveOutlineColor="waveOutlineColor"
      :topBarInfos="topBarInfos"
      >
    </WavePlaylist>
  </div>
</template>

<script>
import WavePlaylist from '../components/WavePlaylist'

export default {
  components: {
    WavePlaylist
  },
  name: 'Home',
  data: function () {
    return {
      tracks: [
        {
          mp3: '/media/audio/v2_track1.mp3',
          img: '/media/img/v2_track1.jpg',
          name: 'Vocals 1'
        },
        {
          mp3: '/media/audio/v2_track2.mp3',
          img: '/media/img/v2_track2.jpg',
          name: 'Vocals 2'
        },
        {
          mp3: '/media/audio/v2_track2.mp3',
          // img: '/media/img/v2_track2.jpg',
          name: 'Vocals 2 vaweform'
        }/*,
        {
          mp3: '/media/audio/v2_track3.mp3',
          img: '/media/img/v2_track3.jpg',
          name: 'Vocals 3'
        },
        {
          mp3: '/media/audio/v2_track4.mp3',
          img: '/media/img/v2_track4.jpg',
          name: 'Vocals 4'
        }
        */
      ],
      trackHeight: 200, // must be same as the height of notation images if using those
      startTime: 1.35,
      waveOutlineColor: '#bbbbbb',
      // trackWidth: 23200 - 200 * 2
      trackWidth: 22800,
      topBarInfos: [
        {
          title: 'first',
          length: 20
        },
        {
          title: 'second',
          length: 60
        },
        {
          title: 'third',
          length: 20
        }
      ]
    }
  }
}
</script>
